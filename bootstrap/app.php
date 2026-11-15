<?php

use App\Domain\Task\Exception\InvalidTaskId;
use App\Domain\Task\Exception\TaskNotFound;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ドメインの「存在しない/不正なID」は 404 として扱う
        $exceptions->map(fn (TaskNotFound $e) => new NotFoundHttpException($e->getMessage(), $e));
        $exceptions->map(fn (InvalidTaskId $e) => new NotFoundHttpException($e->getMessage(), $e));

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
