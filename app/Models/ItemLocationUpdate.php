<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemLocationUpdate extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'location_id',
        'units_per_case',
        'unit_retail',
        'case_cost',
        'case_discount',
        'case_rebate',
        'online_retail',
        'cost_after_discount',
        'unit_of_measure_id',
        'size_id',
        'margin',
        'margin_after_rebate',
        'default_margin',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
