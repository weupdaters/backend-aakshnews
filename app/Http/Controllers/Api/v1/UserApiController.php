<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UpdateProfileRequest;
use App\Http\Resources\Api\v1\NewsResource;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\Bookmark;
use App\Models\ReadingHistory;
use App\Models\UserNotification;
use App\Models\UserPost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/v1/profile
     */
    public function profile()
    {
        $user = Auth::user();
        return $this->successResponse(new UserResource($user), 'User profile fetched.');
    }

    /**
     * PUT /api/v1/profile
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $updateData = [];

        if ($request->filled('name')) {
            $updateData['name'] = $request->input('name');
        }

        if ($request->filled('email')) {
            $updateData['email'] = $request->input('email');
        }

        if ($request->filled('bio')) {
            $updateData['bio'] = $request->input('bio');
        }

        if ($request->filled('avatar')) {
            $updateData['avatar'] = $request->input('avatar');
        }

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        $user->update($updateData);

        return $this->successResponse(new UserResource($user->fresh()), 'Profile updated successfully.');
    }

    /**
     * GET /api/v1/bookmarks
     */
    public function bookmarks(Request $request)
    {
        $user = Auth::user();
        $perPage = (int) $request->input('per_page', 12);

        $bookmarkedPostIds = Bookmark::where('user_id', $user->id)->pluck('user_post_id');

        $paginator = UserPost::whereIn('id', $bookmarkedPostIds)
            ->where('status', 'published')
            ->latest()
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, NewsResource::class);

        return $this->successResponse($formatted['data'], 'Bookmarked articles fetched.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }

    /**
     * GET /api/v1/history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $perPage = (int) $request->input('per_page', 12);

        $historyPostIds = ReadingHistory::where('user_id', $user->id)
            ->latest('read_at')
            ->pluck('user_post_id');

        $paginator = UserPost::whereIn('id', $historyPostIds)
            ->where('status', 'published')
            ->paginate($perPage);

        $formatted = PaginationHelper::format($paginator, NewsResource::class);

        return $this->successResponse($formatted['data'], 'Reading history fetched.', [
            'links' => $formatted['links'],
            'meta'  => $formatted['meta'],
        ]);
    }

    /**
     * GET /api/v1/notifications
     */
    public function notifications(Request $request)
    {
        $user = Auth::user();

        $notifications = UserNotification::where('user_id', $user->id)
            ->latest()
            ->get();

        return $this->successResponse($notifications, 'Notifications fetched.');
    }

    /**
     * PUT /api/v1/notification/read or /notifications/read
     */
    public function markNotificationRead(Request $request)
    {
        $user = Auth::user();
        $notificationId = $request->input('id');

        if ($notificationId) {
            UserNotification::where('user_id', $user->id)
                ->where('id', $notificationId)
                ->update(['is_read' => true]);
        } else {
            UserNotification::where('user_id', $user->id)->update(['is_read' => true]);
        }

        return $this->successResponse(null, 'Notifications marked as read.');
    }
}
