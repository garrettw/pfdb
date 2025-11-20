<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'unit',
        'type',
        'display_order',
        'is_primary_metric',
    ];

    protected $casts = [
        'is_primary_metric' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
