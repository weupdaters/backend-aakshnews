<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\ReelResource;
use App\Http\Resources\Api\v1\VideoResource;
use App\Models\InstagramVideo;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MediaApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/videos
     */
    public function videos(Request $request)
    {
        $perPage = (int) $request->input('per_page', 12);

        $paginator = UserPost::where('status', 'published')
            ->whereNotNull('video_url')
            ->latest()
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, VideoResource::class);

        return $this->successResponse($formatted['data'], 'Videos fetched successfully.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
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
        $perPage = (int) $request->input('per_page', 12);
        $paginator = InstagramVideo::latest()->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, ReelResource::class);

        return $this->successResponse($formatted['data'], 'Reels fetched successfully.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
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
