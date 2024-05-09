<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Redirect https if production
        if($this->app->environment('production') || $this->app->environment('development')) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS','on');
        }
    }
}
