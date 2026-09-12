<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'image',
        'color',
        'status',
    ];

    public static function ensureDefaults()
    {
        if (self::count() === 0) {
            $defaults = [
                ['name' => 'National', 'slug' => 'national', 'color' => '#3B82F6', 'status' => 'active'],
                ['name' => 'State', 'slug' => 'state', 'color' => '#10B981', 'status' => 'active'],
                ['name' => 'Politics', 'slug' => 'politics', 'color' => '#8B5CF6', 'status' => 'active'],
                ['name' => 'Sports', 'slug' => 'sports', 'color' => '#F59E0B', 'status' => 'active'],
                ['name' => 'Business', 'slug' => 'business', 'color' => '#374151', 'status' => 'active'],
                ['name' => 'Technology', 'slug' => 'technology', 'color' => '#06B6D4', 'status' => 'active'],
                ['name' => 'Entertainment', 'slug' => 'entertainment', 'color' => '#EC4899', 'status' => 'active'],
                ['name' => 'World', 'slug' => 'world', 'color' => '#14B8A6', 'status' => 'active'],
            ];
            foreach ($defaults as $cat) {
                self::create($cat);
            }
        }
    }
}
