<?php

namespace App\Http\Controllers;

use App\Contracts\Controllers\AuthControllerInterface;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthController extends Controller implements AuthControllerInterface
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (auth()->check()) {
            throw new BadRequestException(__('auth.errors.user_was_logged_in_before'));
        }
        $credentials = request(['mobile', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            throw new AuthenticationException(__('auth.errors.credential_is_wrong'));
        }

        return Response::data([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ])->send();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkToken()
    {
        if (!auth()->check()) {
            throw new BadRequestException(__('auth.errors.user_is_not_login'));
        }

        return Response::data(new UserResource(auth()->user()))->send();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (!auth()->check()) {
            throw new BadRequestException(__('auth.errors.user_is_not_login'));
        }

        auth()->logout();

        return Response::data(['message' => 'auth.errors.user_is_loged_out_successfully'])->send();
    }
}
