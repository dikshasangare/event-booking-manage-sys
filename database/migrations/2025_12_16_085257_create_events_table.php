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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained('venues');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('about_event')->nullable();
            $table->string('event_type')->default('other'); //'classical', 'fusion', 'rock', 'comedy', 'conference', 'workshop', 'other', 'online', 'offline'
            $table->unsignedTinyInteger('age_limit')->nullable(); // 18, 21, etc.
            $table->string('language')->nullable(); // Hindi, English, Marathi
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->integer('total_duration_minutes')->nullable(); // calculated
            $table->integer('max_capacity')->nullable();
            $table->string('banner_image')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_private')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
