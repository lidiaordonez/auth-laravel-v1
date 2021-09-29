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

        $this->publishes([
            __DIR__.'/models/User.php' => app_path('Models/UserTest.php'),
        ], 'auth-force-updates');

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
