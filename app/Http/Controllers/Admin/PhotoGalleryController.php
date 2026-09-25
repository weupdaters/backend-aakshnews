<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PhotoGallery;

class PhotoGalleryController extends Controller
{
    /**
     * Supported image extensions.
     */
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'bmp'];

    /**
     * Recursively scan directory for image files.
     */
    private function scanImages($dir, $prefix, $sourceType)
    {
        $files = [];
        if (!is_dir($dir)) {
            return $files;
        }

        $items = @scandir($dir);
        if (!$items) return $files;

        foreach ($items as $item) {
            if ($item === '.' || $item === '..' || $item === '.htaccess' || $item === '.gitignore') {
                continue;
            }

            $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($fullPath)) {
                $subFiles = $this->scanImages($fullPath, $prefix . '/' . $item, $sourceType);
                $files = array_merge($files, $subFiles);
            } else {
                $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                if (in_array($ext, $this->allowedExtensions)) {
                    $size = @filesize($fullPath) ?: 0;
                    $mtime = @filemtime($fullPath) ?: 0;
                    $relUrl = $prefix . '/' . $item;
                    $token = base64_encode($sourceType . ':::' . $fullPath);

                    $folder = basename(dirname($fullPath));
                    if ($folder === 'public' || $folder === 'uploads') {
                        $folderName = 'General';
                    } else {
                        $folderName = ucfirst($folder);
                    }

                    $files[] = [
                        'name' => $item,
                        'url' => $relUrl,
                        'full_path' => $fullPath,
                        'token' => $token,
                        'source' => $sourceType,
                        'folder' => $folderName,
                        'size' => $this->formatBytes($size),
                        'raw_size' => $size,
                        'mtime' => $mtime,
                        'date' => date('d M Y, h:i A', $mtime),
                    ];
                }
            }
        }
        return $files;
    }

    /**
     * Format bytes to readable size string.
     */
    private function formatBytes($bytes, $precision = 1)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Validate and resolve token to safe absolute path.
     */
    private function resolveSafePath($token)
    {
        $decoded = @base64_decode($token);
        if (!$decoded || !str_contains($decoded, ':::')) {
            return null;
        }

        [$sourceType, $fullPath] = explode(':::', $decoded, 2);

        $realPath = realpath($fullPath);
        if (!$realPath || !file_exists($realPath)) {
            return null;
        }

        // Validate strictly against allowed directories
        $allowedBases = array_filter([
            realpath(storage_path('app/public')),
            realpath(public_path('uploads')),
            realpath(public_path('storage')),
        ]);

        $isSafe = false;
        foreach ($allowedBases as $base) {
            if ($base && str_starts_with($realPath, $base)) {
                $isSafe = true;
                break;
            }
        }

        return $isSafe ? $realPath : null;
    }

    /**
     * Display Media Library with storage image files.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        // 1. Scan storage/app/public
        $storageDir = storage_path('app/public');
        $storageFiles = $this->scanImages($storageDir, '/storage', 'storage');

        // 2. Scan public/uploads
        $uploadsDir = public_path('uploads');
        $uploadFiles = $this->scanImages($uploadsDir, '/uploads', 'uploads');

        $allFiles = array_merge($storageFiles, $uploadFiles);

        // Sort newest first
        usort($allFiles, function ($a, $b) {
            return $b['mtime'] <=> $a['mtime'];
        });

        $totalCount = count($allFiles);
        $totalBytes = array_sum(array_column($allFiles, 'raw_size'));
        $totalSizeFormatted = $this->formatBytes($totalBytes);

        // Folder counts
        $folders = [
            'all' => 'All Images (' . $totalCount . ')',
        ];
        foreach ($allFiles as $f) {
            $fName = $f['folder'];
            if (!isset($folders[$fName])) {
                $folders[$fName] = $fName;
            }
        }

        // Filter by folder if requested
        $selectedFolder = $request->input('folder', 'all');
        $filteredFiles = $allFiles;
        if ($selectedFolder !== 'all') {
            $filteredFiles = array_filter($filteredFiles, function ($file) use ($selectedFolder) {
                return strtolower($file['folder']) === strtolower($selectedFolder);
            });
        }

        // Search query
        if ($q = $request->input('q')) {
            $q = strtolower(trim($q));
            $filteredFiles = array_filter($filteredFiles, function ($file) use ($q) {
                return str_contains(strtolower($file['name']), $q);
            });
        }

        // Paginate (32 per page)
        $page = (int) $request->input('page', 1);
        $perPage = 32;
        $offset = ($page * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($filteredFiles, $offset, $perPage);
        $paginatedFiles = new LengthAwarePaginator(
            $itemsForCurrentPage,
            count($filteredFiles),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Curated slider photos
        $curatedPhotos = PhotoGallery::latest()->get();

        return view('admin.gallery.index', compact(
            'paginatedFiles',
            'totalCount',
            'totalSizeFormatted',
            'folders',
            'selectedFolder',
            'curatedPhotos'
        ));
    }

    /**
     * Upload one or more new images to storage.
     */
    public function upload(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $request->validate([
            'images'   => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,webp,gif,svg|max:15360',
            'image'    => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:15360',
        ]);

        $files = $request->file('images') ?: [];
        if ($request->hasFile('image')) {
            $files[] = $request->file('image');
        }

        if (empty($files)) {
            return redirect()->back()->with('error', 'Please select at least one image file.');
        }

        $targetFolder = $request->input('folder', 'uploads');
        if ($targetFolder === 'posts') {
            $uploadDir = storage_path('app/public/posts');
        } else {
            $uploadDir = public_path('uploads');
        }

        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $uploaded = 0;
        foreach ($files as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            if (in_array($ext, $this->allowedExtensions)) {
                $safeName = 'media_' . time() . '_' . Str::random(8) . '.' . $ext;
                $file->move($uploadDir, $safeName);
                $uploaded++;
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', "{$uploaded} image(s) uploaded to Media Library successfully!");
    }

    /**
     * Delete a single image file from disk.
     */
    public function destroyFile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $token = $request->input('token');
        $safePath = $this->resolveSafePath($token);

        if (!$safePath) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'File not found or protected.'], 404);
            }
            return redirect()->back()->with('error', 'File not found or protected.');
        }

        @unlink($safePath);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Image permanently deleted from storage.']);
        }
        return redirect()->back()->with('success', 'Image permanently deleted from storage.');
    }

    /**
     * Delete multiple selected image files from disk (Bulk Action).
     */
    public function bulkDestroy(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $tokens = $request->input('tokens', []);
        if (!is_array($tokens) || empty($tokens)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No images selected for deletion.'], 422);
            }
            return redirect()->back()->with('error', 'No images selected for deletion.');
        }

        $deletedCount = 0;
        foreach ($tokens as $token) {
            $safePath = $this->resolveSafePath($token);
            if ($safePath && @unlink($safePath)) {
                $deletedCount++;
            }
        }

        $msg = "{$deletedCount} " . ($deletedCount === 1 ? 'image' : 'images') . " permanently deleted from storage.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'deleted' => $deletedCount,
                'message' => $msg,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Legacy Photo Gallery slider management methods.
     */
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
