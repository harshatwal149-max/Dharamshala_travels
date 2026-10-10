<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * All seeders are idempotent (updateOrCreate by slug / key),
     * so `php artisan db:seed` can be re-run safely.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            VehicleSeeder::class,
            PackageSeeder::class,
            DestinationSeeder::class,
            TaxiRouteSeeder::class,
            BlogSeeder::class,
            HeroBannerSeeder::class,
        ]);
    }
}
