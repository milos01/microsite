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

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	//Home routes
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/template/showEditTemplate', 'HomeController@showEditTemplate')->name('home');

	//User routes
	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::put('/deactivate', 'UserController@deactivateUser')->name('deactivate');
	Route::put('/api/update', 'UserController@updateInfo')->name('update');
	

	//Billing routes
	Route::get('/billing', 'BillingController@billing')->name('billing');
});