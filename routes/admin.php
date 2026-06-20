<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

Route::get('/admin/dashboard', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $instagramVideos = \App\Models\InstagramVideo::latest()->get();
    $posts = \App\Models\UserPost::latest()->get();
    $breakingNews = \App\Models\BreakingNews::latest()->get();
    $photoGallery = \App\Models\PhotoGallery::latest()->get();
    return view('admin.dashboard', compact('instagramVideos', 'posts', 'breakingNews', 'photoGallery'));
});

// Admin Category Management Routes
Route::get('/admin/category', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    
    // Seed default categories if database is empty
    if (\App\Models\Category::count() === 0) {
        $defaults = [
            ['name' => 'National', 'slug' => 'national', 'color' => '#3B82F6', 'status' => 'active'],
            ['name' => 'State', 'slug' => 'state', 'color' => '#10B981', 'status' => 'active'],
            ['name' => 'Politics', 'slug' => 'politics', 'color' => '#8B5CF6', 'status' => 'active'],
            ['name' => 'Sports', 'slug' => 'sports', 'color' => '#F59E0B', 'status' => 'active'],
            ['name' => 'Business', 'slug' => 'business', 'color' => '#374151', 'status' => 'active'],
            ['name' => 'Technology', 'slug' => 'technology', 'color' => '#06B6D4', 'status' => 'active'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'color' => '#EC4899', 'status' => 'active'],
            ['name' => 'World', 'slug' => 'world', 'color' => '#14B8A6', 'status' => 'active'],
        ];
        foreach ($defaults as $cat) {
            \App\Models\Category::create($cat);
        }
    }

    $categories = \App\Models\Category::latest()->get();
    return view('admin.category.index', compact('categories'));
});

Route::get('/admin/category/create', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    return view('admin.category.create');
});

Route::post('/admin/category', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
        'color' => 'required|string|max:7',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/categories'), $fileName);
        $imagePath = 'uploads/categories/' . $fileName;
    }

    \App\Models\Category::create([
        'name' => $request->input('name'),
        'slug' => $request->input('slug'),
        'meta_title' => $request->input('meta_title'),
        'meta_desc' => $request->input('meta_desc'),
        'meta_keywords' => $request->input('meta_keywords'),
        'image' => $imagePath,
        'color' => $request->input('color', '#000000'),
        'status' => $request->input('status', 'active'),
    ]);

    return redirect('/admin/category')->with('success', 'Category added successfully!');
});

Route::get('/admin/category/{id}/edit', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $category = \App\Models\Category::find($id);
    if (!$category) {
        abort(404);
    }

    return view('admin.category.edit', compact('category'));
});

Route::put('/admin/category/{id}', function (Request $request, $id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $category = \App\Models\Category::find($id);
    if (!$category) {
        abort(404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
        'color' => 'required|string|max:7',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $imagePath = $category->image;
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($imagePath && file_exists(public_path($imagePath))) {
            @unlink(public_path($imagePath));
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/categories'), $fileName);
        $imagePath = 'uploads/categories/' . $fileName;
    }

    $category->update([
        'name' => $request->input('name'),
        'slug' => $request->input('slug'),
        'meta_title' => $request->input('meta_title'),
        'meta_desc' => $request->input('meta_desc'),
        'meta_keywords' => $request->input('meta_keywords'),
        'image' => $imagePath,
        'color' => $request->input('color'),
        'status' => $request->input('status'),
    ]);

    return redirect('/admin/category')->with('success', 'Category updated successfully!');
});

Route::delete('/admin/category/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $category = \App\Models\Category::find($id);
    if (!$category) {
        abort(404);
    }

    // Delete image file if exists
    if ($category->image && file_exists(public_path($category->image))) {
        @unlink(public_path($category->image));
    }

    $category->delete();
    return redirect('/admin/category')->with('success', 'Category deleted successfully!');
});

// Admin Advertisement Management Routes
Route::get('/admin/advertisement', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $advertisements = \App\Models\Advertisement::latest()->get();
    return view('admin.advertisement.index', compact('advertisements'));
});

Route::get('/admin/advertisement/create', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    return view('admin.advertisement.create');
});

Route::post('/admin/advertisement', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image' => 'required|image|max:4096',
        'status' => 'required|string|in:active,inactive',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        if (!file_exists(public_path('uploads/advertisements'))) {
            mkdir(public_path('uploads/advertisements'), 0777, true);
        }
        $file->move(public_path('uploads/advertisements'), $fileName);
        $imagePath = 'uploads/advertisements/' . $fileName;
    }

    \App\Models\Advertisement::create([
        'name' => $request->input('name'),
        'image_url' => $imagePath,
        'status' => $request->input('status', 'active'),
    ]);

    return redirect('/admin/advertisement')->with('success', 'Advertisement added successfully!');
});

Route::get('/admin/advertisement/{id}/edit', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $advertisement = \App\Models\Advertisement::find($id);
    if (!$advertisement) {
        abort(404);
    }

    return view('admin.advertisement.edit', compact('advertisement'));
});

