<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    protected $fillable = [
        'poll_id',
        'user_id',
        'ip_address',
        'option_index',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
