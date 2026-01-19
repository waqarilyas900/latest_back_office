<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceGroup extends Model
{
    use SoftDeletes;
    protected $fillable = ['group_name', 'price', 'active'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_price_group', 'price_group_id', 'item_id')
                    ->withTimestamps();
    }
    public function locationUpdates()
    {
        return $this->hasMany(LocationPriceGroupUpdate::class, 'price_group_id');
    }


}
