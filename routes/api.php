<?php

Route::group([
    'prefix' => 'auth',
], static function () {
    Route::post('signin', 'Api\AuthController@signIn');
    Route::post('signup', 'Api\AuthController@signUp');

    Route::group([
        'middleware' => 'auth:api',
    ], static function () {
        Route::post('signout', 'Api\AuthController@signOut');
        Route::get('current-user', 'Api\AuthController@getUser');
    });
});