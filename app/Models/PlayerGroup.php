<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class PlayerGroup extends Model
{
    use LogsActivity;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * @return PlayerGroup[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPlayerGroups()
    {
        $groups = PlayerGroup::with('team.club.hasUser.user')->whereHas('team.club.hasUser.user', function ($query) {
            return $query->where('id', Auth::id());
        })->get();
        return $groups;
    }
}
