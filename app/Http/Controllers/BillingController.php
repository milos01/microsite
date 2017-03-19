<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Braintree_ClientToken;
use Braintree_Transaction;
use App\Events\TokenActivation;

class BillingController extends Controller
{
	/**
     * Show the billing on users profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function billing(){
    	$user = User::findorFail(Auth::id());
    	$nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
    	$totalSum = 0;
    	foreach ($nonactivesites as $key => $website) {
    		$totalSum += $website->theme->price;
    	}
    	// $invoices = $user->invoices();
    	return view('billing')->with('websites', $nonactivesites)->with('totalSum', sprintf("%.2f", $totalSum));
    }

    /**
     * Generate braintree client token.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateBraintreeToken(Request $request){
    	return response()->json([
		    'token' => Braintree_ClientToken::generate(),
		]);
    }

    public function checkout(Request $request){
    	// dd($request->all());
    	$token = $request->get('payment_method_nonce');
    	$user = Auth::user();
    	$user->newSubscription('main', '9qk6')->create($token);
    	return back();

    }

    public function cancelSubscription(){
    	$user = Auth::user();
    	$user->subscription('main')->cancelNow();
    	return back();
    }

    public function renewSubscription(){
    	$user = Auth::user();
    	$user->subscription('main')->resume();
    	return back();
    }

    public function payment(Request $request){

    	$result = Braintree_Transaction::sale([
			'amount' => '10.00',
			'paymentMethodNonce' => $request->payment_method_nonce,
			'options' => [
				'submitForSettlement' => True
			]
		]);
    	if(sizeof($result->errors->deepAll()) == 0){
    		return back()->with('bt_errors', $result->errors->deepAll());
    	}
		event(new TokenActivation());
    	return back();
		
    }
}
