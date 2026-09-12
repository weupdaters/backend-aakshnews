<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\InstagramVideo;

class InstagramVideoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $reels = InstagramVideo::latest()->get();
        return view('admin.instagram.index', compact('reels'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        return view('admin.instagram.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
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

        InstagramVideo::create([
            'title' => $title,
            'url' => $url,
            'embed_url' => $embed_url
        ]);

        return redirect('/admin/instagram')->with('success', 'Instagram Reel added successfully!');
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $reel = InstagramVideo::find($id);
        if (!$reel) {
            abort(404);
        }

        return view('admin.instagram.edit', compact('reel'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $reel = InstagramVideo::find($id);
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
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $reel = InstagramVideo::find($id);
        if (!$reel) {
            abort(404);
        }

        $reel->delete();
        return redirect('/admin/instagram')->with('success', 'Instagram Reel deleted successfully!');
    }
}
