<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_location', 'location_id', 'promotion_id')
                    ->withTimestamps();
    }

    public function combos()
    {
        return $this->belongsToMany(Combo::class, 'combo_location', 'location_id', 'combo_id')
                    ->withTimestamps();
    }
}
