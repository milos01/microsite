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
use Illuminate\Http\Request;
// use Braintree_PaymentMethod;

Route::get('user/invoice/{invoice}', function (Request $request, $invoiceId) {
    return $request->user()->downloadInvoice($invoiceId, [
        'vendor'  => 'Webueno',
        'product' => 'Your Product',
    ]);
});

//Test route
Route::get('/test', function(){});

Route::group(['middleware' => ['auth', 'userExpireTrial']], function () {
	//Paging routes
	Route::get('/home', 'PageController@index')->name('home');
	Route::get('/template/showEditTemplate', 'PageController@showEditTemplate');
	Route::get('/new', 'PageController@showNewSitePage')->name('new');
	Route::get('/token/payment', 'PageController@tokenPaymentPage')->name('tokenPaymentPage');
	Route::get('/admin', 'PageController@showAdminPage')->name('admin')->middleware('admin');
	Route::get('/content_elements', 'PageController@showElementsPage')->name('elements');
	Route::get('/tokens', 'PageController@showTokenPage')->name('tokens');
	Route::get('/billing', 'PageController@billing')->name('billing');

	//User routes
	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::put('/deactivate', 'UserController@deactivateUser')->name('deactivate');
	Route::put('/api/update', 'UserController@updateInfo')->name('update');
	Route::put('/api/user/mode', 'UserController@changeMode')->name('changeMode');
	Route::get('/api/user', 'UserController@getLoggedUser')->name('loggedUser');
	Route::get('/user/{id}/deactivate', 'UserController@userDeactivate')->name('deactivate2');
	Route::get('/user/{id}/activate', 'UserController@userActivate')->name('activate');
	Route::post('/api/addnewuser', 'UserController@addneuser');
	Route::get('/api/user/invoices', 'UserController@loadInvoices');
	Route::get('/api/user/websites', 'UserController@userSites');

	//Picture routes
	Route::post('/api/upload', 'PictureController@uploadPicture');
	
	//Website routes
	Route::post('/api/website', 'WebsiteController@newWebsite');
	Route::get('/website/{id}/delete', 'WebsiteController@deleteWebsite')->name('deleteWebsite');

	//Billing routes
	Route::get('/api/generateToken', 'BillingController@generateBraintreeToken');
	Route::post('/checkout', 'BillingController@checkout')->name('checkout');
	Route::post('/payment', 'BillingController@payment')->name('payment');
	Route::get('/cancelsub', 'BillingController@cancelSubscription')->name('cancelSubscription');
	Route::get('/renewsub', 'BillingController@renewSubscription')->name('renewSubscription');
	Route::get('/samepayment', 'BillingController@samecardPayment')->name('samecardPayment');
	Route::post('/samepaymentonetime', 'BillingController@samecardPaymentOneTime')->name('samecardPaymentOneTime');
	Route::get('/removePaymentMethod', 'BillingController@removePayment')->name('removePayment');

	//Token routes
	Route::post('/api/content_element', 'TokenController@saveContentElement')->name('saveElement');
	Route::post('/api/content_oreder', 'TokenController@saveContentOrder')->name('saveOrder');
	Route::get('/api/saved_elements', 'TokenController@getSavedElements');
	Route::put('/api/saved_elements/{id}', 'TokenController@updateSavedElements');
	Route::delete('/api/saved_elements/{id}', 'TokenController@removeElements');
});