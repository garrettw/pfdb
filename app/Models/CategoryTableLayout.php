<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTableLayout extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'content',
        'display_order',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function layoutColumns(): HasMany
    {
        return $this->hasMany(LayoutColumn::class)->orderBy('display_order');
    }
}
