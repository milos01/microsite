<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Braintree_ClientToken;
use Braintree_Transaction;
use Braintree_Customer;
use Braintree_PaymentMethod;
use App\Events\TokenActivation;
use App\Events\NewTokenOrder;
use App\Events\ActivateWebsite;
use App\Events\GraceWebsites;
use App\Events\UserPaymentCreds;

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
        $activeWebsites = $user->websites()->where('active', 1)->get();
    	$totalSum = $this->totalCount($nonactivesites);
    	return view('billing')->with('websites', $nonactivesites)->with('totalSum', sprintf("%.2f", $totalSum))->with('activeWebsites', $activeWebsites);
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
        $token = $request->payment_method_nonce;

    	if(!$user->braintree_id){
    		$result = Braintree_Customer::create([
			    'firstName' => $user->first_name,
			    'lastName' => $user->last_name,
			    'email' => $user->email,
			    'phone' => $user->phone,
                'paymentMethodNonce' => $token
			]);
            //save user payment creds
            event(new UserPaymentCreds($result->customer->id, $result->customer->paymentMethods[0]->cardType, $result->customer->paymentMethods[0]->last4));
    	}
        
    	
      
    	$nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
    	$totalSum = $this->totalCount($nonactivesites);
    	$result = Braintree_Transaction::sale([
			'amount' => $totalSum,
			'customerId' => $user->braintree_id,
			'options' => [
				'submitForSettlement' => True
			]
		]);
    	if(!$result->success){
    		dd($result->errors->deepAll());
    		return back()->with('bt_errors', $result->errors->deepAll());
    	}

    	if($request->subscribed == "no"){
            //new event for making grace period for new sites
            event(new GraceWebsites($nonactivesites));
        }
    	event(new ActivateWebsite($nonactivesites));
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
