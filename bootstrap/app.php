<?php
use App\Exceptions\BookingException;
use Illuminate\Auth\AuthenticationException;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    // النظام API بالكامل: كل الأخطاء JSON
    $exceptions->shouldRenderJsonWhen(fn (Request $request, Throwable $e) => true);

    $exceptions->render(function (BookingException $e, Request $request) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], $e->statusCode());
    });

    // ModelNotFoundException بيتحول تلقائياً لـ NotFoundHttpException
    $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        return response()->json([
            'success' => false,
            'message' => 'Resource not found.',
        ], 404);
    });

    $exceptions->render(function (ValidationException $e, Request $request) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $e->errors(),
        ], 422);
    });

    $exceptions->render(function (AuthenticationException $e, Request $request) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.',
        ], 401);
    });

    // أي خطأ تاني (لازم يكون آخر واحد)
    $exceptions->render(function (Throwable $e, Request $request) {
        $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        return response()->json([
            'success' => false,
            'message' => ($status === 500 && ! config('app.debug'))
                ? 'Server error.'
                : $e->getMessage(),
        ], $status);
    });

    })->create();
