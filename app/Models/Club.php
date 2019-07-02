<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Club extends Model
{
    use LogsActivity;

    /**
     * @return mixed
     */
    public function hasUser()
    {
        return $this->hasOne(ClubHasUser::class);
    }

    /**
     * @return mixed
     */
    public function authClub()
    {
        return Auth::user()->hasClub->club;
    }

    /**
     * @return Club[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getClubs()
    {
        return Club::with('hasUser.user')->get();
    }
}
