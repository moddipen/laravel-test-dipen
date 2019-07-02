<?php

namespace App\Listeners;

use App\Events\ClubDelete;
use App\Models\Club;
use App\Models\User;

class ClubDeleteFired
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
     * @param ClubDelete $event
     * @throws \Exception
     */
    public function handle(ClubDelete $event)
    {
        $user = User::with('hasClub.club')->whereHas('hasClub.club', function ($query) use ($event) {
            return $query->where('id', $event->clubId);
        })->first();
        if ($user) {
            $user->delete();
        }
        $club = Club::find($event->clubId);
        $club->delete();
    }
}
