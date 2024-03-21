<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id', 'match', 'win', 'lose', 'draw', 'point', 'win_goal', 'lose_goal'
    ];
}
