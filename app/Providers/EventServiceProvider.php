<?php

namespace App\Providers;

use App\Events\ClubDelete;
use App\Events\SendWelcomeMail;
use App\Listeners\ClubDeleteFired;
use App\Listeners\SendWelcomeMailFired;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendWelcomeMail::class => [
            SendWelcomeMailFired::class,
        ],
        ClubDelete::class => [
          ClubDeleteFired::class,
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
