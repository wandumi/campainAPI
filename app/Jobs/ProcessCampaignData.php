<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCampaignData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Campaign $campaign,
        public array $userData
    ) {}

    public function handle(): void
    {
        foreach ($this->userData as $data) {
            $record = CampaignData::updateOrCreate(
                ['campaign_id' => $this->campaign->id, 'user_id' => $data['user_id']],
                [
                    'video_url' => $data['video_url'],
                    'custom_fields' => $data['custom_fields'] ?? []
                ]
            );

            if (!$record->wasRecentlyCreated) {
                Log::warning("Duplicate detected for Campaign ID: {$this->campaign->id}", [
                    'user_id' => $data['user_id'],
                    'action'  => 'updated_existing_record',
                    'context' => 'API Data Ingestion'
                ]);
            }
        }
    }
}
