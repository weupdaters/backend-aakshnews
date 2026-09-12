<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPost;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $posts = UserPost::where('is_admin_post', true)->latest()->get();
        return view('admin.post.index', compact('posts'));
    }

    public function readerCorner()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $posts = UserPost::where('is_admin_post', false)->latest()->get();
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
}
