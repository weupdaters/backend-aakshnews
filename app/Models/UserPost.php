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
        'is_admin_post',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'is_reel',
        'media_type',
    ];

    protected $casts = [
        'is_hero' => 'boolean',
        'is_middle_stack' => 'boolean',
        'is_admin_post' => 'boolean',
        'is_reel' => 'boolean',
        'views_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
