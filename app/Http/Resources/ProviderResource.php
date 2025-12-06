<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rating' => number_format($this->rating, 1),
            'phone' => $this->phone,
            'website' => $this->website,
            'quotes_count' => $this->when(isset($this->quotes_count), $this->quotes_count),
        ];
    }
}
