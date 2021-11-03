<?php

namespace stekel\LaravelUserUtils\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use stekel\LaravelUserUtils\Laravel\Console\ResetPasswords;

class LaravelUserUtilsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                ResetPasswords::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ResetPasswords::class,
        ];
    }
}
