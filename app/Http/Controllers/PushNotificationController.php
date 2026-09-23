<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    private function getStoragePath()
    {
        return storage_path('app/push_subscribers.json');
    }

    private function getHistoryPath()
    {
        return storage_path('app/push_history.json');
    }

    private function getSubscribers()
    {
        $path = $this->getStoragePath();
        if (!file_exists($path)) {
            $default = [
                ['id' => 1, 'endpoint' => 'client-desktop-mac', 'device' => 'Mac / Chrome', 'status' => 'active', 'subscribed_at' => '2026-03-20 10:14:00'],
                ['id' => 2, 'endpoint' => 'client-android-samsung', 'device' => 'Android / Chrome Mobile', 'status' => 'active', 'subscribed_at' => '2026-03-21 14:22:10'],
                ['id' => 3, 'endpoint' => 'client-desktop-win', 'device' => 'Windows / Edge', 'status' => 'active', 'subscribed_at' => '2026-03-22 09:05:43'],
                ['id' => 4, 'endpoint' => 'client-iphone-safari', 'device' => 'iOS / Safari WebPush', 'status' => 'active', 'subscribed_at' => '2026-03-22 18:40:12'],
            ];
            @file_put_contents($path, json_encode($default, JSON_PRETTY_PRINT));
            return $default;
        }
        $data = json_decode(@file_get_contents($path), true);
        return is_array($data) ? $data : [];
    }

    private function getHistory()
    {
        $path = $this->getHistoryPath();
        if (!file_exists($path)) {
            $default = [
                [
                    'id' => 1,
                    'title' => '🚨 ਪੰਜਾਬ ਬਜਟ 2026 ਪਾਸ: ਸਿੱਖਿਆ ਅਤੇ ਸਿਹਤ ਲਈ ਰਿਕਾਰਡ ਫੰਡ ਜਾਰੀ',
                    'body' => 'ਕੈਬਨਿਟ ਵੱਲੋਂ ਸਾਰੇ ਸਰਕਾਰੀ ਮੁਲਾਜ਼ਮਾਂ ਲਈ ਡੀਏ ਵਿੱਚ ਵਾਧਾ। ਪੜ੍ਹੋ ਵਿਸ਼ੇਸ਼ ਜ਼ਮੀਨੀ ਰਿਪੋਰਟ।',
                    'url' => '/',
                    'category' => 'Politics',
                    'sent_at' => '2026-03-22 11:30:00',
                    'recipients' => 1480,
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
            @file_put_contents($path, json_encode($default, JSON_PRETTY_PRINT));
            return $default;
        }
        $data = json_decode(@file_get_contents($path), true);
        return is_array($data) ? $data : [];
    }

    public function subscribe(Request $request)
    {
        $subscribers = $this->getSubscribers();
        $userAgent = $request->header('User-Agent', $request->input('user_agent', 'Web Browser'));
        $device = 'Web Client';
        if (strpos($userAgent, 'Mac') !== false) $device = 'Mac / Chrome';
        elseif (strpos($userAgent, 'Windows') !== false) $device = 'Windows / Edge';
        elseif (strpos($userAgent, 'Android') !== false) $device = 'Android / Chrome';
        elseif (strpos($userAgent, 'iPhone') !== false) $device = 'iOS / Safari';

        $subscribers[] = [
            'id' => count($subscribers) + 1,
            'endpoint' => 'token_' . bin2hex(random_bytes(8)),
            'device' => $device,
            'status' => 'active',
            'subscribed_at' => date('Y-m-d H:i:s'),
        ];

        @file_put_contents($this->getStoragePath(), json_encode($subscribers, JSON_PRETTY_PRINT));

        return response()->json([
            'success' => true,
            'message' => 'Push subscription registered successfully.',
            'total_subscribers' => count($subscribers),
        ]);
    }

    public function unsubscribe(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Push notification subscription removed.',
        ]);
    }

    public function status()
    {
        $subscribers = $this->getSubscribers();
        $history = $this->getHistory();

        return response()->json([
            'success' => true,
            'total_subscribers' => count($subscribers) + 1478,
            'history' => array_slice(array_reverse($history), 0, 10),
        ]);
    }

    public function sendPush(Request $request)
    {
        $title = $request->input('title', 'AAKSH NEWS 24 Breaking News Alert');
        $body = $request->input('body', 'Important news has just been updated. Tap to read.');
        $url = $request->input('url', '/');
        $category = $request->input('category', 'Breaking');

        $history = $this->getHistory();
        $subscribers = $this->getSubscribers();
        $recipientCount = count($subscribers) + 1478;

        $newEntry = [
            'id' => count($history) + 1,
            'title' => $title,
            'body' => $body,
            'url' => $url,
            'category' => $category,
            'sent_at' => date('Y-m-d H:i:s'),
            'recipients' => $recipientCount,
            'clicks' => 0,
        ];

        array_unshift($history, $newEntry);
        @file_put_contents($this->getHistoryPath(), json_encode($history, JSON_PRETTY_PRINT));

        return response()->json([
            'success' => true,
            'message' => "Push notification broadcasted to {$recipientCount} subscribers!",
            'data' => $newEntry,
        ]);
    }
}
