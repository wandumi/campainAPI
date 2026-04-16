<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignData;
use Illuminate\Console\Command;

class GenerateCampaignAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:generate {campaign_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaignId = $this->argument('campaign_id');
        $query = Campaign::withCount('data');

        if ($campaignId) {
            $query->where('id', $campaignId);
        }

        $campaigns = $query->get();

        if ($campaigns->isEmpty()) {
            $this->error('No campaigns found.');
            return;
        }

        $this->info('--- Campaign Analytics Report ---');

        $headers = ['ID', 'Name', 'Total Videos', 'Start Date'];

        $rows = $campaigns->map(fn($c) => [
            $c->id, 
            $c->name, 
            $c->data_count, 
            $c->start_date
        ]);

        $this->table($headers, $rows);

        if ($campaignId) {
            $this->displayCustomFieldsInsights($campaignId);
        }
    }


    private function displayCustomFieldsInsights($campaignId)
    {
        $this->info("\n--- Custom Fields in Json ---");
        
        $allData = CampaignData::where('campaign_id', $campaignId)->get();
        
        $keys = $allData->flatMap(fn($d) => array_keys($d->custom_fields ?? []))->countBy();

        if ($keys->isEmpty()) {
            $this->line('No custom fields found for this campaign.');
            return;
        }

        foreach ($keys as $key => $count) {
            $this->line("Field [{$key}] was populated in {$count} videos.");
        }
    }
}
