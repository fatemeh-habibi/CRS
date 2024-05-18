<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use SoftDeletes;

    protected $table = 'province_cities';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $dates = [];

    public function province()
    {
        return $this->belongsTo(City::class , 'parent_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'parent_id');
    }
}
