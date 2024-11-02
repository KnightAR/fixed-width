<?php

namespace TeamZac\FixedWidth;

use Illuminate\Support\ServiceProvider;
use TeamZac\FixedWidth\Facades\FixedWidth;

class FixedWidthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeLineDefinitionCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('fixed-width', FixedWidth::class);
    }
}
