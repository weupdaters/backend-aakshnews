<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class TranslationService
{
    public static function translateCategory($category, $lang)
    {
        $categoryMap = [
            'hi' => [
                'National' => 'राष्ट्रीय',
                'State' => 'राज्य',
                'Politics' => 'राजनीति',
                'Sports' => 'खेल',
                'Business' => 'व्यापार',
                'Technology' => 'तकनीक',
                'Entertainment' => 'मनोरंजन',
                'Lifestyle' => 'जीवन शैली',
                'Education' => 'शिक्षा',
                'World' => 'विदेश',
                'Photo Gallery' => 'फ़ोटो गैलरी',
                'Breaking News' => 'ताज़ा समाचार',
                'Punjab' => 'पंजाब',
                'Crime' => 'क्राइम'
            ],
            'en' => [
                'National' => 'National',
                'State' => 'State',
                'Politics' => 'Politics',
                'Sports' => 'Sports',
                'Business' => 'Business',
                'Technology' => 'Technology',
                'Entertainment' => 'Entertainment',
                'Lifestyle' => 'Lifestyle',
                'Education' => 'Education',
                'World' => 'World',
                'Photo Gallery' => 'Photo Gallery',
                'Breaking News' => 'Breaking News',
                'Punjab' => 'Punjab',
                'Crime' => 'Crime'
            ],
            'pb' => [
                'National' => 'ਦੇਸ਼',
                'State' => 'ਰਾਜ',
                'Politics' => 'ਰਾਜਨੀਤੀ',
                'Sports' => 'ਖੇਡਾਂ',
                'Business' => 'ਵਪਾਰ',
                'Technology' => 'ਤਕਨਾਲੋਜੀ',
                'Entertainment' => 'ਮਨੋਰੰਜਨ',
                'Lifestyle' => 'ਜੀਵਨ ਸ਼ੈਲੀ',
                'Education' => 'ਸਿੱਖਿਆ',
                'World' => 'ਦੁਨੀਆ',
                'Photo Gallery' => 'ਫੋਟੋ ਗੈਲਰੀ',
                'Breaking News' => 'ਤਾਜ਼ਾ ਖ਼ਬਰਾਂ',
                'Punjab' => 'ਪੰਜਾਬ',
                'Crime' => 'ਅਪਰਾਧ'
            ]
        ];

        $langKey = strtolower($lang);
        if ($langKey === 'pa') {
            $langKey = 'pb';
        }

        return $categoryMap[$langKey][$category] ?? $category;
    }

    public static function detectLanguage($text)
    {
        if (empty($text)) return 'en';
        if (preg_match('/\p{Gurmukhi}/u', $text)) return 'pb';
        if (preg_match('/\p{Devanagari}/u', $text)) return 'hi';
        return 'en';
    }

    public static function translateText($text, $targetLang)
    {
        if (empty($text)) {
            return '';
        }

        $targetLangClean = strtolower($targetLang);
        if ($targetLangClean === 'pa') {
            $targetLangClean = 'pb';
        }

        // 1. Language checks to avoid translating if target language matches source text format
        if ($targetLangClean === 'hi' && preg_match('/\p{Devanagari}/u', $text)) {
            return $text;
        }
        if ($targetLangClean === 'en' && !preg_match('/[^\x00-\x7F]/', $text)) {
            return $text;
        }
        if ($targetLangClean === 'pb' && preg_match('/\p{Gurmukhi}/u', $text)) {
            return $text;
        }

        // 2. Static translation dictionary for seeded/common content to avoid network calls
        $dictionary = [
            "भारत ने T20 विश्व कप 2024 में पाकिस्तान को हराया" => [
                'en' => "India defeated Pakistan in T20 World Cup 2024",
                'pb' => "ਭਾਰਤ ਨੇ ਟੀ-20 ਵਿਸ਼ਵ ਕੱਪ 2024 ਵਿੱਚ ਪਾਕਿਸਤਾਨ ਨੂੰ ਹਰਾਇਆ"
            ],
            "मुंबई में भारी बारिश से जनजीवन प्रभावित, मौसम विभाग का रेड अलर्ट जारी" => [
                'en' => "Heavy rain in Mumbai affects life, Meteorological Department issues red alert",
                'pb' => "ਮੁੰਬਈ ਵਿੱਚ ਭਾਰੀ ਮੀਂਹ ਕਾਰਨ ਜਨਜੀਵਨ ਪ੍ਰਭਾਵਿਤ, ਮੌਸਮ ਵਿਭਾਗ ਵੱਲੋਂ ਰੈੱਡ ਅਲਰਟ ਜਾਰੀ"
            ],
            "शेयर बाजार में बड़ी गिरावट, सेंसेक्स 800 अंक नीचे गिरा" => [
                'en' => "Major fall in stock market, Sensex drops 800 points",
                'pb' => "ਸ਼ੇਅਰ ਬਾਜ਼ਾਰ ਵਿੱਚ ਵੱਡੀ ਗਿਰਾਵਟ, ਸੈਂਸੈਕਸ 800 ਅੰਕ ਹੇਠਾਂ ਡਿੱਗਿਆ"
            ],
            "सोने की कीमतों में भारी उछाल, रिकॉर्ड स्तर पर पहुंचे दाम" => [
                'en' => "Huge jump in gold prices, rates reach record high",
                'pb' => "ਸੋਨੇ ਦੀਆਂ ਕੀਮਤਾਂ ਵਿੱਚ ਭਾਰੀ ਉਛਾਲ, ਕੀਮਤਾਂ ਰਿਕਾਰਡ ਪੱਧਰ 'ਤੇ ਪਹੁੰਚੀਆਂ"
            ],
            "केदारनाथ धाम" => [
                'en' => "Kedarnath Dham",
                'pb' => "ਕੇਦਾਰਨਾਥ ਧਾਮ"
            ],
            "गोवा बीच" => [
                'en' => "Goa Beach",
                'pb' => "ਗੋਆ ਬੀਚ"
            ],
            "लद्दाख यात्रा" => [
                'en' => "Ladakh Trip",
                'pb' => "ਲਦਾਖ ਯਾਤਰਾ"
            ],
            "वाराणसी घाट" => [
                'en' => "Varanasi Ghat",
                'pb' => "ਵਾਰਾਣਸੀ ਘਾਟ"
            ],
            "जयपुर सिटी पैलेस" => [
                'en' => "Jaipur City Palace",
                'pb' => "ਜੈਪੁਰ ਸਿਟੀ ਪੈਲੇਸ"
            ],
            "ताज महल" => [
                'en' => "Taj Mahal",
                'pb' => "ਤਾਜ ਮਹਿਲ"
            ],
            "हम्पी मंदिर" => [
                'en' => "Hampi Temple",
                'pb' => "ਹੰਪੀ ਮੰਦਰ"
            ]
        ];

        if (isset($dictionary[$text][$targetLangClean])) {
            return $dictionary[$text][$targetLangClean];
        }
        if (($targetLangClean === 'pa' || $targetLangClean === 'pb') && isset($dictionary[$text]['pb'])) {
            return $dictionary[$text]['pb'];
        }

        $gtxLang = ($targetLangClean === 'pb' || $targetLangClean === 'pa') ? 'pa' : $targetLangClean;
        $fetchTranslation = function () use ($text, $gtxLang) {
            try {
                $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" . $gtxLang . "&dt=t&q=" . urlencode($text);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                $response = curl_exec($ch);
                curl_close($ch);
                if ($response) {
                    $json = json_decode($response, true);
                    if (isset($json[0]) && is_array($json[0])) {
                        $translated = '';
                        foreach ($json[0] as $sentence) {
                            if (isset($sentence[0])) {
                                $translated .= $sentence[0];
                            }
                        }
                        if (!empty(trim($translated))) {
                            return $translated;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore network errors gracefully
            }
            return $text;
        };

        // Cache safely - don't crash if database cache has connection error
        try {
            $cacheKey = "trans_" . md5($text . "_" . $gtxLang);
            return Cache::remember($cacheKey, 86400, $fetchTranslation);
        } catch (\Throwable $e) {
            return $fetchTranslation();
        }
    }
}
