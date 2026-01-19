<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultiPack extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'modifier_qty',
        'item_cost',
        'enter_retail',
        'margin',
        'linked_item_id',
        'scan_code_modifier',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function linkedItem()
    {
        return $this->belongsTo(Item::class, 'linked_item_id');
    }
}
