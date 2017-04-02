<?php

namespace App\Listeners;

use App\Events\DeactivateWebsites;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeactivateWebsitesListener
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
     * @param  DeactivateWebsites  $event
     * @return void
     */
    public function handle(DeactivateWebsites $event)
    {
        foreach ($event->websites as $key => $site) {
            $site->active = 0;
            $site->save();
        }
    }
}
