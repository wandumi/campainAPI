<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignData;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Client::factory(3)
            ->has(
                Campaign::factory(2)->has(
                    CampaignData::factory(5), 'data' 
                )
            )
            ->create();
    
    }
}
