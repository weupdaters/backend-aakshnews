<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BreakingNews;
use App\Services\TranslationService;

class BreakingNewsController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en');
        $raw = BreakingNews::where('is_active', true)->latest()->get();
        $titles = [];
        foreach ($raw as $item) {
            $titles[] = TranslationService::translateText($item->title, $lang === 'pb' ? 'pa' : $lang);
        }
        return response()->json($titles);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'अनधिकृत पहुंच (Unauthorized access)'], 401);
        }
        $title = $request->input('title');
        if (!$title) {
            return response()->json(['success' => false, 'message' => 'Title is required.'], 400);
        }
        $news = BreakingNews::create([
            'title' => $title,
            'is_active' => true
        ]);
        return response()->json(['success' => true, 'message' => 'Breaking news added successfully!', 'news' => $news]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'अनधिकृत पहुंच (Unauthorized access)'], 401);
        }
        $news = BreakingNews::find($id);
        if (!$news) {
            return response()->json(['success' => false, 'message' => 'Breaking news not found.'], 404);
        }
        $news->delete();
        return response()->json(['success' => true, 'message' => 'Breaking news deleted successfully!']);
    }
}
