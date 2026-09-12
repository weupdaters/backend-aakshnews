<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhotoGallery;
use App\Services\TranslationService;

class PhotoGalleryController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en');
        $photos = PhotoGallery::latest()->get();
        $translated = [];
        foreach ($photos as $photo) {
            $translated[] = [
                'id' => $photo->id,
                'name' => TranslationService::translateText($photo->name, $lang === 'pb' ? 'pa' : $lang),
                'image_url' => $photo->image_url,
                'created_at' => $photo->created_at,
                'updated_at' => $photo->updated_at,
            ];
        }
        return response()->json($translated);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'अनधिकृत पहुंच (Unauthorized access)'], 401);
        }
        $name = $request->input('name');
        $imageUrl = $request->input('image_url');
        if (!$name || !$imageUrl) {
            return response()->json(['success' => false, 'message' => 'Name and image URL are required.'], 400);
        }
        $photo = PhotoGallery::create([
            'name' => $name,
            'image_url' => $imageUrl
        ]);
        return response()->json(['success' => true, 'message' => 'Photo added successfully!', 'photo' => $photo]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'अनधिकृत पहुंच (Unauthorized access)'], 401);
        }
        $photo = PhotoGallery::find($id);
        if (!$photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 404);
        }
        $photo->delete();
        return response()->json(['success' => true, 'message' => 'Photo deleted successfully!']);
    }
}
