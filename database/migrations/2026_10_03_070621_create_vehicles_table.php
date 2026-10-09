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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // e.g. Maruti Suzuki Dzire
            $table->string('category');          // Sedan, SUV, Tempo Traveller
            $table->string('badge')->nullable(); // e.g. Best Seller, Top Rated
            $table->decimal('rate_per_km', 8, 2);// e.g. 12.00
            $table->decimal('base_fare', 8, 2);  // e.g. 1800.00
            $table->integer('seating_capacity'); // e.g. 4
            $table->integer('luggage_capacity'); // e.g. 2
            $table->string('image')->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
