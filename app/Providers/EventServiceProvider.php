<?php

namespace App\Providers;

use App\Events\Orders\LoadDetails\LoadDetailCreatedEvent;
use App\Listeners\Orders\LoadDetails\StoreAirlineSaleFromLoadDetailListener;
use App\Listeners\Orders\LoadDetails\StoreRequiredLoadDetailsListener;
use App\Listeners\Orders\LoadDetails\UpdateEstimateStatusToApprovedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        LoadDetailCreatedEvent::class => [
            UpdateEstimateStatusToApprovedListener::class,
            StoreRequiredLoadDetailsListener::class,
            StoreAirlineSaleFromLoadDetailListener::class
        ]

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
