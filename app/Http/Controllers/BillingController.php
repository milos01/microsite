<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Braintree_ClientToken;
use Braintree_Transaction;
use Braintree_Customer;
use Braintree_PaymentMethodNonce;
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

    	$nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
        $activeWebsites = $user->websites()->where('active', 1)->get();
    	$totalSum = $this->totalCount($nonactivesites);
    	return view('billing')->with('websites', $nonactivesites)->with('totalSum', sprintf("%.2f", $totalSum))->with('activeWebsites', $activeWebsites)->with('invoices', $user->invoicesIncludingPending());
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

        if($user->card_brand == null and $user->card_last_four == null and $user->braintree_id){
            //save user payment creds
            $result = Braintree_Customer::find($user->braintree_id);
            event(new UserPaymentCreds($result->id, $result->paymentMethods[0]->cardType, $result->paymentMethods[0]->last4));
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
    		return back()->with('bt_errors', $result->errors->deepAll());
    	}


    	event(new NewTokenOrder($request));
		event(new TokenActivation());
    	return back();
		
    }

    public function samecardPayment(){
        $user = Auth::user();
        $customer = Braintree_Customer::find(Auth::user()->braintree_id);
        $payment_method_token = $customer->paymentMethods[0]->token;
        $nonce = Braintree_PaymentMethodNonce::create($payment_method_token);
    
        $nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
        $totalSum = $this->totalCount($nonactivesites);
        $result = Braintree_Transaction::sale([
                'amount' => $totalSum,
                'paymentMethodNonce' => $nonce->paymentMethodNonce->nonce,
                'customerId' => $user->braintree_id,
                'options' => [
                    'submitForSettlement' => True
                ]
        ]);
        if(!$result->success){
            return back()->with('bt_errors', $result->errors->deepAll());
        }

        if($user->subscribed == 0){
            //new event for making grace period for new sites
            event(new GraceWebsites($nonactivesites));
        }
        event(new ActivateWebsite($nonactivesites));
        return back();
    }

    public function samecardPaymentOneTime(Request $request){
        $totalSum = $request->total;
        $user = Auth::user();

        $customer = Braintree_Customer::find(Auth::user()->braintree_id);
        $payment_method_token = $customer->paymentMethods[0]->token;
        $nonce = Braintree_PaymentMethodNonce::create($payment_method_token);
    
        $result = Braintree_Transaction::sale([
                'amount' => $totalSum,
                'paymentMethodNonce' => $nonce->paymentMethodNonce->nonce,
                'customerId' => $user->braintree_id,
                'options' => [
                    'submitForSettlement' => True
                ]
        ]);
        if(!$result->success){
            return back()->with('bt_errors', $result->errors->deepAll());
        }

        event(new NewTokenOrder($request));
        event(new TokenActivation());
        return back();
    }

    public function removePayment(){
        $user = Auth::user();
        $user->card_brand = null;
        $user->card_last_four = null;
        $user->save();

        return back();
    }
}
