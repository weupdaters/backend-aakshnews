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
        // 1. Comments table
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('user_post_id')->constrained('user_posts')->onDelete('cascade');
                $table->string('author_name')->nullable();
                $table->text('comment');
                $table->string('status')->default('approved'); // approved, pending, rejected
                $table->timestamps();
            });
        }

        // 2. Bookmarks table
        if (!Schema::hasTable('bookmarks')) {
            Schema::create('bookmarks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_post_id')->constrained('user_posts')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['user_id', 'user_post_id']);
            });
        }

        // 3. Post Likes table
        if (!Schema::hasTable('post_likes')) {
            Schema::create('post_likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_post_id')->constrained('user_posts')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['user_id', 'user_post_id']);
            });
        }

        // 4. Reading History table
        if (!Schema::hasTable('reading_histories')) {
            Schema::create('reading_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_post_id')->constrained('user_posts')->onDelete('cascade');
                $table->timestamp('read_at')->useCurrent();
                $table->timestamps();
            });
        }

        // 5. Polls & Poll Votes tables
        if (!Schema::hasTable('polls')) {
            Schema::create('polls', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->json('options'); // ['Option 1', 'Option 2', ...]
                $table->json('votes')->nullable(); // {'0': 10, '1': 5}
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('poll_votes')) {
            Schema::create('poll_votes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('poll_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('ip_address')->nullable();
                $table->integer('option_index');
                $table->timestamps();
            });
        }

        // 6. Contact Messages table
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('subject')->nullable();
                $table->text('message');
                $table->timestamps();
            });
        }

        // 7. User Notifications table
        if (!Schema::hasTable('user_notifications')) {
            Schema::create('user_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->string('action_url')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('poll_votes');
        Schema::dropIfExists('polls');
        Schema::dropIfExists('reading_histories');
        Schema::dropIfExists('post_likes');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('comments');
    }
};
