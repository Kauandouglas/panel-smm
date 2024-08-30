<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
      'message'
    ];

    public function convertTime(): Attribute
    {
        return new Attribute(
            get: fn() => date('H:i', strtotime($this->created_at)),
        );
    }

}
