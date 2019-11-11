<?php

Route::get('/', function () {
    return redirect(route('adminroute'));
});

Route::get('/challenge', 'AdminControllers\AdminAuthController@initContent')->name('adminroute');
Route::post('/challenge', 'AdminControllers\AdminAuthController@initProcessLogin');