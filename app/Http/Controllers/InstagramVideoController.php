<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InstagramVideo;

class InstagramVideoController extends Controller
{
    public function index()
    {
        return response()->json(InstagramVideo::latest()->get());
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'अनधिकृत पहुंच (Unauthorized access)'], 401);
        }
        $url = $request->input('url');
        $title = $request->input('title');

        if (!$url) {
            return response()->json(['success' => false, 'message' => 'URL is required.'], 400);
        }

        if (preg_match('/instagram\.com\/(p|reel|tv)\/([a-zA-Z0-9_\-]+)/i', $url, $matches)) {
            $type = strtolower($matches[1]);
            $code = $matches[2];
            if ($type === 'reel') {
                $embed_url = "https://www.instagram.com/reel/{$code}/embed/";
            } else {
                $embed_url = "https://www.instagram.com/p/{$code}/embed/";
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please enter a valid Instagram video URL.'], 400);
        }

        $video = InstagramVideo::create([
            'title' => $title,
            'url' => $url,
            'embed_url' => $embed_url
        ]);

        return response()->json(['success' => true, 'message' => 'Instagram video added successfully!', 'video' => $video]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'अनधिकृत पहुंच (Unauthorized access)'], 401);
        }
        $video = InstagramVideo::find($id);
        if (!$video) {
            return response()->json(['success' => false, 'message' => 'Video not found.'], 404);
        }
        $video->delete();
        return response()->json(['success' => true, 'message' => 'Video deleted successfully!']);
    }
}
