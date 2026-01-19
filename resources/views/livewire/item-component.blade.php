<main class="main-wrapper clearfix">
    <div class="col-md-12 widget-holder">

       
       
            <div class="col-span-12">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h5 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ $itemId ? 'Edit Item' : ($selectedItemId ? 'Add Item Details' : 'Enter Item Code Above') }}
                        </h5>
                        <p class="text-blue-100 text-sm mt-1">
                            @if($selectedItemId)
                                {{ $itemId ? 'Update item information and pricing details' : 'Fill in additional details for the selected item' }}
                            @else
                                Enter an item code in the search box above to load existing product or create new one
                            @endif
                        </p>
                    </div>

                    <form wire:submit.prevent="save" class="p-6">
                        <!-- Success Message -->
                        @if (session()->has('success'))
                            <div class="mb-6 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if (session()->has('error'))
                            <div class="mb-6 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Info Message -->
                        @if (session()->has('info'))
                            <div class="mb-6 bg-blue-100 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('info') }}
                            </div>
                        @endif

                        <div class="space-y-8">
                            <!-- ITEM + PRICE SECTIONS -->
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
                                
                                <!-- ITEM DETAILS -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center mb-6">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                        </div>
                                        <h6 class="text-lg font-semibold text-gray-800">Item Details</h6>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 space-y-0">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Item Code</label>
                                            <input type="text" wire:model="code" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 cursor-not-allowed" 
                                                placeholder="Item code will be set from search" readonly/>
                                            <p class="text-xs text-gray-500 mt-1">Code is automatically set when you select an item from the search above</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Item Description <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="item_description" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('item_description') border-red-500 @enderror" 
                                                placeholder="Enter item description"/>
                                            @error('item_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                            <select wire:model="department_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                <option value="">Choose Department</option>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Category</label>
                                            <select wire:model="product_category_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                <option value="">Choose Category</option>
                                                @foreach($productCategories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Group</label>
                                            <select wire:model="price_group_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                <option value="">Choose Price Group</option>
                                                @foreach($priceGroups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Payee</label>
                                            <select wire:model="payee_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                <option value="">Choose Payee</option>
                                                @foreach($payees as $payee)
                                                    <option value="{{ $payee->id }}">{{ $payee->vendor_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Sale Type</label>
                                            <select wire:model="sale_type_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                <option value="">Choose Sale Type</option>
                                                @foreach($saleTypes as $sales)
                                                    <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Qty</label>
                                            <input type="number" wire:model="current_qty" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                                placeholder="0"/>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tag Description</label>
                                            <input type="text" wire:model="tag_description" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                                placeholder="Enter tag description"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- PRICE DETAILS -->
                                <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                                    <div class="flex items-center mb-6">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                        </div>
                                        <h6 class="text-lg font-semibold text-gray-800">Price Details</h6>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach ([
                                            'units_per_case' => 'Units/Case',
                                            'unit_retail' => 'Unit Retail',
                                            'case_cost' => 'Case Cost',
                                            'case_discount' => 'Case Discount',
                                            'case_rebate' => 'Case Rebate',
                                            'online_retail' => 'Online Retail',
                                            'cost_after_discount' => 'Cost/Unit After Discount',
                                            'margin' => 'Margin',
                                            'margin_after_rebate' => 'Margin After Rebate',
                                            'default_margin' => 'Default Margin'
                                        ] as $field => $label)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                                                <input type="number" step="0.01" wire:model="{{ $field }}" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" 
                                                    placeholder="0.00"/>
                                            </div>
                                        @endforeach
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit Of Measure</label>
                                            <select wire:model="unit_of_measure_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                                <option value="">Choose Unit</option>
                                                @foreach($unitOfMeasures as $measures)
                                                    <option value="{{ $measures->id }}">{{ $measures->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                                            <select wire:model="size_id" 
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                                <option value="">Choose Size</option>
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- POS DETAILS -->
                            <div class="bg-purple-50 rounded-lg p-6 border border-purple-200 ">
                                <div class="flex items-center mb-6">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h6 class="text-lg font-semibold text-gray-800">POS Details</h6>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ([
                                        'max_inv' => 'Max Inv',
                                        'min_inv' => 'Min Inv',
                                        'nacs_code' => 'NACS Code',
                                        'nacs_sub_category' => 'NACS Sub Category',
                                        'kitchen_option' => 'Kitchen Print/KDS Option',
                                        'linked_item' => 'Linked Item'
                                    ] as $field => $label)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                                            <input type="text" wire:model="{{ $field }}" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                                placeholder="Enter {{ strtolower($label) }}"/>
                                        </div>
                                    @endforeach
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Age</label>
                                        <select wire:model="min_age" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                            <option value="">Choose Min Age</option>
                                            @foreach($minAges as $age)
                                                <option value="{{ $age->id }}">{{ $age->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tax Rate</label>
                                        <input type="text" wire:model="tax_rate" 
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                            placeholder="Enter tax rate"/>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Blue Law (Commander)</label>
                                        <select wire:model="blue_law" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">NACS Category</label>
                                        <select wire:model="nacs_category_id" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                                            <option value="">Choose NACS Category</option>
                                            @foreach($nacsCategories as $ncat)
                                                <option value="{{ $ncat->id }}">{{ $ncat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="md:col-span-2 lg:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ingredient for Label Packaging</label>
                                        <textarea wire:model="ingredient_for_label" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                                rows="3" 
                                                placeholder="Enter ingredients for label packaging"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-2 lg:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-4">Additional Options</label>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                                <input type="checkbox" wire:model="allow_ebt" 
                                                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"/>
                                                <span class="ml-3 text-sm font-medium text-gray-700">Allow EBT</span>
                                            </label>
                                            
                                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                                <input type="checkbox" wire:model="track_inventory" 
                                                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"/>
                                                <span class="ml-3 text-sm font-medium text-gray-700">Track Inventory Item</span>
                                            </label>
                                            
                                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                                <input type="checkbox" wire:model="discounted_item_taxable" 
                                                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"/>
                                                <span class="ml-3 text-sm font-medium text-gray-700">Discounted Item Subject to Tax</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="flex justify-between gap-4 pt-6 border-t border-gray-200 mt-8">
                            <!-- Left side - Edit Item Codes button (only show if item is selected) -->
                            @if($selectedItemId && $code)
                                <button type="button" wire:click="openItemCodeModal({{ $selectedItemId }}, '{{ $code }}')" 
                                        class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Edit Item Codes
                                </button>
                            @endif
                            
                            <!-- Right side - Cancel and Save buttons -->
                            <div class="flex gap-4">
                                <button type="button" wire:click="hideForm" 
                                        class="px-5 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium shadow flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                                        @if($isLoading) disabled @endif>
                                    @if($isLoading)
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ $itemId ? 'Updating...' : 'Saving...' }}
                                    @else
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $itemId ? 'Update Item' : 'Save Item' }}
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Item Code Modal -->
            @if($showItemCodeModal)
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeItemCodeModal">
                    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
                        <div class="mt-3">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Item Codes for: {{ $selectedItemCode }}
                                </h3>
                                <button wire:click="closeItemCodeModal" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Item Code Component -->
                            @if($selectedItemForCodes)
                                <livewire:product.item-code-component :itemId="$selectedItemForCodes" :itemCode="$selectedItemCode" :allowAddNew="true" />
                            @endif
                        </div>
                    </div>
                </div>
            @endif

</main>
