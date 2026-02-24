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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('section')->nullable(); // VIP / Gold / Silver
            $table->string('row')->nullable();     // A, B, C
            $table->string('number');              // 1, 2, 3
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['available', 'locked', 'booked'])->default('available');
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
