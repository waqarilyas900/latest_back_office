<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Step 2 - Add Items</h2>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Section -->
        <div class="mb-6">
            <div class="flex gap-3 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Search By
                    </label>
                    <select wire:model.live="searchBy" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="code">Scan Code</option>
                        <option value="item_description">Description</option>
                        <option value="product_category_id">Category</option>
                        <option value="payee_id">Manufacturer</option>
                        <option value="department_id">Department</option>
                        <option value="payee_id">Payee</option>
                        <option value="price_group_id">Price Group</option>
                    </select>
                </div>

                <div class="flex-1">
                    @if(in_array($searchBy, ['product_category_id', 'department_id', 'payee_id', 'price_group_id']))
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Value
                        </label>
                        <select wire:model.live="searchValue" 
                                wire:change="searchItems"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Select {{ ucfirst(str_replace('_id', '', $searchBy)) }}</option>
                            @if($searchBy === 'product_category_id')
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @elseif($searchBy === 'department_id')
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            @elseif($searchBy === 'payee_id')
                                @foreach($payees as $payee)
                                    <option value="{{ $payee->id }}">{{ $payee->vendor_name }}</option>
                                @endforeach
                            @elseif($searchBy === 'price_group_id')
                                @foreach($priceGroups as $priceGroup)
                                    <option value="{{ $priceGroup->id }}">{{ $priceGroup->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    @else
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Value
                        </label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="searchValue" 
                                   wire:keyup="searchItems"
                                   placeholder="Enter search value..."
                                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <button type="button" 
                                    wire:click="searchItems"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Search
                            </button>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="button" 
                            wire:click="resetSearch"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Two Column Layout: Search Results and Selected Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Search Results Box -->
            <div class="lg:col-span-1">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Search Results
                    </h3>
                    <span class="text-xs font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full">
                        {{ count($searchResults) }} items
                    </span>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 p-4 max-h-96 overflow-y-auto">
                    @if(count($searchResults) > 0)
                        <!-- Select All Checkbox at Top -->
                        <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-600">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model.live="selectAllSearchResults" 
                                       class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Select All
                                </span>
                            </label>
                        </div>

                        <div class="flex flex-col gap-2">
                            @foreach($searchResults as $item)
                                <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-blue-300 hover:shadow-sm transition-all">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $item['item_description'] ?? 'N/A' }}
                                        </p>
                                        @if(isset($item['code']))
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Code: {{ $item['code'] }}
                                            </p>
                                        @endif
                                    </div>
                                    <button type="button" 
                                            wire:click="addItem({{ $item['id'] }})"
                                            class="ml-2 p-1 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors"
                                            title="Add item">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No items found</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Search by category, code, etc. to load items</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Selected Items Box -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Selected Items
                    </h3>
                    <span class="text-xs font-medium text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                        {{ count($selectedItems) }} selected
                    </span>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl border border-dashed border-green-300 dark:border-green-600 p-4 max-h-96 overflow-y-auto">
                    @if(count($selectedItems) > 0)
                        <!-- Remove All Checkbox at Top -->
                        <div class="mb-3 pb-3 border-b border-green-200 dark:border-green-600">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model.live="selectAllSelectedItems" 
                                       class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Remove All
                                </span>
                            </label>
                        </div>

                        <div class="flex flex-col gap-2">
                            @foreach($selectedItemsData as $item)
                                <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-800 rounded-lg border border-green-200 dark:border-green-600 hover:shadow-sm transition">
                                    <div class="flex items-center flex-1">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $item->item_description ?? 'N/A' }}
                                            </p>
                                            @if($item->code)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Code: {{ $item->code }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" 
                                            wire:click="removeItem({{ $item->id }})"
                                            class="ml-2 p-1 text-red-500 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                            title="Remove item">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No items selected</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Search and add items from the left panel</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <button type="button" 
                    wire:click="backToSetup"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                Back
            </button>
            <button type="button" 
                    wire:click="saveItems"
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                Save
            </button>
            <button type="button" 
                    wire:click="nextToLocation"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Save And Next
            </button>
        </div>
    </div>
</div>
