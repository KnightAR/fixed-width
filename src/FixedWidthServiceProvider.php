<?php

namespace TeamZac\FixedWidth;

use Illuminate\Support\ServiceProvider;

class FixedWidthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('fixed-width', function () {
            return new FixedWidthParser;
        });
    }
}
