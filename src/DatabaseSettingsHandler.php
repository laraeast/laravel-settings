<?php

namespace Laraeast\LaravelSettings;

use Illuminate\Foundation\Application;
use Laraeast\LaravelSettings\Models\Setting;
use Laraeast\LaravelSettings\Contracts\SettingsStore;

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
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        Setting::updateOrCreate([
            'key' => $key,
            'locale' => $this->locale,
        ], [
            'key' => $key,
            'locale' => $this->locale,
            'value' => serialize($value),
        ]);

        $this->fetchSettings();

        return $this;
    }

    /**
     * Set the settings locale.
     *
     * @param null $locale
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
        $this->settings = Setting::where(function ($query) {
            $query->where('locale', $this->locale ?: $this->app->getLocale());
            $query->orWhereNull('locale');
        })->get();
    }

    /**
     * Get the settings row.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function instance($key, $default = null)
    {
        return $this->settings->where('key', $key)->where('locale', $this->locale)->first()
            ?: $default;
    }
}
