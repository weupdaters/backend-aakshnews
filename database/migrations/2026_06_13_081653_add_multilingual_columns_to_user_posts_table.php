<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_posts', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_hi')->nullable()->after('title_en');
            $table->string('title_pb')->nullable()->after('title_hi');
            $table->text('content_en')->nullable()->after('content');
            $table->text('content_hi')->nullable()->after('content_en');
            $table->text('content_pb')->nullable()->after('content_hi');
        });

        // Populate existing posts with translations
        try {
            $posts = \Illuminate\Support\Facades\DB::table('user_posts')->get();
            foreach ($posts as $post) {
                $titleEn = $this->translate($post->title, 'en');
                $titleHi = $this->translate($post->title, 'hi');
                $titlePb = $this->translate($post->title, 'pa');
                
                $contentEn = $this->translate($post->content, 'en');
                $contentHi = $this->translate($post->content, 'hi');
                $contentPb = $this->translate($post->content, 'pa');
                
                \Illuminate\Support\Facades\DB::table('user_posts')
                    ->where('id', $post->id)
                    ->update([
                        'title_en' => $titleEn ?: $post->title,
                        'title_hi' => $titleHi ?: $post->title,
                        'title_pb' => $titlePb ?: $post->title,
                        'content_en' => $contentEn ?: $post->content,
                        'content_hi' => $contentHi ?: $post->content,
                        'content_pb' => $contentPb ?: $post->content,
                    ]);
            }
        } catch (\Exception $e) {
            // Ignore seeding/translation errors if table is empty or connection issues occur
        }
    }

    private function translate($text, $targetLang)
    {
        if (empty($text)) return '';
        try {
            $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" . $targetLang . "&dt=t&q=" . urlencode($text);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
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
            // Fallback
        }
        return $text;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_posts', function (Blueprint $table) {
            $table->dropColumn([
                'title_en', 'title_hi', 'title_pb',
                'content_en', 'content_hi', 'content_pb'
            ]);
        });
    }
};
