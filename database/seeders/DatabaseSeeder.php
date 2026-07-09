<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPost;
use App\Models\BreakingNews;
use App\Models\PhotoGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create default admin if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@newsportal.in'],
            [
                'name' => 'Aakash News Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Clear existing entries to prevent duplication
        BreakingNews::truncate();
        PhotoGallery::truncate();
        
        // Let's not truncate user_posts, but we can seed if it's empty, or add our featured posts
        // For clean state, we can delete older seeded ones if needed, but let's just create them.

        // 3. Seed Breaking News
        $breaking = [
            "भारत ने T20 विश्व कप 2024 में पाकिस्तान को हराया",
            "मुंबई में भारी बारिश से जनजीवन प्रभावित, मौसम विभाग का रेड अलर्ट जारी",
            "शेयर बाजार में बड़ी गिरावट, सेंसेक्स 800 अंक नीचे गिरा",
            "सोने की कीमतों में भारी उछाल, रिकॉर्ड स्तर पर पहुंचे दाम"
        ];
        foreach ($breaking as $title) {
            BreakingNews::create([
                'title' => $title,
                'is_active' => true
            ]);
        }

        // 4. Seed Photo Gallery
        $photos = [
            ['name' => "केदारनाथ धाम", 'image_url' => "/images/photo_kedarnath.png"],
            ['name' => "गोवा बीच", 'image_url' => "/images/photo_goa.png"],
            ['name' => "लद्दाख यात्रा", 'image_url' => "/images/photo_ladakh.png"],
            ['name' => "वाराणसी घाट", 'image_url' => "/images/photo_varanasi.png"],
            ['name' => "जयपुर सिटी पैलेस", 'image_url' => "/images/photo_jaipur.png"],
            ['name' => "ताज महल", 'image_url' => "/images/photo_tajmahal.png"],
            ['name' => "हम्पी मंदिर", 'image_url' => "/images/photo_hampi.png"]
        ];
        foreach ($photos as $photo) {
            PhotoGallery::create($photo);
        }

        // 5. Seed News Articles (UserPost)
        // Main Hero Card
        UserPost::create([
            'user_id' => $admin->id,
            'author_name' => 'Aakash News 24 Desk',
            'title' => "नई दिल्ली में गर्मी ने तोड़ सारे रिकॉर्ड, तापमान 45 डिग्री के पार",
            'content' => "दिल्ली-एनसीआर में भीषण गर्मी का कहर जारी, लोगों को राहत की उम्मीद अगले सप्ताह है। मौसम विभाग ने कई इलाकों के लिए ऑरेंज व रेड अलर्ट जारी किया है। अधिकारियों ने दोपहर 12 बजे से 3 बजे के बीच घर से बाहर न निकलने की सलाह दी है।",
            'category' => "देश",
            'image_url' => "/images/hero_india_gate.png",
            'ai_status' => 'approved',
            'ai_feedback' => 'Seeded featured article',
            'status' => 'published',
            'is_hero' => true,
            'is_middle_stack' => false,
            'views_count' => 12500
        ]);

        // Middle Stack Cards
        $middleStack = [
            [
                'title' => "प्रधानमंत्री मोदी का तीसरी बार शपथ ग्रहण समारोह आज",
                'category' => "राजनीति",
                'content' => "प्रधानमंत्री नरेंद्र मोदी का तीसरी बार शपथ ग्रहण समारोह आज राष्ट्रपति भवन में आयोजित किया जा रहा है। इस समारोह में कई देशों के राष्ट्राध्यक्ष शामिल हो रहे हैं। नई कैबिनेट के गठन को लेकर भी चर्चाएं तेज हैं।",
                'image_url' => "/images/modi_oath.png",
            ],
            [
                'title' => "भारत ने पाकिस्तान को 6 विकेट से हराया",
                'category' => "खेल",
                'content' => "भारत ने एक रोमांचक मुकाबले में पाकिस्तान को 6 विकेट से हरा दिया है। इस जीत के साथ भारतीय टीम ने विश्व कप में अपना दबदबा कायम रखा है। जसप्रीत बुमराह को प्लेयर ऑफ द मैच चुना गया।",
                'image_url' => "/images/cricket_win.png",
            ],
            [
                'title' => "iPhone 16 सीरीज़ इस दिन होगी लॉन्च",
                'category' => "टेक्नोलॉजी",
                'content' => "एप्पल अपनी नई आईफोन 16 सीरीज़ को लॉन्च करने के लिए पूरी तरह तैयार है। तकनीकी विशेषज्ञों के अनुसार इस बार कई बेहतरीन एआई फीचर्स देखने को मिलेंगे और डिजाइन में भी काफी बदलाव किया गया है।",
                'image_url' => "/images/iphone16_launch.png",
            ]
        ];
        foreach ($middleStack as $card) {
            UserPost::create([
                'user_id' => $admin->id,
                'author_name' => 'Aakash News 24 Desk',
                'title' => $card['title'],
                'content' => $card['content'],
                'category' => $card['category'],
                'image_url' => $card['image_url'],
                'ai_status' => 'approved',
                'status' => 'published',
                'is_hero' => false,
                'is_middle_stack' => true,
                'views_count' => rand(1000, 9000)
            ]);
        }

        // Regular/Latest News
        $latest = [
            [
                'title' => "महाराष्ट्र के कई जिलों में भारी बारिश का अलर्ट",
                'category' => "राज्य",
                'content' => "महाराष्ट्र के विभिन्न क्षेत्रों में भारी वर्षा की चेतावनी जारी की गई है। मुंबई और पुणे में सुरक्षा के कड़े इंतजाम किए गए हैं और स्कूल-कॉलेजों को बंद रखने का निर्देश दिया गया है।",
                'image_url' => "/images/rain_traffic.png"
            ],
            [
                'title' => "शेयर बाजार में भारी गिरावट, निवेशकों को नुकसान",
                'category' => "बिजनेस",
                'content' => "वैश्विक बाजार के संकेतों के बीच आज भारतीय शेयर बाजार में भारी बिकवाली देखी गई। सेंसेक्स और निफ्टी में भारी गिरावट दर्ज की गई, जिससे निवेशकों को करोड़ों का नुकसान हुआ है।",
                'image_url' => "/images/stock_market.png"
            ],
            [
                'title' => "ISRO की नई उपलब्धि, सफल हुआ PSLV मिशन",
                'category' => "विज्ञान",
                'content' => "भारतीय अंतरिक्ष अनुसंधान संगठन (इसरो) ने एक बार फिर इतिहास रच दिया है। पीएसएलवी मिशन पूरी तरह से सफल रहा और उपग्रहों को उनकी सही कक्षा में स्थापित कर दिया गया।",
                'image_url' => "/images/isro_rocket.png"
            ],
            [
                'title' => "सलमान खान की फिल्म 'सिकंदर' की रिलीज डेट तय",
                'category' => "मनोरंजन",
                'content' => "सुपरस्टार सलमान खान की आगामी फिल्म 'सिकंदर' की रिलीज डेट की आधिकारिक घोषणा कर दी गई है। प्रशंसक इस फिल्म का बेसब्री से इंतजार कर रहे हैं। फिल्म ईद 2025 पर सिनेमाघरों में दस्तक देगी।",
                'image_url' => "/images/salman_khan.png"
            ]
        ];
        foreach ($latest as $card) {
            UserPost::create([
                'user_id' => $admin->id,
                'author_name' => 'Aakash News 24 Desk',
                'title' => $card['title'],
                'content' => $card['content'],
                'category' => $card['category'],
                'image_url' => $card['image_url'],
                'ai_status' => 'approved',
                'status' => 'published',
                'is_hero' => false,
                'is_middle_stack' => false,
                'views_count' => rand(500, 3000)
            ]);
        }

        // Video News
        $videos = [
            [
                'title' => "दिल्ली में बारिश से जलभराव",
                'category' => "दिल्ली",
                'image_url' => "/images/video_delhi_rain.png",
                'video_url' => "https://www.youtube.com/watch?v=21X5lGlDOfg",
                'duration' => "02:40",
                'views_count' => 12000,
                'content' => "दिल्ली में आज सुबह हुई तेज बारिश के बाद कई इलाकों में गंभीर जलभराव की समस्या पैदा हो गई है। मिंटो ब्रिज और आईटीओ के पास पानी भरने से ट्रैफिक जाम हो गया।"
            ],
            [
                'title' => "भारत की शानदार जीत",
                'category' => "खेल",
                'image_url' => "/images/video_cricket.png",
                'video_url' => "https://www.youtube.com/watch?v=M7lc1UVf-VE",
                'duration' => "03:10",
                'views_count' => 18000,
                'content' => "भारतीय क्रिकेट टीम ने एक बार फिर शानदार प्रदर्शन करते हुए जीत हासिल की। जीत के बाद देश भर में जश्न का माहौल है और कप्तान ने खिलाड़ियों की तारीफ की।"
            ],
            [
                'title' => "राहुल गांधी का बड़ा बयान",
                'category' => "राजनीति",
                'image_url' => "/images/video_rahul.png",
                'video_url' => "https://www.youtube.com/watch?v=jfKfPfyJRdk",
                'duration' => "01:50",
                'views_count' => 8000,
                'content' => "कांग्रेस नेता राहुल गांधी ने आज प्रेस कॉन्फ्रेंस में सरकार की नीतियों पर बड़ा हमला बोला और किसानों के मुद्दे पर गंभीर सवाल खड़े किए।"
            ],
            [
                'title' => "नई इलेक्ट्रिक कार लॉन्च",
                'category' => "टेक्नोलॉजी",
                'image_url' => "/images/video_electric_car.png",
                'video_url' => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
                'duration' => "02:30",
                'views_count' => 7000,
                'content' => "बाजार में आज एक नई इलेक्ट्रिक कार लॉन्च की गई जो सिंगल चार्ज में 500 किलोमीटर की रेंज देने का दावा करती है। इसके फीचर्स और कीमत आकर्षक हैं।"
            ],
            [
                'title' => "अंतरिक्ष में भारत का कमाल",
                'category' => "विज्ञान",
                'image_url' => "/images/video_space.png",
                'video_url' => "https://www.youtube.com/watch?v=9Auq9mYxFEE",
                'duration' => "02:20",
                'views_count' => 11000,
                'content' => "भारतीय अंतरिक्ष कार्यक्रम के तहत आज एक नया उपग्रह सफलतापूर्वक स्थापित किया गया जो देश के संचार क्षेत्र को नई ऊंचाइयों पर ले जाएगा।"
            ]
        ];
        foreach ($videos as $card) {
            UserPost::create([
                'user_id' => $admin->id,
                'author_name' => 'Aakash News 24 Desk',
                'title' => $card['title'],
                'content' => $card['content'],
                'category' => $card['category'],
                'image_url' => $card['image_url'],
                'video_url' => $card['video_url'],
                'duration' => $card['duration'],
                'ai_status' => 'approved',
                'status' => 'published',
                'is_hero' => false,
                'is_middle_stack' => false,
                'views_count' => $card['views_count']
            ]);
        }
    }
}
