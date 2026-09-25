<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPost;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        Category::ensureDefaults();
        $categories = Category::where('status', 'active')->get();

        // 1. High-level dashboard counters (Aggregated in database)
        $totalCount = UserPost::count();
        $publishedCount = UserPost::where('status', 'published')->count();
        $draftCount = UserPost::whereIn('status', ['pending', 'draft'])->count();
        $scheduledCount = UserPost::where('status', 'scheduled')->count();
        $archivedCount = UserPost::whereIn('status', ['rejected', 'archived'])->count();
        $authors = UserPost::distinct()->whereNotNull('author_name')->limit(30)->pluck('author_name');

        // Right side stats
        $todayPublished = UserPost::where('status', 'published')->where('created_at', '>=', now()->startOfDay())->count();
        $todayViews = (int) UserPost::where('created_at', '>=', now()->startOfDay())->sum('views_count');
        $breakingCount = UserPost::where('is_hero', true)->count();

        // 2. High-performance Query: ONLY SELECT NEEDED COLUMNS (No huge content blobs)
        $query = UserPost::select([
            'id', 'title', 'category', 'author_name', 'image_url', 
            'video_url', 'duration', 'is_hero', 'status', 'views_count', 'created_at',
            \Illuminate\Support\Facades\DB::raw('SUBSTRING(content, 1, 160) as summary_content')
        ]);

        // Search query
        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author_name', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($cat = $request->query('category')) {
            if ($cat !== 'all' && !empty($cat)) {
                $query->where('category', $cat);
            }
        }

        // Status filter
        if ($status = $request->query('status')) {
            if ($status !== 'all' && !empty($status)) {
                if ($status === 'breaking') {
                    $query->where('is_hero', true);
                } elseif ($status === 'draft') {
                    $query->whereIn('status', ['pending', 'draft']);
                } else {
                    $query->where('status', $status);
                }
            }
        }

        // Author filter
        if ($author = $request->query('author')) {
            if ($author !== 'all' && !empty($author)) {
                $query->where('author_name', $author);
            }
        }

        // Date filter
        if ($date = $request->query('date')) {
            $query->whereDate('created_at', $date);
        }

        // Sorting
        $sort = $request->query('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest('id');
                break;
            case 'views':
            case 'views_high':
                $query->orderByDesc('views_count');
                break;
            case 'alpha':
                $query->orderBy('title');
                break;
            case 'latest':
            default:
                $query->latest('id');
                break;
        }

        // 3. Server-side Pagination (Default 20 per page)
        $perPage = (int) $request->query('per_page', 20);
        if ($perPage < 5 || $perPage > 100) {
            $perPage = 20;
        }

        $posts = $query->paginate($perPage)->withQueryString();

        return view('admin.post.index', compact(
            'posts',
            'categories',
            'totalCount',
            'publishedCount',
            'draftCount',
            'scheduledCount',
            'archivedCount',
            'authors',
            'todayPublished',
            'todayViews',
            'breakingCount'
        ));
    }

    public function readerCorner()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $posts = UserPost::where('is_admin_post', false)->latest()->take(100)->get();
        return view('admin.reader_corner.index', compact('posts'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        Category::ensureDefaults();
        $categories = Category::where('status', 'active')->latest()->get();
        return view('admin.post.create', compact('categories'));
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $post = UserPost::find($id);
        if (!$post) {
            abort(404);
        }

        Category::ensureDefaults();
        $categories = Category::where('status', 'active')->latest()->get();
        return view('admin.post.edit', compact('post', 'categories'));
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $post = UserPost::find($id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Article not found.'], 404);
        }
        $post->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Article deleted successfully.']);
        }
        return redirect('/admin/post')->with('success', 'Article deleted successfully.');
    }

    public function duplicate($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $post = UserPost::find($id);
        if (!$post) {
            return redirect('/admin/post')->with('error', 'Article not found.');
        }

        $newPost = $post->replicate();
        $newPost->title = $post->title . ' (Copy)';
        $newPost->status = 'draft';
        $newPost->created_at = now();
        $newPost->save();

        return redirect('/admin/post')->with('success', 'Article duplicated as Draft.');
    }

    public function bulkAction(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $ids = $request->input('ids', []);
        $action = $request->input('action');

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'No articles selected.'], 400);
        }

        switch ($action) {
            case 'publish':
                UserPost::whereIn('id', $ids)->update(['status' => 'published']);
                $msg = count($ids) . ' articles published.';
                break;
            case 'draft':
                UserPost::whereIn('id', $ids)->update(['status' => 'draft']);
                $msg = count($ids) . ' articles moved to draft.';
                break;
            case 'archive':
                UserPost::whereIn('id', $ids)->update(['status' => 'archived']);
                $msg = count($ids) . ' articles archived.';
                break;
            case 'delete':
                UserPost::whereIn('id', $ids)->delete();
                $msg = count($ids) . ' articles deleted.';
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }
}
