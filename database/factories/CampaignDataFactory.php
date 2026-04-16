<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\CampaignData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CampaignData>
 */
class CampaignDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'user_id' => 'user_' . $this->faker->unique()->numberBetween(100, 999),
            'video_url' => $this->faker->url,
            'custom_fields' => ['tier' => 'gold', 'region' => 'ZA'],
        ];
    }
}
