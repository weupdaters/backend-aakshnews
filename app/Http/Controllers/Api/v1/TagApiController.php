<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\NewsResource;
use App\Http\Resources\Api\v1\TagResource;
use App\Models\Category;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/tags
     */
    public function index()
    {
        $categories = Category::pluck('name')->toArray();
        $defaultTags = array_merge($categories, ['BreakingNews', 'Politics', 'Cricket', 'Bollywood', 'Tech2026', 'WorldNews']);

        $tags = collect($defaultTags)->map(fn ($tag) => new TagResource($tag));

        return $this->successResponse($tags, 'Tags list fetched.');
    }

    /**
     * GET /api/v1/tags/{slug}
     */
    public function show(Request $request, string $slug)
    {
        $tagName = str_replace('-', ' ', $slug);
        $perPage = (int) $request->input('per_page', 12);

        $paginator = UserPost::where('status', 'published')
            ->where(function ($query) use ($tagName, $slug) {
                $query->where('category', 'LIKE', "%{$tagName}%")
                      ->orWhere('title', 'LIKE', "%{$tagName}%")
                      ->orWhere('content', 'LIKE', "%{$tagName}%");
            })
            ->latest()
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, NewsResource::class);

        return $this->successResponse($formatted['data'], "News tagged with '{$tagName}' fetched.", [
            'tag'   => ['name' => ucfirst($tagName), 'slug' => Str::slug($tagName)],
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }
}
