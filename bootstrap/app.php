<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //

        $exceptions->render(function (AuthenticationException $e, $request) {
            $guard = $e->guards()[0] ?? null;

            if ($guard === 'admin') {
                return redirect()->guest(route('admin.login'));
            }

            return redirect()->guest(route('login'));
        });


    })->create();
