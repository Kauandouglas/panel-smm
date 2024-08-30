<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
      'price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusString(): Attribute
    {
        return new Attribute(
            get: fn() => ($this->status ? 'Aprovado' : 'Pendente'),
        );
    }

    public function convertDate(): Attribute
    {
        return new Attribute(
            get: fn() => date('d/m/Y H:i:s', strtotime($this->created_at)),
        );
    }
}
