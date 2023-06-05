<?php

namespace App\Http\Middleware;

use App\Packages\Rest\Rest;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StandardResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var JsonResponse
         */
        $r = $next($request);

        if ($r->original === null) {
            $code = $r->getStatusCode();

            if ($code >= 200 && $code <= 299) {
                return Rest::success();
            } else {
                return Rest::error($code);
            }
        }

        if (!$r instanceof JsonResponse) {
            return abort(500, 'Response should be json');
        }

        if (!collect($r->original)->has('success', 'code', 'data', 'message', 'status')) {
            return Rest::success($r->original);
        }

        return $r;
    }
}
