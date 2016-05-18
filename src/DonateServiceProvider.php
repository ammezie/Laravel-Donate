<?php

namespace Mezie\donate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class DonateServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // use this if your package has views
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'donate');

        // publish views files
        // $this->publishes([
        //     __DIR__.'/resources/views' => resource_path('views/vendor/donate'),
        // ]);
        
        // // use this if your package has routes
        $this->setupRoutes($this->app->router);
        
        // use this if your package needs a config file
        $this->publishes([
                __DIR__.'/config/config.php' => config_path('donate.php'),
        ]);
        
        // use the vendor configuration file as fallback
        // $this->mergeConfigFrom(
        //     __DIR__.'/config/config.php', 'donate'
        // );
    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Mezie\donate\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDonate();
        
        // use this if your package has a config file
        // config([
        //         'config/donate.php',
        // ]);
    }
    private function registerDonate()
    {
        $this->app->bind('donate',function($app){
            return new Donate($app);
        });
    }
}