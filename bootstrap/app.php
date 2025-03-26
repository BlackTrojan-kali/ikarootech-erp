<?php

use App\Http\Middleware\fromCenterRegion;
use App\Http\Middleware\fromEastRegion;
use App\Http\Middleware\fromLittoralRegion;
use App\Http\Middleware\fromNorthRegion;
use App\Http\Middleware\fromSouthRegion;
use App\Http\Middleware\fromWestRegion;
use App\Http\Middleware\isCommercial;
use App\Http\Middleware\isManager;
use App\Http\Middleware\isProducer;
use App\Http\Middleware\IsSuper;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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
    })->create();