Route::put('/admin/advertisement/{id}', function (Request $request, $id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $advertisement = \App\Models\Advertisement::find($id);
    if (!$advertisement) {
        abort(404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|max:4096',
        'status' => 'required|string|in:active,inactive',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $imagePath = $advertisement->image_url;
    if ($request->hasFile('image')) {
        if ($imagePath && file_exists(public_path($imagePath))) {
            @unlink(public_path($imagePath));
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        if (!file_exists(public_path('uploads/advertisements'))) {
            mkdir(public_path('uploads/advertisements'), 0777, true);
        }
        $file->move(public_path('uploads/advertisements'), $fileName);
        $imagePath = 'uploads/advertisements/' . $fileName;
    }

    $advertisement->update([
        'name' => $request->input('name'),
        'image_url' => $imagePath,
        'status' => $request->input('status'),
    ]);

    return redirect('/admin/advertisement')->with('success', 'Advertisement updated successfully!');
});

Route::delete('/admin/advertisement/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $advertisement = \App\Models\Advertisement::find($id);
    if (!$advertisement) {
        abort(404);
    }

    if ($advertisement->image_url && file_exists(public_path($advertisement->image_url))) {
        @unlink(public_path($advertisement->image_url));
    }

    $advertisement->delete();
    return redirect('/admin/advertisement')->with('success', 'Advertisement deleted successfully!');
});

// Admin News Article Management Routes
Route::get('/admin/post', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $posts = \App\Models\UserPost::latest()->get();
    return view('admin.post.index', compact('posts'));
});

Route::get('/admin/post/create', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    
    // Seed default categories if database is empty
    if (\App\Models\Category::count() === 0) {
        $defaults = [
            ['name' => 'National', 'slug' => 'national', 'color' => '#3B82F6', 'status' => 'active'],
            ['name' => 'State', 'slug' => 'state', 'color' => '#10B981', 'status' => 'active'],
            ['name' => 'Politics', 'slug' => 'politics', 'color' => '#8B5CF6', 'status' => 'active'],
            ['name' => 'Sports', 'slug' => 'sports', 'color' => '#F59E0B', 'status' => 'active'],
            ['name' => 'Business', 'slug' => 'business', 'color' => '#374151', 'status' => 'active'],
            ['name' => 'Technology', 'slug' => 'technology', 'color' => '#06B6D4', 'status' => 'active'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'color' => '#EC4899', 'status' => 'active'],
            ['name' => 'World', 'slug' => 'world', 'color' => '#14B8A6', 'status' => 'active'],
        ];
        foreach ($defaults as $cat) {
            \App\Models\Category::create($cat);
        }
    }

    $categories = \App\Models\Category::where('status', 'active')->latest()->get();
    return view('admin.post.create', compact('categories'));
});

Route::get('/admin/post/{id}/edit', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $post = \App\Models\UserPost::find($id);
    if (!$post) {
        abort(404);
    }

    // Seed default categories if database is empty
    if (\App\Models\Category::count() === 0) {
        $defaults = [
            ['name' => 'National', 'slug' => 'national', 'color' => '#3B82F6', 'status' => 'active'],
            ['name' => 'State', 'slug' => 'state', 'color' => '#10B981', 'status' => 'active'],
            ['name' => 'Politics', 'slug' => 'politics', 'color' => '#8B5CF6', 'status' => 'active'],
            ['name' => 'Sports', 'slug' => 'sports', 'color' => '#F59E0B', 'status' => 'active'],
            ['name' => 'Business', 'slug' => 'business', 'color' => '#374151', 'status' => 'active'],
            ['name' => 'Technology', 'slug' => 'technology', 'color' => '#06B6D4', 'status' => 'active'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'color' => '#EC4899', 'status' => 'active'],
            ['name' => 'World', 'slug' => 'world', 'color' => '#14B8A6', 'status' => 'active'],
        ];
        foreach ($defaults as $cat) {
            \App\Models\Category::create($cat);
        }
    }

    $categories = \App\Models\Category::where('status', 'active')->latest()->get();
    return view('admin.post.edit', compact('post', 'categories'));
});

// Admin Breaking News Management Routes
Route::get('/admin/breaking-news', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $breakingNews = \App\Models\BreakingNews::latest()->get();
    return view('admin.breaking_news.index', compact('breakingNews'));
});

Route::get('/admin/breaking-news/create', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    return view('admin.breaking_news.create');
});

Route::post('/admin/breaking-news', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:500',
        'is_active' => 'required|integer|in:0,1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    \App\Models\BreakingNews::create([
        'title' => $request->input('title'),
        'is_active' => (bool) $request->input('is_active'),
    ]);

    return redirect('/admin/breaking-news')->with('success', 'Breaking News added successfully!');
});

Route::get('/admin/breaking-news/{id}/edit', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $breakingNews = \App\Models\BreakingNews::find($id);
    if (!$breakingNews) {
        abort(404);
    }

    return view('admin.breaking_news.edit', compact('breakingNews'));
});

