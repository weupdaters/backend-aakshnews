<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Http\Resources\Api\v1\NewsResource;
use App\Models\Category;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/categories
     */
    public function index()
    {
        Category::ensureDefaults();

        $categories = Category::where('status', 'active')->get();

        return $this->successResponse(CategoryResource::collection($categories), 'Categories fetched successfully.');
    }

    /**
     * GET /api/v1/categories/{slug}
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            $category = Category::where('name', 'LIKE', $slug)->first();
        }

        if (!$category) {
            return $this->errorResponse('Category not found.', [], 404);
        }

        return $this->successResponse(new CategoryResource($category), 'Category details fetched.');
    }

    /**
     * GET /api/v1/categories/{slug}/news
     */
    public function news(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)
            ->orWhere('name', $slug)
            ->orWhere('name_en', $slug)
            ->orWhere('name_pb', $slug)
            ->first();

        $perPage = (int) $request->input('per_page', 12);

        $paginator = UserPost::where('status', 'published')
            ->where(function ($q) use ($category, $slug) {
                $q->where('category', 'LIKE', "%{$slug}%");
                if ($category) {
                    if ($category->name) $q->orWhere('category', 'LIKE', "%{$category->name}%");
                    if ($category->name_en) $q->orWhere('category', 'LIKE', "%{$category->name_en}%");
                    if ($category->name_pb) $q->orWhere('category', 'LIKE', "%{$category->name_pb}%");
                    if ($category->name_hi) $q->orWhere('category', 'LIKE', "%{$category->name_hi}%");
                    if ($category->slug) $q->orWhere('category', 'LIKE', "%{$category->slug}%");
                }
            })
            ->latest()
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, NewsResource::class);

        return $this->successResponse($formatted['data'], 'Category news list fetched.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }

    /**
     * GET /api/v1/home/category-sections (or /api/category-sections)
     * Returns dynamic categories with posts for landing page:
     * 1. Ordered by post count DESCENDING (highest count first)
     * 2. Empty categories (count == 0) are excluded
     * 3. Includes icon & color from category database model
     * 4. Structured into Featured Lead Story, 4 Sub Articles, and 4 Latest Ticker News
     */
    public function categorySections(Request $request)
    {
        Category::ensureDefaults();
        $categories = Category::where('status', 'active')->get();
        $sections = [];

        foreach ($categories as $cat) {
            $nameEn = $cat->name_en ?: $cat->name;
            $namePb = $cat->name_pb;
            $nameHi = $cat->name_hi;
            $slug = $cat->slug;

            // Query only matching posts for this category with limit 10
            $query = UserPost::where('status', 'published')
                ->where(function ($q) use ($cat, $nameEn, $namePb, $nameHi, $slug) {
                    $q->where('category', $cat->name)
                      ->orWhere('category', $slug);
                    if ($nameEn) $q->orWhere('category', 'LIKE', '%' . $nameEn . '%');
                    if ($namePb) $q->orWhere('category', 'LIKE', '%' . $namePb . '%');
                    if ($nameHi) $q->orWhere('category', 'LIKE', '%' . $nameHi . '%');
                });

            $count = (clone $query)->count();

            // Rule: "jis catroy news nhai uss na show karo" -> Do NOT show empty categories
            if ($count === 0) {
                continue;
            }

            $catPosts = $query->latest()
                ->take(10)
                ->get(['id', 'title', 'content', 'author_name', 'category', 'image_url', 'video_url', 'is_hero', 'views_count', 'created_at']);

            // Lead/Featured Story (First post)
            $leadPost = $catPosts->first();
            $leadImg = $leadPost->image_url ?? '/images/aaksh_anchor_studio.jpg';
            if (!str_starts_with($leadImg, 'http') && !str_starts_with($leadImg, '/')) {
                $leadImg = '/' . $leadImg;
            }

            $isVideo = !empty($leadPost->video_url) || !empty($leadPost->is_video) || ($leadPost->type ?? '') === 'video';

            $featured = [
                'id' => (string) $leadPost->id,
                'title' => $leadPost->title,
                'slug' => 'news-' . $leadPost->id,
                'summary' => !empty($leadPost->content) ? \Illuminate\Support\Str::limit(strip_tags($leadPost->content), 120) : 'Major political developments as opposition raises questions on new financial proposals.',
                'image' => $leadImg,
                'author' => $leadPost->author_name ?? 'Aaksh News Desk',
                'time_ago' => $leadPost->created_at ? $leadPost->created_at->diffForHumans() : '2 hours ago',
                'views' => number_format($leadPost->views_count ?: 18200) . ' views',
                'badge' => $leadPost->is_hero ? 'LIVE UPDATES' : 'EXCLUSIVE',
                'is_video' => $isVideo,
                'video_url' => $leadPost->video_url ?? 'https://www.youtube.com/watch?v=9GydBxsBcsI',
            ];

            // 4 Sub Articles (Middle Column)
            $subArticles = [];
            $subSlice = $catPosts->slice(1, 4)->values();
            foreach ($subSlice as $sub) {
                $subImg = $sub->image_url ?? '/images/aaksh_anchor_studio.jpg';
                if (!str_starts_with($subImg, 'http') && !str_starts_with($subImg, '/')) {
                    $subImg = '/' . $subImg;
                }
                $subArticles[] = [
                    'id' => (string) $sub->id,
                    'title' => $sub->title,
                    'slug' => 'news-' . $sub->id,
                    'image' => $subImg,
                    'time_ago' => $sub->created_at ? $sub->created_at->diffForHumans() : '3 hours ago',
                ];
            }

            // If less than 4, fill with remaining posts or default format
            if (count($subArticles) < 4 && $catPosts->count() > 1) {
                foreach ($catPosts->skip(1)->take(4) as $sub) {
                    if (count($subArticles) >= 4) break;
                    $subImg = $sub->image_url ?? '/images/aaksh_anchor_studio.jpg';
                    if (!str_starts_with($subImg, 'http') && !str_starts_with($subImg, '/')) {
                        $subImg = '/' . $subImg;
                    }
                    $subArticles[] = [
                        'id' => (string) $sub->id,
                        'title' => $sub->title,
                        'slug' => 'news-' . $sub->id,
                        'image' => $subImg,
                        'time_ago' => $sub->created_at ? $sub->created_at->diffForHumans() : '4 hours ago',
                    ];
                }
            }

            // 4 Latest Ticker News (Right Column)
            $tickerNews = [];
            $tickerSlice = $catPosts->slice(1, 5)->values();
            if ($tickerSlice->isEmpty()) {
                $tickerSlice = $catPosts->take(4);
            }
            foreach ($tickerSlice as $tIndex => $ticker) {
                $tickerNews[] = [
                    'id' => (string) $ticker->id,
                    'title' => $ticker->title,
                    'slug' => 'news-' . $ticker->id,
                    'time' => $ticker->created_at ? $ticker->created_at->format('H:i') : sprintf('%02d:30', 11 - $tIndex),
                ];
            }

            $sections[] = [
                'category' => [
                    'id' => (string) $cat->id,
                    'name' => $nameEn,
                    'name_en' => $nameEn,
                    'name_pb' => $namePb ?: $nameEn,
                    'name_hi' => $nameHi ?: $nameEn,
                    'slug' => $slug,
                    'color' => $cat->color ?? '#DC2626',
                    'icon' => $cat->icon ?? 'newspaper',
                    'count' => $count,
                ],
                'featured' => $featured,
                'subArticles' => $subArticles,
                'tickerNews' => $tickerNews,
            ];
        }

        // Rule: "jis bhout jaya hai count of new s phle aya" -> Sort categories by count DESCENDING
        usort($sections, function ($a, $b) {
            return $b['category']['count'] <=> $a['category']['count'];
        });

        // Top 5 Trending News for Right Sidebar
        $trendingPosts = UserPost::where('status', 'published')->orderBy('views_count', 'desc')->take(5)->get();
        $trendingNews = [];
        foreach ($trendingPosts as $rIndex => $tp) {
            $tpImg = $tp->image_url ?? '/images/aaksh_anchor_studio.jpg';
            if (!str_starts_with($tpImg, 'http') && !str_starts_with($tpImg, '/')) {
                $tpImg = '/' . $tpImg;
            }
            $vCount = $tp->views_count ?: (32000 - ($rIndex * 4000));
            $trendingNews[] = [
                'rank' => $rIndex + 1,
                'id' => (string) $tp->id,
                'title' => $tp->title,
                'slug' => 'news-' . $tp->id,
                'image' => $tpImg,
                'views' => ($vCount >= 1000 ? round($vCount / 1000, 1) . 'K' : $vCount) . ' views',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'sections' => $sections,
                'trending' => $trendingNews,
            ],
            'message' => 'Category sections fetched successfully sorted by news count.',
        ]);
    }
}
