<?php

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\AuthorOnly;
use App\Http\Middleware\BlogExists;
use App\Http\Middleware\CacheHeaders;
use App\Http\Middleware\CommentModeration;
use App\Http\Middleware\DraftAccess;
use App\Http\Middleware\GuestOnly;
use App\Http\Middleware\MobileDetection;
use App\Http\Middleware\PageViews;
use App\Http\Middleware\RateLimitComments;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
         // Register middleware aliases
        $middleware->alias([
            'admin.only' => \App\Http\Middleware\AdminOnly::class,
            'author.only' => \App\Http\Middleware\AuthorOnly::class,
            'blog.exists' => \App\Http\Middleware\BlogExists::class,
            'cache.headers' => \App\Http\Middleware\CacheHeaders::class,
            'draft.access' => \App\Http\Middleware\DraftAccess::class,
            'guest.only' => \App\Http\Middleware\GuestOnly::class,
            'mobile.detection' => \App\Http\Middleware\MobileDetection::class,
            'page.views' => \App\Http\Middleware\PageViews::class,
            'rate.limit.comments' => \App\Http\Middleware\RateLimitComments::class,
        ]);

        // Add middleware groups if needed
        $middleware->web(append: [
            // \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
