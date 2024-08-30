<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function convertDate(): Attribute
    {
        return new Attribute(
            get: fn() => date('d/m/Y H:i:s', strtotime($this->created_at)),
        );
    }

    public function scopeDeadline($query)
    {
        $query->where('completed_at', '>', date('Y-m-d H:i:s', strtotime("-24 hours")));
    }

    public function scopeInProgress($query)
    {
        $query->where('status_id', 3);
    }
}
