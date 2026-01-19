<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'promotion_name',
        'pos_description',
        'funded_by',
        'mix_n_match',
        'new_price',
        'price_reduction',
        'quantity',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'offer_image',
        'add_to_deal',
        'offer_description',
    ];

    protected $casts = [
        'add_to_deal' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'new_price' => 'decimal:2',
        'price_reduction' => 'decimal:2',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_promotion', 'promotion_id', 'item_id')
                    ->withTimestamps();
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'promotion_location', 'promotion_id', 'location_id')
                    ->withTimestamps();
    }
}
