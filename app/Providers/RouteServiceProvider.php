<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const ADMIN = '/admin/dashboard';
    public const PROVIDER = '/provider/dashboard';
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */


    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api/api.php'));

            Route::middleware('api')
                ->prefix('api/user')
                ->group(base_path('routes/api/user.php'));

            Route::middleware('api')
                ->prefix('api/provider')
                ->group(base_path('routes/api/provider.php'));

            Route::middleware('web')
                ->group(base_path('routes/site.php'));

            Route::middleware('web')
                // ->prefix('admins')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                // ->prefix('poviders')
                ->group(base_path('routes/provider.php'));
        });
    }
}
