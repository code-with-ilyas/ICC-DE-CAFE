<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClientMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot(); // ✅ Ensure parent boot is called

        // ✅ Register middleware using Router instance
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', AdminMiddleware::class);
        $router->aliasMiddleware('client', ClientMiddleware::class);
    }
}
