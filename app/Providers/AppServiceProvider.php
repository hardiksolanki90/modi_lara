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
        // Create a Service Container
        $this->app->singleton('context', function ($app) {
            return new \App\Classes\Context;
        });
        $urlSegements = request()->segments();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->scope = 'front';
        $urlSegements = request()->segments();
        $adminRoute = $urlSegements;
        if (in_array('storeadmin', $adminRoute)) {
            app()->scope = 'admin';
            config(['app.scope' => 'admin']);
        }
    }
}
