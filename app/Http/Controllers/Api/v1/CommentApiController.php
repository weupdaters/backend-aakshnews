<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CommentRequest;
use App\Http\Resources\Api\v1\CommentResource;
use App\Models\Comment;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/news/{id}/comments
     */
    public function index(Request $request, $id)
    {
        $post = UserPost::find($id);
        if (!$post) {
            return $this->errorResponse('Post not found.', [], 404);
        }

        $perPage = (int) $request->input('per_page', 10);
        $paginator = Comment::where('user_post_id', $id)
            ->where('status', 'approved')
            ->latest()
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, CommentResource::class);

        return $this->successResponse($formatted['data'], 'Comments fetched successfully.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }

    /**
     * POST /api/v1/news/{id}/comments
     */
    public function store(CommentRequest $request, $id)
    {
        $post = UserPost::find($id);
        if (!$post) {
            return $this->errorResponse('Post not found.', [], 404);
        }

        $authorName = $request->input('author_name');
        if (!$authorName) {
            $authorName = Auth::check() ? Auth::user()->name : 'Reader';
        }

        $comment = Comment::create([
            'user_id'      => Auth::id(),
            'user_post_id' => $id,
            'author_name'  => $authorName,
            'comment'      => $request->input('comment'),
            'status'       => 'approved',
        ]);

        return $this->successResponse(new CommentResource($comment), 'Comment added successfully.', [], 201);
    }
}
