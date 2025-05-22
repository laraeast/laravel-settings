<?php

namespace Laraeast\LaravelSettings;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Manager;

class SettingsManager extends Manager
{
    /**
     * Create an instance of the database settings driver.
     */
    public function createDatabaseDriver(): DatabaseSettingsHandler
    {
        return new DatabaseSettingsHandler(app());
    }

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver()
    {
        return Config::get('laravel-settings.driver');
    }

    /**
     * Set the default driver name.
     */
    public function setDefaultDriver(string $name): void
    {
        Config::set(['laravel-settings.driver' => $name]);
    }
}
