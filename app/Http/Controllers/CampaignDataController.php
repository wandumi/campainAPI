<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCampaignData;
use App\Models\Campaign;
use App\Models\CampaignData;
use Illuminate\Http\Request;

class CampaignDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Campaign $campaign)
    {
         $request->validate([
            'data' => 'required|array',
            'data.*.user_id' => 'required|string',
            'data.*.video_url' => 'required|url',
        ]);

        ProcessCampaignData::dispatch($campaign, $request->data);

        return response()->json(['message' => 'Data ingestion accepted.'], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(CampaignData $campaignData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampaignData $campaignData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampaignData $campaignData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampaignData $campaignData)
    {
        //
    }
}
