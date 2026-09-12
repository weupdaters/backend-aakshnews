<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PhotoGallery;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $photos = PhotoGallery::latest()->get();
        return view('admin.gallery.index', compact('photos'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        PhotoGallery::create([
            'name' => $request->input('name'),
            'image_url' => $request->input('image_url'),
        ]);

        return redirect('/admin/gallery')->with('success', 'Photo added to gallery successfully!');
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $photo = PhotoGallery::find($id);
        if (!$photo) {
            abort(404);
        }

        return view('admin.gallery.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $photo = PhotoGallery::find($id);
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
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $photo = PhotoGallery::find($id);
        if (!$photo) {
            abort(404);
        }

        $photo->delete();
        return redirect('/admin/gallery')->with('success', 'Photo deleted successfully!');
    }
}
