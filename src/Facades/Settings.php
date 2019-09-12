<?php

namespace Laraeast\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Laraeast\LaravelSettings\Contracts\SettingsStore locale($locale = null)
 * @method static \Laraeast\LaravelSettings\Models\Setting set($key, $value = null)
 * @method static mixed get($key, $default = null)
 * @method static bool has($key)
 * @method static \Laraeast\LaravelSettings\Contracts\SettingsStore delete($key)
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
