<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartonItemMapping extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'main_item_id',
        'mapped_item_id',
        'pack_qty',
    ];

    public function mappedItem()
    {
        return $this->belongsTo(Item::class, 'mapped_item_id');
    }
    
}
