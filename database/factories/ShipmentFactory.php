<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_number' => strtoupper($this->faker->bothify('TRK########')),
            'customer_id' => \App\Models\Customer::inRandomOrder()->first()->id ?? 1,
            'carrier_id' => \App\Models\Carrier::inRandomOrder()->first()->id ?? 1,
            'origin' => $this->faker->city(),
            'destination' => $this->faker->city(),
            'estimated_delivery' => $this->faker->dateTimeBetween('+1 days', '+7 days'),
            'estimated_cost' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['Shipment Created', 'In Transit', 'Out for Delivery', 'Delivered']),
            'current_latitude' => $this->faker->latitude(),
            'current_longitude' => $this->faker->longitude(),
            'last_location_update' => now(),
            'email_notifications' => $this->faker->boolean(),
            'sms_notifications' => $this->faker->boolean(),
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
