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


Route::group(['middleware' => ['auth', 'userExpireTrial']], function () {
	//Paging routes
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/template/showEditTemplate', 'HomeController@showEditTemplate');
	Route::get('/new', 'HomeController@showNewSitePage')->name('new');
	Route::get('/token/payment', 'HomeController@tokenPaymentPage')->name('tokenPaymentPage');

	//User routes
	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::put('/deactivate', 'UserController@deactivateUser')->name('deactivate');
	Route::put('/api/update', 'UserController@updateInfo')->name('update');
	
	//Website routes
	Route::post('/api/website', 'WebsiteController@newWebsite');
	Route::get('/api/user/websites', 'WebsiteController@userSites');

	//Billing routes
	Route::get('/billing', 'BillingController@billing')->name('billing');
	Route::get('/api/generateToken', 'BillingController@generateBraintreeToken');
	Route::post('/checkout', 'BillingController@checkout')->name('checkout');
	Route::post('/payment', 'BillingController@payment')->name('payment');
	Route::get('/cancelsub', 'BillingController@cancelSubscription')->name('cancelSubscription');
	Route::get('/renewsub', 'BillingController@renewSubscription')->name('renewSubscription');

	//Token routes
	Route::get('/tokens', 'TokenController@showTokenPage')->name('tokens');
	Route::get('/content_elements', 'TokenController@showElementsPage')->name('elements');
	Route::post('/api/content_element', 'TokenController@saveContentElement')->name('saveElement');
	Route::post('/api/content_oreder', 'TokenController@saveContentOrder')->name('saveOrder');
	Route::get('/api/saved_elements', 'TokenController@getSavedElements');
	Route::put('/api/saved_elements/{id}', 'TokenController@updateSavedElements');
	Route::delete('/api/saved_elements/{id}', 'TokenController@removeElements');
});