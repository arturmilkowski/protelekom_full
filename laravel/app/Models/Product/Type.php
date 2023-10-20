<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'condition_id',
        'slug',
        'name',
        'price',
        'promo_price',
        'quantity',
        'hide',
    ];

    protected static function booted(): void
    {
        /*
        static::creating(function (Type $type) {
            $type->slug = str()->slug($type->name);
        });
        static::updating(function (Type $type) {
            $type->slug = str()->slug($type->name);
        });
        */

        static::created(function () {
            Cache::forget('types');
        });
        static::updated(function () {
            Cache::forget('types');
        });
        static::deleted(function () {
            Cache::forget('types');
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}
