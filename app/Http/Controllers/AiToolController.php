<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiToolController extends Controller
{
    public function generateDescription(Request $request)
    {
        $title = $request->input('title', '');
        if (empty($title)) {
            return response()->json(['success' => false, 'message' => 'Title cannot be empty.'], 400);
        }

        $titleLower = mb_strtolower($title);
        $description = "";

        if (mb_strpos($titleLower, 'क्रिकेट') !== false || mb_strpos($titleLower, 'sports') !== false || mb_strpos($titleLower, 'मैच') !== false || mb_strpos($titleLower, 'जीत') !== false) {
            $description = "Aakash News 24 Desk: Very exciting news is coming from the sports world. " . $title . "। In this match, the players showed unprecedented skills. Great enthusiasm is being seen among sports fans.";
        } elseif (mb_strpos($titleLower, 'मोदी') !== false || mb_strpos($titleLower, 'चुनाव') !== false || mb_strpos($titleLower, 'politics') !== false || mb_strpos($titleLower, 'सरकार') !== false) {
            $description = "Aakash News 24 Desk: A new turn has been seen in the country's politics. " . $title . "। After this decision, political activity has intensified. Analysts are assessing the impact.";
        } elseif (mb_strpos($titleLower, 'rain') !== false || mb_strpos($titleLower, 'weather') !== false || mb_strpos($titleLower, 'heat') !== false || mb_strpos($titleLower, 'temperature') !== false) {
            $description = "Aakash News 24 Desk: An alert has been issued by the IMD. " . $title . "। Administration advised citizens to take precautions. Stay tuned for weather updates.";
        } elseif (mb_strpos($titleLower, 'gold') !== false || mb_strpos($titleLower, 'market') !== false || mb_strpos($titleLower, 'stock') !== false || mb_strpos($titleLower, 'price') !== false) {
            $description = "Aakash News 24 Desk: The biggest buzz from the business world today. " . $title . "। Experts suggest volatility is due to global cues. Investors are advised to make wise decisions.";
        } else {
            $description = "Aakash News 24 Desk: An extremely important piece of news has come to light. " . $title . "। Our special team is tracking the development. Stay tuned for latest updates and analysis.";
        }

        return response()->json(['success' => true, 'description' => $description]);
    }

    public function suggestTitle(Request $request)
    {
        $category = $request->input('category', 'Punjab');
        $content = $request->input('content', '');
        $currentTitle = $request->input('title', '');

        $suggestions = [];
        if (!empty($currentTitle)) {
            $suggestions = [
                $currentTitle . " : ਵਿਸ਼ੇਸ਼ ਜ਼ਮੀਨੀ ਰਿਪੋਰਟ ਅਤੇ ਵੱਡੇ ਖ਼ੁਲਾਸੇ",
                "ਵੱਡੀ ਖ਼ਬਰ: " . $currentTitle . " ਨੂੰ ਲੈ ਕੇ ਸਰਕਾਰੀ ਹੁਕਮ ਜਾਰੀ",
                $currentTitle . " - ਜਾਣੋ ਹਰ ਪਹਿਲੂ ਅਤੇ ਤਾਜ਼ਾ ਜਾਣਕਾਰੀ",
            ];
        } else {
            $suggestions = [
                $category . " ਵਿਕਾਸ ਯੋਜਨਾਵਾਂ ਨੂੰ ਲੈ ਕੇ ਨਵਾਂ ਐਲਾਨ",
                "ਪੰਜਾਬ ਬਜਟ 2026: ਆਮ ਜਨਤਾ ਲਈ ਵੱਡੀਆਂ ਰਾਹਤਾਂ",
                "ਜ਼ਮੀਨੀ ਪੱਧਰ 'ਤੇ ਲੋਕਾਂ ਦੀਆਂ ਮੁੱਖ ਮੰਗਾਂ: ਖ਼ਾਸ ਰਿਪੋਰਟ",
            ];
        }

        return response()->json(['success' => true, 'titles' => $suggestions]);
    }

    public function assistantAction(Request $request)
    {
        $action = $request->input('action', 'improve');
        $content = $request->input('content', '');

        if (empty($content)) {
            return response()->json(['success' => false, 'message' => 'Please write content first.'], 400);
        }

        $result = $content;
        switch ($action) {
            case 'improve':
                $result = trim($content) . "\n\nਇਸ ਮਾਮਲੇ ਦੀ ਗੰਭੀਰਤਾ ਨੂੰ ਦੇਖਦੇ ਹੋਏ ਸੰਬੰਧਿਤ ਵਿਭਾਗਾਂ ਨੂੰ ਤੁਰੰਤ ਕਾਰਵਾਈ ਦੇ ਨਿਰਦੇਸ਼ ਦਿੱਤੇ ਗਏ ਹਨ। ਪ੍ਰਸ਼ਾਸਨ ਨੇ ਭਰੋਸਾ ਦਿੱਤਾ ਹੈ ਕਿ ਜਲਦ ਹੀ ਸਾਰੀਆਂ ਕਮੀਆਂ ਨੂੰ ਦੂਰ ਕਰ ਲਿਆ ਜਾਵੇਗਾ।";
                break;
            case 'grammar':
                $result = preg_replace('/\s+/', ' ', trim($content));
                $result = str_replace([' ,', ' .', ' !'], [',', '.', '!'], $result);
                break;
            case 'summarize':
                $result = "ਮੁੱਖ ਅੰਸ਼ (Summary Highlights):\n• ਮਾਮਲੇ ਨਾਲ ਜੁੜੇ ਪ੍ਰਮੁੱਖ ਤੱਥ ਸਾਹਮਣੇ ਆਏ।\n• ਅਧਿਕਾਰੀਆਂ ਵੱਲੋਂ ਜਾਂਚ ਦੇ ਹੁਕਮ ਜਾਰੀ।\n• ਆਮ ਜਨਤਾ ਨੂੰ ਸੁਚੇਤ ਰਹਿਣ ਦੀ ਅਪੀਲ।\n\n" . $content;
                break;
            case 'translate':
                $result = $content;
                break;
        }

        return response()->json(['success' => true, 'result' => $result]);
    }

    public function generateAiImage(Request $request)
    {
        $title = $request->input('title', '');
        if (empty($title)) {
            return response()->json(['success' => false, 'message' => 'Title is required to generate image.'], 400);
        }

        $titleLower = mb_strtolower($title);
        $prompt = "professional news photograph of ";

        if (mb_strpos($titleLower, 'क्रिकेट') !== false || mb_strpos($titleLower, 'sports') !== false || mb_strpos($titleLower, 'मैच') !== false || mb_strpos($titleLower, 'जीत') !== false) {
            $prompt .= "Indian cricket team celebrating victory, stadium background, dramatic lighting, high quality news photo";
        } elseif (mb_strpos($titleLower, 'मोदी') !== false || mb_strpos($titleLower, 'चुनाव') !== false || mb_strpos($titleLower, 'politics') !== false) {
            $prompt .= "Indian politics parliament building or press conference, politician speaking behind podium, professional photo journalism";
        } elseif (mb_strpos($titleLower, 'rain') !== false || mb_strpos($titleLower, 'weather') !== false) {
            $prompt .= "heavy monsoon rain in Indian city street, dramatic clouds, realistic journalism photo";
        } elseif (mb_strpos($titleLower, 'gold') !== false || mb_strpos($titleLower, 'market') !== false || mb_strpos($titleLower, 'price') !== false) {
            $prompt .= "gold bars and stock market chart graphics, financial news, high quality 3d render";
        } else {
            $prompt .= urlencode($title) . ", professional editorial news photo, high resolution";
        }

        $imageUrl = "https://image.pollinations.ai/prompt/" . urlencode($prompt) . "?width=800&height=450&nologo=true";

        try {
            $imageContent = file_get_contents($imageUrl);
            if ($imageContent) {
                $filename = 'ai_' . time() . '.jpg';
                if (!file_exists(public_path('uploads'))) {
                    mkdir(public_path('uploads'), 0777, true);
                }
                file_put_contents(public_path('uploads/') . $filename, $imageContent);
                $localUrl = '/uploads/' . $filename;
                return response()->json(['success' => true, 'url' => $localUrl]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'url' => $imageUrl]);
        }

        return response()->json(['success' => false, 'message' => 'Error generating image.'], 500);
    }
}
