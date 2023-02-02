<?php

Route::namespace('Modules\\Backend\\System')->group(static function () {

	Route::prefix('users')->name('users.')->group(static function () {
		Route::get('form/change-password/{user}', 'UsersController@formChangePassword')->name('form_change_password');
		Route::get('profile/{user}', 'UsersController@profile')->name('profile');
		Route::get('export/excel', 'UsersController@exportExcel')->name('export_excel');

		Route::post('change-state/{user}', 'UsersController@changeState')->name('change_state');
		Route::post('change-password/{user}', 'UsersController@changePassword')->name('change_password');
		Route::post('reset-default-password/{user}', 'UsersController@resetDefaultPassword')->name('reset_default_password');
	});
	Route::prefix('system_logs')->name('system_logs.')->group(static function () {
		Route::get('index', 'SystemLogsController@index')->name('index');

		Route::post('view/detail', 'SystemLogsController@viewDetail')->name('view_detail');
		Route::post('table', 'SystemLogsController@table')->name('table');
	});
	Route::prefix('activity_logs')->name('activity_logs.')->group(static function () {
		Route::get('get/logs', 'ActivityLogsController@getMoreLogs')->name('get_more_logs');
		Route::get('index', 'ActivityLogsController@index')->name('index');
		Route::get('export/excel', 'ActivityLogsController@exportExcel')->name('export_excel');

		Route::get('view/detail/{activityLog}', 'ActivityLogsController@viewDetail')->name('view_detail');
		Route::post('table', 'ActivityLogsController@table')->name('table');

	});

});