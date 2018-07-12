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

Route::get('/', function () {
	return view('welcome');
});

/* Start: Admin Routes */
Route::group(['prefix'=>'/admin'], function(){

	Route::get('/dashboard','AdminDashboardController@dashboard');
	
	/* Start: User Module Routes */
	Route::group(['prefix'=>'/users'], function(){
		Route::get('/', 'AdminUserController@users');
		Route::get('/add', 'AdminUserController@add');
		Route::get('/edit/{id}', 'AdminUserController@edit');
		Route::post('/adduser', 'AdminUserController@saveuser');
		Route::get('/status/{id}', 'AdminUserController@status');
		Route::get('/delete/{id}', 'AdminUserController@delete');
		Route::post('/active_all', 'AdminUserController@active_all');
		Route::post('/inactive_all', 'AdminUserController@inactive_all');
		Route::post('/delete_all', 'AdminUserController@delete_all');
	});
	/* End: User Module Routes */
});
/* End: Admin Routes */