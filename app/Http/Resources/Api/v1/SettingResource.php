<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Setting;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $settings = Setting::getAllSettings();

        $logo = !empty($settings['site_logo'])
            ? (str_starts_with($settings['site_logo'], 'http') ? $settings['site_logo'] : url($settings['site_logo']))
            : null;

        $favicon = !empty($settings['site_favicon'])
            ? (str_starts_with($settings['site_favicon'], 'http') ? $settings['site_favicon'] : url($settings['site_favicon']))
            : url('/favicon.ico');

        $social = [
            'youtube'   => !empty($settings['youtube_url']) ? $settings['youtube_url'] : null,
            'facebook'  => !empty($settings['facebook_url']) ? $settings['facebook_url'] : null,
            'instagram' => !empty($settings['instagram_url']) ? $settings['instagram_url'] : null,
            'twitter'   => !empty($settings['twitter_url']) ? $settings['twitter_url'] : null,
            'whatsapp'  => !empty($settings['whatsapp_url']) ? $settings['whatsapp_url'] : null,
            'telegram'  => !empty($settings['telegram_url']) ? $settings['telegram_url'] : null,
            'linkedin'  => !empty($settings['linkedin_url']) ? $settings['linkedin_url'] : null,
        ];

        return [
            'site_name'        => $settings['site_name'] ?? 'AAKSH NEWS',
            'site_title'       => $settings['site_name'] ?? 'AAKSH NEWS',
            'tagline'          => $settings['site_tagline'] ?? 'Voice of Truth',
            'site_tagline'     => $settings['site_tagline'] ?? 'Voice of Truth',
            'logo'             => $logo,
            'site_logo'        => $logo,
            'favicon'          => $favicon,
            'site_favicon'     => $favicon,
            'meta_title'       => $settings['meta_title'] ?? 'AAKSH NEWS - Voice of Truth | Latest Punjab, India & World News',
            'meta_description' => $settings['meta_description'] ?? 'AAKSH NEWS delivers reliable, unbiased 24x7 breaking news, live TV broadcast, political analysis, sports updates, and regional reports across Punjab, India, and worldwide.',
            'meta_keywords'    => $settings['meta_keywords'] ?? 'Aaksh News, Punjab News, Breaking News, Punjabi News, Live TV, India News, Politics, Sports',
            'live_tv_url'      => $settings['live_tv_stream_url'] ?? '',
            'contact'          => [
                'email'   => $settings['contact_email'] ?? 'contact@aakshnews.com',
                'phone'   => $settings['contact_phone'] ?? '+91 98765 43210',
                'address' => $settings['contact_address'] ?? 'Sector 17, Chandigarh, Punjab 160017',
            ],
            'social_links'     => $social,
            'raw_settings'     => $settings,
        ];
    }
}
