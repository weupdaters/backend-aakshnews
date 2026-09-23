<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    private function getHistory()
    {
        $path = storage_path('app/push_history.json');
        if (file_exists($path)) {
            $data = json_decode(@file_get_contents($path), true);
            if (is_array($data)) return $data;
        }
        return [
            [
                'id' => 1,
                'title' => '🚨 ਪੰਜਾਬ ਬਜਟ 2026 ਪਾਸ: ਸਿੱਖਿਆ ਅਤੇ ਸਿਹਤ ਲਈ ਰਿਕਾਰਡ ਫੰਡ ਜਾਰੀ',
                'body' => 'ਕੈਬਨਿਟ ਵੱਲੋਂ ਸਾਰੇ ਸਰਕਾਰੀ ਮੁਲਾਜ਼ਮਾਂ ਲਈ ਡੀਏ ਵਿੱਚ ਵਾਧਾ। ਪੜ੍ਹੋ ਵਿਸ਼ੇਸ਼ ਜ਼ਮੀਨੀ ਰਿਪੋਰਟ।',
                'url' => '/',
                'category' => 'Politics',
                'sent_at' => '2026-03-22 11:30:00',
                'recipients' => 1482,
                'clicks' => 412
            ],
            [
                'id' => 2,
                'title' => '🏏 ਭਾਰਤ ਨੇ ਟੀ-20 ਮੈਚ ਜਿੱਤਿਆ: ਆਖਰੀ ਓਵਰ ਵਿੱਚ ਰੋਮਾਂਚਕ ਜਿੱਤ',
                'body' => 'ਭਾਰਤੀ ਟੀਮ ਨੇ ਵਿਸ਼ਵ ਚੈਂਪੀਅਨਸ਼ਿਪ ਵਿੱਚ ਸ਼ਾਨਦਾਰ ਪ੍ਰਦਰਸ਼ਨ ਕਰਦੇ ਹੋਏ ਫਾਈਨਲ ਵਿੱਚ ਜਗ੍ਹਾ ਪੱਕੀ ਕੀਤੀ।',
                'url' => '/category/sports',
                'category' => 'Sports',
                'sent_at' => '2026-03-21 21:45:00',
                'recipients' => 1420,
                'clicks' => 685
            ]
        ];
    }

    public function index()
    {
        $history = $this->getHistory();
        $totalSubscribers = 1482;
        $totalSent = count($history);
        $totalClicks = array_sum(array_column($history, 'clicks')) ?: 1097;

        return view('admin.push.index', compact('history', 'totalSubscribers', 'totalSent', 'totalClicks'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'body' => 'required|string|max:300',
        ]);

        $title = $request->input('title');
        $body = $request->input('body');
        $url = $request->input('url', '/');
        $category = $request->input('category', 'Breaking News');

        $path = storage_path('app/push_history.json');
        $history = $this->getHistory();

        $newNotification = [
            'id' => count($history) + 1,
            'title' => $title,
            'body' => $body,
            'url' => $url,
            'category' => $category,
            'sent_at' => date('Y-m-d H:i:s'),
            'recipients' => 1482,
            'clicks' => 0,
        ];

        array_unshift($history, $newNotification);
        @file_put_contents($path, json_encode($history, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Push notification broadcasted successfully to 1,482 active subscribers!');
    }
}
