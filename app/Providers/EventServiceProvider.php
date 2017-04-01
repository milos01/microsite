<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\TokenActivation' => [
            'App\Listeners\TokenActivationListener',
        ],
        'App\Events\NewTokenOrder' => [
            'App\Listeners\NewTokeOrderListener',
        ],
        'App\Events\ActivateWebsite' => [
            'App\Listeners\ActivateWebsiteListener',
        ],
        'App\Events\GraceWebsites' => [
            'App\Listeners\GraceWebsitesListener',
        ],
        'App\Events\SubscribeWebsites' => [
            'App\Listeners\SubscribeWebsitesListener',
        ],
        'App\Events\UserPaymentCreds' => [
            'App\Listeners\UserPaymentCredsListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
