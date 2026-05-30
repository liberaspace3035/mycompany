<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Railway は HTTPS→HTTP のリバースプロキシのため、本番のみ HTTPS で URL 生成させる。
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
