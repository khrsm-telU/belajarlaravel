<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryScore extends Model
{
    protected $table = 'story_scores';

    protected $fillable = [
        'session_id',
        'player_name',
        'story_id',
        'points',
        'objectives_completed',
        'duration_seconds',
    ];
}
