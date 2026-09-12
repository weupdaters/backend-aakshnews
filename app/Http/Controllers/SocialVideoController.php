<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocialMediaService;

class SocialVideoController extends Controller
{
    public function youtubeVideos(Request $request)
    {
        $lang = $request->query('lang', 'en');
        return response()->json(SocialMediaService::getYouTubeChannelVideos($lang));
    }

    public function facebookVideos(Request $request)
    {
        $lang = $request->query('lang', 'en');
        return response()->json(SocialMediaService::getFacebookPageVideos($lang));
    }

    public function testYt()
    {
        return response()->json(SocialMediaService::getYouTubeChannelVideos('en'));
    }
}
