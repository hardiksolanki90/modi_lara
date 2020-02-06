<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request as AppRequest;
use Request;
use App\Classes\Context;

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
    public function boot(AppRequest $request)
    {
        Schema::defaultStringLength(191);
        if (config('modilara.load_configuration')) {
          $this->initProcessMaintenance();
          $this->bootApplication($request);
        }
    }

    /**
     * [bootApplication description]
     * boot services from configured value in database
     */
    private function bootApplication($request)
    {
        $path_array = $request->segments();
        
        if (in_array(config('modilara.admin_route'), $path_array)) {
            $paths = resource_path('views/admin/' . config('modilara.admin_theme') . '/templates');
            $array_path = array(
                '0' => $paths
            );
            config(['view.paths' => $array_path]);
            config(['modilara.app_scope' => 'admin']);
        } else {
            $paths = resource_path('views/front/' . config('modilara.front_theme') . '/templates');
            $array_path = array(
                '0' => $paths
            );
        }

        view()->addLocation($paths);
        config(['modilara.context' => \App\Classes\Context::getContext()]);
        config(['modilara.request' => $request]);
    }

    protected function initProcessMaintenance()
    {
        $first_segment = Request::segment(1);
        $m = app()->context->configuration->get('DEBUG_MODE');
        config(['modilara.maintenance' => $m]);
    }
}
