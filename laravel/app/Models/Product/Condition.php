<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name'];

    protected static function booted(): void
    {
        static::creating(function (Condition $condition) {
            $condition->slug = str()->slug($condition->name);
        });
        static::updating(function (Condition $condition) {
            $condition->slug = str()->slug($condition->name);
        });

        static::created(function () {
            Cache::forget('conditions');
        });
        static::updated(function () {
            Cache::forget('conditions');
        });
        static::deleted(function () {
            Cache::forget('conditions');
        });
    }

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }
}
