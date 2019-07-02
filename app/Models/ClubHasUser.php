<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubHasUser extends Model
{
    protected $fillable = ['user_id', 'club_id'];

    protected $table='club_user';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
