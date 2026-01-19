<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'item_description',
        'department_id',
        'product_category_id',
        'price_group_id',
        'payee_id',
        'sale_type_id',
        'current_qty',
        'tag_description',
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
        'max_inv',
        'min_inv',
        'min_age',
        'tax_rate',
        'nacs_code',
        'blue_law',
        'nacs_category_id',
        'nacs_sub_category_id',
        'kitchen_option',
        'linked_item_id',
        'allow_ebt',
        'track_inventory',
        'discounted_item_taxable',
        'ingredient_for_label',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function priceGroup()
    {
        return $this->belongsTo(PriceGroup::class, 'price_group_id');
    }
    public function priceGroups()
    {
        return $this->belongsToMany(PriceGroup::class, 'item_price_group', 'item_id', 'price_group_id')
                    ->withTimestamps();
    }

    public function payee()
    {
        return $this->belongsTo(Payee::class);
    }

    public function saleType()
    {
        return $this->belongsTo(SaleType::class);
    }

    public function unitOfMeasure()
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    // public function taxRate()
    // {
    //     return $this->belongsTo(TaxRate::class);
    // }

    public function nacsCategory()
    {
        return $this->belongsTo(NacsCategory::class);
    }

    // public function nacsSubCategory()
    // {
    //     return $this->belongsTo(NacsSubCategory::class);
    // }

    public function codes()
    {
        return $this->hasMany(ItemCode::class);
    }

    public function linkedItem()
    {
        return $this->belongsTo(Item::class, 'linked_item_id');
    }

    public function cartonMappings()
    {
        return $this->hasMany(CartonItemMapping::class, 'carton_item_id');
    }

    public function insideCartons()
    {
        return $this->hasMany(CartonItemMapping::class, 'inner_item_id');
    }
    public function locationUpdates()
    {
        return $this->hasMany(ItemLocationUpdate::class);
    }

    public function locationUpdateFor($locationId)
    {
        return $this->hasOne(ItemLocationUpdate::class)
                    ->where('location_id', $locationId);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'item_promotion', 'item_id', 'promotion_id')
                    ->withTimestamps();
    }

    public function comboGroups()
    {
        return $this->belongsToMany(ComboGroup::class, 'combo_group_items', 'item_id', 'combo_group_id')
                    ->withTimestamps();
    }

}
