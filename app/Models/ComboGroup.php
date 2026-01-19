<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComboGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'combo_id',
        'description',
        'quantity',
        'combo_price',
        'items_count',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'combo_price' => 'decimal:2',
        'items_count' => 'integer',
    ];

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'combo_group_items', 'combo_group_id', 'item_id')
                    ->withTimestamps();
    }

}
