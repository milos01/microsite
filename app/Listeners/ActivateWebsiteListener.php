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
        foreach ($event->website as $key => $site) {
            $site->active = 1;
            if($site->expire_at && Auth::user()->subscribed == 1){
                $site->expire_at = $this->now->addMonth();
            }else if($site->expire_at && Auth::user()->subscribed == 0){
                $site->grace_period = $this->now->addMonth();
                $site->expire_at = null;
            }else if($site->grace_period && Auth::user()->subscribed == 1){
                $site->expire_at = $this->now->addMonth();
                $site->grace_period = null;
            }else{
                 $site->expire_at = $this->now->addMonth();
            }
            $site->save();
        }
        
    }
}
