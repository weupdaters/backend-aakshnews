<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class TranslationService
{
    public static function translateCategory($category, $lang)
    {
        $categoryMap = [
            'hi' => [
                'National' => 'National', 'State' => 'State', 'Politics' => 'Politics', 'Sports' => 'Sports', 'Business' => 'Business', 'Technology' => 'Technology', 'Entertainment' => 'Entertainment', 'Lifestyle' => 'Lifestyle', 'Education' => 'Education', 'World' => 'World', 'Photo Gallery' => 'Photo Gallery', 'Breaking News' => 'Breaking News'
            ],
            'en' => [
                'National' => 'National', 'State' => 'State', 'Politics' => 'Politics', 'Sports' => 'Sports', 'Business' => 'Business', 'Technology' => 'Technology', 'Entertainment' => 'Entertainment', 'Lifestyle' => 'Lifestyle', 'Education' => 'Education', 'World' => 'World', 'Photo Gallery' => 'Photo Gallery', 'Breaking News' => 'Breaking News'
            ],
            'pb' => [
                'National' => 'ਦੇਸ਼', 'State' => 'ਰਾਜ', 'Politics' => 'ਰਾਜਨੀਤੀ', 'Sports' => 'ਖੇਡਾਂ', 'Business' => 'ਵਪਾਰ', 'Technology' => 'ਤਕਨਾਲੋਜੀ', 'Entertainment' => 'ਮਨੋਰੰਜਨ', 'Lifestyle' => 'ਜੀਵਨ ਸ਼ੈਲੀ', 'Education' => 'ਸਿੱਖਿਆ', 'World' => 'ਦੁਨੀਆ', 'Photo Gallery' => 'ਫੋਟੋ ਗੈਲਰੀ', 'Breaking News' => 'ਤਾਜ਼ਾ ਖ਼ਬਰਾਂ'
            ]
        ];

        return $categoryMap[$lang][$category] ?? $category;
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

        $cacheKey = "trans_" . md5($text . "_" . $targetLangClean);
        return Cache::remember($cacheKey, 86400, function () use ($text, $targetLangClean) {
            try {
                $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" . $targetLangClean . "&dt=t&q=" . urlencode($text);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $response = curl_exec($ch);
                curl_close($ch);
                if ($response) {
                    $json = json_decode($response, true);
                    if (isset($json[0])) {
                        $translated = '';
                        foreach ($json[0] as $sentence) {
                            $translated .= $sentence[0];
                        }
                        return $translated;
                    }
                }
            } catch (\Exception $e) {
                // ignore
            }
            return $text;
        });
    }
}
