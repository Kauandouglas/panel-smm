<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function notificationsMany()
    {
        return $this->belongsToMany(Notification::class);
    }

    public function userServicePrices()
    {
        return $this->hasMany(UserServicePrice::class);
    }

    public function password(): Attribute
    {
        return new Attribute(
            set: fn($value) => (!empty($value) ? Hash::make($value) : $this->password),
        );
    }

    public function setImage($value)
    {
        if (!is_null($value)) {
            if($this->image) {
                Storage::delete($this->image);
            }

            $upload = $value->store('users/' . $this->id);
            $this->attributes['image'] = $upload;
        }
    }

    public function getUrlImage(): Attribute
    {
        if (!empty($this->image) && File::exists('../public/storage/' . $this->image)) {
            $image = route('imagecache', [
                'template' => 'person',
                'filename' => $this->image,
                'w' => 50,
                'h' => 50
            ]);
        } else {
            $image = asset('panel/img/avatar/avatar-1.png');
        }

        return new Attribute(
            get: fn() => $image,
        );
    }

    public function convertDate(): Attribute
    {
        return new Attribute(
            get: fn() => date('d/m/Y H:i:s', strtotime($this->created_at)),
        );
    }

    public function convertDateLogin(): Attribute
    {
        return new Attribute(
            get: fn() => date('d/m/Y H:i:s', strtotime($this->latest_login_at)),
        );
    }

    public function convertBalance(): Attribute
    {
        return new Attribute(
            get: fn() => number_format($this->balance, 2, ',', '.'),
        );
    }

    public function scopeUsers($query)
    {
        $query->where('role', 1);
    }
}
