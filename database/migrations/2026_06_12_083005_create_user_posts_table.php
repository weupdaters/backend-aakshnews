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
        Schema::create('user_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('author_name')->nullable();
            $table->string('title');
            $table->text('content');
            $table->string('category')->default('General');
            $table->string('image_url')->nullable();
            $table->string('ai_status')->default('pending'); // pending, approved, flagged, rejected
            $table->text('ai_feedback')->nullable();
            $table->string('status')->default('pending'); // pending, published, hidden
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_posts');
    }
};
