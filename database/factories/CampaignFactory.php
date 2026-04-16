<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(), 
            'name' => $this->faker->sentence(3),
            'start_date' => now()->toDateString(),
        ];
    }
}
