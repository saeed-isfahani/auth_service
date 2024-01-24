<?php

namespace App\Exceptions;

use App\Facades\ApiResponse;
use App\Facades\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response as ResponseCodes;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, $exception)
    {
        if ($exception instanceof BadRequestException) {
            return Response::data(['message' => $exception->getMessage()])->send(ResponseCodes::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof UnauthorizedException) {
            return Response::data(['message' => $exception->getMessage()])->send(ResponseCodes::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AuthenticationException) {
            return Response::data(['message' => $exception->getMessage()])->send(ResponseCodes::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->messages();

            return Response::data(['message' => $exception->getMessage(), 'errors' => $errors])->send(ResponseCodes::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        return Response::data(['message' => 'Unexpected Error , try later please'])->send(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR);
    }
}
