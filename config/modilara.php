<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Route
    |--------------------------------------------------------------------------
    |
    | This value refers to your admin route which will serve requests for your
    | admin side of the website.
    |
    */
    'admin_route' => 'challenge',

    /*
    |--------------------------------------------------------------------------
    | App Scope
    |--------------------------------------------------------------------------
    |
    | This value should not be changed here as this value will change dynamically with
    | every request it serves. Application first try to search admin_route defined in URL, if so, then it will be
    | changing this scope to front
    |
    */
    'app_scope' => 'front',

    /*
    |--------------------------------------------------------------------------
    | Front Theme
    |--------------------------------------------------------------------------
    |
    | This value actually refers to the directory located under resources/front/{name_of_theme}
    | so that your application can have mutliple themes but it search view and resource file in
    | active theme.
    |
    */
   'front_theme' => 'hardik-default',

    /*
    |--------------------------------------------------------------------------
    | Admin Theme
    |--------------------------------------------------------------------------
    |
    | This value actually refers to the directory located under resources/admin/{name_of_theme}
    | so that your application can have mutliple themes but it search view and resource file in
    | active theme.
    |
    */
   'admin_theme' => 'hardik-admin',

    /*
    |--------------------------------------------------------------------------
    | App Context
    |--------------------------------------------------------------------------
    |
    | This value is going to be set dynamically in AppServiceProvider file when application boot.
    |
    */
   'context' => [],

    /*
    |--------------------------------------------------------------------------
    | Current request
    |--------------------------------------------------------------------------
    |
    | This value is going to be set dynamically in AppServiceProvider file when application boot.
    |
    */
   'request' => [],

   /*
   |--------------------------------------------------------------------------
   | MAINTENANCE MODE
   |--------------------------------------------------------------------------
   |
   | This value is going to be set dynamically MAINTENANCE mode in AppServiceProvider file when
   | application boot.
   |
   */
  'maintenance' => '0',

  /*
  |--------------------------------------------------------------------------
  | Configuration
  |--------------------------------------------------------------------------
  |
  | This settings load configuration file which will boot the application with
  | some additional configuration
  |
  */
 'load_configuration' => true,

  /*
  |--------------------------------------------------------------------------
  | Configuration
  |--------------------------------------------------------------------------
  |
  | This settings load configuration file which will boot the application with
  | some additional configuration
  |
  */
 'dashboard_analytics' => false,
];
