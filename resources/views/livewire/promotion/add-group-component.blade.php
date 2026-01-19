<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Step 2 - Add Groups</h2>

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

        <!-- Add New Group Button -->
        <div class="flex justify-end mb-4">
            <button type="button" 
                    wire:click="addNewGroup"
                    class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                Add new group
            </button>
        </div>

        <!-- Groups Table -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full border border-gray-300 dark:border-gray-600 rounded-lg">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                            Description
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                            Quantity
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                            Combo Price
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                            Items Count
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($groups as $index => $group)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3">
                                <input type="text" 
                                       wire:model.live.debounce.500ms="groups.{{ $index }}.description"
                                       placeholder="Enter description"
                                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" 
                                       wire:model.live.debounce.500ms="groups.{{ $index }}.quantity"
                                       min="0"
                                       placeholder="0"
                                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" 
                                       wire:model.live.debounce.500ms="groups.{{ $index }}.combo_price"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       class="w-full border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                {{ $group['items_count'] }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            wire:click="openItemModal({{ $group['id'] }})"
                                            class="text-blue-600 hover:text-blue-700 underline text-sm">
                                        Add/Edit Items
                                    </button>
                                    <button type="button" 
                                            wire:click="deleteGroup({{ $group['id'] }})"
                                            wire:confirm="Are you sure you want to delete this group?"
                                            class="text-teal-600 hover:text-teal-700 font-bold text-lg">
                                        ×
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                No groups added yet. Click "Add new group" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Combo Price:</span>
                <span class="px-4 py-2 bg-teal-100 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300 rounded-lg font-semibold">
                    ${{ number_format($totalComboPrice, 2) }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Items Count:</span>
                <span class="px-4 py-2 bg-teal-100 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300 rounded-lg font-semibold">
                    {{ $totalItemsCount }}
                </span>
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
                    wire:click="saveGroups"
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                Save
            </button>
            <button type="button" 
                    wire:click="nextToLocation"
                    class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                Save And Next
            </button>
        </div>
    </div>

    <!-- Add/Edit Items Slide-in Form from Right -->
    @if($showItemModal && $selectedGroupId)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50" wire:click.self="closeItemModal">
            <div class="absolute right-0 top-0 h-full w-full max-w-5xl bg-white dark:bg-gray-800 shadow-2xl overflow-y-auto transform transition-transform duration-300 ease-in-out">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Add/Edit Items for Group</h3>
                        <button wire:click="closeItemModal" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

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
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
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
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-6">
                        <!-- Search and Select Items Panel (Left) -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white">
                                    Search and Select Items
                                </h4>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 p-4 max-h-96 overflow-y-auto">
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

                                    <!-- Search Results Table -->
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 dark:bg-gray-600">
                                                <tr>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        <input type="checkbox" 
                                                               wire:model.live="selectAllSearchResults" 
                                                               class="w-3 h-3 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Scan Code
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Description
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Retail
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                                @foreach($searchResults as $item)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <td class="px-2 py-2">
                                                            <input type="checkbox" 
                                                                   wire:model.live="selectedItems" 
                                                                   value="{{ $item['id'] }}" 
                                                                   class="w-3 h-3 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                        </td>
                                                        <td class="px-2 py-2 text-gray-700 dark:text-gray-300">
                                                            {{ $item['code'] ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-2 py-2 text-gray-700 dark:text-gray-300">
                                                            {{ $item['item_description'] ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-2 py-2 text-gray-700 dark:text-gray-300">
                                                            ${{ number_format($item['unit_retail'] ?? 0, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">No items found</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Search by code, description, etc. to load items</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Transfer Arrow Button -->
                        <div class="flex items-center justify-center">
                            <button type="button" 
                                    wire:click="addAllItems"
                                    class="w-12 h-12 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors flex items-center justify-center text-2xl font-bold shadow-lg">
                                →
                            </button>
                        </div>

                        <!-- Items Panel (Right) -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white">
                                    Items
                                </h4>
                                <span class="text-xs font-medium text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                                    {{ count($selectedItems) }} items
                                </span>
                            </div>

                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-300 dark:border-green-600 p-4 max-h-96 overflow-y-auto">
                                @if(count($selectedItems) > 0)
                                    <!-- Selected Items Table -->
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-green-100 dark:bg-green-800">
                                                <tr>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Scan Code
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Description
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Retail
                                                    </th>
                                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-green-200 dark:divide-green-600">
                                                @foreach($selectedItemsData as $item)
                                                    <tr class="hover:bg-green-100 dark:hover:bg-green-800">
                                                        <td class="px-2 py-2 text-gray-700 dark:text-gray-300">
                                                            {{ $item->code ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-2 py-2 text-gray-700 dark:text-gray-300">
                                                            {{ $item->item_description ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-2 py-2 text-gray-700 dark:text-gray-300">
                                                            ${{ number_format($item->unit_retail ?? 0, 2) }}
                                                        </td>
                                                        <td class="px-2 py-2">
                                                            <button type="button" 
                                                                    wire:click="removeItem({{ $item->id }})"
                                                                    class="text-red-500 hover:text-red-600">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">No items selected</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Search and select items from the left panel</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" 
                                wire:click="closeItemModal"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            Close
                        </button>
                        <button type="button" 
                                wire:click="saveGroupItems"
                                class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                            Save Items
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
