<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCode extends Model
{
    protected $fillable = [
        'item_code',
        'payee_id',
        'item_id',
    ];

    public function payee()
    {
        return $this->belongsTo(Payee::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
