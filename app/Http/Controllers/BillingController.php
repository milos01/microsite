<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Braintree_ClientToken;
use Braintree_Transaction;
use Braintree_Customer;
use App\Events\TokenActivation;
use App\Events\NewTokenOrder;

class BillingController extends Controller
{
	/**
     * Show the billing on users profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function billing(){
    	$user = User::findorFail(Auth::id());
    	// dd($user->invoicesIncludingPending());
    	$nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
    	$totalSum = $this->totalCount($nonactivesites);
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

    private function totalCount($nonactivesites){
    	$totalSum = 0;
    	foreach ($nonactivesites as $key => $website) {
    		$totalSum += $website->theme->price;
    	}
    	return $totalSum;
    }

    public function checkout(Request $request){
    	$user = Auth::user();

    	if(!$user->braintree_id){
    		Braintree_Customer::create([
			    'firstName' => $user->first_name,
			    'lastName' => $user->last_name,
			    'email' => $user->email,
			    'phone' => $user->phone
			]);
    	}
    	$token = $request->payment_method_nonce;
    	$nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
    	$totalSum = $this->totalCount($nonactivesites);
    	$result = Braintree_Transaction::sale([
			'amount' => $totalSum,
			'paymentMethodNonce' => $token,
			'customerId' => $user->braintree_id,
			'options' => [
				'submitForSettlement' => True
			]
		]);
    	if(!$result->success){
    		dd($result->errors->deepAll());
    		return back()->with('bt_errors', $result->errors->deepAll());
    	}
    	
    	//event for site activaiton
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
    	$user = Auth::user();
    	if($user->braintree_id){
			$result = Braintree_Transaction::sale([
				'amount' => $request->total,
				'paymentMethodNonce' => $request->payment_method_nonce,
				'customerId' => $user->braintree_id,
				'options' => [
					'submitForSettlement' => True
				]
			]);
    	}
    	if(!$result->success){
    		dd($result->errors->deepAll());
    		return back()->with('bt_errors', $result->errors->deepAll());
    	}


    	event(new NewTokenOrder($request));
		event(new TokenActivation());
    	return back();
		
    }
}
