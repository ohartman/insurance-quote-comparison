<?php

use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\ProviderController;
use Illuminate\Support\Facades\Route;

// Quote routes
Route::apiResource('quotes', QuoteController::class);

// Provider routes
Route::get('providers', [ProviderController::class, 'index']);
Route::get('providers/{provider}', [ProviderController::class, 'show']);
