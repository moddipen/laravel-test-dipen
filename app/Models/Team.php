<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{
    use LogsActivity;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    /**
     * @return Team[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTeams()
    {
        $teams = Team::with('club.hasUser.user')->whereHas('club.hasUser.user', function ($query) {
            return $query->where('id', '=', Auth::id());
        })->get();
        return $teams;
    }
}
