<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SocialMediaService
{
    public static function getYouTubeChannelVideos($lang)
    {
        $apiKey = config('services.youtube.api_key');
        $channelId = config('services.youtube.channel_id', 'UChzSKThf_4nVN2SZkhzUlng');

        if (empty($channelId)) {
            return [];
        }

        $cacheKey = 'youtube_videos_channel_' . $channelId . '_' . $lang;
        try {
            return Cache::remember($cacheKey, 600, function () use ($apiKey, $channelId, $lang) {
            try {
                if (!empty($apiKey)) {
                    $playlistId = $channelId;
                    if (substr($channelId, 0, 2) === 'UC') {
                        $playlistId = 'UU' . substr($channelId, 2);
                    }

                    $url = "https://www.googleapis.com/youtube/v3/playlistItems?key=" . urlencode($apiKey) . "&playlistId=" . urlencode($playlistId) . "&part=snippet&maxResults=12";

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 8);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                    curl_setopt($ch, CURLOPT_REFERER, request()->getSchemeAndHttpHost() ?: config('app.url', 'http://localhost'));
                    $response = curl_exec($ch);
                    curl_close($ch);

                    if ($response) {
                        $data = json_decode($response, true);
                        if (isset($data['items']) && !empty($data['items'])) {
                            $videos = [];
                            foreach ($data['items'] as $item) {
                                $snippet = $item['snippet'] ?? [];
                                $resourceId = $snippet['resourceId'] ?? [];
                                $videoId = $resourceId['videoId'] ?? '';
                                if (empty($videoId)) continue;

                                $title = $snippet['title'] ?? 'YouTube Video';
                                $publishedAt = $snippet['publishedAt'] ?? '';
                                $timeStr = !empty($publishedAt) ? Carbon::parse($publishedAt)->diffForHumans() : 'Recently';

                                $thumbUrl = "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
                                if (isset($snippet['thumbnails']['maxres']['url'])) {
                                    $thumbUrl = $snippet['thumbnails']['maxres']['url'];
                                } elseif (isset($snippet['thumbnails']['high']['url'])) {
                                    $thumbUrl = $snippet['thumbnails']['high']['url'];
                                } elseif (isset($snippet['thumbnails']['medium']['url'])) {
                                    $thumbUrl = $snippet['thumbnails']['medium']['url'];
                                }

                                $videos[] = [
                                    'id'           => $videoId,
                                    'title'        => $title,
                                    'time'         => $timeStr,
                                    'publishedAt'  => $timeStr,
                                    'views'        => 'YouTube',
                                    'duration'     => 'Video',
                                    'image'        => $thumbUrl,
                                    'thumbnailUrl' => $thumbUrl,
                                    'embed_url'    => "https://www.youtube.com/embed/" . $videoId . "?autoplay=1",
                                    'embedUrl'     => "https://www.youtube.com/embed/" . $videoId . "?autoplay=1",
                                    'url'          => "https://www.youtube.com/watch?v=" . $videoId,
                                    'videoUrl'     => "https://www.youtube.com/watch?v=" . $videoId,
                                    'category'     => TranslationService::translateCategory("Breaking News", $lang)
                                ];
                            }
                            if (!empty($videos)) {
                                return $videos;
                            }
                        }
                    }
                }

                // Automatic Keyless Live YouTube RSS Feed
                $url = "https://www.youtube.com/feeds/videos.xml?channel_id=" . urlencode($channelId);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 8);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $xmlString = curl_exec($ch);
                curl_close($ch);

                if ($xmlString) {
                    preg_match_all('/<entry>(.*?)<\/entry>/s', $xmlString, $entries);
                    if (isset($entries[1]) && !empty($entries[1])) {
                        $videos = [];
                        foreach ($entries[1] as $entry) {
                            preg_match('/<yt:videoId>(.*?)<\/yt:videoId>/', $entry, $vidMatch);
                            preg_match('/<title>(.*?)<\/title>/', $entry, $titleMatch);
                            preg_match('/<published>(.*?)<\/published>/', $entry, $pubMatch);
                            preg_match('/<media:thumbnail[^>]+url=["\'](.*?)["\']/', $entry, $thumbMatch);
                            preg_match('/<media:statistics[^>]+views=["\'](\d+)["\']/', $entry, $viewMatch);

                            $videoId = $vidMatch[1] ?? '';
                            if (empty($videoId)) continue;

                            $title = html_entity_decode($titleMatch[1] ?? 'YouTube Video', ENT_QUOTES, 'UTF-8');
                            $publishedAt = $pubMatch[1] ?? '';
                            $timeStr = !empty($publishedAt) ? Carbon::parse($publishedAt)->diffForHumans() : 'Recently';
                            $thumbUrl = $thumbMatch[1] ?? ("https://i.ytimg.com/vi/" . $videoId . "/hqdefault.jpg");

                            $viewsCount = isset($viewMatch[1]) ? (int) $viewMatch[1] : 0;
                            $viewsStr = $viewsCount >= 1000 ? (number_format($viewsCount / 1000, 1) . 'K Views') : ($viewsCount > 0 ? ($viewsCount . ' Views') : 'New Video');

                            $videos[] = [
                                'id'           => $videoId,
                                'title'        => $title,
                                'time'         => $timeStr,
                                'publishedAt'  => $timeStr,
                                'views'        => $viewsStr,
                                'duration'     => 'Video',
                                'image'        => $thumbUrl,
                                'thumbnailUrl' => $thumbUrl,
                                'embed_url'    => "https://www.youtube.com/embed/" . $videoId . "?autoplay=1",
                                'embedUrl'     => "https://www.youtube.com/embed/" . $videoId . "?autoplay=1",
                                'url'          => "https://www.youtube.com/watch?v=" . $videoId,
                                'videoUrl'     => "https://www.youtube.com/watch?v=" . $videoId,
                                'category'     => TranslationService::translateCategory("Breaking News", $lang)
                            ];
                        }
                        if (!empty($videos)) {
                            return $videos;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore
            }
            return self::getAakshChannelVideos($lang);
        });
        } catch (\Throwable $e) {
            return self::getAakshChannelVideos($lang);
        }
    }

    public static function getAakshChannelVideos($lang = 'pa')
    {
        return [
            [
                'id'           => '9GydBxsBcsI',
                'title'        => 'ਪਟਿਆਲਾ ਦੇ ਟੋਪਖਾਨਾ ਮੋੜ ’ਤੇ ਪਹਿਲੀ ਵਾਰ ਸਜਿਆ ਗਣੇਸ਼ ਜੀ ਦਾ ਸ਼ਾਨਦਾਰ ਫੁੱਲ ਏ.ਸੀ. ਪੰਡਾਲ! #Patiala',
                'duration'     => '4:03',
                'views'        => '1.8K Views',
                'time'         => '5h ago',
                'publishedAt'  => '5h ago',
                'image'        => 'https://i.ytimg.com/vi/9GydBxsBcsI/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/9GydBxsBcsI/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=9GydBxsBcsI',
                'videoUrl'     => 'https://www.youtube.com/watch?v=9GydBxsBcsI',
                'embed_url'    => 'https://www.youtube.com/embed/9GydBxsBcsI?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/9GydBxsBcsI?autoplay=1',
                'category'     => 'ਪਟਿਆਲਾ',
            ],
            [
                'id'           => '-qSLQ5V9Mn4',
                'title'        => 'ਪੰਜਾਬ ਦੀਆਂ ਸੜਕਾਂ ’ਤੇ ਸੁਰੱਖਿਆ ਦੀ ਨਵੀਂ ਪਹਿਲ! Sadak Suraksha Force',
                'duration'     => '6:01',
                'views'        => '2.4K Views',
                'time'         => '1d ago',
                'publishedAt'  => '1d ago',
                'image'        => 'https://i.ytimg.com/vi/-qSLQ5V9Mn4/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/-qSLQ5V9Mn4/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=-qSLQ5V9Mn4',
                'videoUrl'     => 'https://www.youtube.com/watch?v=-qSLQ5V9Mn4',
                'embed_url'    => 'https://www.youtube.com/embed/-qSLQ5V9Mn4?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/-qSLQ5V9Mn4?autoplay=1',
                'category'     => 'ਪੰਜਾਬ',
            ],
            [
                'id'           => '_Lx4aiiERWc',
                'title'        => 'ਖੇਡਾਂ ਨੂੰ ਮਿਲੀ ਨਵੀਂ ਰਫ਼ਤਾਰ! ਪੰਜਾਬ ਸਰਕਾਰ ਦਾ Sports ’ਤੇ ਖਾਸ ਫੋਕਸ #PunjabSports',
                'duration'     => '4:53',
                'views'        => '3.1K Views',
                'time'         => '2d ago',
                'publishedAt'  => '2d ago',
                'image'        => 'https://i.ytimg.com/vi/_Lx4aiiERWc/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/_Lx4aiiERWc/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=_Lx4aiiERWc',
                'videoUrl'     => 'https://www.youtube.com/watch?v=_Lx4aiiERWc',
                'embed_url'    => 'https://www.youtube.com/embed/_Lx4aiiERWc?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/_Lx4aiiERWc?autoplay=1',
                'category'     => 'ਖੇਡਾਂ',
            ],
            [
                'id'           => 'Wcq4IGNr1Z0',
                'title'        => 'ਪੰਜਾਬ ’ਚ ਸਿਹਤ ਸਹੂਲਤਾਂ ਨੂੰ ਮਿਲੀ ਨਵੀਂ ਰਫ਼ਤਾਰ! ਮੁਹੱਲਾ ਕਲੀਨਿਕਾਂ ਦਾ ਫਾਇਦਾ #PunjabHealth',
                'duration'     => '4:36',
                'views'        => '4.5K Views',
                'time'         => '3d ago',
                'publishedAt'  => '3d ago',
                'image'        => 'https://i.ytimg.com/vi/Wcq4IGNr1Z0/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/Wcq4IGNr1Z0/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=Wcq4IGNr1Z0',
                'videoUrl'     => 'https://www.youtube.com/watch?v=Wcq4IGNr1Z0',
                'embed_url'    => 'https://www.youtube.com/embed/Wcq4IGNr1Z0?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/Wcq4IGNr1Z0?autoplay=1',
                'category'     => 'ਸਿਹਤ',
            ],
            [
                'id'           => 'yHhO1mAnGjk',
                'title'        => 'ਹਮਲੇ ਤੋਂ ਬਾਅਦ ਗੁੱਸੇ ’ਚ Ravneet Bittu! ਪਹਿਲੀ ਵਾਰ ਖੁੱਲ੍ਹ ਕੇ ਬੋਲੇ | Attack Update',
                'duration'     => '15:07',
                'views'        => '12.8K Views',
                'time'         => '4d ago',
                'publishedAt'  => '4d ago',
                'image'        => 'https://i.ytimg.com/vi/yHhO1mAnGjk/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/yHhO1mAnGjk/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=yHhO1mAnGjk',
                'videoUrl'     => 'https://www.youtube.com/watch?v=yHhO1mAnGjk',
                'embed_url'    => 'https://www.youtube.com/embed/yHhO1mAnGjk?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/yHhO1mAnGjk?autoplay=1',
                'category'     => 'ਸਿਆਸਤ',
            ],
            [
                'id'           => 'xAbQI08-lpM',
                'title'        => 'ਪੰਜਾਬ ’ਚ ਰੇਲ ਰੋਕੋ ਅੰਦੋਲਨ ਸ਼ੁਰੂ! ਪਟੜੀਆਂ ’ਤੇ ਬੈਠੇ ਕਿਸਾਨ',
                'duration'     => '3:59',
                'views'        => '9.2K Views',
                'time'         => '5d ago',
                'publishedAt'  => '5d ago',
                'image'        => 'https://i.ytimg.com/vi/xAbQI08-lpM/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/xAbQI08-lpM/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=xAbQI08-lpM',
                'videoUrl'     => 'https://www.youtube.com/watch?v=xAbQI08-lpM',
                'embed_url'    => 'https://www.youtube.com/embed/xAbQI08-lpM?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/xAbQI08-lpM?autoplay=1',
                'category'     => 'ਕਿਸਾਨ',
            ],
            [
                'id'           => 'mA_lNdDvGKc',
                'title'        => 'ਪੰਜਾਬ ਦੀ Health Facility ਹੋਈ ਮਜ਼ਬੂਤ! ਲੋਕਾਂ ਲਈ ਸਿਹਤ ਸੇਵਾਵਾਂ ’ਤੇ ਫੋਕਸ',
                'duration'     => '7:17',
                'views'        => '5.6K Views',
                'time'         => '6d ago',
                'publishedAt'  => '6d ago',
                'image'        => 'https://i.ytimg.com/vi/mA_lNdDvGKc/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/mA_lNdDvGKc/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=mA_lNdDvGKc',
                'videoUrl'     => 'https://www.youtube.com/watch?v=mA_lNdDvGKc',
                'embed_url'    => 'https://www.youtube.com/embed/mA_lNdDvGKc?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/mA_lNdDvGKc?autoplay=1',
                'category'     => 'ਵਿਕਾਸ',
            ],
            [
                'id'           => 'cpn5b_RFNgM',
                'title'        => 'DA ਦੇ ਪੈਸੇ ਕਦੋਂ ਮਿਲਣਗੇ? ਪੰਜਾਬ ਦੀ ਸਿਆਸਤ ’ਤੇ ਵੀ ਖੁੱਲ੍ਹ ਕੇ ਗੱਲ! #podcast',
                'duration'     => '2:17',
                'views'        => '7.4K Views',
                'time'         => '1w ago',
                'publishedAt'  => '1w ago',
                'image'        => 'https://i.ytimg.com/vi/cpn5b_RFNgM/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/cpn5b_RFNgM/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=cpn5b_RFNgM',
                'videoUrl'     => 'https://www.youtube.com/watch?v=cpn5b_RFNgM',
                'embed_url'    => 'https://www.youtube.com/embed/cpn5b_RFNgM?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/cpn5b_RFNgM?autoplay=1',
                'category'     => 'ਪੌਡਕਾਸਟ',
            ],
            [
                'id'           => 'a0Ocpi05KMY',
                'title'        => 'ਨਸ਼ਾ ਮੁਕਤ ਪੰਜਾਬ ਯਾਤਰਾ ਦਾ ਕਾਊਂਟਡਾਊਨ ਸ਼ੁਰੂ! 4 ਦਿਨ ਬਾਅਦ ਵੱਡਾ ਐਕਸ਼ਨ',
                'duration'     => '3:16',
                'views'        => '6.1K Views',
                'time'         => '1w ago',
                'publishedAt'  => '1w ago',
                'image'        => 'https://i.ytimg.com/vi/a0Ocpi05KMY/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/a0Ocpi05KMY/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=a0Ocpi05KMY',
                'videoUrl'     => 'https://www.youtube.com/watch?v=a0Ocpi05KMY',
                'embed_url'    => 'https://www.youtube.com/embed/a0Ocpi05KMY?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/a0Ocpi05KMY?autoplay=1',
                'category'     => 'ਮੁਹਿੰਮ',
            ],
            [
                'id'           => '-KbZyTnbCRE',
                'title'        => 'ਸੜਕਾਂ ਦੇ ਨਵੀਨੀਕਰਨ ਨਾਲ ਬਦਲੇਗੀ ਪੰਜਾਬ ਦੀ ਤਸਵੀਰ! #PunjabDevelopment',
                'duration'     => '4:04',
                'views'        => '4.2K Views',
                'time'         => '1w ago',
                'publishedAt'  => '1w ago',
                'image'        => 'https://i.ytimg.com/vi/-KbZyTnbCRE/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/-KbZyTnbCRE/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=-KbZyTnbCRE',
                'videoUrl'     => 'https://www.youtube.com/watch?v=-KbZyTnbCRE',
                'embed_url'    => 'https://www.youtube.com/embed/-KbZyTnbCRE?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/-KbZyTnbCRE?autoplay=1',
                'category'     => 'ਵਿਕਾਸ',
            ],
            [
                'id'           => 'bkiJGqiH3hA',
                'title'        => 'ਕੀ Money Problem ਦਾ ਵੀ Vastu ਨਾਲ ਕੋਈ Connection ਹੋ ਸਕਦਾ ਹੈ?',
                'duration'     => '33:16',
                'views'        => '8.9K Views',
                'time'         => '2w ago',
                'publishedAt'  => '2w ago',
                'image'        => 'https://i.ytimg.com/vi/bkiJGqiH3hA/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/bkiJGqiH3hA/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=bkiJGqiH3hA',
                'videoUrl'     => 'https://www.youtube.com/watch?v=bkiJGqiH3hA',
                'embed_url'    => 'https://www.youtube.com/embed/bkiJGqiH3hA?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/bkiJGqiH3hA?autoplay=1',
                'category'     => 'ਵਾਸਤੂ',
            ],
            [
                'id'           => 'zgZiKy2pLXw',
                'title'        => 'ਸੜਕਾਂ ਦੇ ਨਵੀਨੀਕਰਨ ਲਈ ਪੰਜਾਬ ਸਰਕਾਰ ਦੀ ਵੱਡੀ ਪਹਿਲ!',
                'duration'     => '4:48',
                'views'        => '3.7K Views',
                'time'         => '2w ago',
                'publishedAt'  => '2w ago',
                'image'        => 'https://i.ytimg.com/vi/zgZiKy2pLXw/hq720.jpg',
                'thumbnailUrl' => 'https://i.ytimg.com/vi/zgZiKy2pLXw/hq720.jpg',
                'url'          => 'https://www.youtube.com/watch?v=zgZiKy2pLXw',
                'videoUrl'     => 'https://www.youtube.com/watch?v=zgZiKy2pLXw',
                'embed_url'    => 'https://www.youtube.com/embed/zgZiKy2pLXw?autoplay=1',
                'embedUrl'     => 'https://www.youtube.com/embed/zgZiKy2pLXw?autoplay=1',
                'category'     => 'ਪੰਜਾਬ',
            ],
        ];
    }

    public static function getFacebookMockVideos($lang)
    {
        return [
            [
                'id' => 'fb_mock_1',
                'title' => $lang === 'en' ? 'Aaksh News 24x7 Live Coverage: Special Ground Report' : ($lang === 'pb' ? 'ਆਕਸ਼ ਨਿਊਜ਼ 24x7 ਲਾਈਵ ਕਵਰੇਜ: ਵਿਸ਼ੇਸ਼ ਜ਼ਮੀਨੀ ਰਿਪੋਰਟ' : 'आकश न्यूज़ 24x7 लाइव: ग्राउंड रिपोर्ट'),
                'time' => '1 hour ago',
                'duration' => '05:32',
                'image' => '/images/hero_india_gate.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("News", $lang)
            ],
            [
                'id' => 'fb_mock_2',
                'title' => $lang === 'en' ? 'Exclusive Interview: Key Political Developments & Analysis' : ($lang === 'pb' ? 'ਵਿਸ਼ੇਸ਼ ਇੰਟਰਵਿਊ: ਮੁੱਖ ਰਾਜਨੀਤਿਕ ਘਟਨਾਵਾਂ ਅਤੇ ਵਿਸ਼ਲੇਸ਼ਣ' : 'विशेष साक्षात्कार: प्रमुख राजनीतिक घटनाक्रम और विश्लेषण'),
                'time' => '3 hours ago',
                'duration' => '10:15',
                'image' => '/images/parliament.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("Politics", $lang)
            ],
            [
                'id' => 'fb_mock_3',
                'title' => $lang === 'en' ? 'Ground Reality: Impact of Rain and Weather in Metro Cities' : ($lang === 'pb' ? 'ਜ਼ਮੀਨੀ ਹਕੀਕਤ: ਮਹਾਨਗਰਾਂ ਵਿੱਚ ਮੀਂਹ ਅਤੇ ਮੌਸਮ ਦਾ ਪ੍ਰਭਾਵ' : 'जमीनी हकीकत: मेट्रो शहरों में बारिश और मौसम का प्रभाव'),
                'time' => '5 hours ago',
                'duration' => '03:45',
                'image' => '/images/video_delhi_rain.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("National", $lang)
            ],
            [
                'id' => 'fb_mock_4',
                'title' => $lang === 'en' ? 'Sports Round-up: India\'s Major Win & Post-Match Discussion' : ($lang === 'pb' ? 'ਖੇਡਾਂ ਦਾ ਦੌਰ: ਭਾਰਤ ਦੀ ਵੱਡੀ ਜਿੱਤ ਅਤੇ ਮੈਚ ਤੋਂ ਬਾਅਦ ਦੀ ਚਰਚਾ' : 'स्पोर्ट्स राउंड-अप: भारत की बड़ी जीत और मैच के बाद चर्चा'),
                'time' => '8 hours ago',
                'duration' => '07:20',
                'image' => '/images/video_cricket.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("Sports", $lang)
            ],
            [
                'id' => 'fb_mock_5',
                'title' => $lang === 'en' ? 'Tech Talk: New Gadgets & Artificial Intelligence Innovations' : ($lang === 'pb' ? 'ਟੈਕ ਟਾਕ: ਨਵੇਂ ਗੈਜੇਟਸ ਅਤੇ ਆਰਟੀਫੀਸ਼ੀਅਲ ਇੰਟੈਲੀਜੈਂਸ ਨਵੀਨਤਾਵਾਂ' : 'टेक टॉक: नए गैजेट्स और आर्टिफिशियल इंटेलिजेंस नवाचार'),
                'time' => '12 hours ago',
                'duration' => '04:12',
                'image' => '/images/ai_technology.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("Technology", $lang)
            ],
            [
                'id' => 'fb_mock_6',
                'title' => $lang === 'en' ? 'Business Update: Markets, Inflation & Budget Analysis' : ($lang === 'pb' ? 'ਕਾਰੋਬਾਰੀ ਅਪਡੇਟ: ਬਾਜ਼ਾਰ, ਮਹਿੰਗਾਈ ਅਤੇ ਬਜਟ ਵਿਸ਼ਲੇਸ਼ਣ' : 'बिजनेस अपडेट: बाजार, महंगाई और बजट विश्लेषण'),
                'time' => '1 day ago',
                'duration' => '08:30',
                'image' => '/images/stock_market.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("Business", $lang)
            ],
            [
                'id' => 'fb_mock_7',
                'title' => $lang === 'en' ? 'Entertainment Desk: Movie Reviews & Celebrity Spotting' : ($lang === 'pb' ? 'ਮਨੋਰੰਜਨ ਡੈਸਕ: ਫਿਲਮ ਸਮੀਖਿਆਵਾਂ ਅਤੇ ਸੇਲਿਬ੍ਰਿਟੀ ਸਪੌਟਿੰਗ' : 'मनोरंजन डेस्क: मूवी समीक्षा और सेलिब्रिटी स्पॉटिंग'),
                'time' => '2 days ago',
                'duration' => '02:50',
                'image' => '/images/salman_khan.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("Entertainment", $lang)
            ],
            [
                'id' => 'fb_mock_8',
                'title' => $lang === 'en' ? 'World View: Global News Highlights & Strategic Alliances' : ($lang === 'pb' ? 'ਵਿਸ਼ਵ ਦ੍ਰਿਸ਼ਟੀਕੋਣ: ਗਲੋਬਲ ਖ਼ਬਰਾਂ ਦੀਆਂ ਮੁੱਖ ਗੱਲਾਂ' : 'विश्व दृष्टिकोण: वैश्विक समाचार मुख्य अंश और रणनीतिक गठबंधन'),
                'time' => '3 days ago',
                'duration' => '06:15',
                'image' => '/images/world_leaders_category.png',
                'embed_url' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10153231379986336%2F&show_text=false&t=0',
                'url' => 'https://www.facebook.com/facebook/videos/10153231379986336/',
                'category' => TranslationService::translateCategory("World", $lang)
            ]
        ];
    }

    public static function getFacebookPageVideos($lang)
    {
        $accessToken = config('services.facebook.page_access_token');
        $pageId = config('services.facebook.page_id');

        if (empty($pageId) || empty($accessToken)) {
            return self::getFacebookMockVideos($lang);
        }

        $cacheKey = 'facebook_videos_page_' . $pageId . '_' . $lang;
        return Cache::remember($cacheKey, 1800, function () use ($accessToken, $pageId, $lang) {
            try {
                $photosUrl = "https://graph.facebook.com/v19.0/" . urlencode($pageId) . "/photos?fields=id,name,images,created_time,link&access_token=" . urlencode($accessToken);
                $videosUrl = "https://graph.facebook.com/v19.0/" . urlencode($pageId) . "/videos?fields=description,title,embed_html,source,picture,created_time,length,permalink_url&access_token=" . urlencode($accessToken);

                $videos = [];

                // 1. Try Photos Endpoint
                $ch = curl_init($photosUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                $resPhotos = curl_exec($ch);
                curl_close($ch);

                if ($resPhotos) {
                    $dataPhotos = json_decode($resPhotos, true);
                    if (isset($dataPhotos['data']) && is_array($dataPhotos['data'])) {
                        foreach ($dataPhotos['data'] as $item) {
                            $photoId = $item['id'] ?? '';
                            if (empty($photoId)) continue;
                            $title = $item['name'] ?? 'Facebook Media';
                            $title = Str::limit($title, 100);
                            $createdTime = $item['created_time'] ?? '';
                            $timeStr = !empty($createdTime) ? Carbon::parse($createdTime)->diffForHumans() : 'Recently';
                            $permalinkUrl = $item['link'] ?? "https://www.facebook.com/" . $photoId;
                            $embedUrl = "https://www.facebook.com/plugins/post.php?href=" . urlencode($permalinkUrl) . "&show_text=false";

                            $videos[] = [
                                'id' => $photoId,
                                'title' => $title,
                                'time' => $timeStr,
                                'duration' => 'Media',
                                'image' => isset($item['images'][0]['source']) ? $item['images'][0]['source'] : '/images/hero_india_gate.png',
                                'embed_url' => $embedUrl,
                                'url' => $permalinkUrl,
                                'category' => TranslationService::translateCategory("Entertainment", $lang)
                            ];
                        }
                    }
                }

                // 2. Try Videos Endpoint
                if (empty($videos)) {
                    $ch = curl_init($videosUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                    $response = curl_exec($ch);
                    curl_close($ch);

                    if ($response) {
                        $data = json_decode($response, true);
                        if (isset($data['data']) && is_array($data['data'])) {
                            foreach ($data['data'] as $item) {
                                $videoId = $item['id'] ?? '';
                                if (empty($videoId)) continue;

                                $title = $item['title'] ?? ($item['description'] ?? 'Facebook Video');
                                $title = Str::limit($title, 100);
                                $createdTime = $item['created_time'] ?? '';
                                $timeStr = !empty($createdTime) ? Carbon::parse($createdTime)->diffForHumans() : 'Recently';

                                $length = $item['length'] ?? 0;
                                $duration = '00:00';
                                if ($length > 0) {
                                    $mins = floor($length / 60);
                                    $secs = $length % 60;
                                    $duration = sprintf("%02d:%02d", $mins, $secs);
                                }

                                $thumbUrl = $item['picture'] ?? '/images/video_delhi_rain.png';
                                $permalinkUrl = $item['permalink_url'] ?? "https://www.facebook.com/watch/?v=" . $videoId;
                                $embedUrl = "https://www.facebook.com/plugins/video.php?href=" . urlencode($permalinkUrl) . "&show_text=false&t=0";

                                $videos[] = [
                                    'id' => $videoId,
                                    'title' => $title,
                                    'time' => $timeStr,
                                    'duration' => $duration,
                                    'image' => $thumbUrl,
                                    'embed_url' => $embedUrl,
                                    'url' => $permalinkUrl,
                                    'category' => TranslationService::translateCategory("Entertainment", $lang)
                                ];
                            }
                        }
                    }
                }

                if (empty($videos)) {
                    return self::getFacebookMockVideos($lang);
                }

                return array_slice($videos, 0, 8);
            } catch (\Exception $e) {
                return self::getFacebookMockVideos($lang);
            }
        });
    }
}
