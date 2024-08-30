<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'link',
        'price',
        'quantity',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function refill()
    {
        return $this->hasOne(Refill::class);
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function convertPrice(): Attribute
    {
        return new Attribute(
            get: fn() => number_format($this->price, 3, '.', '.'),
        );
    }

    public function convertDate(): Attribute
    {
        return new Attribute(
            get: fn() => date('d/m/Y H:i:s', strtotime($this->created_at)),
        );
    }

    public function scopePending($query)
    {
        $query->where('status_id', 1);
    }

    public function scopeCompleted($query)
    {
        $query->where('status_id', 4);
    }
}
