<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;




use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ItemTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'item-table-xg8qss-table';
    public bool $showFilters = true;
    
    // Modal properties
    public $showItemModal = false;
    public $selectedItemId = null;
    public $selectedItemCode = '';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput()
                 ->showToggleColumns(),
             
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    // public function datasource(): Builder
    // {
    //     return Item::query()
    //         ->with('department');
    // }
    public function datasource(): Builder
    {
        $user = Auth::user();
        

        $locationIds = $user->locations()->pluck('location_id')->toArray();

        return Item::query()
            ->with('department')
            ->with(['locationUpdates' => function ($query) use ($locationIds) {
                $query->whereIn('location_id', $locationIds);
            }]);
    }


    public function relationSearch(): array
    {
        return [];
    }

    // public function fields(): PowerGridFields
    // {
    //     return PowerGrid::fields()
    //         ->add('code')
    //         ->add('item_description')
    //         ->add('units_per_case')
    //         ->add('case_cost')
    //         ->add('case_discount')
    //         ->add('cost_after_discount')
    //         ->add('unit_retail')
    //         ->add('online_retail')
    //         ->add('margin')
    //         ->add('default_margin')
    //         ->add('department');
            
    //         // ->add('department_id')
    //         // ->add('product_category_id')
    //         // ->add('price_group_id')
    //         // ->add('payee_id')
    //         // ->add('sale_type_id')
    //         // ->add('current_qty')
    //         // ->add('tag_description')
    //         // ->add('case_rebate')
    //         // ->add('unit_of_measure_id')
    //         // ->add('size_id')
    //         // ->add('margin_after_rebate')
    //         // ->add('max_inv')
    //         // ->add('min_inv')
    //         // ->add('min_age')
    //         // ->add('tax_rate')
    //         // ->add('nacs_code')
    //         // ->add('blue_law')
    //         // ->add('nacs_category_id')
    //         // ->add('nacs_sub_category_id')
    //         // ->add('kitchen_option')
    //         // ->add('allow_ebt')
    //         // ->add('track_inventory')
    //         // ->add('discounted_item_taxable')
    //         // ->add('ingredient_for_label')
    //         // ->add('created_at');
    // }
    public function fields(): PowerGridFields
    {
        $user = Auth::user();
        $locationIds = $user->locations()->pluck('location_id')->toArray();

        return PowerGrid::fields()
            ->add('code')
            ->add('item_description')
            // Price fields with location-specific override
            ->add('units_per_case', function(Item $item) use ($locationIds) {
                $locationUpdate = $item->locationUpdates()
                                    ->whereIn('location_id', $locationIds)
                                    ->first();
                return optional($locationUpdate)->units_per_case ?? $item->units_per_case;
            })
            ->add('case_cost', function(Item $item) use ($locationIds) {
                $locationUpdate = $item->locationUpdates()
                                    ->whereIn('location_id', $locationIds)
                                    ->first();
                return optional($locationUpdate)->case_cost ?? $item->case_cost;
            })
            ->add('unit_retail', function(Item $item) use ($locationIds) {
                $locationUpdate = $item->locationUpdates()
                                    ->whereIn('location_id', $locationIds)
                                    ->first();
                return optional($locationUpdate)->unit_retail ?? $item->unit_retail;
            })
            // other fields
            ->add('online_retail')
            ->add('margin')
            ->add('default_margin')
            ->add('department');
    }


    public function columns(): array
    {
        return [
            Column::make('Scan Code', 'code')->sortable()->searchable(),
            Column::make('Desc', 'item_description')->sortable()->searchable(),
            Column::make('U.Case', 'units_per_case')->sortable()->searchable(),
            Column::make('Case Cost', 'case_cost')->sortable()->searchable(),
            Column::make('Case Disc.', 'case_discount')->sortable()->searchable(),
            Column::make('Unit Cost After Disc.', 'cost_after_discount')->sortable()->searchable(),
            Column::make('Unit retail', 'unit_retail')->sortable()->searchable(),
            Column::make('Online Retail', 'online_retail')->sortable()->searchable(),
            Column::make('Margin', 'margin')->sortable()->searchable(),
            Column::make('Default Margin', 'default_margin')->sortable()->searchable(),

            Column::make('Department', 'department_id'),
            // Column::make('Product category id', 'product_category_id'),
            // Column::make('Price group id', 'price_group_id'),
            // Column::make('Payee id', 'payee_id'),
            // Column::make('Sale type id', 'sale_type_id'),
            // Column::make('Current qty', 'current_qty')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Tag description', 'tag_description')
            //     ->sortable()
            //     ->searchable(),

          

           

          

           

            // Column::make('Case rebate', 'case_rebate')
            //     ->sortable()
            //     ->searchable(),

          

           

            // Column::make('Unit of measure id', 'unit_of_measure_id'),
            // Column::make('Size id', 'size_id'),
          

            // Column::make('Margin after rebate', 'margin_after_rebate')
            //     ->sortable()
            //     ->searchable(),

          

            // Column::make('Max inv', 'max_inv')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Min inv', 'min_inv')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Min age', 'min_age')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Tax rate', 'tax_rate')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Nacs code', 'nacs_code')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Blue law', 'blue_law')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Nacs category id', 'nacs_category_id'),
            // Column::make('Nacs sub category id', 'nacs_sub_category_id'),
            // Column::make('Kitchen option', 'kitchen_option')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Allow ebt', 'allow_ebt')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Track inventory', 'track_inventory')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Discounted item taxable', 'discounted_item_taxable')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Ingredient for label', 'ingredient_for_label')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
             Filter::inputText('code'),
             Filter::inputText('item_description'),
             Filter::inputText('units_per_case'),
             Filter::inputText('case_cost'),
             Filter::inputText('case_discount'),
             Filter::inputText('cost_after_discount'),
             Filter::inputText('unit_retail'),
             Filter::inputText('online_retail'),
             Filter::inputText('margin'),
             Filter::inputText('default_margin'),
             Filter::select('department_id', 'department_id')
                ->dataSource(Department::all())
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    #[\Livewire\Attributes\On('openItemModal')]
    public function handleOpenItemModal($itemId, $itemCode): void
    {
        $this->openItemModal($itemId, $itemCode);
    }

    public function openItemModal($itemId, $itemCode): void
    {
        $this->selectedItemId = $itemId;
        $this->selectedItemCode = $itemCode;
        $this->showItemModal = true;
    }

    public function closeItemModal(): void
    {
        $this->showItemModal = false;
        $this->selectedItemId = null;
        $this->selectedItemCode = '';
    }

    #[\Livewire\Attributes\On('refreshItemTable')]
    public function handleRefreshItemTable(): void
    {
        // Force refresh the PowerGrid table
        // This will trigger a re-render and refresh the data
        $this->resetPage();
    }

    public function actions(Item $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('openItemModal', ['itemId' => $row->id, 'itemCode' => $row->code]),
            
            Button::add('item-code')
                ->slot('Item Code')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('openItemCodeModal', ['itemId' => $row->id, 'itemCode' => $row->code])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */

}
