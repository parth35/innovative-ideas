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

	/* Start: Auth Routes */
	Route::group(['prefix'=>'/login'], function(){
		Route::get('/', 'AuthController@login');
		Route::post('/doLogin', 'AuthController@doLogin');
	});
	Route::get('/logout', 'AuthController@logout');
	/* End: Auth Routes */

	Route::get('/dashboard','AdminDashboardController@dashboard');
	
	/* Start: Tags Module Routes */
	Route::group(['prefix'=>'/tags'], function(){
		Route::get('/', 'AdminTagsController@tags');
		Route::get('/add', 'AdminTagsController@add');
		Route::get('/edit/{id}', 'AdminTagsController@edit');
		Route::post('/adduser', 'AdminTagsController@savetag');
		Route::get('/status/{id}', 'AdminTagsController@status');
		Route::get('/delete/{id}', 'AdminTagsController@delete');
		Route::post('/active_all', 'AdminTagsController@active_all');
		Route::post('/inactive_all', 'AdminTagsController@inactive_all');
		Route::post('/delete_all', 'AdminTagsController@delete_all');
	});
	/* End: Tags Module Routes */

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