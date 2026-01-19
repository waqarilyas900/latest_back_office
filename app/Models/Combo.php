<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'image',
        'deal_description',
        'add_to_deal',
    ];

    protected $casts = [
        'add_to_deal' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function groups()
    {
        return $this->hasMany(ComboGroup::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'combo_location', 'combo_id', 'location_id')
                    ->withTimestamps();
    }
}
