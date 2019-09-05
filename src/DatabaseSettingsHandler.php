<?php

namespace Laraeast\LaravelSettings;

use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Laraeast\LaravelSettings\Contracts\SettingsStore;
use Laraeast\LaravelSettings\Models\Setting;

class DatabaseSettingsHandler implements SettingsStore
{
    /**
     * The settings collection.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $settings;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Create Settings instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->fetchSettings();
    }

    /**
     * Set a new settings item.
     *
     * @param $key
     * @param null $value
     *
     * @return \Laraeast\LaravelSettings\Models\Setting
     */
    public function set($key, $value = null)
    {
        Cache::forget('settings');

        $this->supportLocaledKey($key);

        $model = $this->getModelClassName();

        $model::updateOrCreate([
            'key'    => $key,
            'locale' => $this->locale,
        ], [
            'key'    => $key,
            'locale' => $this->locale,
            'value'  => serialize($value),
        ]);

        $this->fetchSettings();

        $value = $this->instance($key);

        $this->locale = null;

        return $value;
    }

    /**
     * Set the settings locale.
     *
     * @param null $locale
     *
     * @return $this
     */
    public function locale($locale = null)
    {
        $this->locale = $locale ?: $this->app->getLocale();

        return $this;
    }

    /**
     * Get the given item.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $instance = $this->instance($key);

        $this->locale = null;

        return $instance ? unserialize($instance->value) : $default;
    }

    /**
     * Fetch the settings collection.
     *
     * @return void
     */
    private function fetchSettings()
    {
        $model = $this->getModelClassName();

        if ($this->app['config']->get('laravel-settings.use_cache')) {
            $expireSeconds = $this->app['config']->get('laravel-settings.cache_expire');

            $this->settings = Cache::remember(
                'settings',
                Carbon::now()->addSeconds($expireSeconds),
                function () use ($model) {
                    return $model::get();
                }
            );
        } else {
            $this->settings = $model::get();
        }
    }

    /**
     * Get the settings row.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function instance($key, $default = null)
    {
        $this->supportLocaledKey($key);

        return $this->settings->where('key', $key)->where('locale', $this->locale)->first()
            ?: $default;
    }

    /**
     * Determine whether the key is already exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return (bool) $this->instance($key);
    }

    /**
     * Delete the given key from storage.
     *
     * @param string $key
     *
     * @return $this
     */
    public function delete($key)
    {
        if ($this->instance($key)) {
            Cache::forget('settings');

            $this->instance($key)->delete();

            $this->fetchSettings();
        }

        return $this;
    }

    /**
     * Update locale if the key has the language.
     *
     * @param $key
     */
    private function supportLocaledKey(&$key)
    {
        if (strpos($key, ':') !== false) {
            $this->locale(explode(':', $key)[1]);
            $key = explode(':', $key)[0];
        }
    }

    /**
     * The model class name.
     *
     * @return string
     */
    private function getModelClassName()
    {
        $model = $this->app['config']->get('laravel-settings.model_class');

        return $model ?: Setting::class;
    }
}
