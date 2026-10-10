<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');                    // Monastery, Nature, Trek, Heritage...
            $table->string('tagline')->nullable();
            $table->text('short_desc');
            $table->text('description');
            $table->string('image');
            $table->json('gallery')->nullable();
            $table->json('highlights')->nullable();
            $table->string('distance')->nullable();        // e.g. 9 km from Dharamshala
            $table->string('altitude')->nullable();
            $table->string('best_time')->nullable();
            $table->string('timings')->nullable();
            $table->string('entry_fee')->nullable();
            $table->text('how_to_reach')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
