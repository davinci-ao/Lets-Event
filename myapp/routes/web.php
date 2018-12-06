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

// dashboard
Route::get('/home', 'HomeController@index')->name('home');

// the routes for admins
Route::group(['middleware' => ['checkRole']], function () {

	// category
	Route::resource('category', 'CategoryController')->except(['create']);	
	Route::resource('location', 'LocationController')->except(['create']);	

	// CSV import
	Route::get('/import', 'ImportController@index')->name('import');
	Route::post('/import', 'ImportController@processImport')->name('import_parse');

	//Users
	Route::get('/users', 'UserController@index')->name('userIndex');
	Route::get('/users/{id}', 'UserController@viewUser')->name('editUser');
	Route::post('/users/updateUser', 'UserController@updateUser')->name('updateUser');
	//approve events
	Route::get('/event/approve', 'EventController@approve')->name('eventApprove');
});
Route::resource('category', 'CategoryController')->only([
    'index', 'show'
]);
// events
Route::resource('event', 'EventController');