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


Route::get('/events/overview', 'EventController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/category/index/', 'CategoryController@index')->name('indexCategory');
Route::post('/category/create', 'CategoryController@createCategory')->name('createCategory');
//Import csv
Route::get('/importcsv', 'ImportController@index')->name('import');
Route::get('/errorparseimport', 'ImportController@errorParseImport')->name('import_parse_error');
Route::post('/parseimport', 'ImportController@parseImport')->name('import_parse');
Route::post('/processimport', 'ImportController@processImport')->name('import_process');