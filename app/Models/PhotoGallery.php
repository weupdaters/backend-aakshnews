<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    protected $table = 'photo_galleries';

    protected $fillable = [
        'name',
        'image_url',
    ];
}
