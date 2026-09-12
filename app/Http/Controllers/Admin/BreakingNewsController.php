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

        BreakingNews::create([
            'title' => $request->input('title'),
            'is_active' => (bool) $request->input('is_active'),
        ]);

        return redirect('/admin/breaking-news')->with('success', 'Breaking News added successfully!');
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

        $breakingNews->update([
            'title' => $request->input('title'),
            'is_active' => (bool) $request->input('is_active'),
        ]);

        return redirect('/admin/breaking-news')->with('success', 'Breaking News updated successfully!');
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
