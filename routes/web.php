<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });


Auth::routes();
Route::group(['middleware' => ['auth']], function() {
  Route::get('/', 'KriteriaController@index');
  Route::get('/result', 'ResultController@index')->name('result');
  Route::get('/gAhpKri', 'ResultController@gAhpKri')->name('gAhpKri');
  Route::get('/gAhpSub', 'ResultController@gAhpSub')->name('gAhpSub');
  Route::get('/gAhpPem', 'ResultController@gAhpPem')->name('gAhpPem');
  Route::get('/gFuzKri', 'ResultController@gFuzKri')->name('gFuzKri');
  Route::get('/gFuzSub', 'ResultController@gFuzSub')->name('gFuzSub');
  Route::get('/gFuzPem', 'ResultController@gFuzPem')->name('gFuzPem');

  Route::resource('kriterias', 'KriteriaController');

  Route::resource('subKriterias', 'SubKriteriaController');

  Route::resource('experts', 'ExpertController');

  Route::resource('kriteriaKriterias', 'KriteriaKriteriaController');

  Route::get('/kriteriaKriterias/create/{id}', 'KriteriaKriteriaController@create')->name('CreateKriteriaKriteria');
  Route::get('/subKriterias/create/{id}', 'SubKriteriaController@create')->name('CreateSubKriteria');

  Route::get('/subKriteriaSubKriterias/create/{id}', 'SubKriteriaSubKriteriaController@create')->name('CreateSubKriteriaSubKriteria');
  Route::resource('subKriteriaSubKriterias', 'SubKriteriaSubKriteriaController');
  Route::resource('kriterias.SubKriterias', 'SubKriteriaController');
  Route::get('/subKriterias/kriterias/{id}', 'SubKriteriaSubKriteriaController@kriteria')->name('showKriterias');


  Route::resource('pemasoks', 'PemasokController');

  Route::resource('experts.pemasokSubs', 'PemasokSubController');
  Route::resource('pemasokSubs', 'PemasokSubController');
  Route::delete('/destroyAllByExpertId/{expert_id}', ['uses' => 'KriteriaKriteriaController@destroyAllByExpertId', 'as' => 'dKri']);
  Route::delete('/destroyAllSubByKriteriaId/{kriteria_id}', ['uses'=>'SubKriteriaSubKriteriaController@destroyAllByKriteriaId', 'as' => 'dSub']);
  Route::delete('/destroyAllPSubsByExpertId/{expert_id}', ['uses'=>'PemasokSubController@destroyAllByExpertId', 'as'=>'dPSub']);


});
