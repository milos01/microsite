<?php

namespace App\Listeners;

use App\Events\NewTokenOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TokenOrder;
use App\TokenElement;
use Auth;

class NewTokeOrderListener
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
     * @param  NewTokeOrder  $event
     * @return void
     */
    public function handle(NewTokenOrder $event)
    {
        $elements = TokenElement::where('user_id', Auth::id())->where('payed', 0)->get();

        $order = new TokenOrder();
        $order->tat = $event->request->tat;
        $order->total = $event->request->total;
        $order->save();

        foreach ($elements as $key => $element) {
           $element->order()->attach($order->id);
        }
    }
}
