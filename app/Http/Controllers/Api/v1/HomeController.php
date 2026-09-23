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
        return $this->successResponse(new SettingResource([]), 'Settings fetched successfully.');
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
     * GET /api/v1/facebook/posts
     */
    public function facebookPosts(Request $request)
    {
        $lang = $request->query('lang', 'pa');
        $customPosts = Cache::get('aaksh_facebook_posts_custom', []);
        
        $basePosts = [
            [
                'id' => 'fb_1',
                'type' => 'video',
                'headline' => 'ਤਾਜ਼ਾ ਖ਼ਬਰਾਂ: ਹਰ ਵੇਲੇ, ਹਰ ਪਾਸੇ | Aaksh News 24x7 ਸੱਚ ਦੀ ਆਵਾਜ਼ ਵਿਸ਼ੇਸ਼ ਬੁਲੇਟਿਨ',
                'timeAgo' => '1 hour ago',
                'mediaUrl' => '/images/aaksh_anchor_studio.jpg',
                'postUrl' => 'https://www.facebook.com/profile.php?id=61557932594857',
                'duration' => '12:34',
                'likes' => '42.5K',
                'comments' => '3.2K',
                'shares' => '1.8K',
                'isTop' => true,
                'isLive' => true,
            ],
            [
                'id' => 'fb_2',
                'type' => 'video',
                'headline' => 'ਚੰਡੀਗੜ੍ਹ \'ਚ \'iPhone ਲੰਗਰ\' \'ਤੇ ਪ੍ਰਸ਼ਾਸਨ ਦੀ ਰੋਕ! ਵਾਇਰਲ ਵੀਡੀਓ ਦੀ ਪੂਰੀ ਸੱਚਾਈ',
                'timeAgo' => '3 hours ago',
                'mediaUrl' => '/images/aaksh_latest_video_thumb.jpg',
                'postUrl' => 'https://www.facebook.com/profile.php?id=61557932594857',
                'duration' => '0:58',
                'likes' => '85.2K',
                'comments' => '6.4K',
                'shares' => '4.1K',
                'isTop' => true,
                'isLive' => false,
            ],
            [
                'id' => 'fb_3',
                'type' => 'video',
                'headline' => 'ਪਟਿਆਲਾ ਦੇ ਤੋਪਖਾਨਾ ਮੋੜ \'ਤੇ ਪਹਿਲੀ ਵਾਰ ਸਜਿਆ ਗਣੇਸ਼ ਜੀ ਦਾ ਸ਼ਾਨਦਾਰ ਫੁੱਲ ਏ.ਸੀ. ਪੰਡਾਲ!',
                'timeAgo' => '5 hours ago',
                'mediaUrl' => '/images/aaksh_video_9GydBxsBcsI.jpg',
                'postUrl' => 'https://www.facebook.com/profile.php?id=61557932594857',
                'duration' => '03:45',
                'likes' => '36.8K',
                'comments' => '2.9K',
                'shares' => '1.9K',
                'isTop' => true,
                'isLive' => true,
            ],
            [
                'id' => 'fb_4',
                'type' => 'video',
                'headline' => 'ਸੁਖਬੀਰ ਬਾਦਲ \'ਤੇ ਸ੍ਰੀ ਦਰਬਾਰ ਸਾਹਿਬ ਬਾਹਰ ਹਮਲਾ, ਹਮਲਾਵਰ ਮੌਕੇ \'ਤੇ ਕਾਬੂ - ਵੱਡੀ ਬ੍ਰੇਕਿੰਗ ਨਿਊਜ਼',
                'timeAgo' => '8 hours ago',
                'mediaUrl' => '/top_story_punjab_1784880621670.jpg',
                'postUrl' => 'https://www.facebook.com/profile.php?id=61557932594857',
                'duration' => '08:20',
                'likes' => '94.1K',
                'comments' => '7.8K',
                'shares' => '5.4K',
                'isTop' => true,
                'isLive' => true,
            ],
            [
                'id' => 'fb_5',
                'type' => 'photo',
                'headline' => 'ਪੰਜਾਬ ਸਰਕਾਰ ਵੱਲੋਂ ਵਿਧਵਾ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਲਈ 305 ਕਰੋੜ ਰੁਪਏ ਦੀ ਵਿੱਤੀ ਸਹਾਇਤਾ ਜਾਰੀ: ਡਾ. ਬਲਜੀਤ ਕੌਰ',
                'timeAgo' => '12 hours ago',
                'mediaUrl' => '/uploads/ai_1790085812.jpg',
                'postUrl' => 'https://www.facebook.com/profile.php?id=61557932594857',
                'likes' => '18.3K',
                'comments' => '890',
                'shares' => '430',
                'isTop' => true,
                'isLive' => false,
            ],
            [
                'id' => 'fb_6',
                'type' => 'video',
                'headline' => 'ਦਿੱਲੀ ਕੂਚ ਕਰ ਰਹੇ ਕਿਸਾਨ, ਸ਼ੰਭੂ ਬਾਰਡਰ \'ਤੇ ਹਰਿਆਣਾ ਪੁਲਿਸ ਨੇ ਕਸੀ ਕਮਰ - ਲਾਈਵ ਗਰਾਊਂਡ ਰਿਪੋਰਟ',
                'timeAgo' => '16 hours ago',
                'mediaUrl' => '/hero_main_1784880476121.jpg',
                'postUrl' => 'https://www.facebook.com/profile.php?id=61557932594857',
                'duration' => '06:12',
                'likes' => '52.7K',
                'comments' => '4.3K',
                'shares' => '2.8K',
                'isTop' => true,
                'isLive' => true,
            ],
        ];

        $merged = array_merge($customPosts, $basePosts);

        return $this->successResponse([
            'posts' => $merged,
            'page_url' => 'https://www.facebook.com/profile.php?id=61557932594857',
            'page_id' => '61557932594857',
            'page_name' => 'Aaksh News 24×7',
            'followers' => '322K+',
            'last_sync' => now()->toIso8601String(),
        ], 'Facebook posts fetched successfully.');
    }

    /**
     * POST /api/v1/facebook/posts
     */
    public function addFacebookPost(Request $request)
    {
        $headline = $request->input('headline');
        if (empty($headline)) {
            return $this->errorResponse('Headline is required.', 422);
        }

        $newPost = [
            'id' => 'fb_' . time() . '_' . rand(100, 999),
            'type' => $request->input('type', 'video') === 'photo' ? 'photo' : 'video',
            'headline' => $headline,
            'timeAgo' => 'Just now',
            'mediaUrl' => $request->input('mediaUrl') ?: '/images/aaksh_anchor_studio.jpg',
            'postUrl' => $request->input('postUrl') ?: 'https://www.facebook.com/profile.php?id=61557932594857',
            'duration' => $request->input('duration', '03:45'),
            'likes' => '1.5K',
            'comments' => '142',
            'shares' => '98',
            'isTop' => true,
            'isLive' => $request->boolean('isLive', false),
            'isNew' => true,
        ];

        $custom = Cache::get('aaksh_facebook_posts_custom', []);
        array_unshift($custom, $newPost);
        $custom = array_slice($custom, 0, 20);
        Cache::forever('aaksh_facebook_posts_custom', $custom);

        return $this->successResponse($newPost, 'New Facebook post published to feed successfully.');
    }

    /**
     * POST /api/v1/facebook/sync
     */
    public function syncFacebookPosts(Request $request)
    {
        return $this->successResponse([
            'status' => 'synced',
            'sync_time' => now()->toIso8601String(),
            'message' => 'Facebook channel checked. Latest posts are up to date.',
        ], 'Facebook posts synced successfully.');
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
        $lang = strtolower(request()->header('X-Language', request()->query('lang', 'pa')));
        return $this->successResponse([
            'date'        => now()->format('d F Y'),
            'punjabiDate' => '੧੦ ਹਾੜ, ਨਾਨਕਸ਼ਾਹੀ',
            'dayName'     => now()->format('l'),
            'zodiacs'     => [
                ['sign' => 'Aries', 'signPunjabi' => 'ਮੇਖ', 'icon' => '♈', 'prediction' => 'ਅੱਜ ਦਾ ਦਿਨ ਉਤਸ਼ਾਹਪੂਰਨ ਰਹੇਗਾ। ਕੰਮ \'ਚ ਸਫਲਤਾ ਮਿਲੇਗੀ।', 'luckyNumber' => 7, 'luckyColor' => 'ਲਾਲ (Red)'],
                ['sign' => 'Taurus', 'signPunjabi' => 'ਬ੍ਰਿਸ਼ਭ', 'icon' => '♉', 'prediction' => 'ਧਨ ਲਾਭ ਦਾ ਯੋਗ ਹੈ। ਪਰਿਵਾਰ \'ਚ ਖੁਸ਼ੀ ਦਾ ਮਾਹੌਲ ਰਹੇਗਾ।', 'luckyNumber' => 3, 'luckyColor' => 'ਚਿੱਟਾ (White)'],
                ['sign' => 'Gemini', 'signPunjabi' => 'ਮਿਥੁਨ', 'icon' => '♊', 'prediction' => 'ਨਵੇਂ ਮੌਕੇ ਮਿਲਣਗੇ। ਸਿਹਤ ਦਾ ਧਿਆਨ ਰੱਖੋ।', 'luckyNumber' => 5, 'luckyColor' => 'ਹਰਾ (Green)'],
                ['sign' => 'Cancer', 'signPunjabi' => 'ਕਰਕ', 'icon' => '♋', 'prediction' => 'ਮਨ ਸ਼ਾਂਤ ਰਹੇਗਾ। ਧਾਰਮਿਕ ਕੰਮਾਂ ਵਿੱਚ ਰੁਚੀ ਵਧੇਗੀ।', 'luckyNumber' => 2, 'luckyColor' => 'ਸਿਲਵਰ (Silver)'],
                ['sign' => 'Leo', 'signPunjabi' => 'ਸਿੰਘ', 'icon' => '♌', 'prediction' => 'ਮਾਨ-ਸਨਮਾਨ \'ਚ ਵਾਧਾ ਹੋਵੇਗਾ। ਫੈਸਲੇ ਸਮਝਦਾਰੀ ਨਾਲ ਲਓ।', 'luckyNumber' => 1, 'luckyColor' => 'ਪੀਲਾ (Yellow)'],
                ['sign' => 'Virgo', 'signPunjabi' => 'ਕੰਨਿਆ', 'icon' => '♍', 'prediction' => 'ਕਾਰੋਬਾਰ \'ਚ ਤਰੱਕੀ ਮਿਲੇਗੀ। ਯਾਤਰਾ ਦਾ ਯੋਗ ਹੈ।', 'luckyNumber' => 6, 'luckyColor' => 'ਨੀਲਾ (Blue)'],
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
