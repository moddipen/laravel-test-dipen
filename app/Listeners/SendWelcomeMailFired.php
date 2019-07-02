<?php

namespace App\Listeners;

use App\Events\SendWelcomeMail;
use App\Mail\AccountCreated;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailFired
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
     * @param  SendWelcomeMail  $event
     * @return void
     */
    public function handle(SendWelcomeMail $event)
    {
        Mail::to($event->data['email'])->send(
            new AccountCreated($event->data)
        );
    }
}
