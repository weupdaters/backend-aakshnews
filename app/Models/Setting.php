<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * Get a setting by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::getAllSettings();
        return $all[$key] ?? $default;
    }

    /**
     * Set / update a setting value.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget('site_settings_cache');

        return $setting;
    }

    /**
     * Return all settings as key => value dictionary with fallback defaults.
     */
    public static function getAllSettings(): array
    {
        $defaults = [
            'site_name'          => 'Aaksh News 24x7',
            'site_tagline'       => 'ਸੱਚ ਦੀ ਆਵਾਜ਼',
            'site_tagline_hi'    => 'सच की आवाज',
            'site_tagline_en'    => 'Voice of Truth',
            'youtube_url'        => 'https://www.youtube.com/@AakshNews24x7',
            'facebook_url'       => 'https://facebook.com',
            'instagram_url'      => 'https://instagram.com',
            'twitter_url'        => '',
            'whatsapp_url'       => '',
            'telegram_url'       => '',
            'linkedin_url'       => '',
            'contact_email'      => 'contact@aakshnews.com',
            'contact_phone'      => '+91 98765 43210',
            'contact_address'    => 'Sector 17, Chandigarh, Punjab 160017',
            'live_tv_stream_url' => 'https://www.youtube.com/embed/live_stream?channel=UChzSKThf_4nVN2SZkhzUlng&autoplay=1',
        ];

        try {
            return Cache::remember('site_settings_cache', 3600, function () use ($defaults) {
                try {
                    $rows = self::all()->pluck('value', 'key')->toArray();
                    return array_merge($defaults, array_filter($rows, function ($v) {
                        return $v !== null;
                    }));
                } catch (\Throwable $e) {
                    return $defaults;
                }
            });
        } catch (\Throwable $e) {
            return $defaults;
        }
    }
}
