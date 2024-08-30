<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'api_id',
        'type_id',
        'api_service',
        'name',
        'description',
        'quantity_min',
        'quantity_max',
        'price',
        'refill',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function api()
    {
        return $this->belongsTo(Api::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function userServicePrice()
    {
        return $this->hasOne(UserServicePrice::class);
    }

    public function convertPrice(): Attribute
    {
        return new Attribute(
            get: fn() => number_format($this->price, 2, ',', '.'),
        );
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
