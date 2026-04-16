<?php

use App\Jobs\ProcessCampaignData;
use App\Models\Campaign;
use App\Models\CampaignData;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the background job actually saves data to the database', function () {
    $campaign = Campaign::factory()->create();
    $userData = [
        [
            'user_id' => 'user_test_1',
            'video_url' => 'https://video.com',
            'custom_fields' => ['color' => 'red']
        ]
    ];

    (new ProcessCampaignData($campaign, $userData))->handle();

    $this->assertDatabaseHas('campaign_data', [
        'campaign_id' => $campaign->id,
        'user_id' => 'user_test_1',
        'video_url' => 'https://video.com'
    ]);
});

test('it handles duplicate user_ids by updating the existing record', function () {
    $campaign = Campaign::factory()->create();
    $user_id = 'duplicate_user';

    (new ProcessCampaignData($campaign, [
        ['user_id' => $user_id, 'video_url' => 'https://video.com']
    ]))->handle();

    (new ProcessCampaignData($campaign, [
        ['user_id' => $user_id, 'video_url' => 'https://video.com']
    ]))->handle();

    expect(CampaignData::count())->toBe(1);
    $this->assertDatabaseHas('campaign_data', [
        'user_id' => $user_id,
        'video_url' => 'https://video.com'
    ]);
});
