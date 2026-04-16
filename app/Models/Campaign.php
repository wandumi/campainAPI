<?php

namespace App\Models;

use App\Models\Campaign;
use App\Models\CampaignData;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignFactory> */
    use HasFactory;

    protected $fillable = [
            "client_id", 
            "name",
            "start_date",
            "end_date"
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }

    public function data() {
        return $this->hasMany(CampaignData::class);
    }
}
