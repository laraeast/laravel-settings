<?php

namespace Laraeast\LaravelSettings\Providers;

use Illuminate\Support\ServiceProvider;
use Laraeast\LaravelSettings\Console\SettingsTableCommand;
use Laraeast\LaravelSettings\SettingsManager;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('settings.manager', function ($app) {
            return new SettingsManager($app);
        });
        $this->app->singleton('settings', function ($app) {
            return $app->make('settings.manager')->driver();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-settings.php', 'laravel-settings');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/laravel-settings.php' => config_path('laravel-settings.php'),
            ], 'settings:config');

            $this->commands([
                SettingsTableCommand::class,
            ]);
        }
    }
}
