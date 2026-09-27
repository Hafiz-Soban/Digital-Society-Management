<?php

<<<<<<< HEAD
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
=======
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'check.status' => \App\Http\Middleware\CheckStatus::class,
<<<<<<< HEAD
=======
            'check.maintenance' => \App\Http\Middleware\CheckMaintenanceDue::class,
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\CheckStatus::class,
<<<<<<< HEAD
        ]);

        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (Auth::check()) {
                /** @var User $user */
                $user = Auth::user();
                return match($user->role?->name) {
                    'admin' => route('admin.dashboard'),
                    'resident' => route('resident.dashboard'),
                    'security_guard' => route('security.dashboard'),
                    default => '/',
                };
            }
            return '/';
        });
=======
            \App\Http\Middleware\CheckMaintenanceDue::class,
        ]);
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return response()->view('errors.403', [], 403);
            }
        });
    })->create();
