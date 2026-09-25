<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SearchNewsRequest;
use App\Http\Resources\Api\v1\AuthorResource;
use App\Http\Resources\Api\v1\NewsResource;
use App\Http\Resources\Api\v1\ReelResource;
use App\Http\Resources\Api\v1\VideoResource;
use App\Models\Bookmark;
use App\Models\BreakingNews;
use App\Models\InstagramVideo;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/news
     */
    public function index(Request $request)
    {
        $query = UserPost::query()->where('status', 'published');

        if ($request->filled('category')) {
            $catInput = trim($request->input('category'));
            if (!in_array(strtolower($catInput), ['all', 'ਸਭੀ', 'सभी'])) {
                $matchedCat = \App\Models\Category::where('slug', $catInput)
                    ->orWhere('name', $catInput)
                    ->orWhere('name_en', $catInput)
                    ->orWhere('name_pb', $catInput)
                    ->orWhere('name_hi', $catInput)
                    ->first();

                $query->where(function ($q) use ($catInput, $matchedCat) {
                    $q->where('category', 'LIKE', '%' . $catInput . '%');
                    if ($matchedCat) {
                        if ($matchedCat->name) $q->orWhere('category', 'LIKE', '%' . $matchedCat->name . '%');
                        if ($matchedCat->name_en) $q->orWhere('category', 'LIKE', '%' . $matchedCat->name_en . '%');
                        if ($matchedCat->name_pb) $q->orWhere('category', 'LIKE', '%' . $matchedCat->name_pb . '%');
                        if ($matchedCat->name_hi) $q->orWhere('category', 'LIKE', '%' . $matchedCat->name_hi . '%');
                        if ($matchedCat->slug) $q->orWhere('category', 'LIKE', '%' . $matchedCat->slug . '%');
                    }
                });
            }
        }

        if ($request->filled('author')) {
            $query->where(function ($q) use ($request) {
                $q->where('author_name', 'LIKE', '%' . $request->input('author') . '%')
                  ->orWhere('user_id', $request->input('author'));
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->boolean('featured')) {
            $query->where('is_hero', true);
        }

        if ($request->boolean('trending')) {
            $query->orderBy('views_count', 'desc');
        } elseif ($request->input('sort') === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $perPage = (int) $request->input('per_page', 12);
        $paginator = $query->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, NewsResource::class);

        return $this->successResponse($formatted['data'], 'News items fetched successfully.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }

    /**
     * GET /api/v1/news/{slug}
     */
    public function show($slug)
    {
        $post = null;

        if (is_numeric($slug)) {
            $post = UserPost::find($slug);
        } else {
            // 1. If slug ends with hyphen and ID (e.g. news-title-slug-123), extract trailing ID
            if (preg_match('/-(\d+)$/', $slug, $matches)) {
                $post = UserPost::find($matches[1]);
            }

            // 2. Try matching title across all languages directly
            if (!$post) {
                $cleanTitle = trim(str_replace('-', ' ', $slug));
                $post = UserPost::where('status', 'published')
                    ->where(function ($q) use ($cleanTitle) {
                        $q->where('title', 'LIKE', "%{$cleanTitle}%")
                          ->orWhere('title_en', 'LIKE', "%{$cleanTitle}%")
                          ->orWhere('title_pb', 'LIKE', "%{$cleanTitle}%")
                          ->orWhere('title_hi', 'LIKE', "%{$cleanTitle}%");
                    })
                    ->first();
            }
        }

        if (!$post || $post->status !== 'published') {
            return $this->errorResponse('Article not found.', [], 404);
        }

        // Increment view count
        $post->increment('views_count');

        // Fetch related news from same category
        $relatedNews = UserPost::where('status', 'published')
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get();

        $resourceData = (new NewsResource($post))->toArray(request());
        $resourceData['related_news'] = NewsResource::collection($relatedNews);

        return $this->successResponse($resourceData, 'Article details fetched successfully.');
    }

    /**
     * POST /api/v1/news/{id}/view
     */
    public function incrementView($id)
    {
        $post = UserPost::find($id);
        if (!$post) {
            return $this->errorResponse('Post not found.', [], 404);
        }

        $post->increment('views_count');

        return $this->successResponse(['views_count' => $post->views_count], 'View count updated successfully.');
    }

    /**
     * POST /api/v1/news/{id}/share
     */
    public function incrementShare($id)
    {
        $post = UserPost::find($id);
        if (!$post) {
            return $this->errorResponse('Post not found.', [], 404);
        }

        return $this->successResponse(['shared' => true], 'Share count updated successfully.');
    }

    /**
     * POST /api/v1/news/{id}/bookmark (Authenticated)
     */
    public function bookmark($id)
    {
        $user = Auth::user();
        $post = UserPost::find($id);

        if (!$post) {
            return $this->errorResponse('Post not found.', [], 404);
        }

        $existing = Bookmark::where('user_id', $user->id)->where('user_post_id', $id)->first();

        if ($existing) {
            $existing->delete();
            return $this->successResponse(['bookmarked' => false], 'Bookmark removed.');
        }

        Bookmark::create([
            'user_id'      => $user->id,
            'user_post_id' => $id,
        ]);

        return $this->successResponse(['bookmarked' => true], 'Article bookmarked successfully.');
    }

    /**
     * POST /api/v1/news/{id}/like (Authenticated)
     */
    public function like($id)
    {
        $user = Auth::user();
        $post = UserPost::find($id);

        if (!$post) {
            return $this->errorResponse('Post not found.', [], 404);
        }

        $existing = PostLike::where('user_id', $user->id)->where('user_post_id', $id)->first();

        if ($existing) {
            $existing->delete();
            return $this->successResponse(['liked' => false], 'Like removed.');
        }

        PostLike::create([
            'user_id'      => $user->id,
            'user_post_id' => $id,
        ]);

        return $this->successResponse(['liked' => true], 'Article liked successfully.');
    }

    /**
     * POST /api/v1/news/{id}/react (Public / Optional Auth)
     */
    public function react($id, Request $request)
    {
        $post = UserPost::find($id);
        if (!$post) {
            if (!is_numeric($id) && preg_match('/(\d+)$/', $id, $matches)) {
                $post = UserPost::find($matches[1]);
            }
        }

        $type = $request->input('type', 'like'); // like, dislike, or emoji like '❤️'
        $action = $request->input('action', 'add'); // add, remove

        // If user is authenticated, sync with PostLike table
        $user = Auth::guard('sanctum')->user() ?: Auth::user();
        if ($user && $post) {
            $existing = PostLike::where('user_id', $user->id)->where('user_post_id', $post->id)->first();
            if ($action === 'remove' || ($type === 'dislike' && $existing)) {
                if ($existing) $existing->delete();
            } elseif ($type === 'like' && !$existing) {
                PostLike::create([
                    'user_id'      => $user->id,
                    'user_post_id' => $post->id,
                ]);
            }
        }

        return $this->successResponse([
            'status' => 'success',
            'type'   => $type,
            'action' => $action,
            'post_id'=> $post ? $post->id : $id,
        ], 'Reaction recorded successfully.');
    }

    /**
     * GET /api/v1/breaking-news
     */
    public function breakingNews()
    {
        $lang = strtolower(request()->header('X-Language', request()->query('lang', 'pa')));
        if ($lang === 'pa') {
            $lang = 'pb';
        }

        $items = BreakingNews::where('is_active', true)->latest()->get()->map(function ($item) use ($lang) {
            $title = match ($lang) {
                'en' => $item->title_en ?: \App\Services\TranslationService::translateText($item->title, 'en'),
                'hi' => $item->title_hi ?: \App\Services\TranslationService::translateText($item->title, 'hi'),
                'pb' => $item->title_pb ?: \App\Services\TranslationService::translateText($item->title, 'pa'),
                default => $item->title,
            };
            return $title;
        });

        return $this->successResponse($items, 'Breaking news fetched.');
    }

    /**
     * GET /api/v1/trending
     */
    public function trending()
    {
        $trending = UserPost::where('status', 'published')->orderBy('views_count', 'desc')->take(10)->get();

        return $this->successResponse(NewsResource::collection($trending), 'Trending news fetched.');
    }

    /**
     * GET /api/v1/featured
     */
    public function featured()
    {
        $featured = UserPost::where('status', 'published')->where('is_hero', true)->latest()->take(5)->get();

        if ($featured->isEmpty()) {
            $featured = UserPost::where('status', 'published')->latest()->take(5)->get();
        }

        return $this->successResponse(NewsResource::collection($featured), 'Featured news fetched.');
    }

    /**
     * GET /api/v1/search
     */
    public function search(SearchNewsRequest $request)
    {
        $q = $request->input('q');
        $type = $request->input('type', 'all');

        $newsResults = collect();
        $videoResults = collect();
        $reelResults = collect();
        $authorResults = collect();

        if ($q) {
            if (in_array($type, ['all', 'news'])) {
                $newsResults = UserPost::where('status', 'published')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'LIKE', "%{$q}%")
                              ->orWhere('content', 'LIKE', "%{$q}%");
                    })
                    ->latest()
                    ->take(10)
                    ->get();
            }

            if (in_array($type, ['all', 'videos'])) {
                $videoResults = UserPost::where('status', 'published')
                    ->whereNotNull('video_url')
                    ->where('title', 'LIKE', "%{$q}%")
                    ->latest()
                    ->take(5)
                    ->get();
            }

            if (in_array($type, ['all', 'reels'])) {
                $reelResults = InstagramVideo::where('title', 'LIKE', "%{$q}%")->latest()->take(5)->get();
            }

            if (in_array($type, ['all', 'authors'])) {
                $authorResults = User::where('name', 'LIKE', "%{$q}%")->latest()->take(5)->get();
            }
        }

        return $this->successResponse([
            'news'    => NewsResource::collection($newsResults),
            'videos'  => VideoResource::collection($videoResults),
            'reels'   => ReelResource::collection($reelResults),
            'authors' => AuthorResource::collection($authorResults),
        ], 'Search results fetched.');
    }
}
