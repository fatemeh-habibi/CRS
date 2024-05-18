<?php

namespace App\Models;

use App\Helpers\Model\Authorable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; // include this after passport install

class User extends Authenticatable
{
    use Notifiable, HasApiTokens; // update this after passport install
    use SoftDeletes,Authorable;

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
        'password' => 'hashed',
    ];

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class,'coupon_users');
    }
}
