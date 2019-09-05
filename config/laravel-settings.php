<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default settings "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "database"
    |
    */

    'driver' => 'database',

    /*
    |--------------------------------------------------------------------------
    | Cache Settings Query
    |--------------------------------------------------------------------------
    |
    | This option controls the settings performance.
    |
    */

    'use_cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Cache Expiration Time
    |--------------------------------------------------------------------------
    |
    | This option controls the expiration time in seconds.
    |
    */

    'cache_expire' => 60 * 60 * 24 * 30, // 1 month

    /*
    |--------------------------------------------------------------------------
    | Setting Model Class
    |--------------------------------------------------------------------------
    |
    | If you want to customize model for application settings you should
    | add your custom settings model class name here.
    |
    | Used only in "database" driver.
    |
    */

    'model_class' => null,
];
