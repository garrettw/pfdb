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

    public function getAttributeValue($attributeId)
    {
        return $this->productAttributes()
            ->where('attribute_id', $attributeId)
            ->value('value');
    }

    public function setAttributeValue($attributeId, $value)
    {
        return $this->productAttributes()->updateOrCreate(
            ['attribute_id' => $attributeId],
            ['value' => $value]
        );
    }
}
