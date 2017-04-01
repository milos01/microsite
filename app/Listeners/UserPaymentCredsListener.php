<?php

namespace App\Listeners;

use App\Events\UserPaymentCreds;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class UserPaymentCredsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserPaymentCreds  $event
     * @return void
     */
    public function handle(UserPaymentCreds $event)
    {
        $user = Auth::user();
        $user->braintree_id = $event->customer_id;
        $user->card_brand = $event->card_brand;
        $user->card_last_four = $event->last4;
        $user->save();
    }
}
