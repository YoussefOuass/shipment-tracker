<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    \App\Models\Customer::factory(5)->create();
    \App\Models\Carrier::factory(3)->create();
    \App\Models\Shipment::factory(10)->create();

    // Create multiple tracking updates per shipment
    \App\Models\Shipment::all()->each(function ($shipment) {
        \App\Models\TrackingUpdate::factory(3)->create([
            'shipment_id' => $shipment->id
        ]);
    });
}
}
