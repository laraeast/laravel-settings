<?php

namespace Laraeast\LaravelSettings\Contracts;

use Illuminate\Foundation\Application;
use Laraeast\LaravelSettings\Models\Setting;

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
     */
    public function set(string $key, mixed $value = null): Setting;

    /**
     * Get the given item.
     *
     * @template TDefault
     *
     * @param string $key
     * @param TDefault|null $default
     * @return ($default is null ? Setting : TDefault)
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Get the settings row.
     *
     * @template TDefault
     *
     * @param string $key
     * @param TDefault|null $default
     * @return ($default is null ? Setting : TDefault)
     */
    public function instance(string $key, mixed $default = null): mixed;

    /**
     * Delete the given key from storage.
     *
     */
    public function delete(string $key): self;

    /**
     * Determine whether the key is already exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Set the settings locale.
     */
    public function locale(?string $locale = null): self;
}
