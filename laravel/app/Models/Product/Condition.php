<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    }

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }
}
