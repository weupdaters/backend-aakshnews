<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'site_name'    => 'AAKSH NEWS 24',
            'logo'         => url('/images/logo.png'),
            'favicon'      => url('/favicon.ico'),
            'theme'        => [
                'primary_color'   => '#dc2626',
                'secondary_color' => '#1e293b',
                'dark_mode'       => true,
            ],
            'contact'      => [
                'email'   => 'contact@aakashnews24.com',
                'phone'   => '+91 98765 43210',
                'address' => 'New Delhi, India',
            ],
            'social_links' => [
                'facebook'  => 'https://facebook.com/aakashnews24',
                'twitter'   => 'https://twitter.com/aakashnews24',
                'instagram' => 'https://instagram.com/aakashnews24',
                'youtube'   => 'https://youtube.com/@aakashnews24',
            ],
            'seo'          => [
                'default_title'       => 'AAKSH NEWS 24 — Latest Hindi & English News',
                'default_description' => 'Stay updated with live news, breaking news, sports, politics, and local coverage on AAKSH NEWS 24.',
                'meta_keywords'       => 'news, breaking news, sports, politics, live tv, video news',
            ],
            'header'       => [
                'ticker_enabled'     => true,
                'breaking_bar'       => true,
            ],
            'footer'       => [
                'copyright'          => '© 2026 AAKSH NEWS 24. All Rights Reserved.',
            ],
            'ads_config'   => [
                'enabled'            => true,
                'google_adsense_id'  => 'ca-pub-1234567890123456',
            ],
        ];
    }
}
