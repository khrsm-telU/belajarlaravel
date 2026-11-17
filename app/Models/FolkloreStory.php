<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolkloreStory extends Model
{
    protected $table = 'folklore_stories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'synopsis',
        'origin_region',
        'marker_code',
        'max_points',
    ];
}
