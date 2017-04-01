<?php

namespace App\Listeners;

use App\Events\GraceWebsites;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GraceWebsitesListener
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
     * @param  GraceWebsites  $event
     * @return void
     */
    public function handle(GraceWebsites $event)
    {
        foreach ($event->websites as $key => $site) {
            $site->grace_period = $site->expire_at;
            $site->expire_at = null;
            $site->save();
        }
    }
}
