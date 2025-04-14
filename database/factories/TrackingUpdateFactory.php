<?php

namespace Database\Factories;

use App\Models\TrackingUpdate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrackingUpdate>
 */
class TrackingUpdateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackingUpdate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['Shipment Created', 'In Transit', 'Out for Delivery', 'Delivered', 'Delayed'];
        $status = $this->faker->randomElement($statuses);
        
        return [
            'shipment_id' => \App\Models\Shipment::inRandomOrder()->first()->id ?? 1,
            'status' => $status,
            'location' => $this->faker->city(),
            'updated_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
