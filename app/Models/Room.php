<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class,'room_facilities');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'favorite');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    #Find rooms available for specific dates and guest count,considering room types and pricing.
    public function scopeSearch($query,$startDate,$endDate,$guest_count,$room_type_id,$min_price,$max_price)
    {
        return $query->whereDoesntHave('reservations', function ($query) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })
        ->where('guest_count', $guest_count)
        ->where('activated',1)
        ->whereBetween('price', [$min_price, $max_price])
        ->where('room_type_id', $room_type_id);
    }
}
