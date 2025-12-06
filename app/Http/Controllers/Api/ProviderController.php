<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProviderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $providers = Provider::withCount('quotes')
            ->orderBy('rating', 'desc')
            ->get();

        return ProviderResource::collection($providers);
    }

    public function show(Provider $provider): ProviderResource
    {
        $provider->loadCount('quotes');
        return new ProviderResource($provider);
    }
}
