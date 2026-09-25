<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BreakingNews;

class BreakingNewsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $breakingNews = BreakingNews::latest()->get();
        return view('admin.breaking_news.index', compact('breakingNews'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        return view('admin.breaking_news.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:500',
            'is_active' => 'required|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = $request->input('title');
        $titleEn = $request->input('title_en');
        $titleHi = $request->input('title_hi');
        $titlePb = $request->input('title_pb');

        $detectedLang = \App\Services\TranslationService::detectLanguage($title);
        if ($detectedLang === 'pb') {
            $titlePb = $titlePb ?: $title;
            $titleHi = $titleHi ?: \App\Services\TranslationService::translateText($title, 'hi');
            $titleEn = $titleEn ?: \App\Services\TranslationService::translateText($title, 'en');
        } elseif ($detectedLang === 'hi') {
            $titleHi = $titleHi ?: $title;
            $titlePb = $titlePb ?: \App\Services\TranslationService::translateText($title, 'pa');
            $titleEn = $titleEn ?: \App\Services\TranslationService::translateText($title, 'en');
        } else {
            $titleEn = $titleEn ?: $title;
            $titleHi = $titleHi ?: \App\Services\TranslationService::translateText($title, 'hi');
            $titlePb = $titlePb ?: \App\Services\TranslationService::translateText($title, 'pa');
        }

        BreakingNews::create([
            'title' => $title,
            'title_en' => $titleEn,
            'title_hi' => $titleHi,
            'title_pb' => $titlePb,
            'is_active' => (bool) $request->input('is_active'),
        ]);

        return redirect('/admin/breaking-news')->with('success', 'Breaking News added successfully with automatic multi-language translations!');
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $breakingNews = BreakingNews::find($id);
        if (!$breakingNews) {
            abort(404);
        }

        return view('admin.breaking_news.edit', compact('breakingNews'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $breakingNews = BreakingNews::find($id);
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

        $title = $request->input('title');
        $titleEn = $request->input('title_en');
        $titleHi = $request->input('title_hi');
        $titlePb = $request->input('title_pb');

        $detectedLang = \App\Services\TranslationService::detectLanguage($title);
        if ($detectedLang === 'pb') {
            $titlePb = $titlePb ?: $title;
            $titleHi = $titleHi ?: \App\Services\TranslationService::translateText($title, 'hi');
            $titleEn = $titleEn ?: \App\Services\TranslationService::translateText($title, 'en');
        } elseif ($detectedLang === 'hi') {
            $titleHi = $titleHi ?: $title;
            $titlePb = $titlePb ?: \App\Services\TranslationService::translateText($title, 'pa');
            $titleEn = $titleEn ?: \App\Services\TranslationService::translateText($title, 'en');
        } else {
            $titleEn = $titleEn ?: $title;
            $titleHi = $titleHi ?: \App\Services\TranslationService::translateText($title, 'hi');
            $titlePb = $titlePb ?: \App\Services\TranslationService::translateText($title, 'pa');
        }

        $breakingNews->update([
            'title' => $title,
            'title_en' => $titleEn,
            'title_hi' => $titleHi,
            'title_pb' => $titlePb,
            'is_active' => (bool) $request->input('is_active'),
        ]);

        return redirect('/admin/breaking-news')->with('success', 'Breaking News updated successfully with multi-language translations!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $breakingNews = BreakingNews::find($id);
        if (!$breakingNews) {
            abort(404);
        }

        $breakingNews->delete();
        return redirect('/admin/breaking-news')->with('success', 'Breaking News deleted successfully!');
    }
}
