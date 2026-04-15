<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignDataController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/campaigns', [CampaignController::class, 'store']);
    
    Route::post('/campaigns/{campaign}/data', [CampaignDataController::class, 'store']);
});
