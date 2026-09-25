<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|mimes:jpeg,png,jpg,webp,gif|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $file = $request->file('image');
        $allowedExtensions = ['jpeg', 'png', 'jpg', 'webp', 'gif'];
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file extension. Only image files (JPG, PNG, WebP, GIF) are allowed.'
            ], 422);
        }

        $uploadDir = public_path('uploads');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Prevent script execution in uploads directory
        $htaccessPath = $uploadDir . DIRECTORY_SEPARATOR . '.htaccess';
        if (!file_exists($htaccessPath)) {
            @file_put_contents($htaccessPath, "<FilesMatch \"\\.(php|phtml|php3|php4|php5|php7|phar|sh|cgi|pl|py)$\">\n    Order Deny,Allow\n    Deny from all\n</FilesMatch>\n");
        }

        // Generate safe randomized filename
        $safeName = 'img_' . time() . '_' . Str::random(12) . '.' . $ext;
        $file->move($uploadDir, $safeName);

        $url = '/uploads/' . $safeName;
        return response()->json([
            'success' => true,
            'url' => $url,
            'filename' => $safeName
        ]);
    }
}
