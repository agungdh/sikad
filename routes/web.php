<?php

Route::get('/', function() {
	return view('template.palih');
});

Route::get('/dosen', 'DosenController@index')->name('dosen.index');
Route::post('/dosen/getTableData', 'DosenController@getTableData')->name('dosen.getTableData');
Route::post('/dosen', 'DosenController@store')->name('dosen.store');
Route::get('/dosen/{id}', 'DosenController@show')->name('dosen.show');
Route::put('/dosen/{id}', 'DosenController@update')->name('dosen.update');
Route::delete('/dosen/{id}', 'DosenController@delete')->name('dosen.delete');