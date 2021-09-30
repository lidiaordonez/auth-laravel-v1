<?php

namespace FaithFM\AuthLaravel;

use Illuminate\Support\ServiceProvider;

class AuthLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // publish/clone everything contained in the "clone" folder of our repo (to the matching folder in our project)
        $this->publishes([
            __DIR__.'/../clone/' => base_path(),
        ], 'auth-force-updates');
    }

}
