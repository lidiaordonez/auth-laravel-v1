<?php

namespace FaithFM\AuthLaravel;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;

class AuthLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // $filesToClone = [
        //     'app/Models/User.php',
        //     'app/Http/Controllers/Auth/Auth0IndexController.php',
        // ];

        // foreach ($filesToClone as $file)
        //     $this->publishes([
        //         __DIR__.'/../clone/'.$file => base_path($file),
        //     ], 'auth-force-updates');

        // publish/clone everything contained in the "clone" folder of our repo (to the matching folder in our project)
        $this->publishes([
            __DIR__.'/../clone/' => base_path(),
        ], 'auth-force-updates');

        // $this->publishes([
        //     __DIR__.'/../clone/app/Models/User.php' => app_path('Models/User.php'),
        // ], 'auth-force-updates');

        // $this->publishes([
        //     __DIR__.'/../clone/app/Http/Controllers/Auth/Auth0IndexController.php' => app_path('Http/Controllers/Auth/Auth0IndexController.php'),
        // ], 'auth-force-updates');

            // __DIR__.'/../config/nova.php' => config_path('nova.php'),
            // __DIR__.'/../public' => public_path('vendor/nova'),
            // __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova'),
            // __DIR__.'/../database/migrations' => database_path('migrations'),
         
    }



    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

}
