<?php

namespace Laraeast\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Laraeast\LaravelSettings\Contracts\SettingsStore locale(?string $locale = null)
 * @method static \Laraeast\LaravelSettings\Models\Setting set(string $key, mixed $value = null)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static bool has(string $key)
 * @method static \Laraeast\LaravelSettings\Contracts\SettingsStore delete(string $key)
 * @method static mixed instance(string $key, mixed $default = null)
 */
class Settings extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'settings';
    }
}
