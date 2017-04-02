<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;
use Braintree_Customer;
use Braintree_PaymentMethodNonce;
use Braintree_Transaction;

class CheckUserTrial
{
    public $now;

    public function __construct()
    {
        $this->now = Carbon::now();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $userWebsites = $user->websites()->with('theme')->get();
        foreach ($userWebsites as $key => $site) {
            if ($site->expire_at && $site->active == 1) {
                if($this->now->diffInDays($site->expire_at, false) <= 0){
                    $site->expire_at = Carbon::parse($site->expire_at)->addMonth();
                    $site->save();

                    /*
                    * Separate in job or make scheduled task
                    */
                    $customer = Braintree_Customer::find($user->braintree_id);
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
                }
                
                //event for billing
            }
        }
        

        return $next($request);
    }

    private function totalCount($nonactivesites){
        $totalSum = 0;
        foreach ($nonactivesites as $key => $website) {
            $totalSum += $website->theme->price;
        }
        return $totalSum;
    }
}
