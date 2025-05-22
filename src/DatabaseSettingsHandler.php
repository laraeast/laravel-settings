<?php

namespace Laraeast\LaravelSettings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Laraeast\LaravelSettings\Contracts\SettingsStore;
use Laraeast\LaravelSettings\Models\Setting;

class DatabaseSettingsHandler implements SettingsStore
{
    protected Collection $settings;

    protected ?string $locale = null;

    public function __construct(private Application $app)
    {
        $this->fetchSettings();
    }

    /**
     * Set a new settings item.
     */
    public function set(string $key, mixed $value = null): Setting
    {
        Cache::forget('settings');

        $this->supportLocaledKey($key);

        $model = $this->getModelClassName();

        $model::updateOrCreate([
            'key' => $key,
            'locale' => $this->locale,
        ], [
            'key' => $key,
            'locale' => $this->locale,
            'value' => serialize($value),
        ]);

        $this->fetchSettings();

        $value = $this->instance($key);

        $this->locale = null;

        return $value;
    }

    /**
     * Set the settings locale.
     */
    public function locale(?string $locale = null): self
    {
        $this->locale = $locale ?: $this->app->getLocale();

        return $this;
    }

    /**
     * Get the given item.
     *
     * @template TDefault
     *
     * @param string $key
     * @param TDefault|null $default
     * @return ($default is null ? Setting : TDefault)
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $instance = $this->instance($key);

        $this->locale = null;

        return $instance ? unserialize($instance->value) : $default;
    }

    /**
     * Fetch the settings collection.
     */
    private function fetchSettings(): void
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
     * @template TDefault
     *
     * @param string $key
     * @param TDefault|null $default
     * @return ($default is null ? Setting : TDefault)
     */
    public function instance(string $key, mixed $default = null): mixed
    {
        $this->supportLocaledKey($key);

        return $this->settings->where('key', $key)->where('locale', $this->locale)->first()
            ?: $default;
    }

    /**
     * Determine whether the key is already exists.
     */
    public function has(string $key): bool
    {
        return (bool)$this->instance($key);
    }

    /**
     * Delete the given key from storage.
     */
    public function delete(string $key): self
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
     */
    private function supportLocaledKey(string &$key): void
    {
        if (str_contains($key, ':')) {
            $this->locale(explode(':', $key)[1]);
            $key = explode(':', $key)[0];
        }
    }

    /**
     * The model class name.
     *
     * @return class-string<Setting>
     */
    private function getModelClassName(): string
    {
        $model = $this->app['config']->get('laravel-settings.model_class');

        return $model ?: Setting::class;
    }
}
