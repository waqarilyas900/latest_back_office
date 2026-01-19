<div class="col-span-12 mt-8">
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-100 to-indigo-100 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold text-gray-900">Manage Group Items</h5>
                    <p class="text-sm text-gray-600 mt-1">Attach or detach items from this price group</p>
                </div>
                <button wire:click="hideForm"
                        class="text-gray-500 hover:text-gray-700 p-2 rounded-full transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6">
            <!-- Filter & Search -->
            <div class="mb-4 flex gap-3">
                <select wire:model="searchField"
                    class="rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <option value="item_description">By Description</option>
                    <option value="payee">By Payee</option>
                    <option value="sku">By SKU</option>
                </select>

                <input
                    type="text"
                    wire:model.live.debounce.300ms="searchTerm"
                    placeholder="Search items..."
                    class="flex-1 rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <!-- Items Panels -->
            <form wire:submit.prevent="attachItems" class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Available Items -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h6 class="text-base font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Available Items
                            </h6>
                            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full">
                                {{ count($items) }} total
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl border border-dashed border-gray-200 p-4 max-h-96 overflow-y-auto">
                            <div class="flex flex-col gap-3">
                                @forelse($items as $item)
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all duration-150 cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model.live="selectedItems" 
                                               value="{{ $item->id }}" 
                                               class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700 flex-1">
                                            {{ $item->item_description }}
                                        </span>
                                        @if(in_array($item->id, $selectedItems))
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Selected
                                            </span>
                                        @endif
                                    </label>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">No items available</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Attached Items -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h6 class="text-base font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Attached Items
                            </h6>
                            <span class="text-xs font-medium text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                                {{ count($selectedItems) }} selected
                            </span>
                        </div>

                        <div class="bg-green-50 rounded-xl border border-dashed border-green-200 p-4 max-h-96 overflow-y-auto">
                            <div class="flex flex-col gap-3">
                                @if(count($selectedItems) > 0)
                                    @foreach(App\Models\Item::whereIn('id', $selectedItems)->get() as $attachedItem)
                                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-green-200 hover:shadow-sm transition">
                                            <div class="flex items-center">
                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ $attachedItem->item_description }}
                                                </span>
                                            </div>
                                            <button type="button" 
                                                    wire:click="removeItem({{ $attachedItem->id }})"
                                                    class="text-red-500 hover:text-red-600 p-1 rounded transition-colors"
                                                    title="Remove item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-8">
                                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">No items attached</p>
                                        <p class="text-xs text-gray-400">Select items from the left panel to attach</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <button type="button" 
                            wire:click="hideForm" 
                            class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        Save Changes
                    </button>
                </div>

                <!-- Success Message -->
                @if(session()->has('message'))
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-green-700">{{ session('message') }}</span>
                    </div>
                @endif

            </form>
        </div>
    </div>
</div>
