<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationPriceGroupUpdate extends Model
{
    protected $fillable = [
        'user_id',
        'location_id',
        'price_group_id',
        'price',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function priceGroup()
    {
        return $this->belongsTo(PriceGroup::class);
    }
}
