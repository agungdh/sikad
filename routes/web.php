<?php

Route::get('/', function() {
	return view('template.palih');
})->name('main.index');

Route::get('/tendang', function() {
	return view('template.palih');
})->name('main.tendang')->middleware('MustLoggedIn');

Route::get('/seed/dosen', 'SeedController@dosen');
Route::get('/seed/matkul', 'SeedController@matkul');

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

Route::post('/dosen/getTableData', 'DosenController@getTableData')->name('dosen.getTableData');
Route::post('/matkul/getTableData', 'MatkulController@getTableData')->name('matkul.getTableData');
Route::post('/jadwal/getTableData', 'JadwalController@getTableData')->name('jadwal.getTableData');
Route::post('/jadwal/getDosen', 'JadwalController@getDosen')->name('jadwal.getDosen');
Route::post('/jadwal/getMatkul', 'JadwalController@getMatkul')->name('jadwal.getMatkul');

Route::resources([
	'/dosen' => 'DosenController',
	'/matkul' => 'MatkulController',
	'/jadwal' => 'JadwalController',
]);