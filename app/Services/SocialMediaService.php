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
        return Cache::remember($cacheKey, 1800, function () use ($apiKey, $channelId, $lang) {
            try {
                if (!empty($apiKey)) {
                    $playlistId = $channelId;
                    if (substr($channelId, 0, 2) === 'UC') {
                        $playlistId = 'UU' . substr($channelId, 2);
                    }

                    $url = "https://www.googleapis.com/youtube/v3/playlistItems?key=" . urlencode($apiKey) . "&playlistId=" . urlencode($playlistId) . "&part=snippet&maxResults=12";

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                    curl_setopt($ch, CURLOPT_REFERER, request()->getSchemeAndHttpHost() ?: config('app.url', 'http://localhost'));
                    $response = curl_exec($ch);
                    curl_close($ch);

                    if ($response) {
                        $data = json_decode($response, true);
                        if (isset($data['items'])) {
                            $videos = [];
                            foreach ($data['items'] as $item) {
                                $snippet = $item['snippet'] ?? [];
                                $resourceId = $snippet['resourceId'] ?? [];
                                $videoId = $resourceId['videoId'] ?? '';
                                if (empty($videoId)) continue;

                                $title = $snippet['title'] ?? 'YouTube Video';
                                $publishedAt = $snippet['publishedAt'] ?? '';
                                $timeStr = !empty($publishedAt) ? Carbon::parse($publishedAt)->diffForHumans() : 'Recently';

                                $thumbUrl = '/images/video_delhi_rain.png';
                                if (isset($snippet['thumbnails']['maxres']['url'])) {
                                    $thumbUrl = $snippet['thumbnails']['maxres']['url'];
                                } elseif (isset($snippet['thumbnails']['high']['url'])) {
                                    $thumbUrl = $snippet['thumbnails']['high']['url'];
                                } elseif (isset($snippet['thumbnails']['medium']['url'])) {
                                    $thumbUrl = $snippet['thumbnails']['medium']['url'];
                                }

                                $videos[] = [
                                    'title' => $title,
                                    'time' => $timeStr,
                                    'views' => 'YouTube',
                                    'duration' => 'Live/Video',
                                    'image' => $thumbUrl,
                                    'embed_url' => "https://www.youtube.com/embed/" . $videoId . "?enablejsapi=1",
                                    'url' => "https://www.youtube.com/watch?v=" . $videoId,
                                    'category' => TranslationService::translateCategory("Breaking News", $lang)
                                ];
                            }
                            return $videos;
                        }
                    }
                }

                // Keyless Fallback via Public YouTube RSS Feed
                $url = "https://www.youtube.com/feeds/videos.xml?channel_id=" . urlencode($channelId);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $xmlString = curl_exec($ch);
                curl_close($ch);

                if ($xmlString) {
                    preg_match_all('/<entry>(.*?)<\/entry>/s', $xmlString, $entries);
                    if (isset($entries[1])) {
                        $videos = [];
                        foreach ($entries[1] as $entry) {
                            preg_match('/<yt:videoId>(.*?)<\/yt:videoId>/', $entry, $vidMatch);
                            preg_match('/<title>(.*?)<\/title>/', $entry, $titleMatch);
                            preg_match('/<published>(.*?)<\/published>/', $entry, $pubMatch);
                            preg_match('/<media:thumbnail[^>]+url=["\'](.*?)["\']/', $entry, $thumbMatch);

                            $videoId = $vidMatch[1] ?? '';
                            if (empty($videoId)) continue;

                            $title = html_entity_decode($titleMatch[1] ?? 'YouTube Video', ENT_QUOTES, 'UTF-8');
                            $publishedAt = $pubMatch[1] ?? '';
                            $timeStr = !empty($publishedAt) ? Carbon::parse($publishedAt)->diffForHumans() : 'Recently';
                            $thumbUrl = $thumbMatch[1] ?? ("https://img.youtube.com/vi/" . $videoId . "/hqdefault.jpg");

                            $videos[] = [
                                'title' => $title,
                                'time' => $timeStr,
                                'views' => 'YouTube',
                                'duration' => 'Video',
                                'image' => $thumbUrl,
                                'embed_url' => "https://www.youtube.com/embed/" . $videoId . "?enablejsapi=1",
                                'url' => "https://www.youtube.com/watch?v=" . $videoId,
                                'category' => TranslationService::translateCategory("Breaking News", $lang)
                            ];
                        }
                        return $videos;
                    }
                }
            } catch (\Exception $e) {
                // ignore
            }
            return [];
        });
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
