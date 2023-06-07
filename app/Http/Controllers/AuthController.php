<?php

namespace App\Http\Controllers;

use App\Entities\AuthEntity;
use App\Entities\RegisterEntity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        /**
         * @var AuthEntity
         */
        $data = AuthEntity::validateAndCreate($credentials);

        if (!$token = auth()->attempt($data->toArray())) {
            return new UnauthorizedException;
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        /**
         * @var RegisterEntity
         */
        $data = RegisterEntity::validateAndCreate($request->all());
        User::create($data->toArray());
    }

    /**
     * Get the authenticated User.
     */
    public function me()
    {
        return auth()->user();
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        auth()->logout();
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken(string $token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
        ];
    }
}
