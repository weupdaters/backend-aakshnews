<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\ReelResource;
use App\Http\Resources\Api\v1\VideoResource;
use App\Models\InstagramVideo;
use App\Models\UserPost;
use App\Services\SocialMediaService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/videos
     */
    public function videos(Request $request)
    {
        $lang = $request->header('X-Language', $request->input('lang', 'pa'));
        if (!in_array($lang, ['en', 'hi', 'pa'])) {
            $lang = 'pa';
        }

        $ytVideos = SocialMediaService::getYouTubeChannelVideos($lang);

        // Fetch DB user_posts with video_url if any exist
        $dbVideos = [];
        try {
            $posts = UserPost::where('status', 'published')
                ->whereNotNull('video_url')
                ->latest()
                ->take(6)
                ->get();
            if ($posts->isNotEmpty()) {
                $dbVideos = VideoResource::collection($posts)->resolve();
            }
        } catch (\Exception $e) {
            // ignore if db error
        }

        $merged = array_merge($ytVideos, $dbVideos);

        $normalized = array_map(function ($item) {
            $v = is_array($item) ? $item : (array) $item;
            $id = $v['id'] ?? (string) ($v['videoId'] ?? rand(100, 999));
            $title = $v['title'] ?? 'Aaksh News Video';
            $thumb = !empty($v['thumbnailUrl']) ? $v['thumbnailUrl'] : (!empty($v['image']) ? $v['image'] : "https://img.youtube.com/vi/{$id}/hqdefault.jpg");
            $duration = $v['duration'] ?? '05:00';
            $views = $v['views'] ?? '1.5K Views';
            $publishedAt = $v['publishedAt'] ?? ($v['time'] ?? 'Recently');
            $videoUrl = $v['videoUrl'] ?? ($v['url'] ?? "https://www.youtube.com/watch?v={$id}");
            $embedUrl = $v['embedUrl'] ?? ($v['embed_url'] ?? "https://www.youtube.com/embed/{$id}?autoplay=1");
            $category = $v['category'] ?? 'ਖ਼ਬਰਾਂ';

            return [
                'id'           => (string) $id,
                'title'        => $title,
                'slug'         => Str::slug($title) . '-' . $id,
                'thumbnailUrl' => $thumb,
                'duration'     => $duration,
                'views'        => $views,
                'publishedAt'  => $publishedAt,
                'videoUrl'     => $videoUrl,
                'embedUrl'     => $embedUrl,
                'category'     => $category,
            ];
        }, $merged);

        return $this->successResponse(array_values($normalized), 'Videos fetched successfully.');
    }

    /**
     * GET /api/v1/videos/{slug}
     */
    public function videoShow($slug)
    {
        $video = UserPost::where('status', 'published')
            ->whereNotNull('video_url')
            ->find($slug);

        if (!$video) {
            return $this->errorResponse('Video not found.', [], 404);
        }

        return $this->successResponse(new VideoResource($video), 'Video details fetched.');
    }

    /**
     * GET /api/v1/reels
     */
    public function reels(Request $request)
    {
        $lang = $request->header('X-Language', $request->input('lang', 'pa'));
        if (!in_array($lang, ['en', 'hi', 'pa'])) {
            $lang = 'pa';
        }

        $perPage = (int) $request->input('per_page', 12);

        // Fetch real YouTube Channel News Videos as Reels
        $ytVideos = SocialMediaService::getYouTubeChannelVideos($lang);
        $reels = [];

        foreach ($ytVideos as $v) {
            $id = $v['id'] ?? '9GydBxsBcsI';
            $reels[] = [
                'id'           => (string) $id,
                'title'        => $v['title'] ?? 'AAKSH News Short',
                'slug'         => Str::slug($v['title'] ?? 'short') . '-' . $id,
                'url'          => "https://www.youtube.com/watch?v={$id}",
                'videoUrl'     => "https://www.youtube.com/watch?v={$id}",
                'video_url'    => "https://www.youtube.com/watch?v={$id}",
                'embed_url'    => "https://www.youtube.com/embed/{$id}?autoplay=1",
                'thumbnailUrl' => !empty($v['thumbnailUrl']) ? $v['thumbnailUrl'] : "https://i.ytimg.com/vi/{$id}/hq720.jpg",
                'duration'     => $v['duration'] ?? '0:45',
                'views'        => $v['views'] ?? '15.4K',
                'category'     => $v['category'] ?? 'ਸ਼ਾਰਟਸ',
                'likes'        => '4.2K',
                'shares'       => '1.5K',
                'created_at'   => now()->toIso8601String(),
            ];
        }

        // Also merge DB reels if available
        try {
            $dbVideos = InstagramVideo::latest()->take(6)->get();
            if ($dbVideos->isNotEmpty()) {
                $dbFormatted = ReelResource::collection($dbVideos)->resolve();
                $reels = array_merge($reels, $dbFormatted);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Paginate / slice to perPage
        $sliced = array_slice($reels, 0, $perPage);

        return $this->successResponse($sliced, 'Reels fetched successfully.');
    }

    /**
     * GET /api/v1/reels/{slug}
     */
    public function reelShow($slug)
    {
        $reel = InstagramVideo::find($slug);

        if (!$reel) {
            return $this->errorResponse('Reel not found.', [], 404);
        }

        return $this->successResponse(new ReelResource($reel), 'Reel details fetched.');
    }
}
