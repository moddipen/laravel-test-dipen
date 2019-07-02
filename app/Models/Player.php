<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Player extends Model implements HasMedia
{
    use HasMediaTrait, LogsActivity;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(PlayerGroup::class, 'player_group_id');
    }

    /**
     * @return Player[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPlayers()
    {
        $players = Player::with('group.team.club.hasUser.user')->whereHas('group.team.club.hasUser.user', function ($query) {
            return $query->where('id', Auth::id());
        })->get();
        return $players;
    }
}
