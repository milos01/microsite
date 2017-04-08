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
use App\Http\Controllers\Helpers\UserHelper as Usr;

class BillingController extends Controller
{
	
    use Usr;
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

    /**
     * Checkout payment form.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request){
    	$user = Auth::user();
        $token = $request->payment_method_nonce;

        $nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
        $totalSum = $this->totalCount($nonactivesites);

        if(!$user->braintree_id){
          $result = Braintree_Customer::create([
             'firstName' => $user->first_name,
             'lastName' => $user->last_name,
             'email' => $user->email,
             'phone' => $user->phone,
             'paymentMethodNonce' => $token,
                // 'creditCard' => [
                //     'cardholderName' => $request->cardholder
                // ]
             ]);
            //save user payment creds
          event(new UserPaymentCreds($result->customer->id, $result->customer->paymentMethods[0]->cardType, $result->customer->paymentMethods[0]->last4));
      }
      if($user->card_brand and $user->card_last_four and $user->braintree_id){
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
    }

    if($user->card_brand == null and $user->card_last_four == null and $user->braintree_id){
            //save user payment creds
        $customer = Braintree_Customer::find($user->braintree_id);
        $result = Braintree_PaymentMethod::create([
            'customerId' => $user->braintree_id,
            'paymentMethodNonce' => $request->payment_method_nonce,
                // 'cardholderName' => $request->cardholder,
            'options' => [
            'makeDefault' => true
            ]
            ]);
        if($result->success){
            $resultt = Braintree_Transaction::sale([
                'amount' => $totalSum,
                'customerId' => $user->braintree_id,
                'options' => [
                'submitForSettlement' => True
                ]
                ]);
            $ct = null;
            $l4 = null;
            foreach ($resultt->transaction->creditCard as $key => $value) {
                if($key == "cardType"){
                    $ct = $value;
                }else if($key ==  "last4"){
                    $l4 = $value;
                }
            }
            event(new UserPaymentCreds($customer->id, $ct, $l4));
        }

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
       $result = null;
       if($user->braintree_id and $user->card_brand and $user->card_last_four){
         $result = Braintree_Transaction::sale([
            'amount' => $request->total,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'customerId' => $user->braintree_id,
            'options' => [
            'submitForSettlement' => True
            ]
            ]);
         if(!$result->success){
            return back()->with('bt_errors', $result->errors->deepAll());
        }
    }


    if($user->card_brand == null and $user->card_last_four == null and $user->braintree_id){
                // //save user payment creds


        $customer = Braintree_Customer::find($user->braintree_id);


        $result = Braintree_PaymentMethod::create([
            'customerId' => $user->braintree_id,
            'paymentMethodNonce' => $request->payment_method_nonce,
                    // 'cardholderName' => $request->cardholder,
            'options' => [
            'makeDefault' => true
            ]
            ]);
        if($result->success){
            $resultt = Braintree_Transaction::sale([
                'amount' => $request->total,
                'customerId' => $user->braintree_id,
                'options' => [
                'submitForSettlement' => True
                ]
                ]);

            $ct = null;
            $l4 = null;
            foreach ($resultt->transaction->creditCard as $key => $value) {
                if($key == "cardType"){
                    $ct = $value;
                }else if($key ==  "last4"){
                    $l4 = $value;
                }
            }
            event(new UserPaymentCreds($customer->id, $ct, $l4));
        }
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

    /**
     * Pay with saved payment method.
     *
     * @return \Illuminate\Http\Response
     */
    public function samecardPaymentOneTime(Request $request){
        $totalSum = $request->total;
        $user = $this->loggedUser();

        $customer = Braintree_Customer::find($user->braintree_id);
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

    /**
     * Remove saved payment method.
     *
     * @return \Illuminate\Http\Response
     */
    public function removePayment(){
        $user = $this->loggedUser();
        $user->card_brand = null;
        $user->card_last_four = null;
        $user->save();

        return back();
    }
}
