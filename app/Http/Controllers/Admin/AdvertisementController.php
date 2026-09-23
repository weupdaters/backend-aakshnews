<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        $advertisements = Advertisement::latest()->get();
        return view('admin.advertisement.index', compact('advertisements'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }
        return view('admin.advertisement.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'link_url' => 'nullable|string|max:255',
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

        Advertisement::create([
            'name' => $request->input('name'),
            'image_url' => $imagePath,
            'link_url' => $request->input('link_url'),
            'status' => $request->input('status', 'active'),
        ]);

        return redirect('/admin/advertisement')->with('success', 'Advertisement added successfully!');
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            abort(404);
        }

        return view('admin.advertisement.edit', compact('advertisement'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'link_url' => 'nullable|string|max:255',
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
            'link_url' => $request->input('link_url'),
            'status' => $request->input('status'),
        ]);

        return redirect('/admin/advertisement')->with('success', 'Advertisement updated successfully!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            abort(404);
        }

        if ($advertisement->image_url && file_exists(public_path($advertisement->image_url))) {
            @unlink(public_path($advertisement->image_url));
        }

        $advertisement->delete();
        return redirect('/admin/advertisement')->with('success', 'Advertisement deleted successfully!');
    }
}
