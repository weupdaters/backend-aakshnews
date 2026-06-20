<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    protected $fillable = [
        'user_id',
        'author_name',
        'title',
        'content',
        'category',
        'image_url',
        'video_url',
        'ai_status',
        'ai_feedback',
        'status',
        'is_hero',
        'is_middle_stack',
        'views_count',
        'duration',
        'title_en',
        'title_hi',
        'title_pb',
        'content_en',
        'content_hi',
        'content_pb',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
