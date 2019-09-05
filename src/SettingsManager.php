<?php

namespace Laraeast\LaravelSettings;

use Illuminate\Support\Manager;

class SettingsManager extends Manager
{
    /**
     * Create an instance of the database settings driver.
     *
     * @return \Laraeast\LaravelSettings\DatabaseSettingsHandler
     */
    public function createDatabaseDriver()
    {
        return new DatabaseSettingsHandler($this->app);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['laravel-settings.driver'];
    }

    /**
     * Set the default driver name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['laravel-settings.driver'] = $name;
    }
}
