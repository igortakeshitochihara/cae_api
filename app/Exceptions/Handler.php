<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        ValidationException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable  $exception)
    {
        if ($exception instanceof AuthenticationException)
            return response()->json(['message' => $exception->getMessage(), 'status' => 401], 401);

        if ($exception instanceof NotFoundHttpException)
            return response()->json(['message' => 'Route URL Not Found', 'status' => 404], 404);

        if ($exception instanceof MethodNotAllowedHttpException)
            return response()->json(['message' => 'Controller Not Found', 'status' => 404], 404);

        if ($exception instanceof ServiceException) {
            if ($exception->getData() == null)
                return response()->json(['message' => $exception->getMessage()], 400);
            return response()->json(['message' => $exception->getMessage(), 'data' => $exception->getData()], 400);
        }

        if ($exception instanceof ValidationException) {
            $result = [];
            foreach ($exception->validator->getMessageBag()->getMessages() as $messages)
                foreach ($messages as $message)
                    array_push($result, $message);
            return response()->json(['message' => implode(" ", $result), 'status' => 400], 400);
        }

        return response()->json(['message' => $exception->getMessage(), 'status' => 500], 500);
    }
}
