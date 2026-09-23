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
            $table->string('meta_title')->nullable()->after('content_pb');
            $table->text('meta_desc')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_desc');
            $table->boolean('is_reel')->default(false)->after('meta_keywords');
            $table->string('media_type')->default('image')->after('is_reel'); // 'image', 'video', 'reel'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_posts', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_desc', 'meta_keywords', 'is_reel', 'media_type']);
        });
    }
};
