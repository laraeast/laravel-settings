<p align="center">
	<a href="https://github.styleci.io/repos/179407016"><img src="https://github.styleci.io/repos/179407016/shield?style=flat" alt="StyleCI"></a>
	<a href="https://travis-ci.org/laraeast/laravel-settings"><img src="https://travis-ci.org/laraeast/laravel-settings.svg?branch=master" alt="Travis Build Status"></a>
	<a href="https://circleci.com/gh/laraeast/laravel-settings"><img src="https://circleci.com/gh/laraeast/laravel-settings.png?style=shield" alt="Circleci Build Status"></a>
	<a href="https://packagist.org/packages/laraeast/laravel-settings"><img src="https://poser.pugx.org/laraeast/laravel-settings/d/total.svg" alt="Total Downloads"></a>
	<a href="https://packagist.org/packages/laraeast/laravel-settings"><img src="https://poser.pugx.org/laraeast/laravel-settings/v/stable.svg" alt="Latest Stable Version"></a>
	<a href="https://packagist.org/packages/laraeast/laravel-settings"><img src="https://poser.pugx.org/laraeast/laravel-settings/license.svg" alt="License"></a>
</p>
 
# Persistent Settings Manager for Laravel
 
 * Simple key-value storage
 * Localization supported.
 * Localization using [Astrotomic/laravel-translatable](https://github.com/Astrotomic/laravel-translatable) Structure
 
## Installation
 
1. Install package
 
    ```bash
    composer require laraeast/laravel-settings
    ```
 
1. Edit config/app.php (Skip this step if you are using laravel 5.5+)
 
    service provider:
 
    ```php
    Laraeast\LaravelSettings\Providers\SettingsServiceProvider::class,
    ```
 
    class aliases:
 
    ```php
    'Settings' => Laraeast\LaravelSettings\Facades\Settings::class,
    ```
 
1. Create settings table for `database` driver
 
    ```bash
    php artisan settings:table
    php artisan migrate
    ```
 
## Usage
 
```php
Settings::get('name', 'Computer');
// get setting value with key 'name'
// return 'Computer' if the key does not exists

Settings::locale('en')->get('name', 'Computer');
// get setting value with key and language
 
Settings::get('name:en', 'Computer');
// get setting value with key and language
 
Settings::set('name', 'Computer');
// set setting value by key
 
Settings::locale('en')->set('name', 'Computer');
// set setting value by key and language
 
Settings::set('name:en', 'Computer');
// set setting value by key and language
 
Settings::has('name');
// check the key exists, return boolean
 
Settings::locale('en')->has('name');
// check the key exists by language, return boolean
 
Settings::has('name:en');
// check the key exists by language, return boolean
 
Settings::delete('name');
// delete the setting by key
 
Settings::locale('en')->delete('name');
// delete the setting by key and language
 
Settings::delete('name:en');
// delete the setting by key and language
```
 
## Dealing with array
 
```php
Settings::get('item');
// return null;
 
Settings::set('item', ['USB' => '8G', 'RAM' => '4G']);
Settings::get('item');
// return array(
//     'USB' => '8G',
//     'RAM' => '4G',
// );
```
### Usage
```php
Settings::locale('en')->set('title', 'Example Website');
 
Settings::locale('en')->get('title');
// return return 'Example Website';
 
Settings::set('title:ar', 'عنوان الموقع');

Settings::locale('ar')->get('title');
// return return 'عنوان الموقع';

Settings::locale('ar')->has('title') // bool
Settings::locale('ar')->delete('title') 

App::setLocale('en');

Settings::locale()->get('title');
// return return 'Example Website';
```
### Extend Driver
> You can extend your custom driver by adding this code in `register()` method of your `AppServiceProvier` 

###### EX :
```php
$this->app['settings.manager']->extend('file', function () {
	return new SettingsFileDriverHandler();
});
```
> Note : your custom driver `SettingsFileDriverHandler` should implements `Laraeast\LaravelSettings\Contracts\SettingsStore` contract
```
<?php

namespace App\LaravelSettings;

use Laraeast\LaravelSettings\Contracts\SettingsStore;

class SettingsFileDriverHandler implements SettingsStore
{
    ...
}
```
