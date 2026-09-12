<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InstagramVideo;
use App\Models\UserPost;
use App\Models\BreakingNews;
use App\Models\PhotoGallery;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $instagramVideos = InstagramVideo::latest()->get();
        $posts = UserPost::latest()->get();
        $breakingNews = BreakingNews::latest()->get();
        $photoGallery = PhotoGallery::latest()->get();

        return view('admin.dashboard', compact('instagramVideos', 'posts', 'breakingNews', 'photoGallery'));
    }
}
