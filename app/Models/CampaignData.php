<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignData extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignDataFactory> */
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'video_url',
        'custom_fields',
    ];
    
    protected $casts = [
        'custom_fields' => 'array',
    ];
}
