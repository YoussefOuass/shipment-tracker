<?php

namespace Database\Factories;

use App\Models\Carrier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carrier>
 */
class CarrierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carrier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $carriers = [
            ['name' => 'DHL', 'code' => 'DHL'],
            ['name' => 'FedEx', 'code' => 'FDX'],
            ['name' => 'UPS', 'code' => 'UPS'],
            ['name' => 'USPS', 'code' => 'USP'],
            ['name' => 'TNT', 'code' => 'TNT'],
            ['name' => 'Aramex', 'code' => 'ARM']
        ];
        
        $carrier = $this->faker->unique()->randomElement($carriers);
        
        return [
            'name' => $carrier['name'],
            'code' => $carrier['code'],
        ];
    }
}
