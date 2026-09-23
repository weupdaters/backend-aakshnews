<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\BreakingNews;
use App\Models\Category;
use App\Models\InstagramVideo;
use App\Models\PhotoGallery;
use App\Models\Poll;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create or update default admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@newsportal.in'],
            [
                'name'     => 'Aakash News Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Clear breaking news, polls, and ads for clean seed state
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        BreakingNews::truncate();
        \App\Models\PollVote::truncate();
        Poll::truncate();
        Advertisement::truncate();
        InstagramVideo::truncate();
        PhotoGallery::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 3. Seed Categories with 3-language names
        $categories = [
            [
                'name'          => 'ਪੰਜਾਬ News',
                'name_en'       => 'Punjab News',
                'name_hi'       => 'पंजाब समाचार',
                'name_pb'       => 'ਪੰਜਾਬ News',
                'slug'          => 'punjab',
                'color'         => '#E50914',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਇੰਡੀਆ News',
                'name_en'       => 'India News',
                'name_hi'       => 'इंडिया समाचार',
                'name_pb'       => 'ਇੰਡੀਆ News',
                'slug'          => 'india',
                'color'         => '#1D4ED8',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਵਰਲਡ News',
                'name_en'       => 'World News',
                'name_hi'       => 'विश्व समाचार',
                'name_pb'       => 'ਵਰਲਡ News',
                'slug'          => 'world',
                'color'         => '#059669',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਰਾਜਨੀਤੀ',
                'name_en'       => 'Politics',
                'name_hi'       => 'राजनीति',
                'name_pb'       => 'ਰਾਜਨੀਤੀ',
                'slug'          => 'politics',
                'color'         => '#D97706',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਕਾਰੋਬਾਰ',
                'name_en'       => 'Business',
                'name_hi'       => 'व्यापार',
                'name_pb'       => 'ਕਾਰੋਬਾਰ',
                'slug'          => 'business',
                'color'         => '#7C3AED',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਖੇਡਾਂ',
                'name_en'       => 'Sports',
                'name_hi'       => 'खेल',
                'name_pb'       => 'ਖੇਡਾਂ',
                'slug'          => 'sports',
                'color'         => '#EA580C',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਕ੍ਰਿਕਟ',
                'name_en'       => 'Cricket',
                'name_hi'       => 'क्रिकेट',
                'name_pb'       => 'ਕ੍ਰਿਕਟ',
                'slug'          => 'cricket',
                'color'         => '#0284C7',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਮਨੋਰੰਜਨ',
                'name_en'       => 'Entertainment',
                'name_hi'       => 'मनोरंजन',
                'name_pb'       => 'ਮਨੋਰੰਜਨ',
                'slug'          => 'entertainment',
                'color'         => '#DB2777',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਤਕਨਾਲੋਜੀ',
                'name_en'       => 'Technology',
                'name_hi'       => 'तकनीक',
                'name_pb'       => 'ਤਕਨਾਲੋਜੀ',
                'slug'          => 'tech',
                'color'         => '#4F46E5',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਸਿਹਤ',
                'name_en'       => 'Health',
                'name_hi'       => 'स्वास्थ्य',
                'name_pb'       => 'ਸਿਹਤ',
                'slug'          => 'health',
                'color'         => '#0D9488',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਸਿੱਖਿਆ',
                'name_en'       => 'Education',
                'name_hi'       => 'शिक्षा',
                'name_pb'       => 'ਸਿੱਖਿਆ',
                'slug'          => 'education',
                'color'         => '#2563EB',
                'status'        => 'active',
            ],
            [
                'name'          => 'ਕਿਸਾਨ',
                'name_en'       => 'Farmers',
                'name_hi'       => 'किसान',
                'name_pb'       => 'ਕਿਸਾਨ',
                'slug'          => 'farmers',
                'color'         => '#15803D',
                'status'        => 'active',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Seed Breaking News in 3 Languages
        $breakingNewsItems = [
            [
                'title'    => 'ਪੰਜਾਬ ਸਰਕਾਰ ਵੱਲੋਂ ਵਿਧਵਾ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਲਈ ₹305 ਕਰੋੜ ਦੀ ਵਿੱਤੀ ਸਹਾਇਤਾ ਜਾਰੀ',
                'title_en' => 'Punjab Govt releases over Rs 305 crore financial assistance for destitute women',
                'title_hi' => 'पंजाब सरकार द्वारा विधवा और बेसहारा महिलाओं के लिए ₹305 करोड़ की वित्तीय सहायता जारी',
                'title_pb' => 'ਪੰਜਾਬ ਸਰਕਾਰ ਵੱਲੋਂ ਵਿਧਵਾ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਲਈ ₹305 ਕਰੋੜ ਦੀ ਵਿੱਤੀ ਸਹਾਇਤਾ ਜਾਰੀ',
                'is_active'=> true,
            ],
            [
                'title'    => 'IPL 2026: ਪੰਜਾਬ ਕਿੰਗਜ਼ ਨੇ ਰੋਮਾਂਚਕ ਮੁਕਾਬਲੇ ਵਿੱਚ ਦਿੱਲੀ ਕੈਪੀਟਲਜ਼ ਨੂੰ 8 ਵਿਕਟਾਂ ਨਾਲ ਹਰਾਇਆ',
                'title_en' => 'IPL 2026: Punjab Kings beat Delhi Capitals by 8 wickets in a thriller',
                'title_hi' => 'IPL 2026: पंजाब किंग्स ने रोमांचक मैच में दिल्ली कैपिटल्स को 8 विकेट से हराया',
                'title_pb' => 'IPL 2026: ਪੰਜਾਬ ਕਿੰਗਜ਼ ਨੇ ਰੋਮਾਂਚਕ ਮੁਕਾਬਲੇ ਵਿੱਚ ਦਿੱਲੀ ਕੈਪੀਟਲਜ਼ ਨੂੰ 8 ਵਿਕਟਾਂ ਨਾਲ ਹਰਾਇਆ',
                'is_active'=> true,
            ],
            [
                'title'    => 'ਮੌਸਮ ਅਪਡੇਟ: ਮੌਸਮ ਵਿਭਾਗ ਨੇ ਉੱਤਰੀ ਭਾਰਤ ਵਿੱਚ ਭਾਰੀ ਮੀਂਹ ਦਾ ਓਰੇਂਜ ਅਲਰਟ ਜਾਰੀ ਕੀਤਾ',
                'title_en' => 'Weather Update: IMD issues Orange alert for heavy rainfall across North India',
                'title_hi' => 'मौसम अपडेट: मौसम विभाग ने उत्तर भारत में भारी बारिश का ऑरेंज अलर्ट जारी किया',
                'title_pb' => 'ਮੌਸਮ ਅਪਡੇਟ: ਮੌਸਮ ਵਿਭਾਗ ਨੇ ਉੱਤਰੀ ਭਾਰਤ ਵਿੱਚ ਭਾਰੀ ਮੀਂਹ ਦਾ ਓਰੇਂਜ ਅਲਰਟ ਜਾਰੀ ਕੀਤਾ',
                'is_active'=> true,
            ],
            [
                'title'    => 'ਸੈਂਸੈਕਸ 800 ਅੰਕ ਉਛਲਿਆ, ਨਿਫਟੀ 24,500 ਦੇ ਪਾਰ ਇਤਿਹਾਸਕ ਪੱਧਰ \'ਤੇ ਬੰਦ',
                'title_en' => 'Sensex surges 800 points, Nifty closes above 24,500 at record high',
                'title_hi' => 'सेंसेक्स 800 अंक उछला, निफ्टी 24,500 के पार ऐतिहासिक स्तर पर बंद',
                'title_pb' => 'ਸੈਂਸੈਕਸ 800 ਅੰਕ ਉਛਲਿਆ, ਨਿਫਟੀ 24,500 ਦੇ ਪਾਰ ਇਤਿਹਾਸਕ ਪੱਧਰ \'ਤੇ ਬੰਦ',
                'is_active'=> true,
            ],
            [
                'title'    => 'ISRO ਗਗਨਯਾਨ ਮਿਸ਼ਨ: ਚਾਲਕ ਦਲ ਕੈਪਸੂਲ ਸੁਰੱਖਿਆ ਪ੍ਰਣਾਲੀ ਦੀ ਸਫਲ ਜਾਂਚ ਪੂਰੀ',
                'title_en' => 'ISRO Gaganyaan Mission: Successful testing of crew capsule safety system completed',
                'title_hi' => 'ISRO गगनयान मिशन: क्रू कैप्सूल सुरक्षा प्रणाली का सफल परीक्षण पूरा',
                'title_pb' => 'ISRO ਗਗਨਯਾਨ ਮਿਸ਼ਨ: ਚਾਲਕ ਦਲ ਕੈਪਸੂਲ ਸੁਰੱਖਿਆ ਪ੍ਰਣਾਲੀ ਦੀ ਸਫਲ ਜਾਂਚ ਪੂਰੀ',
                'is_active'=> true,
            ],
        ];

        foreach ($breakingNewsItems as $b) {
            BreakingNews::create($b);
        }

        // 5. Seed Core Articles (UserPost)
        $posts = [
            [
                'title'          => 'ਪੰਜਾਬ ਸਰਕਾਰ ਵੱਲੋਂ ਵਿਧਵਾ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਲਈ 305 ਕਰੋੜ ਰੁਪਏ ਤੋਂ ਵੱਧ ਦੀ ਵਿੱਤੀ ਸਹਾਇਤਾ ਜਾਰੀ: ਡਾ. ਬਲਜੀਤ ਕੌਰ',
                'title_en'       => 'Punjab Govt Releases Over Rs. 305 Crore in Financial Assistance for Widowed and Destitute Women: Dr. Baljit Kaur',
                'title_hi'       => 'पंजाब सरकार द्वारा विधवा एवं बेसहारा महिलाओं के लिए 305 करोड़ रुपये से अधिक की वित्तीय सहायता जारी: डॉ. बलजीत कौर',
                'title_pb'       => 'ਪੰਜਾਬ ਸਰਕਾਰ ਵੱਲੋਂ ਵਿਧਵਾ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਲਈ 305 ਕਰੋੜ ਰੁਪਏ ਤੋਂ ਵੱਧ ਦੀ ਵਿੱਤੀ ਸਹਾਇਤਾ ਜਾਰੀ: ਡਾ. ਬਲਜੀਤ ਕੌਰ',
                'content'        => '<p>ਪੰਜਾਬ ਸਰਕਾਰ ਨੇ ਵਿਧਵਾਵਾਂ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਦੀ ਭਲਾਈ ਲਈ ਇਤਿਹਾਸਕ ਫੈਸਲਾ ਲੈਂਦਿਆਂ 305 ਕਰੋੜ ਰੁਪਏ ਤੋਂ ਵੱਧ ਦੀ ਰਾਸ਼ੀ ਸਿੱਧੇ ਲਾਭਪਾਤਰੀਆਂ ਦੇ ਬੈਂਕ ਖਾਤਿਆਂ ਵਿੱਚ ਟਰਾਂਸਫਰ ਕੀਤੀ ਹੈ। ਸਮਾਜਿਕ ਸੁਰੱਖਿਆ ਅਤੇ ਇਸਤਰੀ ਤੇ ਬਾਲ ਵਿਕਾਸ ਮੰਤਰੀ ਡਾ. ਬਲਜੀਤ ਕੌਰ ਨੇ ਦੱਸਿਆ ਕਿ ਇਹ ਸਕੀਮ ਸੂਬੇ ਦੇ ਸਾਰੇ 23 ਜ਼ਿਲ੍ਹਿਆਂ ਵਿੱਚ ਇੱਕੋ ਸਮੇਂ ਲਾਗੂ ਕੀਤੀ ਗਈ ਹੈ।</p>',
                'content_en'     => '<p>In a historic move for the welfare of vulnerable women, the Punjab Government has released over Rs 305 crore directly into the bank accounts of widowed and destitute beneficiaries. Social Security, Women and Child Development Minister Dr. Baljit Kaur stated that this scheme ensures financial empowerment across all 23 districts of Punjab.</p>',
                'content_hi'     => '<p>पंजाब सरकार ने विधवा और बेसहारा महिलाओं के कल्याण के लिए एक ऐतिहासिक कदम उठाते हुए 305 करोड़ रुपये से अधिक की राशि सीधे लाभार्थियों के बैंक खातों में स्थानांतरित की है। सामाजिक सुरक्षा मंत्री डॉ. बलजीत कौर ने बताया कि यह योजना पंजाब के सभी 23 जिलों में एक साथ लागू की गई है।</p>',
                'content_pb'     => '<p>ਪੰਜਾਬ ਸਰਕਾਰ ਨੇ ਵਿਧਵਾਵਾਂ ਅਤੇ ਨਿਰਆਸ਼ਰਿਤ ਔਰਤਾਂ ਦੀ ਭਲਾਈ ਲਈ ਇਤਿਹਾਸਕ ਫੈਸਲਾ ਲੈਂਦਿਆਂ 305 ਕਰੋੜ ਰੁਪਏ ਤੋਂ ਵੱਧ ਦੀ ਰਾਸ਼ੀ ਸਿੱਧੇ ਲਾਭਪਾਤਰੀਆਂ ਦੇ ਬੈਂਕ ਖਾਤਿਆਂ ਵਿੱਚ ਟਰਾਂਸਫਰ ਕੀਤੀ ਹੈ।</p>',
                'category'       => 'PUNJAB NEWS',
                'image_url'      => '/hero_main_1784880476121.jpg',
                'is_hero'        => true,
                'is_middle_stack'=> false,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 45200,
            ],
            [
                'title'          => 'ਚੰਡੀਗੜ੍ਹ \'ਚ ਮੀਂਹ ਨਾਲ ਮੌਸਮ ਸੁਹਾਵਣਾ, ਤਾਪਮਾਨ \'ਚ ਗਿਰਾਵਟ',
                'title_en'       => 'Pleasant weather in Chandigarh after rains, temperature drops',
                'title_hi'       => 'चंडीगढ़ में बारिश से मौसम हुआ सुहावना, तापमान में गिरावट',
                'title_pb'       => 'ਚੰਡੀਗੜ੍ਹ \'ਚ ਮੀਂਹ ਨਾਲ ਮੌਸਮ ਸੁਹਾਵਣਾ, ਤਾਪਮਾਨ \'ਚ ਗਿਰਾਵਟ',
                'content'        => '<p>ਚੰਡੀਗੜ੍ਹ ਅਤੇ ਆਸ-ਪਾਸ ਦੇ ਇਲਾਕਿਆਂ ਵਿੱਚ ਸਵੇਰ ਤੋਂ ਹੋਈ ਭਾਰੀ ਬਾਰਿਸ਼ ਕਾਰਨ ਲੋਕਾਂ ਨੂੰ ਗਰਮੀ ਤੋਂ ਵੱਡੀ ਰਾਹਤ ਮਿਲੀ ਹੈ। ਮੌਸਮ ਵਿਭਾਗ ਨੇ ਆਉਣ ਵਾਲੇ 48 ਘੰਟਿਆਂ ਵਿੱਚ ਹੋਰ ਮੀਂਹ ਦੀ ਸੰਭਾਵਨਾ ਜਤਾਈ ਹੈ।</p>',
                'content_en'     => '<p>Heavy rainfall in Chandigarh and surrounding regions brought major relief from scorching heat. IMD predicts further showers in the next 48 hours.</p>',
                'content_hi'     => '<p>चंडीगढ़ और आसपास के इलाकों में हुई भारी बारिश से लोगों को भीषण गर्मी से राहत मिली है। मौसम विभाग ने अगले 48 घंटों में और बारिश का अनुमान जताया है।</p>',
                'content_pb'     => '<p>ਚੰਡੀਗੜ੍ਹ ਅਤੇ ਆਸ-ਪਾਸ ਦੇ ਇਲਾਕਿਆਂ ਵਿੱਚ ਸਵੇਰ ਤੋਂ ਹੋਈ ਭਾਰੀ ਬਾਰਿਸ਼ ਕਾਰਨ ਲੋਕਾਂ ਨੂੰ ਗਰਮੀ ਤੋਂ ਵੱਡੀ ਰਾਹਤ ਮਿਲੀ ਹੈ।</p>',
                'category'       => 'BREAKING',
                'image_url'      => '/latest_update_india_1784880496963.jpg',
                'is_hero'        => false,
                'is_middle_stack'=> true,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 18200,
            ],
            [
                'title'          => 'IPL 2026: ਪੰਜਾਬ ਕਿੰਗਜ਼ ਨੇ ਦਿੱਲੀ ਨੂੰ 8 ਵਿਕਟਾਂ ਨਾਲ ਹਰਾਇਆ',
                'title_en'       => 'IPL 2026: Punjab Kings defeat Delhi by 8 wickets in high-octane match',
                'title_hi'       => 'IPL 2026: पंजाब किंग्स ने दिल्ली को 8 विकेट से करारी मात दी',
                'title_pb'       => 'IPL 2026: ਪੰਜਾਬ ਕਿੰਗਜ਼ ਨੇ ਦਿੱਲੀ ਨੂੰ 8 ਵਿਕਟਾਂ ਨਾਲ ਹਰਾਇਆ',
                'content'        => '<p>ਮੋਹਾਲੀ ਦੇ ਆਈਐਸ ਬਿੰਦਰਾ ਸਟੇਡੀਅਮ ਵਿੱਚ ਖੇਡੇ ਗਏ ਮੈਚ ਵਿੱਚ ਪੰਜਾਬ ਕਿੰਗਜ਼ ਨੇ ਸ਼ਾਨਦਾਰ ਗੇਂਦਬਾਜ਼ੀ ਅਤੇ ਬੱਲੇਬਾਜ਼ੀ ਕਰਦਿਆਂ ਦਿੱਲੀ ਕੈਪੀਟਲਜ਼ ਨੂੰ 8 ਵਿਕਟਾਂ ਨਾਲ ਹਰਾਇਆ।</p>',
                'content_en'     => '<p>In a thrilling encounter at Mohali, Punjab Kings delivered a commanding performance with both bat and ball to register an 8-wicket win over Delhi Capitals.</p>',
                'content_hi'     => '<p>मोहाली में खेले गए रोमांचक मुकाबले में पंजाब किंग्स ने शानदार खेल का प्रदर्शन करते हुए दिल्ली कैपिटल्स को 8 विकेट से हरा दिया।</p>',
                'content_pb'     => '<p>ਮੋਹਾਲੀ ਦੇ ਆਈਐਸ ਬਿੰਦਰਾ ਸਟੇਡੀਅਮ ਵਿੱਚ ਖੇਡੇ ਗਏ ਮੈਚ ਵਿੱਚ ਪੰਜਾਬ ਕਿੰਗਜ਼ ਨੇ ਸ਼ਾਨਦਾਰ ਗੇਂਦਬਾਜ਼ੀ ਅਤੇ ਬੱਲੇਬਾਜ਼ੀ ਕਰਦਿਆਂ ਦਿੱਲੀ ਕੈਪੀਟਲਜ਼ ਨੂੰ 8 ਵਿਕਟਾਂ ਨਾਲ ਹਰਾਇਆ।</p>',
                'category'       => 'SPORTS',
                'image_url'      => '/trending_monsoon_1784880752822.jpg',
                'is_hero'        => false,
                'is_middle_stack'=> true,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 32100,
            ],
            [
                'title'          => 'ਸੈਂਸੈਕਸ 800 ਅੰਕ ਉਛਲਿਆ, ਨਿਫਟੀ 24,500 ਦੇ ਉੱਪਰ ਬੰਦ',
                'title_en'       => 'Sensex Surges 800 Points: Nifty Closes Above 24,500 Mark Amid Global Rally',
                'title_hi'       => 'सेंसेक्स 800 अंक उछला, निफ्टी 24,500 के पार रिकॉर्ड स्तर पर बंद',
                'title_pb'       => 'ਸੈਂਸੈਕਸ 800 ਅੰਕ ਉਛਲਿਆ, ਨਿਫਟੀ 24,500 ਦੇ ਉੱਪਰ ਬੰਦ',
                'content'        => '<p>ਵਿਦੇਸ਼ੀ ਨਿਵੇਸ਼ਕਾਂ ਦੀ ਖਰੀਦਦਾਰੀ ਅਤੇ ਆਈਟੀ ਤੇ ਬੈਂਕਿੰਗ ਸੈਕਟਰ ਵਿੱਚ ਭਾਰੀ ਤੇਜ਼ੀ ਨਾਲ ਭਾਰਤੀ ਸ਼ੇਅਰ ਬਾਜ਼ਾਰ ਨੇ ਅੱਜ ਨਵਾਂ ਰਿਕਾਰਡ ਕਾਇਮ ਕੀਤਾ।</p>',
                'content_en'     => '<p>Massive buying in banking, IT, and auto sectors drove Indian indices to historic highs, with the benchmark Sensex jumping 800 points.</p>',
                'content_hi'     => '<p>विदेशी निवेशकों की मजबूत लिवाली और आईटी तथा बैंकिंग शेयरों में तेजी के चलते भारतीय शेयर बाजार नए रिकॉर्ड स्तर पर पहुंच गया।</p>',
                'content_pb'     => '<p>ਵਿਦੇਸ਼ੀ ਨਿਵੇਸ਼ਕਾਂ ਦੀ ਖਰੀਦਦਾਰੀ ਅਤੇ ਆਈਟੀ ਤੇ ਬੈਂਕਿੰਗ ਸੈਕਟਰ ਵਿੱਚ ਭਾਰੀ ਤੇਜ਼ੀ ਨਾਲ ਭਾਰਤੀ ਸ਼ੇਅਰ ਬਾਜ਼ਾਰ ਨੇ ਅੱਜ ਨਵਾਂ ਰਿਕਾਰਡ ਕਾਇਮ ਕੀਤਾ।</p>',
                'category'       => 'BUSINESS',
                'image_url'      => '/trending_sensex_1784880763796.jpg',
                'is_hero'        => false,
                'is_middle_stack'=> true,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 28900,
            ],
            [
                'title'          => 'ISRO ਦਾ ਅਗਲਾ ਮਿਸ਼ਨ: ਗਗਨਯਾਨ ਦੀ ਤਿਆਰੀ ਅੰਤਿਮ ਚਰਣ \'ਚ',
                'title_en'       => 'ISRO\'s Next Mission: Gaganyaan Enters Final Stage of Crew Capsule Testing',
                'title_hi'       => 'ISRO का अगला मिशन: गगनयान क्रू मॉड्यूल परीक्षण के अंतिम चरण में',
                'title_pb'       => 'ISRO ਦਾ ਅਗਲਾ ਮਿਸ਼ਨ: ਗਗਨਯਾਨ ਦੀ ਤਿਆਰੀ ਅੰਤਿਮ ਚਰਣ \'ਚ',
                'content'        => '<p>ਭਾਰਤ ਦੇ ਪਹਿਲੇ ਮਾਨਵ ਪੁਲਾੜ ਮਿਸ਼ਨ ਗਗਨਯਾਨ ਲਈ ਇਸਰੋ ਵਿਗਿਆਨੀਆਂ ਨੇ ਸੁਰੱਖਿਆ ਪੈਰਾਸ਼ੂਟ ਅਤੇ ਚਾਲਕ ਕੈਪਸੂਲ ਦੇ ਅਹਿਮ ਟੈਸਟ ਸਫਲਤਾਪੂਰਵਕ ਪੂਰੇ ਕਰ ਲਏ ਹਨ।</p>',
                'content_en'     => '<p>India\'s human spaceflight program reaches a major milestone as ISRO engineers complete critical safety qualification tests for the Gaganyaan crew capsule.</p>',
                'content_hi'     => '<p>भारत के मानव अंतरिक्ष मिशन गगनयान के लिए इसरो ने महत्वपूर्ण क्रू मॉड्यूल परीक्षण सफलतापूर्वक पूरे कर लिए हैं।</p>',
                'content_pb'     => '<p>ਭਾਰਤ ਦੇ ਪਹਿਲੇ ਮਾਨਵ ਪੁਲਾੜ ਮਿਸ਼ਨ ਗਗਨਯਾਨ ਲਈ ਇਸਰੋ ਵਿਗਿਆਨੀਆਂ ਨੇ ਸੁਰੱਖਿਆ ਪੈਰਾਸ਼ੂਟ ਅਤੇ ਚਾਲਕ ਕੈਪਸੂਲ ਦੇ ਅਹਿਮ ਟੈਸਟ ਸਫਲਤਾਪੂਰਵਕ ਪੂਰੇ ਕਰ ਲਏ ਹਨ।</p>',
                'category'       => 'TECH',
                'image_url'      => '/trending_isro_1784880562542.jpg',
                'is_hero'        => false,
                'is_middle_stack'=> false,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 22100,
            ],
            [
                'title'          => 'ਸੋਨੇ ਦੀਆਂ ਕੀਮਤਾਂ \'ਚ ਗਿਰਾਵਟ, ਘਰੇਲੂ ਬਾਜ਼ਾਰ ਵਿੱਚ ਹੋਇਆ ਸਸਤਾ',
                'title_en'       => 'Gold Prices Today See Slight Dip in Domestic Market Ahead of Festive Season',
                'title_hi'       => 'सोने की कीमतों में हल्की गिरावट, त्योहारी सीजन से पहले सस्ता हुआ सोना',
                'title_pb'       => 'ਸੋਨੇ ਦੀਆਂ ਕੀਮਤਾਂ \'ਚ ਗਿਰਾਵਟ, ਘਰੇਲੂ ਬਾਜ਼ਾਰ ਵਿੱਚ ਹੋਇਆ ਸਸਤਾ',
                'content'        => '<p>ਤਿਉਹਾਰੀ ਸੀਜ਼ਨ ਤੋਂ ਪਹਿਲਾਂ ਸਰਾਫ਼ਾ ਬਾਜ਼ਾਰ ਵਿੱਚ 24 ਕੈਰੇਟ ਸੋਨੇ ਦੀ ਕੀਮਤ ਵਿੱਚ ਪ੍ਰਤੀ 10 ਗ੍ਰਾਮ ਗਿਰਾਵਟ ਦਰਜ ਕੀਤੀ ਗਈ ਹੈ।</p>',
                'content_en'     => '<p>24-Karat gold prices saw a slight dip ahead of the festive shopping season, trading at favorable rates in major metro jewelry markets.</p>',
                'content_hi'     => '<p>त्योहारी सीजन से पहले सर्राफा बाजार में 24 कैरेट सोने की कीमतों में गिरावट दर्ज की गई, जिससे खरीदारों को राहत मिली है।</p>',
                'content_pb'     => '<p>ਤਿਉਹਾਰੀ ਸੀਜ਼ਨ ਤੋਂ ਪਹਿਲਾਂ ਸਰਾਫ਼ਾ ਬਾਜ਼ਾਰ ਵਿੱਚ 24 ਕੈਰੇਟ ਸੋਨੇ ਦੀ ਕੀਮਤ ਵਿੱਚ ਪ੍ਰਤੀ 10 ਗ੍ਰਾਮ ਗਿਰਾਵਟ ਦਰਜ ਕੀਤੀ ਗਈ ਹੈ।</p>',
                'category'       => 'MARKET',
                'image_url'      => '/latest_gold_market_1784880600424.jpg',
                'is_hero'        => false,
                'is_middle_stack'=> false,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 14500,
            ],
            [
                'title'          => 'ਵਾਇਰਲ ਦਾਅਵਾ: ਕੀ ਪੰਜਾਬ \'ਚ ਮੁਫ਼ਤ ਬਿਜਲੀ ਸਕੀਮ ਬੰਦ ਹੋ ਰਹੀ ਹੈ?',
                'title_en'       => 'Fact Check: Is Free 300 Unit Electricity Scheme Ending in Punjab?',
                'title_hi'       => 'फैक्ट चेक: क्या पंजाब में 300 यूनिट मुफ्त बिजली योजना बंद हो रही है?',
                'title_pb'       => 'ਵਾਇਰਲ ਦਾਅਵਾ: ਕੀ ਪੰਜਾਬ \'ਚ ਮੁਫ਼ਤ ਬਿਜਲੀ ਸਕੀਮ ਬੰਦ ਹੋ ਰਹੀ ਹੈ?',
                'content'        => '<p><strong>ਦਾਅਵਾ:</strong> ਸੋਸ਼ਲ ਮੀਡੀਆ \'ਤੇ ਦਾਅਵਾ ਕੀਤਾ ਜਾ ਰਿਹਾ ਹੈ ਕਿ ਸਰਕਾਰ ਮੁਫ਼ਤ ਬਿਜਲੀ ਬੰਦ ਕਰ ਰਹੀ ਹੈ।<br><strong>ਸੱਚਾਈ:</strong> ਝੂਠਾ ਦਾਅਵਾ। ਪੰਜਾਬ ਸਰਕਾਰ ਨੇ ਸਪੱਸ਼ਟ ਕੀਤਾ ਹੈ ਕਿ ਮੁਫ਼ਤ ਬਿਜਲੀ ਸਕੀਮ ਨਿਰਵਿਘਨ ਜਾਰੀ ਰਹੇਗੀ।</p>',
                'content_en'     => '<p><strong>Claim:</strong> Social media posts claim Punjab is ending 300 units free power.<br><strong>Fact:</strong> False claim. The state government confirmed the scheme continues uninterrupted.</p>',
                'content_hi'     => '<p><strong>दावा:</strong> सोशल मीडिया पर दावा किया जा रहा है कि मुफ्त बिजली योजना बंद हो रही है।<br><strong>सच्चाई:</strong> दावा गलत है। सरकार ने स्पष्ट किया है कि योजना जारी रहेगी।</p>',
                'content_pb'     => '<p><strong>ਦਾਅਵਾ:</strong> ਸੋਸ਼ਲ ਮੀਡੀਆ \'ਤੇ ਦਾਅਵਾ ਕੀਤਾ ਜਾ ਰਿਹਾ ਹੈ ਕਿ ਸਰਕਾਰ ਮੁਫ਼ਤ ਬਿਜਲੀ ਬੰਦ ਕਰ ਰਹੀ ਹੈ।<br><strong>ਸੱਚਾਈ:</strong> ਝੂਠਾ ਦਾਅਵਾ। ਪੰਜਾਬ ਸਰਕਾਰ ਨੇ ਸਪੱਸ਼ਟ ਕੀਤਾ ਹੈ ਕਿ ਮੁਫ਼ਤ ਬਿਜਲੀ ਸਕੀਮ ਨਿਰਵਿਘਨ ਜਾਰੀ ਰਹੇਗੀ।</p>',
                'category'       => 'Fact Check',
                'image_url'      => '/top_story_punjab_1784880621670.jpg',
                'is_hero'        => false,
                'is_middle_stack'=> false,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 9800,
            ],
            [
                'title'          => 'ਮੁੱਖ ਮੰਤਰੀ ਪ੍ਰੈਸ ਕਾਨਫਰੰਸ: ਵਿਕਾਸ ਯੋਜਨਾਵਾਂ ਦਾ ਰੋਡਮੈਪ ਜਾਰੀ',
                'title_en'       => 'Chief Minister Press Conference: Roadmap for Development Projects Released',
                'title_hi'       => 'मुख्यमंत्री प्रेस कॉन्फ्रेंस: विकास परियोजनाओं का रोडमैप जारी',
                'title_pb'       => 'ਮੁੱਖ ਮੰਤਰੀ ਪ੍ਰੈਸ ਕਾਨਫਰੰਸ: ਵਿਕਾਸ ਯੋਜਨਾਵਾਂ ਦਾ ਰੋਡਮੈਪ ਜਾਰੀ',
                'content'        => '<p>ਸੂਬੇ ਵਿੱਚ ਸਿਹਤ, ਸਿੱਖਿਆ ਅਤੇ ਉਦਯੋਗ ਖੇਤਰ ਨੂੰ ਨਵੀਂ ਦਿਸ਼ਾ ਦੇਣ ਲਈ ਵਿਸਤ੍ਰਿਤ ਯੋਜਨਾ ਦਾ ਐਲਾਨ ਕੀਤਾ ਗਿਆ।</p>',
                'content_en'     => '<p>A comprehensive masterplan covering health, education, and rural connectivity infrastructure was announced today.</p>',
                'content_hi'     => '<p>राज्य में स्वास्थ्य, शिक्षा और उद्योग क्षेत्र को नई गति देने के लिए व्यापक योजना की घोषणा की गई।</p>',
                'content_pb'     => '<p>ਸੂਬੇ ਵਿੱਚ ਸਿਹਤ, ਸਿੱਖਿਆ ਅਤੇ ਉਦਯੋਗ ਖੇਤਰ ਨੂੰ ਨਵੀਂ ਦਿਸ਼ਾ ਦੇਣ ਲਈ ਵਿਸਤ੍ਰਿਤ ਯੋਜਨਾ ਦਾ ਐਲਾਨ ਕੀਤਾ ਗਿਆ।</p>',
                'category'       => 'Videos',
                'image_url'      => '/top_story_world_1784880571337.jpg',
                'video_url'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration'       => '08:45',
                'is_hero'        => false,
                'is_middle_stack'=> false,
                'is_admin_post'  => true,
                'status'         => 'published',
                'views_count'    => 19400,
            ],
        ];

        foreach ($posts as $postData) {
            UserPost::create(array_merge($postData, [
                'user_id'     => $admin->id,
                'author_name' => 'Aakash News Desk',
                'ai_status'   => 'approved',
                'ai_feedback' => 'Seeded production article',
            ]));
        }

        // 6. Seed Interactive Opinion Poll
        Poll::create([
            'question'  => 'ਕੀ ਤੁਹਾਨੂੰ ਲੱਗਦਾ ਹੈ ਕਿ ਸਰਕਾਰ ਦਾ ₹305 ਕਰੋੜ ਦਾ ਵਿੱਤੀ ਪੈਕੇਜ ਜ਼ਮੀਨੀ ਪੱਧਰ \'ਤੇ ਔਰਤਾਂ ਦੀ ਆਰਥਿਕ ਸਥਿਤੀ ਸੁਧਾਰੇਗਾ?',
            'options'   => [
                'ਹਾਂ, ਬਹੁਤ ਵੱਡਾ ਸੁਧਾਰ ਹੋਵੇਗਾ',
                'ਨਹੀਂ, ਕੋਈ ਖਾਸ ਫਰਕ ਨਹੀਂ ਪਵੇਗਾ',
                'ਕਹਿ ਨਹੀਂ ਸਕਦੇ / ਵਿਚਾਰ ਅਧੀਨ',
            ],
            'votes'     => [
                0 => 9840,
                1 => 3210,
                2 => 1470,
            ],
            'is_active' => true,
        ]);

        // 7. Seed Instagram Reels
        $reels = [
            [
                'title'     => 'ਪੰਜਾਬ ਵਿੱਚ ਮੌਸਮ ਦਾ ਤਾਜ਼ਾ ਹਾਲ 🌧️',
                'url'       => 'https://assets.mixkit.co/videos/preview/mixkit-rain-falling-on-a-glass-roof-41558-large.mp4',
                'embed_url' => 'https://assets.mixkit.co/videos/preview/mixkit-rain-falling-on-a-glass-roof-41558-large.mp4',
            ],
            [
                'title'     => 'ਸ੍ਰੀ ਹਰਿਮੰਦਰ ਸਾਹਿਬ ਜੀ ਦਾ ਅਲੌਕਿਕ ਨਜ਼ਾਰਾ 🪔',
                'url'       => 'https://assets.mixkit.co/videos/preview/mixkit-hands-holding-a-glowing-lantern-41547-large.mp4',
                'embed_url' => 'https://assets.mixkit.co/videos/preview/mixkit-hands-holding-a-glowing-lantern-41547-large.mp4',
            ],
            [
                'title'     => 'IPL 2026: ਪੰਜਾਬ ਕਿੰਗਜ਼ ਦਾ ਜਿੱਤ ਦਾ ਜਸ਼ਨ 🎉',
                'url'       => 'https://assets.mixkit.co/videos/preview/mixkit-stadium-lights-shining-in-the-dark-41551-large.mp4',
                'embed_url' => 'https://assets.mixkit.co/videos/preview/mixkit-stadium-lights-shining-in-the-dark-41551-large.mp4',
            ],
        ];

        foreach ($reels as $reel) {
            InstagramVideo::create($reel);
        }

        // 8. Seed Advertisements
        Advertisement::create([
            'name'      => 'Top Header Sponsored Banner',
            'image_url' => '/images/ad_banner.png',
            'status'    => 'active',
        ]);
        Advertisement::create([
            'name'      => 'Sidebar Premium Box',
            'image_url' => '/images/ad_sidebar.png',
            'status'    => 'active',
        ]);
    }
}
