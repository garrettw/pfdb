<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Retailer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($retailer) {
            if (empty($retailer->slug)) {
                $retailer->slug = Str::slug($retailer->name);
            }
        });

        static::updating(function ($retailer) {
            if ($retailer->isDirty('name') && empty($retailer->slug)) {
                $retailer->slug = Str::slug($retailer->name);
            }
        });
    }

    public function retailerLinks(): HasMany
    {
        return $this->hasMany(RetailerLink::class);
    }
}
