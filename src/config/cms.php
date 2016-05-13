<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Register routes
    |--------------------------------------------------------------------------
    |
    | Determines if the default admin routes should be registered or not
    |
    | Default: true
    |
    */

    'routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Base url
    |--------------------------------------------------------------------------
    |
    | The CMS will be available on the following url
    |
    | Eg.: "/admin", "/cms" 
    |
    */

    'url' => '/admin',

    /*
    |--------------------------------------------------------------------------
    | Name of controller
    |--------------------------------------------------------------------------
    |
    | Enter the name of controller that will use the CMS.
    | It's required for automatic routing.
    |
    */
   
    'controller' => 'AdminController',

    /*
    |--------------------------------------------------------------------------
    | View directory
    |--------------------------------------------------------------------------
    |
    | The following path will contain the CMS views.
    |
    | Base directory: resources/views/...
    |
    | Eg.: "admin", "cms" 
    |
    */

    'views' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Default locale
    |--------------------------------------------------------------------------
    |
    | The default locale of the cms.
    |
    | Eg.: 'en' / 'hu' / etc
    |
    */

    'locale' => 'hu',
);
