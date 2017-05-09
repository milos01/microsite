<?php
namespace App\Http\Controllers\Helpers;
use App\User;
use Braintree_Transaction;
use Braintree_Customer;
use Braintree_PaymentMethodNonce;
use Braintree_PaymentMethod;


trait BraintreeHelper {

     /**
     * Braintree make sale.
     *
     * @return Braintree_Transaction
     */
     public function b3Sale(User $user, $total, $isSameSale, $hasOwnPaymentToken) {
     	if(!$isSameSale && !$hasOwnPaymentToken){
     		$b3_params = [
     		'amount' => $total,
     		'customerId' => $user->braintree_id,
     		'options' => [
     			'submitForSettlement' => True
     			]
     		]; 
     	}else{
     		if(!$hasOwnPaymentToken){
     			$customer = $this->b3FindCustomer($user);
     			$payment_method_token = $customer->paymentMethods[0]->token;
     			$nonce = $this->b3PaymentMethodNonce($payment_method_token);
     		}else{

     		}

     		$b3_params = [
     		'amount' => $total,
     		'paymentMethodNonce' => $nonce->paymentMethodNonce->nonce,
     		'customerId' => $user->braintree_id,
     		'options' => [
     			'submitForSettlement' => True
     			]
     		];
     	}
     	
     	return Braintree_Transaction::sale($b3_params);
     }

     /**
     * Braintree find customer.
     *
     * @return Braintree_Transaction
     */
     public function b3FindCustomer(User $user) {
     	return Braintree_Customer::find($user->braintree_id);
     }

     /**
     * Braintree create customer.
     *
     * @return Braintree_Transaction
     */
     public function b3CreateCustomer(User $user, $token) {
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
     	return $result;
     }

     /**
     * Braintree create *payment method nonce* for user, when user want to stay subscribed.
     *
     * @return Braintree_Transaction
     */
     public function b3PaymentMethodNonce($payment_method_token){
     	return Braintree_PaymentMethodNonce::create($payment_method_token);
     }

     /**
     * Braintree create payment method for user.
     *
     * @return Braintree_Transaction
     */
     public function b3CreatePaymentMethod(User $user, $nonce){
     	$result = Braintree_PaymentMethod::create([
     		'customerId' => $user->braintree_id,
     		'paymentMethodNonce' => $nonce,
                    // 'cardholderName' => $request->cardholder,
     		'options' => [
     			'makeDefault' => true
     		]
     		]);
     	return $result;
     }
     /**
     * Braintree remove customer.
     *
     * @return Braintree_Transaction
     */
     public function b3RemoveCustomer($customerId){
        Braintree_Customer::delete($customerId);
     }
 }