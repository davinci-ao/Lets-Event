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

Route::group(['middleware' => ['checkRole']], function () {

	// category

	Route::resource('category', 'CategoryController')->except(['create', 'show']);	
	Route::resource('location', 'LocationController');	


	// CSV import
	Route::get('/import', 'ImportController@index')->name('import');
	Route::post('/import', 'ImportController@processImport')->name('import_parse');

	//Users
	Route::get('/Users/viewAll', 'UserController@index')->name('userIndex');
	Route::get('/Users/view/singleUser/{userID}', 'UserController@viewUser')->name('editUser');
	Route::post('/users/updateUser', 'UserController@updateUser')->name('updateUser');

	//approve events
	Route::get('/event/approve', 'EventController@approveIndex')->name('eventApprove');
});

// events
Route::resource('event', 'EventController');