Route::put('/admin/breaking-news/{id}', function (Request $request, $id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $breakingNews = \App\Models\BreakingNews::find($id);
    if (!$breakingNews) {
        abort(404);
    }

    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:500',
        'is_active' => 'required|integer|in:0,1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $breakingNews->update([
        'title' => $request->input('title'),
        'is_active' => (bool) $request->input('is_active'),
    ]);

    return redirect('/admin/breaking-news')->with('success', 'Breaking News updated successfully!');
});

Route::delete('/admin/breaking-news/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $breakingNews = \App\Models\BreakingNews::find($id);
    if (!$breakingNews) {
        abort(404);
    }

    $breakingNews->delete();
    return redirect('/admin/breaking-news')->with('success', 'Breaking News deleted successfully!');
});

// Admin Instagram Reels Management Routes
Route::get('/admin/instagram', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $reels = \App\Models\InstagramVideo::latest()->get();
    return view('admin.instagram.index', compact('reels'));
});

Route::get('/admin/instagram/create', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    return view('admin.instagram.create');
});

Route::post('/admin/instagram', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $validator = Validator::make($request->all(), [
        'url' => 'required|url',
        'title' => 'nullable|string|max:500',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $url = $request->input('url');
    $title = $request->input('title');

    if (preg_match('/instagram\.com\/(p|reel|tv)\/([a-zA-Z0-9_\-]+)/i', $url, $matches)) {
        $type = strtolower($matches[1]);
        $code = $matches[2];
        if ($type === 'reel') {
            $embed_url = "https://www.instagram.com/reel/{$code}/embed/";
        } else {
            $embed_url = "https://www.instagram.com/p/{$code}/embed/";
        }
    } else {
        return redirect()->back()->with('error', 'Invalid Instagram URL. Please enter a valid Reel, Post or TV URL.')->withInput();
    }

    \App\Models\InstagramVideo::create([
        'title' => $title,
        'url' => $url,
        'embed_url' => $embed_url
    ]);

    return redirect('/admin/instagram')->with('success', 'Instagram Reel added successfully!');
});

Route::get('/admin/instagram/{id}/edit', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $reel = \App\Models\InstagramVideo::find($id);
    if (!$reel) {
        abort(404);
    }

    return view('admin.instagram.edit', compact('reel'));
});

Route::put('/admin/instagram/{id}', function (Request $request, $id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $reel = \App\Models\InstagramVideo::find($id);
    if (!$reel) {
        abort(404);
    }

    $validator = Validator::make($request->all(), [
        'url' => 'required|url',
        'title' => 'nullable|string|max:500',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $url = $request->input('url');
    $title = $request->input('title');

    if (preg_match('/instagram\.com\/(p|reel|tv)\/([a-zA-Z0-9_\-]+)/i', $url, $matches)) {
        $type = strtolower($matches[1]);
        $code = $matches[2];
        if ($type === 'reel') {
            $embed_url = "https://www.instagram.com/reel/{$code}/embed/";
        } else {
            $embed_url = "https://www.instagram.com/p/{$code}/embed/";
        }
    } else {
        return redirect()->back()->with('error', 'Invalid Instagram URL. Please enter a valid Reel, Post or TV URL.')->withInput();
    }

    $reel->update([
        'title' => $title,
        'url' => $url,
        'embed_url' => $embed_url
    ]);

    return redirect('/admin/instagram')->with('success', 'Instagram Reel updated successfully!');
});

Route::delete('/admin/instagram/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $reel = \App\Models\InstagramVideo::find($id);
    if (!$reel) {
        abort(404);
    }

    $reel->delete();
    return redirect('/admin/instagram')->with('success', 'Instagram Reel deleted successfully!');
});

// Admin Photo Gallery Management Routes
Route::get('/admin/gallery', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    $photos = \App\Models\PhotoGallery::latest()->get();
    return view('admin.gallery.index', compact('photos'));
});

Route::get('/admin/gallery/create', function () {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }
    return view('admin.gallery.create');
});

Route::post('/admin/gallery', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image_url' => 'required|url',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    \App\Models\PhotoGallery::create([
        'name' => $request->input('name'),
        'image_url' => $request->input('image_url'),
    ]);

    return redirect('/admin/gallery')->with('success', 'Photo added to gallery successfully!');
});

Route::get('/admin/gallery/{id}/edit', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $photo = \App\Models\PhotoGallery::find($id);
    if (!$photo) {
        abort(404);
    }

    return view('admin.gallery.edit', compact('photo'));
});

Route::put('/admin/gallery/{id}', function (Request $request, $id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $photo = \App\Models\PhotoGallery::find($id);
    if (!$photo) {
        abort(404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image_url' => 'required|url',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $photo->update([
        'name' => $request->input('name'),
        'image_url' => $request->input('image_url'),
    ]);

    return redirect('/admin/gallery')->with('success', 'Photo updated successfully!');
});

Route::delete('/admin/gallery/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Please log in.');
    }

    $photo = \App\Models\PhotoGallery::find($id);
    if (!$photo) {
        abort(404);
    }

    $photo->delete();
    return redirect('/admin/gallery')->with('success', 'Photo deleted successfully!');
});
