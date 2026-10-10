<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxi_routes', function (Blueprint $table) {
            $table->id();
            $table->string('from_city');
            $table->string('to_city');
            $table->string('slug')->unique();
            $table->unsignedInteger('distance_km');
            $table->string('duration');                    // e.g. 5–6 hours
            $table->decimal('sedan_fare', 10, 2)->nullable();
            $table->decimal('suv_fare', 10, 2)->nullable();
            $table->decimal('traveller_fare', 10, 2)->nullable();
            $table->text('short_desc');
            $table->text('description');
            $table->json('highlights')->nullable();         // stops & sights on the way
            $table->string('image');
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->boolean('is_popular')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxi_routes');
    }
};
