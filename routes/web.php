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
        'vendor'  => 'Your Company',
        'product' => 'Your Product',
    ]);
});

Route::get('/test', function(){
	$collection = Braintree_CreditCardVerification::search([
		// Braintree_CreditCardVerificationSearch::customerEmail()->is("ivanpredojev@gmail.com"),
		  // Braintree_CreditCardVerificationSearch::creditCardCardholderName()->is("Tom Smith"),
		  // Braintree_CreditCardVerificationSearch::creditCardExpirationDate()->is("05/2012"),
		  // Braintree_CreditCardVerificationSearch::creditCardNumber()->startsWith("4111"),
		  // Braintree_CreditCardVerificationSearch::creditCardNumber()->endsWith("1111"),
		  Braintree_CreditCardVerificationSearch::creditCardCardType()->is(Braintree_CreditCard::VISA),
		  // Braintree_CreditCardVerificationSearch::creditCardExpirationDate()->is("02/16"),
	]);
	// dd($collection);
	foreach($collection as $verification) {
    var_dump($verification->billing);
	}
});

Route::group(['middleware' => ['auth', 'userExpireTrial']], function () {
	//Paging routes
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/template/showEditTemplate', 'HomeController@showEditTemplate');
	Route::get('/new', 'HomeController@showNewSitePage')->name('new');
	Route::get('/token/payment', 'HomeController@tokenPaymentPage')->name('tokenPaymentPage');
	Route::get('/admin', 'HomeController@showAdminPage')->name('admin')->middleware('admin');

	//User routes
	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::put('/deactivate', 'UserController@deactivateUser')->name('deactivate');
	Route::put('/api/update', 'UserController@updateInfo')->name('update');
	Route::put('/api/user/mode', 'UserController@changeMode')->name('changeMode');
	Route::get('/api/user', 'UserController@getLoggedUser')->name('loggedUser');
	Route::get('/user/{id}/deactivate', 'UserController@userDeactivate')->name('deactivate2');
	Route::get('/user/{id}/activate', 'UserController@userActivate')->name('activate');
	Route::post('/api/addnewuser', 'UserController@addneuser');
	
	//Website routes
	Route::post('/api/website', 'WebsiteController@newWebsite');
	Route::get('/api/user/websites', 'WebsiteController@userSites');
	Route::get('/website/{id}/delete', 'WebsiteController@deleteWebsite')->name('deleteWebsite');

	//Billing routes
	Route::get('/billing', 'BillingController@billing')->name('billing');
	Route::get('/api/generateToken', 'BillingController@generateBraintreeToken');
	Route::post('/checkout', 'BillingController@checkout')->name('checkout');
	Route::post('/payment', 'BillingController@payment')->name('payment');
	Route::get('/cancelsub', 'BillingController@cancelSubscription')->name('cancelSubscription');
	Route::get('/renewsub', 'BillingController@renewSubscription')->name('renewSubscription');
	Route::get('/samepayment', 'BillingController@samecardPayment')->name('samecardPayment');
	Route::post('/samepaymentonetime', 'BillingController@samecardPaymentOneTime')->name('samecardPaymentOneTime');
	Route::get('/removePaymentMethod', 'BillingController@removePayment')->name('removePayment');

	//Token routes
	Route::get('/tokens', 'TokenController@showTokenPage')->name('tokens');
	Route::get('/content_elements', 'TokenController@showElementsPage')->name('elements');
	Route::post('/api/content_element', 'TokenController@saveContentElement')->name('saveElement');
	Route::post('/api/content_oreder', 'TokenController@saveContentOrder')->name('saveOrder');
	Route::get('/api/saved_elements', 'TokenController@getSavedElements');
	Route::put('/api/saved_elements/{id}', 'TokenController@updateSavedElements');
	Route::delete('/api/saved_elements/{id}', 'TokenController@removeElements');
});