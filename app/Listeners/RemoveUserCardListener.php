<?php

namespace App\Listeners;

use App\Events\RemoveUserCard;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveUserCardListener
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
     * @param  RemoveUserCard  $event
     * @return void
     */
    public function handle(RemoveUserCard $event)
    {
        $event->user->braintree_id = null;
        $event->user->card_brand = null;
        $event->user->card_last_four = null;
        $event->user->save();
    }
}
