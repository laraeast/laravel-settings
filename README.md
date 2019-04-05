[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
 
# Persistent Settings Manager for Laravel
 
 * Simple key-value storage
 * Localization supported.
 * Localization using [dimsav/laravel-translatable](https://github.com/dimsav/laravel-translatable) Structure
 
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
 
Settings::all();
// get all settings
 
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
 
Settings::forget('name');
// delete the setting by key
 
Settings::locale('en')->forget('name');
// delete the setting by key and language
 
Settings::forget('name:en');
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
Settings::locale('ar')->forget('title') 

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

[ico-version]: https://img.shields.io/packagist/v/laraeast/laravel-settings.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
 
[ico-downloads]: https://img.shields.io/packagist/dt/laraeast/laravel-settings.svg?style=flat-square