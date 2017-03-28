<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Collection;

class ActivateWebsite
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $website;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $website)
    {
        $this->website = $website;
    }


}
