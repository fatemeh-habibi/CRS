<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $appends = ['total_price'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function payment(): BelongsTo
    {
        return $this->hasOne(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    #Calculate the total cost of a reservation (including room price,taxes, and any applicable promotions).
    public function getTotalPriceAttribute(Room $room,Coupon $coupon,$tax)
    {
        $day = 1;
        $price = optional($room)->price * $day;

        return $price - optional($coupon)->amount($price) - $tax;
    }

    #Check if a guest has an existing reservation for a specific date and room type.
    public function scopeSearch($query,$startDate,$endDate,$room_type_id)
    {
        return $query->whereHas('room', function ($query) {
            return $query->where('room_type_id', $room_type_id);
        })
        ->whereBetween('date', [$startDate, $endDate]);
    }

    #Use accessors and mutators for data manipulation within the model (optional).
    protected function CheckIn(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  Carbon::parse($value)->format('m/d/Y'),
            set: fn ($value) =>  Carbon::parse($value)->format('Y-m-d'),
        );
    }

    protected function CheckOut(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  Carbon::parse($value)->format('m/d/Y'),
            set: fn ($value) =>  Carbon::parse($value)->format('Y-m-d'),
        );
    }
}
