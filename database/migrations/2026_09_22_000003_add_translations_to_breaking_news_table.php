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
        Schema::table('breaking_news', function (Blueprint $table) {
            if (!Schema::hasColumn('breaking_news', 'title_en')) {
                $table->string('title_en')->nullable()->after('title');
            }
            if (!Schema::hasColumn('breaking_news', 'title_hi')) {
                $table->string('title_hi')->nullable()->after('title_en');
            }
            if (!Schema::hasColumn('breaking_news', 'title_pb')) {
                $table->string('title_pb')->nullable()->after('title_hi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('breaking_news', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_hi', 'title_pb']);
        });
    }
};
