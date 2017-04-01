<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserPaymentCreds
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer_id;
    public $card_brand;
    public $last4;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cid, $card_brand, $last4)
    {
        $this->customer_id = $cid;
        $this->card_brand = $card_brand;
        $this->last4 = $last4;
    }
}
