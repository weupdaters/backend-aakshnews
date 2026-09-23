<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BreakingNews extends Model
{
    protected $fillable = [
        'title',
        'title_en',
        'title_hi',
        'title_pb',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
