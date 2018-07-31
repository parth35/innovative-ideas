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
	
	/* Start: Countries Module Routes */
	Route::group(['prefix'=>'/cities'], function(){
		Route::get('/', 'AdminCitiesController@cities');
		Route::post('/get_data', 'AdminCitiesController@get_data');
		Route::post('/get_city_data', 'AdminCitiesController@get_city_data');
		Route::get('/add', 'AdminCitiesController@add');
		Route::get('/edit/{id}', 'AdminCitiesController@edit');
		Route::post('/addUpdate', 'AdminCitiesController@savecity');
		Route::get('/status/{id}', 'AdminCitiesController@status');
		Route::get('/delete/{id}', 'AdminCitiesController@delete');
		Route::post('/active_all', 'AdminCitiesController@active_all');
		Route::post('/inactive_all', 'AdminCitiesController@inactive_all');
		Route::post('/delete_all', 'AdminCitiesController@delete_all');
	});
	/* End: Countries Module Routes */
	
	/* Start: Countries Module Routes */
	Route::group(['prefix'=>'/countries'], function(){
		Route::get('/', 'AdminCountriesController@countries');
		Route::get('/add', 'AdminCountriesController@add');
		Route::get('/edit/{id}', 'AdminCountriesController@edit');
		Route::post('/addUpdate', 'AdminCountriesController@savecountry');
		Route::get('/status/{id}', 'AdminCountriesController@status');
		Route::get('/delete/{id}', 'AdminCountriesController@delete');
		Route::post('/active_all', 'AdminCountriesController@active_all');
		Route::post('/inactive_all', 'AdminCountriesController@inactive_all');
		Route::post('/delete_all', 'AdminCountriesController@delete_all');
	});
	/* End: Countries Module Routes */

	/* Start: Countries Module Routes */
	Route::group(['prefix'=>'/gallery'], function(){
		Route::get('/', 'AdminGalleryController@list');
	});
	/* End: Countries Module Routes */

	/* Start: States Module Routes */
	Route::group(['prefix'=>'/states'], function(){
		Route::get('/', 'AdminStatesController@states');
		Route::post('/get_data', 'AdminStatesController@get_data');
		Route::get('/add', 'AdminStatesController@add');
		Route::get('/edit/{id}', 'AdminStatesController@edit');
		Route::post('/addUpdate', 'AdminStatesController@savestate');
		Route::get('/status/{id}', 'AdminStatesController@status');
		Route::get('/delete/{id}', 'AdminStatesController@delete');
		Route::post('/active_all', 'AdminStatesController@active_all');
		Route::post('/inactive_all', 'AdminStatesController@inactive_all');
		Route::post('/delete_all', 'AdminStatesController@delete_all');
	});
	/* End: States Module Routes */
	
	/* Start: Tags Module Routes */
	Route::group(['prefix'=>'/tags'], function(){
		Route::get('/', 'AdminTagsController@tags');
		Route::get('/add', 'AdminTagsController@add');
		Route::get('/edit/{id}', 'AdminTagsController@edit');
		Route::post('/addUpdate', 'AdminTagsController@savetag');
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
		Route::post('/addUpdate', 'AdminUserController@saveuser');
		Route::get('/status/{id}', 'AdminUserController@status');
		Route::get('/delete/{id}', 'AdminUserController@delete');
		Route::post('/active_all', 'AdminUserController@active_all');
		Route::post('/inactive_all', 'AdminUserController@inactive_all');
		Route::post('/delete_all', 'AdminUserController@delete_all');
	});
	/* End: User Module Routes */
});
/* End: Admin Routes */