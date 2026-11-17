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
        Schema::create('folklore_stories', function (Blueprint $table) {
            $table->string('id', 50)->primary(); // contoh: story_001
            $table->string('title', 200);
            $table->text('synopsis');
            $table->string('origin_region', 100)->nullable();
            $table->string('marker_code', 50); // contoh: MRK-001
            $table->integer('max_points')->default(100);
            $table->timestamps();
        });

        Schema::create('story_scores', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->unique();
            $table->string('player_name', 150);
            $table->string('story_id', 50);
            $table->integer('points')->default(0);
            $table->integer('objectives_completed')->default(0);
            $table->integer('duration_seconds')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_scores');
        Schema::dropIfExists('folklore_stories');
    }
};
