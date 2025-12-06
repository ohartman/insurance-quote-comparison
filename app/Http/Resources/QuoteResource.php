<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'provider' => new ProviderResource($this->whenLoaded('provider')),
            'coverage_type' => $this->coverage_type,
            'monthly_premium' => number_format($this->monthly_premium, 2),
            'annual_premium' => number_format($this->annual_premium, 2),
            'deductible' => number_format($this->deductible, 2),
            'coverage_limit' => number_format($this->coverage_limit, 2),
            'total_cost' => number_format($this->total_cost, 2),
            'customer' => [
                'name' => $this->customer_name,
                'email' => $this->customer_email,
            ],
            'vehicle' => [
                'year' => $this->vehicle_year,
                'make' => $this->vehicle_make,
                'model' => $this->vehicle_model,
            ],
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
