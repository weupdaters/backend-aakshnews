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
use Illuminate\Support\Facades\Cache;

class CategoryApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/categories
     */
    public function index()
    {
        Category::ensureDefaults();

        $categories = Cache::remember('api_v1_categories_all', 3600, function () {
            return Category::where('status', 'active')->get();
        });

        return $this->successResponse(CategoryResource::collection($categories), 'Categories fetched successfully.');
    }

    /**
     * GET /api/v1/categories/{slug}
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            // Fallback match by category name
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
        $category = Category::where('slug', $slug)->first();
        $catName = $category ? $category->name : $slug;

        $perPage = (int) $request->input('per_page', 12);

        $paginator = UserPost::where('status', 'published')
            ->where(function ($q) use ($catName, $slug) {
                $q->where('category', $catName)
                  ->orWhere('category', 'LIKE', "%{$slug}%");
            })
            ->latest()
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, NewsResource::class);

        return $this->successResponse($formatted['data'], 'Category news list fetched.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }
}
