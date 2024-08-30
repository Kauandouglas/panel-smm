<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function nameApi(): Attribute
    {
        return new Attribute(
            get: fn() => $this->status_api($this->id),
        );
    }

    private function status_api($status)
    {
        switch ($status){
            case 1:
                return "Pending";
            case 2:
                return "Processing";
            case 3:
                return "In progress";
            case 4:
                return "Completed";
            case 5:
                return "Partial";
            case 6:
                return "Canceled";
        }
    }
}
