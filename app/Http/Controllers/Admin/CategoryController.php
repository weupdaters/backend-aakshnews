<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        Category::ensureDefaults();
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
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

        Category::create([
            'name' => $request->input('name'),
            'name_en' => $request->input('name_en') ?: $request->input('name'),
            'name_hi' => $request->input('name_hi'),
            'name_pb' => $request->input('name_pb'),
            'slug' => $request->input('slug'),
            'meta_title' => $request->input('meta_title'),
            'meta_desc' => $request->input('meta_desc'),
            'meta_keywords' => $request->input('meta_keywords'),
            'image' => $imagePath,
            'color' => $request->input('color', '#3B82F6'),
            'icon' => $request->input('icon', 'newspaper'),
            'status' => $request->input('status', 'active'),
        ]);

        return redirect('/admin/category')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $category = Category::find($id);
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
            'name_en' => $request->input('name_en') ?: $request->input('name'),
            'name_hi' => $request->input('name_hi'),
            'name_pb' => $request->input('name_pb'),
            'slug' => $request->input('slug'),
            'meta_title' => $request->input('meta_title'),
            'meta_desc' => $request->input('meta_desc'),
            'meta_keywords' => $request->input('meta_keywords'),
            'image' => $imagePath,
            'color' => $request->input('color', $category->color),
            'icon' => $request->input('icon', $category->icon ?? 'newspaper'),
            'status' => $request->input('status', 'active'),
        ]);

        return redirect('/admin/category')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }

        if ($category->image && file_exists(public_path($category->image))) {
            @unlink(public_path($category->image));
        }

        $category->delete();
        return redirect('/admin/category')->with('success', 'Category deleted successfully!');
    }
}
