<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rating',
        'phone',
        'website',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
    ];

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
