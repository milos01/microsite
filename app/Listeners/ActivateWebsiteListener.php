<?php

namespace App\Listeners;

use App\Events\ActivateWebsite;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateWebsiteListener
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
     * @param  ActivateWebsite  $event
     * @return void
     */
    public function handle(ActivateWebsite $event)
    {
        foreach ($event->website as $key => $site) {
            $site->active = 1;
            $site->save();
        }
        
    }
}
