<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'model',
        'notes',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function retailerLinks(): HasMany
    {
        return $this->hasMany(RetailerLink::class);
    }

    public function getEavAttribute($attributeId)
    {
        if ($this->relationLoaded('productAttributes')) {
            $productAttribute = $this->productAttributes
                ->firstWhere('attribute_id', $attributeId);

            return $productAttribute ? $productAttribute->value : null;
        }

        return $this->productAttributes()
            ->where('attribute_id', $attributeId)
            ->value('value');
    }

    public function setEavAttribute($attributeId, $value)
    {
        return $this->productAttributes()->updateOrCreate(
            ['attribute_id' => $attributeId],
            ['value' => $value]
        );
    }
}
