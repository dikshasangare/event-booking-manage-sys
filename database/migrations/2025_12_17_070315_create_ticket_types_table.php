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
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('name'); // VIP, Regular, Early Bird
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('INR');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('sold')->default(0);
            $table->unsignedInteger('min_per_order')->default(1);
            $table->unsignedInteger('max_per_order')->default(10);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->dateTime('sale_start')->nullable();
            $table->dateTime('sale_end')->nullable();
            $table->enum('sales_channel', ['online', 'offline', 'invite'])->default('online');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
