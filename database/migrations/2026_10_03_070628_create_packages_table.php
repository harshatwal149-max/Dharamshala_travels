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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('duration');          // e.g. 3 Days / 2 Nights
            $table->decimal('starting_price', 8, 2);
            $table->string('thumbnail');
            $table->text('short_desc');
            $table->json('itinerary');           // Day-by-day details
            $table->json('inclusions');
            $table->decimal('rating', 2, 1)->default(4.9);
            $table->integer('reviews_count')->default(24);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
