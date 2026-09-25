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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email'); // admin, reporter, user
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'district')) {
                $table->string('district')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'state')) {
                $table->string('state')->default('Punjab')->after('district');
            }
            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points')->default(100)->after('state');
            }
            if (!Schema::hasColumn('users', 'badge')) {
                $table->string('badge')->default('Citizen Journalist')->after('points');
            }
            if (!Schema::hasColumn('users', 'reporter_id')) {
                $table->string('reporter_id')->nullable()->unique()->after('badge');
            }
            if (!Schema::hasColumn('users', 'is_verified_reporter')) {
                $table->boolean('is_verified_reporter')->default(false)->after('reporter_id');
            }
        });

        // Create reporter applications table if it doesn't exist
        if (!Schema::hasTable('reporter_applications')) {
            Schema::create('reporter_applications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->string('district');
                $table->string('city')->nullable();
                $table->string('id_proof_type')->default('Aadhaar');
                $table->string('id_proof_number');
                $table->text('experience')->nullable();
                $table->text('motivation')->nullable();
                $table->string('status')->default('pending'); // pending, approved, rejected
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = ['role', 'phone', 'district', 'state', 'points', 'badge', 'reporter_id', 'is_verified_reporter'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::dropIfExists('reporter_applications');
    }
};
