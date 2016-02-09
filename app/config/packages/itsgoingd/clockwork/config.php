<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Clockwork
    |--------------------------------------------------------------------------
    |
    | You can explicitly enable or disable Clockwork here. When enabled, special
    | headers for communication with the Clockwork Chrome extension will be
    | included in your application responses and requests data will be available
    | at /__clockwork url.
    | When set to null, Clockwork behavior is controlled by app.debug setting.
    | Default: null
    |
    */

    'enable' => null,

    /*
    |--------------------------------------------------------------------------
    | Enable data collection, when Clockwork is disabled
    |--------------------------------------------------------------------------
    |
    | This setting controls, whether data about application requests will be
    | recorded even when Clockwork is disabled (useful for later analysis).
    | Default: true
    |
    */

    'collect_data_always' => true,

    /*
    |--------------------------------------------------------------------------
    | Filter collected data
    |--------------------------------------------------------------------------
    |
    | You can filter collected data by specifying what you don't want to collect
    | here.
    |
    */

    'filter' => [
        'routes', // It might be a good idea to not collect routes in every request as this might use a lot of disk space
    ],

];
