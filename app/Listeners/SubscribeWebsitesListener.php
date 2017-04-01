<?php

namespace App\Listeners;

use App\Events\SubscribeWebsites;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeWebsitesListener
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
     * @param  SubscribeWebsites  $event
     * @return void
     */
    public function handle(SubscribeWebsites $event)
    {
        foreach ($event->websites as $key => $site) {
            $site->expire_at = $site->grace_period;
            $site->grace_period = null;
            $site->save();
        }
    }
}
