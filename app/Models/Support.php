<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject'
    ];

    public function supportMessages()
    {
        return $this->hasMany(SupportMessage::class);
    }

    public function convertDate(): Attribute
    {
        return new Attribute(
            get: fn() => date('d/m/Y H:i:s', strtotime($this->created_at)),
        );
    }

    public function statusString(): Attribute
    {
        switch ($this->status){
            case 0:
                return new Attribute(
                    get: fn() => 'Aberto',
                );
            case 1:
                return new Attribute(
                    get: fn() => 'Respondido',
                );
            case 2:
                return new Attribute(
                    get: fn() => 'Fechado',
                );
        }
    }

    public function scopeActive($query)
    {
        $query->whereIn('status', [0,1]);
    }
}
