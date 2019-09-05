<?php

namespace Laraeast\LaravelSettings\Contracts;

use Illuminate\Foundation\Application;

interface SettingsStore
{
    /**
     * Create Settings instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app);

    /**
     * Set a new settings item.
     *
     * @param $key
     * @param null $value
     *
     * @return $this
     */
    public function set($key, $value = null);

    /**
     * Get the given item.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Get the settings row.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function instance($key, $default = null);

    /**
     * Delete the given key from storage.
     *
     * @param string $key
     *
     * @return $this
     */
    public function delete($key);

    /**
     * Determine whether the key is already exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Set the settings locale.
     *
     * @param null $locale
     *
     * @return $this
     */
    public function locale($locale);
}
