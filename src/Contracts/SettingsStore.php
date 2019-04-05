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
     * @return $this
     */
    public function set($key, $value = null);

    /**
     * Get the given item.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);
}
