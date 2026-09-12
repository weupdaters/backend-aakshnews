<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\AdResource;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Http\Resources\Api\v1\CricketResource;
use App\Http\Resources\Api\v1\FuelResource;
use App\Http\Resources\Api\v1\GoldResource;
use App\Http\Resources\Api\v1\MarketResource;
use App\Http\Resources\Api\v1\NewsResource;
use App\Http\Resources\Api\v1\ReelResource;
use App\Http\Resources\Api\v1\SettingResource;
use App\Http\Resources\Api\v1\VideoResource;
use App\Http\Resources\Api\v1\WeatherResource;
use App\Models\Advertisement;
use App\Models\BreakingNews;
use App\Models\Category;
use App\Models\InstagramVideo;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/home
     */
    public function index()
    {
        $homeData = Cache::remember('api_v1_home_data', 300, function () {
            $heroNews = UserPost::where('status', 'published')->where('is_hero', true)->latest()->first()
                ?? UserPost::where('status', 'published')->latest()->first();

            $breakingNews = BreakingNews::where('is_active', true)->latest()->pluck('title');
            $latestNews = UserPost::where('status', 'published')->latest()->take(10)->get();
            $trendingNews = UserPost::where('status', 'published')->orderBy('views_count', 'desc')->take(6)->get();
            $featuredCategories = Category::where('status', 'active')->take(6)->get();

            $videos = UserPost::where('status', 'published')->whereNotNull('video_url')->latest()->take(6)->get();
            $reels = InstagramVideo::latest()->take(6)->get();
            $editorPicks = UserPost::where('status', 'published')->where('is_middle_stack', true)->take(4)->get();
            $ads = Advertisement::where('status', 'active')->get();

            return [
                'hero_slider'         => $heroNews ? new NewsResource($heroNews) : null,
                'breaking_news'       => $breakingNews,
                'latest_news'         => NewsResource::collection($latestNews),
                'trending_news'       => NewsResource::collection($trendingNews),
                'featured_categories' => CategoryResource::collection($featuredCategories),
                'videos'              => VideoResource::collection($videos),
                'reels'               => ReelResource::collection($reels),
                'editor_picks'        => NewsResource::collection($editorPicks),
                'ads'                 => AdResource::collection($ads),
                'widgets'             => [
                    'weather' => new WeatherResource([]),
                    'gold'    => new GoldResource([]),
                    'fuel'    => new FuelResource([]),
                    'market'  => new MarketResource([]),
                    'cricket' => new CricketResource([]),
                ],
                'social_links'        => [
                    'facebook'  => 'https://facebook.com/aakashnews24',
                    'twitter'   => 'https://twitter.com/aakashnews24',
                    'instagram' => 'https://instagram.com/aakashnews24',
                    'youtube'   => 'https://youtube.com/@aakashnews24',
                ],
            ];
        });

        return $this->successResponse($homeData, 'Home feed fetched successfully.');
    }

    /**
     * GET /api/v1/settings
     */
    public function settings()
    {
        $settings = Cache::remember('api_v1_settings', 3600, function () {
            return new SettingResource([]);
        });

        return $this->successResponse($settings, 'Settings fetched successfully.');
    }

    /**
     * GET /api/v1/ads
     */
    public function ads()
    {
        $ads = Advertisement::where('status', 'active')->get();

        return $this->successResponse([
            'header'     => AdResource::collection($ads->take(1)),
            'sidebar'    => AdResource::collection($ads->skip(1)->take(2)),
            'footer'     => AdResource::collection($ads->skip(3)->take(1)),
            'native_ads' => AdResource::collection($ads),
            'in_feed'    => AdResource::collection($ads),
        ], 'Ads configuration fetched successfully.');
    }

    /**
     * GET /api/v1/social
     */
    public function social()
    {
        return $this->successResponse([
            'facebook'  => 'https://facebook.com/aakashnews24',
            'twitter'   => 'https://twitter.com/aakashnews24',
            'instagram' => 'https://instagram.com/aakashnews24',
            'youtube'   => 'https://youtube.com/@aakashnews24',
        ], 'Social links fetched successfully.');
    }

    /**
     * GET /api/v1/live-tv
     */
    public function liveTv()
    {
        return $this->successResponse([
            'title'       => 'AAKSH NEWS 24 Live TV',
            'stream_url'  => 'https://www.youtube.com/embed/live_stream?channel=AAKASHNEWS24',
            'is_live'     => true,
            'description' => 'Watch 24/7 Live Hindi & English News Stream',
        ], 'Live TV stream details fetched successfully.');
    }

    /**
     * GET /api/v1/weather
     */
    public function weather()
    {
        return $this->successResponse(new WeatherResource([]), 'Weather data fetched.');
    }

    /**
     * GET /api/v1/astrology
     */
    public function astrology()
    {
        return $this->successResponse([
            'horoscope' => [
                'Aries' => 'Today brings creative clarity and career advancements.',
                'Taurus' => 'Financial stability improves. Focus on personal health.',
                'Gemini' => 'Networking opens up exciting new opportunities.',
            ]
        ], 'Astrology predictions fetched.');
    }

    /**
     * GET /api/v1/gold
     */
    public function gold()
    {
        return $this->successResponse(new GoldResource([]), 'Gold & Silver rates fetched.');
    }

    /**
     * GET /api/v1/fuel
     */
    public function fuel()
    {
        return $this->successResponse(new FuelResource([]), 'Fuel prices fetched.');
    }

    /**
     * GET /api/v1/market
     */
    public function market()
    {
        return $this->successResponse(new MarketResource([]), 'Stock market indices fetched.');
    }

    /**
     * GET /api/v1/cricket
     */
    public function cricket()
    {
        return $this->successResponse(new CricketResource([]), 'Cricket scores fetched.');
    }

    /**
     * GET /api/v1/epaper
     */
    public function epaper()
    {
        return $this->successResponse([
            'edition'   => 'New Delhi Daily',
            'date'      => now()->toDateString(),
            'pdf_url'   => url('/epaper/today.pdf'),
            'pages_count' => 12,
        ], 'E-paper details fetched.');
    }
}
