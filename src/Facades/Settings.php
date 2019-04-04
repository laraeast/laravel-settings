<?php

namespace Laraeast\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Laraeast\LaravelSettings\Contracts\SettingsStore locale($locale = null)
 * @method static \Laraeast\LaravelSettings\Contracts\SettingsStore set($key, $value)
 * @method static mixed get($key, $default = null)
 * @method static mixed instance($key, $default = null)
 */
class Settings extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}
