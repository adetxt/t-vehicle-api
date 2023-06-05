<?php

namespace App\Packages\Rest;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Rest
{
    protected bool $success;
    protected mixed $data;
    protected ?int $code;
    protected ?string $message;
    protected ?Throwable $e;

    protected array $status = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing', // WebDAV; RFC 2518
        103 => 'Early Hints', // RFC 8297
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information', // since HTTP/1.1
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content', // RFC 7233
        207 => 'Multi-Status', // WebDAV; RFC 4918
        208 => 'Already Reported', // WebDAV; RFC 5842
        226 => 'IM Used', // RFC 3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // Previously "Moved temporarily"
        303 => 'See Other', // since HTTP/1.1
        304 => 'Not Modified', // RFC 7232
        305 => 'Use Proxy', // since HTTP/1.1
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect', // since HTTP/1.1
        308 => 'Permanent Redirect', // RFC 7538
        400 => 'Bad Request',
        401 => 'Unauthorized', // RFC 7235
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required', // RFC 7235
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed', // RFC 7232
        413 => 'Payload Too Large', // RFC 7231
        414 => 'URI Too Long', // RFC 7231
        415 => 'Unsupported Media Type', // RFC 7231
        416 => 'Range Not Satisfiable', // RFC 7233
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot', // RFC 2324, RFC 7168
        421 => 'Misdirected Request', // RFC 7540
        422 => 'Unprocessable Entity', // WebDAV; RFC 4918
        423 => 'Locked', // WebDAV; RFC 4918
        424 => 'Failed Dependency', // WebDAV; RFC 4918
        425 => 'Too Early', // RFC 8470
        426 => 'Upgrade Required',
        428 => 'Precondition Required', // RFC 6585
        429 => 'Too Many Requests', // RFC 6585
        431 => 'Request Header Fields Too Large', // RFC 6585
        451 => 'Unavailable For Legal Reasons', // RFC 7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates', // RFC 2295
        507 => 'Insufficient Storage', // WebDAV; RFC 4918
        508 => 'Loop Detected', // WebDAV; RFC 5842
        510 => 'Not Extended', // RFC 2774
        511 => 'Network Authentication Required', // RFC 6585
    ];

    public static function success(mixed $data = null, int $code = 200, ?string $message = null): JsonResponse
    {
        $instance = self::new($data, $code, $message);

        return $instance->toResponse();
    }

    public static function error(?int $code = 500, ?string $message = null, mixed $data = null, ?Throwable $e = null): JsonResponse
    {
        $instance = self::new($data, $code, $message, $e);

        return $instance->toResponse();
    }

    public static function mapException(Throwable|HttpException|ValidationException $exception)
    {
        switch (get_class($exception)) {
            case ValidationException::class:
                return self::error(400, data: $exception->errors(), e: $exception);
                break;
            case ModelNotFoundException::class:
                return self::error(404, $exception->getMessage(), e: $exception);
                break;
            case AuthenticationException::class:
                return self::error(401, $exception->getMessage(), e: $exception);
                break;
            case UnauthorizedException::class:
                return self::error(403, $exception->getMessage(), e: $exception);
                break;
            default:
                if ($exception instanceof HttpException) {
                    return self::error($exception->getStatusCode(), $exception->getMessage(), e: $exception);
                } elseif ((int) $exception->getCode() >= 400 && (int) $exception->getCode() <= 500) {
                    return self::error(code: (int) $exception->getCode(), message: $exception->getMessage(), e: $exception);
                }

                return self::error(500, $exception->getMessage(), e: $exception);
        }
    }

    protected static function new(mixed $data = null, ?int $code = 200, ?string $message = '', ?Throwable $e = null, ?int $customCode = null)
    {
        $instance = new self;
        $instance->data = $data;
        $instance->code = $customCode ?? $code;
        $instance->message = $message;
        $instance->e = $e;

        return $instance;
    }

    public function toResponse()
    {
        $data = [
            'success' => $this->code < 400,
            'code' => $this->code,
            'message' => $this->message,
            'status' => $this->getStatus(),
            'data' => $this->getData(),
        ];

        if (app()->environment('local') && $this->e && $this->isTracable()) {
            $data['original'] = [
                'file' => sprintf('%s:%d', $this->e->getFile(), $this->e->getLine()),
                'trace' => collect($this->e->getTrace())
                    ->map(fn ($i) => sprintf('%s:%d @%s', $i['file'] ?? '', $i['line'] ?? '', $i['function'] ?? ''))
                    ->take(10),
            ];
        }

        return response()->json($data, $this->code);
    }

    protected function isTracable()
    {
        return ($this->e->getCode() >= 500 || $this->e->getCode() < 200) && ($this->code >= 500 || $this->code < 200);
    }

    protected function getData(): mixed
    {
        if (gettype($this->data) != 'object') {
            return $this->data;
        }

        switch (get_class($this->data)) {
            case LengthAwarePaginator::class:
                /**
                 * @var LengthAwarePaginator
                 */
                $data = $this->data;

                return [
                    'items' => $data->items(),
                    'page' => $data->currentPage(),
                    'pageSize' => $data->perPage(),
                    'total' => $data->total(),
                    'lastPage' => $data->lastPage(),
                ];

            case Paginator::class:
                /**
                 * @var Paginator
                 */
                $data = $this->data;

                return [
                    'items' => $data->items(),
                    'page' => $data->currentPage(),
                    'pageSize' => $data->perPage(),
                ];

            default:
                return $this->data;
        }
    }

    protected function getStatus(): string
    {
        if ($this->code <= 0) {
            return 'Unknown Status';
        }

        return isset($this->status[$this->code]) ? $this->status[$this->code] : 'Unknown Status';
    }
}
