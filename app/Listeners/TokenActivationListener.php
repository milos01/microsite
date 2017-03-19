<?php

namespace App\Listeners;

use App\Events\TokenActivation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TokenElement;
use Auth;

class TokenActivationListener
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
     * @param  TokenActivation  $event
     * @return void
     */
    public function handle(TokenActivation $event)
    {
        $elements = TokenElement::where('user_id', Auth::id())->where('payed', 0)->get();
        foreach ($elements as $key => $element) {
            $element->payed = 1;
            $element->save();
        }
    }
}
