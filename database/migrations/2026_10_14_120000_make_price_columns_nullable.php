<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Prices are no longer collected or shown anywhere on the site,
     * so the old price columns must accept empty values.
     */
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('starting_price', 8, 2)->nullable()->change();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('rate_per_km', 8, 2)->nullable()->change();
            $table->decimal('base_fare', 8, 2)->nullable()->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('estimated_fare', 10, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('starting_price', 8, 2)->nullable(false)->change();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('rate_per_km', 8, 2)->nullable(false)->change();
            $table->decimal('base_fare', 8, 2)->nullable(false)->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('estimated_fare', 10, 2)->nullable(false)->change();
        });
    }
};
