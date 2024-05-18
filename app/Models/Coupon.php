<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class,'coupon_users');
    }

    #Apply a promotion to a reservation and update the total cost. 
    public function getAmountAttribute($total)
    {
        if($this->type == 'fixed'){
            return $this->value;
        } elseif ($this->type == 'percent'){
            return ($this->discount_amount / 100) * $total;
        } else{
            return 0;
        }
    }
}
