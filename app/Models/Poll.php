<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'question',
        'options',
        'votes',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'votes'   => 'array',
        'is_active' => 'boolean',
    ];

    public function userVotes()
    {
        return $this->hasMany(PollVote::class);
    }
}
