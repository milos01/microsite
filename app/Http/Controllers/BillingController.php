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
use App\Http\Controllers\Helpers\BraintreeHelper as Brain3;

class BillingController extends Controller
{
	
    use Usr;
    use Brain3;
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
     * CPayment on billing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request){
    	$user = $this->loggedUser();
        $token = $request->payment_method_nonce;
        $nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
        $totalSum = $this->totalCount($nonactivesites);

        

        if(!$user->braintree_id){
          $result = $this->b3CreateCustomer($user, $token);

          event(new UserPaymentCreds($result->customer->id, $result->customer->paymentMethods[0]->cardType, $result->customer->paymentMethods[0]->last4));
        }
        if($user->card_brand and $user->card_last_four and $user->braintree_id){
            $result = $this->b3Sale($user, $totalSum, false, false);
            
            if(!$result->success){
                return back()->with('bt_errors', $result->errors->deepAll());
            }
        }

        if($user->card_brand == null and $user->card_last_four == null and $user->braintree_id){
            $result = $this->b3CreatePaymentMethod($user, $token);
            
            if($result->success){
                $saleResult = $this->b3Sale($user, $totalSum, false, false);
                $this->updateUserCardCreds($saleResult);
            }
        }

        if($request->subscribed == "no"){
            event(new GraceWebsites($nonactivesites));
        }
        event(new ActivateWebsite($nonactivesites));
        return back();
    }
    
     /**
     * Payment on token page.
     *
     * @return Void
     */
    public function payment(Request $request){
        $user = $this->loggedUser();
        $totalSum = $request->total;
        $nonce = $request->payment_method_nonce;
        $result = null;
        if($user->braintree_id and $user->card_brand and $user->card_last_four){
            $result = $this->b3Sale($user, $totalSum, true, $nonce);
         
            if(!$result->success){
                return back()->with('bt_errors', $result->errors->deepAll());
            }
        }

        if($user->card_brand == null and $user->card_last_four == null and $user->braintree_id){
            $customer = Braintree_Customer::find($user->braintree_id);
            $result = $this->b3CreatePaymentMethod($user, $nonces);

            if($result->success){
                $saleResult = $this->b3Sale($user, $totalSum, false, false);
                $this->updateUserCardCreds($saleResult);
            }
        }
        event(new NewTokenOrder($request));
        event(new TokenActivation());
        return back();
    }

     /**
     * Update user card credential after adding new payment method.
     *
     * @return Void
     */
    private function updateUserCardCreds($saleResult){
        $ct = null;
        $l4 = null;
        foreach ($saleResult->transaction->creditCard as $key => $value) {
            if($key == "cardType"){
                $ct = $value;
            }else if($key ==  "last4"){
                $l4 = $value;
            }
        }

        $customer = $this->b3FindCustomer($this->loggedUser());
        event(new UserPaymentCreds($customer->id, $ct, $l4));
    }

     /**
     * Pay with saved payment method on billing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function samecardPayment(){
        $user = $this->loggedUser();
        $nonactivesites = $user->websites()->with('theme')->where('active', 0)->get();
        $totalSum = $this->totalCount($nonactivesites);
        
        $result = $this->b3Sale($user, $totalSum, true, false);
        
        if(!$result->success){
            return back()->with('bt_errors', $result->errors->deepAll());
        }

        if($user->subscribed == 0){
            event(new GraceWebsites($nonactivesites));
        }
        event(new ActivateWebsite($nonactivesites));
        return back();
    }

    /**
     * Pay with saved payment method on token page.
     *
     * @return \Illuminate\Http\Response
     */
    public function samecardPaymentOneTime(Request $request){
        $totalSum = $request->total;
        $user = $this->loggedUser();

        $result = $this->b3Sale($user, $totalSum, true, false);

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

    /**
     * Total count of inactive websites.
     *
     * @return \Illuminate\Http\Response
     */
    private function totalCount($nonactivesites){
        $totalSum = 0;
        foreach ($nonactivesites as $key => $website) {
            $totalSum += $website->theme->price;
        }
        return $totalSum;
    }

}
