<?php

namespace App\Listeners;

use App\Events\ActivateWebsite;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Auth;

class ActivateWebsiteListener
{
    public $now;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->now = Carbon::now();
    }

    /**
     * Handle the event.
     *
     * @param  ActivateWebsite  $event
     * @return void
     */
    public function handle(ActivateWebsite $event)
    {
        echo "uso";
        $monthAhead = $this->now->addMonth();
        foreach ($event->website as $key => $site) {
            $site->active = 1;
            if($site->expire_at != '' && Auth::user()->subscribed == 1){
                $site->expire_at = $monthAhead;
            }else if($site->expire_at != null && Auth::user()->subscribed == 0){
                $site->grace_period = $monthAhead;
                $site->expire_at = null;
            }else if($site->grace_period != null && Auth::user()->subscribed == 1){
                $site->expire_at = $monthAhead;
                $site->grace_period = null;
            }else{
                 $site->grace_period = $monthAhead;
            }
            $site->save();
        }
        
    }
}
