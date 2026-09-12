<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\AuthorResource;
use App\Http\Resources\Api\v1\NewsResource;
use App\Models\User;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthorApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/authors
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 12);
        $paginator = User::withCount('posts')->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, AuthorResource::class);

        return $this->successResponse($formatted['data'], 'Authors fetched successfully.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }

    /**
     * GET /api/v1/authors/{slug}
     */
    public function show($slug)
    {
        $author = null;

        if (is_numeric($slug)) {
            $author = User::find($slug);
        } else {
            $parts = explode('-', $slug);
            $possibleId = end($parts);
            if (is_numeric($possibleId)) {
                $author = User::find($possibleId);
            }
            if (!$author) {
                $author = User::where('name', 'LIKE', str_replace('-', ' ', $slug))->first();
            }
        }

        if (!$author) {
            return $this->errorResponse('Author not found.', [], 404);
        }

        $authorNews = UserPost::where('status', 'published')
            ->where(function ($q) use ($author) {
                $q->where('user_id', $author->id)
                  ->orWhere('author_name', $author->name);
            })
            ->latest()
            ->take(10)
            ->get();

        $authorData = (new AuthorResource($author))->toArray(request());
        $authorData['news'] = NewsResource::collection($authorNews);

        return $this->successResponse($authorData, 'Author details fetched successfully.');
    }
}
