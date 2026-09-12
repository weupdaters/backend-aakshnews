<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0777, true);
            }
            $file->move(public_path('uploads'), $filename);
            $url = '/uploads/' . $filename;
            return response()->json(['success' => true, 'url' => $url]);
        }
        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }
}
