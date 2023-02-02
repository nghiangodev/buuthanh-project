<?php

Route::namespace('Modules\\Backend\\Business')->group(static function () {

    Route::prefix('numberals')->name('numberals.')->group(static function () {
        Route::get('/star-resolution-list', 'NumberalsController@starResolutions')->name('star_resolution_list');
        Route::get('/export-excel/', 'NumberalsController@exportExcel')->name('export_excel');
    });
});
