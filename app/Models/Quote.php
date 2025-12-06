<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'coverage_type',
        'monthly_premium',
        'deductible',
        'coverage_limit',
        'customer_name',
        'customer_email',
        'vehicle_year',
        'vehicle_make',
        'vehicle_model',
    ];

    protected $casts = [
        'monthly_premium' => 'decimal:2',
        'deductible' => 'decimal:2',
        'coverage_limit' => 'decimal:2',
        'vehicle_year' => 'integer',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function getAnnualPremiumAttribute(): float
    {
        return $this->monthly_premium * 12;
    }

    public function getTotalCostAttribute(): float
    {
        return $this->annual_premium + $this->deductible;
    }
}
