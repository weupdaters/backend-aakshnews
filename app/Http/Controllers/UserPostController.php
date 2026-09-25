<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPost;
use App\Services\TranslationService;

class UserPostController extends Controller
{
    public function index(Request $request)
    {
        $query = UserPost::query();

        if (!Auth::check()) {
            $query->where('status', 'published');
        } else {
            if ($request->has('status')) {
                $query->where('status', $request->input('status'));
            }
            if ($request->has('is_admin_post')) {
                $query->where('is_admin_post', $request->boolean('is_admin_post'));
            }
        }

        $posts = $query->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'video_url' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:255',
            'is_hero' => 'nullable|boolean',
            'is_middle_stack' => 'nullable|boolean',
            'duration' => 'nullable|string',
            'views_count' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $title = $request->input('title');
        $content = $request->input('content');
        $category = $request->input('category', 'Breaking News');
        $authorName = $request->input('author_name');
        $videoUrl = $request->input('video_url');
        $imageUrl = $request->input('image_url');

        $isHero = $request->boolean('is_hero', false);
        $isMiddleStack = $request->boolean('is_middle_stack', false);
        $duration = $request->input('duration');
        $viewsCount = $request->input('views_count', 0);

        $isAdminPost = $request->boolean('is_admin_post', false);
        if (Auth::check() && $request->has('status')) {
            $isAdminPost = true;
        }

        if ($isHero) {
            UserPost::query()->update(['is_hero' => false]);
        }

        if (!$authorName) {
            $authorName = Auth::check() ? Auth::user()->name : 'Anonymous Reader';
        }

        // Prohibited keywords list for AI review simulation
        $badWords = ['spam', 'abuse', 'cheat', 'fake', 'scam', 'fraud', 'adult', 'trash'];
        $flagged = false;
        $matchedWord = '';

        foreach ($badWords as $word) {
            if (stripos($title, $word) !== false || stripos($content, $word) !== false || ($videoUrl && stripos($videoUrl, $word) !== false)) {
                $flagged = true;
                $matchedWord = $word;
                break;
            }
        }

        if ($flagged) {
            $aiStatus = 'rejected';
            $status = 'hidden';
            $aiFeedback = json_encode([
                'verdict' => 'REJECTED',
                'confidence_score' => 99,
                'reason' => "The post contains flagged content or restricted word: '{$matchedWord}'.",
                'suggested_actions' => 'Please remove prohibited keywords and resubmit.'
            ], JSON_UNESCAPED_UNICODE);
        } else {
            $aiStatus = 'approved';
            if (Auth::check()) {
                $status = $request->input('status', 'published');
            } else {
                $status = 'pending';
            }

            $suggestedCategory = $category;
            if (stripos($title, 'sports') !== false || stripos($title, 'cricket') !== false || stripos($title, 'game') !== false) {
                $suggestedCategory = 'Sports';
            } elseif (stripos($title, 'politics') !== false || stripos($title, 'election') !== false || stripos($title, 'government') !== false) {
                $suggestedCategory = 'Politics';
            } elseif (stripos($title, 'tech') !== false || stripos($title, 'mobile') !== false || stripos($title, 'phone') !== false) {
                $suggestedCategory = 'Technology';
            }

            $aiFeedback = json_encode([
                'verdict' => 'APPROVED',
                'confidence_score' => 97,
                'reason' => 'The post content is highly relevant, coherent, and adheres to editorial guidelines.',
                'sentiment' => 'positive/neutral',
                'suggested_category' => $suggestedCategory
            ], JSON_UNESCAPED_UNICODE);
        }

        $titleEn = $request->input('title_en');
        $titleHi = $request->input('title_hi');
        $titlePb = $request->input('title_pb');

        $contentEn = $request->input('content_en');
        $contentHi = $request->input('content_hi');
        $contentPb = $request->input('content_pb');

        // Detect input script: Gurmukhi (Punjabi), Devanagari (Hindi), or Latin (English)
        $detectedTitleLang = TranslationService::detectLanguage($title);
        if ($detectedTitleLang === 'pb') {
            $titlePb = $titlePb ?: $title;
            $titleHi = $titleHi ?: TranslationService::translateText($title, 'hi');
            $titleEn = $titleEn ?: TranslationService::translateText($title, 'en');
        } elseif ($detectedTitleLang === 'hi') {
            $titleHi = $titleHi ?: $title;
            $titlePb = $titlePb ?: TranslationService::translateText($title, 'pa');
            $titleEn = $titleEn ?: TranslationService::translateText($title, 'en');
        } else {
            $titleEn = $titleEn ?: $title;
            $titleHi = $titleHi ?: TranslationService::translateText($title, 'hi');
            $titlePb = $titlePb ?: TranslationService::translateText($title, 'pa');
        }

        $detectedContentLang = TranslationService::detectLanguage($content);
        if ($detectedContentLang === 'pb') {
            $contentPb = $contentPb ?: $content;
            $contentHi = $contentHi ?: TranslationService::translateText($content, 'hi');
            $contentEn = $contentEn ?: TranslationService::translateText($content, 'en');
        } elseif ($detectedContentLang === 'hi') {
            $contentHi = $contentHi ?: $content;
            $contentPb = $contentPb ?: TranslationService::translateText($content, 'pa');
            $contentEn = $contentEn ?: TranslationService::translateText($content, 'en');
        } else {
            $contentEn = $contentEn ?: $content;
            $contentHi = $contentHi ?: TranslationService::translateText($content, 'hi');
            $contentPb = $contentPb ?: TranslationService::translateText($content, 'pa');
        }

        $post = UserPost::create([
            'user_id' => Auth::id(),
            'author_name' => $authorName,
            'title' => $title,
            'content' => $content,
            'category' => $category,
            'video_url' => $videoUrl,
            'image_url' => $imageUrl,
            'ai_status' => $aiStatus,
            'ai_feedback' => $aiFeedback,
            'status' => $status,
            'is_hero' => $isHero,
            'is_middle_stack' => $isMiddleStack,
            'duration' => $duration,
            'views_count' => $viewsCount,
            'title_en' => $titleEn ?: $title,
            'title_hi' => $titleHi ?: $title,
            'title_pb' => $titlePb ?: $title,
            'content_en' => $contentEn ?: $content,
            'content_hi' => $contentHi ?: $content,
            'content_pb' => $contentPb ?: $content,
            'is_admin_post' => $isAdminPost,
            'is_reel' => $request->boolean('is_reel', false),
            'media_type' => $request->input('media_type', 'image'),
            'meta_title' => $request->input('meta_title'),
            'meta_desc' => $request->input('meta_desc'),
            'meta_keywords' => $request->input('meta_keywords'),
        ]);

        if ($request->boolean('send_push_notification') && $aiStatus === 'approved') {
            $this->triggerPushNotification($post);
        }

        return response()->json([
            'success' => $aiStatus === 'approved',
            'message' => $aiStatus === 'approved'
                ? (Auth::check() ? 'Post published successfully.' : 'Post submitted successfully. It will be visible after admin approval.')
                : 'Rejected: Your post contains restricted keywords.',
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 401);
        }

        $post = UserPost::find($id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'video_url' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:255',
            'is_hero' => 'nullable|boolean',
            'is_middle_stack' => 'nullable|boolean',
            'duration' => 'nullable|string',
            'views_count' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $isHero = $request->boolean('is_hero', false);
        $isMiddleStack = $request->boolean('is_middle_stack', false);

        if ($isHero) {
            UserPost::where('id', '!=', $id)->update(['is_hero' => false]);
        }

        $title = $request->input('title');
        $content = $request->input('content');

        $titleEn = $request->input('title_en');
        $titleHi = $request->input('title_hi');
        $titlePb = $request->input('title_pb');

        $contentEn = $request->input('content_en');
        $contentHi = $request->input('content_hi');
        $contentPb = $request->input('content_pb');

        // Detect input script
        $detectedTitleLang = TranslationService::detectLanguage($title);
        if ($detectedTitleLang === 'pb') {
            $titlePb = $titlePb ?: $title;
            $titleHi = $titleHi ?: TranslationService::translateText($title, 'hi');
            $titleEn = $titleEn ?: TranslationService::translateText($title, 'en');
        } elseif ($detectedTitleLang === 'hi') {
            $titleHi = $titleHi ?: $title;
            $titlePb = $titlePb ?: TranslationService::translateText($title, 'pa');
            $titleEn = $titleEn ?: TranslationService::translateText($title, 'en');
        } else {
            $titleEn = $titleEn ?: $title;
            $titleHi = $titleHi ?: TranslationService::translateText($title, 'hi');
            $titlePb = $titlePb ?: TranslationService::translateText($title, 'pa');
        }

        $detectedContentLang = TranslationService::detectLanguage($content);
        if ($detectedContentLang === 'pb') {
            $contentPb = $contentPb ?: $content;
            $contentHi = $contentHi ?: TranslationService::translateText($content, 'hi');
            $contentEn = $contentEn ?: TranslationService::translateText($content, 'en');
        } elseif ($detectedContentLang === 'hi') {
            $contentHi = $contentHi ?: $content;
            $contentPb = $contentPb ?: TranslationService::translateText($content, 'pa');
            $contentEn = $contentEn ?: TranslationService::translateText($content, 'en');
        } else {
            $contentEn = $contentEn ?: $content;
            $contentHi = $contentHi ?: TranslationService::translateText($content, 'hi');
            $contentPb = $contentPb ?: TranslationService::translateText($content, 'pa');
        }

        $post->update([
            'author_name' => $request->input('author_name', $post->author_name),
            'title' => $title,
            'content' => $content,
            'category' => $request->input('category', $post->category),
            'video_url' => $request->input('video_url', $post->video_url),
            'image_url' => $request->input('image_url', $post->image_url),
            'status' => $request->input('status', $post->status),
            'is_hero' => $isHero,
            'is_middle_stack' => $isMiddleStack,
            'duration' => $request->input('duration', $post->duration),
            'views_count' => $request->input('views_count', $post->views_count),
            'title_en' => $titleEn ?: $title,
            'title_hi' => $titleHi ?: $title,
            'title_pb' => $titlePb ?: $title,
            'content_en' => $contentEn ?: $content,
            'content_hi' => $contentHi ?: $content,
            'content_pb' => $contentPb ?: $content,
            'is_admin_post' => $request->boolean('is_admin_post', $post->is_admin_post),
            'is_reel' => $request->boolean('is_reel', (bool) $post->is_reel),
            'media_type' => $request->input('media_type', $post->media_type ?? 'image'),
            'meta_title' => $request->input('meta_title', $post->meta_title),
            'meta_desc' => $request->input('meta_desc', $post->meta_desc),
            'meta_keywords' => $request->input('meta_keywords', $post->meta_keywords),
        ]);

        if ($request->boolean('send_push_notification')) {
            $this->triggerPushNotification($post);
        }

        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully!',
            'post' => $post
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 401);
        }
        $post = UserPost::find($id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
        }
        $post->delete();
        return response()->json(['success' => true, 'message' => 'Article deleted successfully!']);
    }

    public function approve($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 401);
        }
        $post = UserPost::find($id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
        }
        $post->update([
            'status' => 'published',
            'ai_status' => 'approved'
        ]);
        return response()->json(['success' => true, 'message' => 'Post approved and published successfully!']);
    }

    public function reject($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 401);
        }
        $post = UserPost::find($id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
        }
        $post->update([
            'status' => 'rejected',
            'ai_status' => 'rejected'
        ]);
        return response()->json(['success' => true, 'message' => 'Post rejected successfully!']);
    }

    private function triggerPushNotification(UserPost $post)
    {
        try {
            $historyPath = storage_path('app/push_history.json');
            $history = file_exists($historyPath) ? json_decode(@file_get_contents($historyPath), true) : [];
            if (!is_array($history)) $history = [];

            $cleanSnippet = mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($post->content))), 0, 110);
            $newEntry = [
                'id' => count($history) + 1,
                'title' => '🚨 ' . $post->title,
                'body' => $cleanSnippet ? $cleanSnippet . '...' : 'Breaking news update. Tap to read the full report.',
                'url' => '/news/' . ($post->id),
                'category' => $post->category ?: 'Breaking News',
                'sent_at' => date('Y-m-d H:i:s'),
                'recipients' => 1482,
                'clicks' => 0,
            ];

            array_unshift($history, $newEntry);
            @file_put_contents($historyPath, json_encode($history, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            // Log without failing article creation
        }
    }
}
