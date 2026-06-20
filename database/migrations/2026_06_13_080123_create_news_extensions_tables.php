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
        // 1. Create breaking_news table
        Schema::create('breaking_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Create photo_galleries table
        Schema::create('photo_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url');
            $table->timestamps();
        });

        // 3. Add extra columns to user_posts table
        Schema::table('user_posts', function (Blueprint $table) {
            $table->boolean('is_hero')->default(false)->after('status');
            $table->boolean('is_middle_stack')->default(false)->after('is_hero');
            $table->integer('views_count')->default(0)->after('is_middle_stack');
            $table->string('duration')->nullable()->after('video_url'); // for video posts duration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_posts', function (Blueprint $table) {
            $table->dropColumn(['is_hero', 'is_middle_stack', 'views_count', 'duration']);
        });

        Schema::dropIfExists('photo_galleries');
        Schema::dropIfExists('breaking_news');
    }
};
