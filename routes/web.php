<?php

use Illuminate\Support\Str;

Route::group(['middleware' => 'language'], static function () {
    Auth::routes();

    Route::prefix('auth')->namespace('Auth')->group(static function () {
        Route::get('otp', 'LoginController@formOtp')->name('otp');

        Route::post('resend-otp', 'LoginController@resendOtp')->middleware('throttle:1,5')->name('resend_otp');
        Route::post('login-otp', 'LoginController@loginOtp')->name('login_otp');
    });

    Route::get('/', 'HomeController@index')->middleware(['auth', 'active'])->name('home');

    Route::get('/js/lang', 'HomeController@lang')->name('lang');
    Route::get('change-language/{locale}', static function ($locale) {
        \Session::put('locale', $locale);

        return redirect()->back();
    })->name('change_language');

    $routeArr = getRouteConfig();
    foreach ($routeArr as $key => $routes) {
        $namespace = ucfirst($key);
        $prefix    = $key;

        // ROUTE CHUNG
        Route::namespace("Modules\\Backend\\$namespace")->prefix($prefix)->group(static function () use ($routes) {
            foreach ($routes as $route) {
                $ucTable         = ucfirst(Str::studly($route));
                $ucTableSingular = Str::singular($ucTable);
                $varRouteName    = lcfirst(Str::studly($route));

                if (class_exists("App\\Models\\{$ucTableSingular}")) {
                    Route::resource($route, "{$ucTable}Controller");
                    Route::get("/{$route}/lists/list", "{$ucTable}Controller@{$varRouteName}")->name("{$route}.list");
                    Route::post("/{$route}/lists/table", "{$ucTable}Controller@table")->name("{$route}.table");

                    Route::delete("/{$route}/action/deletes", "{$ucTable}Controller@destroys")->name("{$route}.destroys");
//                    Route::post("/{$route}/action/edits", "{$ucTable}Controller@edits")->name("{$route}.edits");
//                    Route::put("/{$route}/action/updates", "{$ucTable}Controller@updates")->name("{$route}.updates");
                }
            }
        });
    }

    //note: auto include tất cả file trong folder modules
    include_route_files(__DIR__ . '/modules/');
});