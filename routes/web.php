<?php

Route::get('/', function() {
	return view('template.palih');
});

Route::get('/seed', function() {
	$dosens = [];
	$matkuls = [];

	$faker = \Faker\Factory::create();

	for ($i=1; $i <= 1000; $i++) { 
		$dosens[$i]['nidn'] = 123456 + $i;
		$dosens[$i]['nama'] = $faker->name;
		
		$matkuls[$i]['kode'] = 123456 + $i;
		$matkuls[$i]['matkul'] = $faker->word;
	}

	\App\Models\Dosen::insert($dosens);
	\App\Models\Matkul::insert($matkuls);
});

Route::get('/dosen', 'DosenController@index')->name('dosen.index');
Route::post('/dosen/getTableData', 'DosenController@getTableData')->name('dosen.getTableData');
Route::post('/dosen', 'DosenController@store')->name('dosen.store');
Route::get('/dosen/{id}', 'DosenController@show')->name('dosen.show');
Route::put('/dosen/{id}', 'DosenController@update')->name('dosen.update');
Route::delete('/dosen/{id}', 'DosenController@delete')->name('dosen.delete');

Route::get('/matkul', 'MatkulController@index')->name('matkul.index');
Route::post('/matkul/getTableData', 'MatkulController@getTableData')->name('matkul.getTableData');
Route::post('/matkul', 'MatkulController@store')->name('matkul.store');
Route::get('/matkul/{id}', 'MatkulController@show')->name('matkul.show');
Route::put('/matkul/{id}', 'MatkulController@update')->name('matkul.update');
Route::delete('/matkul/{id}', 'MatkulController@delete')->name('matkul.delete');