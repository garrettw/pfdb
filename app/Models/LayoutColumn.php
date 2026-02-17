<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayoutColumn extends Model
{
    protected $fillable = [
        'category_table_layout_id',
        'attribute_id',
        'label',
        'display_order',
    ];

    public function categoryTableLayout(): BelongsTo
    {
        return $this->belongsTo(CategoryTableLayout::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
