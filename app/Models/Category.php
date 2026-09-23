<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'name_hi',
        'name_pb',
        'slug',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'image',
        'color',
        'icon',
        'status',
    ];

    public static function ensureDefaults()
    {
        $defaults = [
            ['name' => 'Politics', 'name_en' => 'Politics', 'name_hi' => 'राजनीति', 'name_pb' => 'ਰਾਜਨੀਤੀ', 'slug' => 'politics', 'color' => '#DC2626', 'icon' => 'vote', 'status' => 'active'],
            ['name' => 'Sports', 'name_en' => 'Sports', 'name_hi' => 'खेल', 'name_pb' => 'ਖੇਡਾਂ', 'slug' => 'sports', 'color' => '#16A34A', 'icon' => 'trophy', 'status' => 'active'],
            ['name' => 'Business', 'name_en' => 'Business', 'name_hi' => 'व्यापार', 'name_pb' => 'ਕਾਰੋਬਾਰ', 'slug' => 'business', 'color' => '#2563EB', 'icon' => 'bar-chart-2', 'status' => 'active'],
            ['name' => 'Punjab', 'name_en' => 'Punjab', 'name_hi' => 'पंजाब', 'name_pb' => 'ਪੰਜਾਬ', 'slug' => 'punjab', 'color' => '#D97706', 'icon' => 'sparkles', 'status' => 'active'],
            ['name' => 'World', 'name_en' => 'World', 'name_hi' => 'विदेश', 'name_pb' => 'ਵਿਦੇਸ਼', 'slug' => 'world', 'color' => '#0D9488', 'icon' => 'globe', 'status' => 'active'],
            ['name' => 'Entertainment', 'name_en' => 'Entertainment', 'name_hi' => 'मनोरंजन', 'name_pb' => 'ਮਨੋਰੰਜਨ', 'slug' => 'entertainment', 'color' => '#DB2777', 'icon' => 'tv', 'status' => 'active'],
            ['name' => 'Technology', 'name_en' => 'Technology', 'name_hi' => 'तकनीक', 'name_pb' => 'ਤਕਨਾਲੋਜੀ', 'slug' => 'technology', 'color' => '#7C3AED', 'icon' => 'cpu', 'status' => 'active'],
            ['name' => 'National', 'name_en' => 'National', 'name_hi' => 'राष्ट्रीय', 'name_pb' => 'ਰਾਸ਼ਟਰੀ', 'slug' => 'national', 'color' => '#EA580C', 'icon' => 'flag', 'status' => 'active'],
        ];

        foreach ($defaults as $cat) {
            $existing = self::where('slug', $cat['slug'])->first();
            if (!$existing) {
                self::create($cat);
            } else {
                // Update icon and translations if missing
                $updated = false;
                if (empty($existing->icon)) {
                    $existing->icon = $cat['icon'];
                    $updated = true;
                }
                if (empty($existing->name_pb)) {
                    $existing->name_pb = $cat['name_pb'];
                    $updated = true;
                }
                if (empty($existing->name_hi)) {
                    $existing->name_hi = $cat['name_hi'];
                    $updated = true;
                }
                if (empty($existing->name_en)) {
                    $existing->name_en = $cat['name_en'];
                    $updated = true;
                }
                if ($updated) {
                    $existing->save();
                }
            }
        }
    }
}
