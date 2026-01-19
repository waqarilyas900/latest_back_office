<div class="p-6">
    <!-- Multi Pack Definition Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Multi Pack Definition</h2>
        
        @if($current_item_id)
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
            <p class="text-sm text-blue-800">
                <strong>Current Item ID:</strong> {{ $current_item_id }} | 
                <strong>Item Cost:</strong> {{ $item_cost }} | 
                <strong>Margin:</strong> {{ $margin }} | 
                <strong>Retail:</strong> {{ $enter_retail }}
            </p>
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <!-- Modifier / Qty -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modifier / Qty</label>
                <input type="number" 
                       wire:model="modifier_qty" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('modifier_qty') border-red-500 @enderror"
                       placeholder="Enter quantity">
                @error('modifier_qty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Item Cost (from selected item) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Item Cost</label>
                <input type="number" 
                       step="0.01"
                       wire:model="item_cost" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('item_cost') border-red-500 @enderror"
                       placeholder="0.00">
                @error('item_cost') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Enter Retail -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Enter Retail</label>
                <input type="number" 
                       step="0.01"
                       wire:model="enter_retail" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('enter_retail') border-red-500 @enderror"
                       placeholder="Enter retail price">
                @error('enter_retail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Margin (from selected item) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Margin</label>
                <input type="number" 
                       step="0.01"
                       wire:model="margin" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('margin') border-red-500 @enderror"
                       placeholder="Margin">
                @error('margin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Placeholder to keep 5 columns layout -->
            <div></div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center">
            <div class="flex space-x-3">
                <button wire:click="save" 
                        class="px-6 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-save mr-2"></i>Save
                </button>
                <button wire:click="clearForm" 
                        class="px-6 py-2 border border-teal-600 text-teal-600 rounded-md hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-times mr-2"></i>Clear
                </button>
                {{-- @if($current_item_id)
                <button wire:click="testLoadItem" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-sm">
                    <i class="fas fa-bug mr-1"></i>Test Load
                </button>
                @endif --}}
            </div>
            
            <a href="#" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                View all multi packs
            </a>
        </div>
    </div>

    <!-- Multi Pack Components Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Multi Pack Components</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scan Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scan Code Modifier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Margin</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($multi_pack_items as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row['item']['code'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row['item']['item_description'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row['modifier_qty'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($row['item_cost'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($row['enter_retail'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row['scan_code_modifier'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($row['margin'], 2) }}%
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">No multi pack items for this item</p>
                                <p class="text-sm">Create a new multi pack using the form above.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <div x-data="{ show: false, message: '' }" 
         x-show="show" 
         x-transition
         @show-success.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
         @show-error.window="show = true; message = $event.detail; setTimeout(() => show = false, 5000)"
         class="fixed top-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" x-show="show">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span x-text="message"></span>
            </div>
        </div>
    </div>
</div>