<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name'];

    protected static function booted(): void
    {
        static::created(function () {
            Cache::forget('categories');
        });
        static::updated(function () {
            Cache::forget('categories');
        });
        static::deleted(function () {
            Cache::forget('categories');
        });
    }

    /*
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    */
}
