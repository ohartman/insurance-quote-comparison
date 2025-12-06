<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Quote::with('provider');

        // Filter by coverage type
        if ($request->has('coverage_type')) {
            $query->where('coverage_type', $request->coverage_type);
        }

        // Filter by price range
        if ($request->has('min_premium')) {
            $query->where('monthly_premium', '>=', $request->min_premium);
        }

        if ($request->has('max_premium')) {
            $query->where('monthly_premium', '<=', $request->max_premium);
        }

        // Filter by provider
        if ($request->has('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        $quotes = $query->orderBy('monthly_premium')->get();

        return QuoteResource::collection($quotes);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'coverage_type' => 'required|in:liability,collision,comprehensive,full',
            'monthly_premium' => 'required|numeric|min:0',
            'deductible' => 'required|numeric|min:0',
            'coverage_limit' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'vehicle_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_make' => 'required|string|max:255',
            'vehicle_model' => 'required|string|max:255',
        ]);

        $quote = Quote::create($validated);
        $quote->load('provider');

        return (new QuoteResource($quote))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Quote $quote): QuoteResource
    {
        $quote->load('provider');
        return new QuoteResource($quote);
    }

    public function update(Request $request, Quote $quote): QuoteResource
    {
        $validated = $request->validate([
            'provider_id' => 'sometimes|exists:providers,id',
            'coverage_type' => 'sometimes|in:liability,collision,comprehensive,full',
            'monthly_premium' => 'sometimes|numeric|min:0',
            'deductible' => 'sometimes|numeric|min:0',
            'coverage_limit' => 'sometimes|numeric|min:0',
            'customer_name' => 'sometimes|string|max:255',
            'customer_email' => 'sometimes|email|max:255',
            'vehicle_year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_make' => 'sometimes|string|max:255',
            'vehicle_model' => 'sometimes|string|max:255',
        ]);

        $quote->update($validated);
        $quote->load('provider');

        return new QuoteResource($quote);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        $quote->delete();

        return response()->json([
            'message' => 'Quote deleted successfully'
        ], 204);
    }
}
