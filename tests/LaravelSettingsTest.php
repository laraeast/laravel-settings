<?php

namespace Laraeast\LaravelSettings\Tests;

use Laraeast\LaravelSettings\Facades\Settings;
use Laraeast\LaravelSettings\Models\Setting;
use Laraeast\LaravelSettings\Providers\SettingsServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelSettingsTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [SettingsServiceProvider::class];
    }

    /**
     * Load package alias.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Settings' => Settings::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /** @test */
    public function it_can_set_and_get_data()
    {
        Settings::set('name', 'Ahmed Fathy');
        Settings::set('phone', '021207687151');
        $this->assertEquals(Settings::get('phone'), '021207687151');
        $this->assertEquals(Settings::get('name'), 'Ahmed Fathy');
    }

    /** @test */
    public function it_returns_default_value_if_the_key_does_not_exists()
    {
        $this->assertEquals(Settings::get('UndefindKey', 'FooBar'), 'FooBar');
    }

    /** @test */
    public function it_returns_unique_value_of_localed_data()
    {
        Settings::locale('en')->set('language', 'English');
        Settings::locale('ar')->set('language', 'Arabic');
        $this->assertEquals(Settings::locale('en')->get('language'), 'English');
        $this->assertEquals(Settings::locale('ar')->get('language'), 'Arabic');
        Settings::locale('en')->delete('language');
        Settings::locale('ar')->delete('language');
        Settings::set('language:en', 'English');
        Settings::set('language:ar', 'Arabic');
        $this->assertEquals(Settings::locale('en')->get('language'), 'English');
        $this->assertEquals(Settings::locale('ar')->get('language'), 'Arabic');
        $this->assertEquals(Settings::get('language:en'), 'English');
        $this->assertEquals(Settings::get('language:ar'), 'Arabic');
        Settings::locale('en')->set('language', 'English');
        $this->assertEquals(Setting::where(['locale' => 'en', 'key' => 'language'])->count(), 1);
    }

    /** @test */
    public function it_determine_if_the_value_exists()
    {
        Settings::set('name', 'Ahmed');
        $this->assertTrue(Settings::has('name'));
        Settings::locale('en')->set('language', 'English');
        $this->assertTrue(Settings::locale('en')->has('language'));
        $this->assertTrue(Settings::has('language:en'));
    }

    /** @test */
    public function it_can_deleted_the_specific_key()
    {
        Settings::set('name', 'Ahmed');
        $this->assertTrue(Settings::has('name'));
        Settings::delete('name');
        $this->assertFalse(Settings::has('name'));
        $this->assertDatabaseMissing('settings', [
            'key' => 'name',
        ]);
        Settings::locale('en')->set('name', 'Ahmed');
        Settings::locale('ar')->set('name', 'احمد');
        $this->assertTrue(Settings::locale('en')->has('name'));
        $this->assertTrue(Settings::locale('ar')->has('name'));
        Settings::locale('en')->delete('name');
        $this->assertFalse(Settings::locale('en')->has('name'));
        $this->assertTrue(Settings::locale('ar')->has('name'));
        $this->assertDatabaseMissing('settings', [
            'key'    => 'name',
            'locale' => 'en',
        ]);
        Settings::delete('name:ar');
        $this->assertFalse(Settings::locale('ar')->has('name'));
        $this->assertFalse(Settings::has('name:ar'));
        $this->assertDatabaseMissing('settings', [
            'key'    => 'name',
            'locale' => 'ar',
        ]);
    }

    /** @test */
    public function it_returns_model_after_set_value()
    {
        $this->assertInstanceOf(Setting::class, Settings::set('foo', 'bar'));
    }
}
