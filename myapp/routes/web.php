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


Route::get('/', 'WelcomeController@index');

//register
Route::get('/register/setPassword/{token}', 'Auth\RegisterController@completeRegistration')->name('completeRegister');
Route::post('/register/setPassword', 'Auth\RegisterController@SetPassword')->name('setPassword');

Auth::routes();

// home
Route::get('/home', 'HomeController@index')->name('home');

// category
Route::group(['middleware' => ['checkRole']], function () {
	Route::get('/category/index/', 'CategoryController@index')->name('indexCategory');
	Route::post('/category/create', 'CategoryController@createCategory')->name('createCategory');
	Route::get('/category/delete/{categoryId}', 'CategoryController@deleteCategory')->name('deleteCategory');
	Route::get('/category/edit/{id}', 'CategoryController@viewEditCategory')->name('editCategory');
	Route::post('/category/edit', 'CategoryController@editCategoryAction')->name('editCategoryAction');

	// CSV import
	Route::get('/importcsv', 'ImportController@index')->name('import');
	Route::get('/errorparseimport', 'ImportController@errorParseImport')->name('import_parse_error');
	Route::post('/parseimport', 'ImportController@parseImport')->name('import_parse');
	Route::post('/processimport', 'ImportController@processImport')->name('import_process');
});

//event
Route::get('/event/createEvent', 'EventController@create')->name('indexCreateEvent');
Route::post('/event/createEvent', 'EventController@createSave')->name('createEvent');
Route::get('/event/overview', 'EventController@index')->name('eventIndex');
Route::get('/event/view/{eventID}', 'EventController@viewEvent')->name('viewEvent');
Route::get('/event/register/{eventId}', 'EventController@registerEvent')->name('RegisterEvent');
Route::post('/event/register', 'EventController@registerEventAction')->name('RegisterEventAction');
Route::post('/event/writeOut', 'EventController@writeOutOfEvent')->name('WriteOutEvent');
Route::get('/event/delete/{eventID}', 'EventController@deleteEvent')->name('deleteEvent');
