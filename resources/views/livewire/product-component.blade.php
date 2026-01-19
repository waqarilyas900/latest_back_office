<div class="p-6">
   @include('layouts.partial.productnav')

    <!-- Global Search Bar -->
    <div class="mb-4 relative mt-5">
        <div class="relative">
            <input 
                type="text" 
                placeholder="Scan or type item code..." 
                wire:model.live="search"
                autofocus
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @if(!empty($searchResults))
                <div class="absolute z-10 bg-white border rounded w-full shadow max-h-60 overflow-y-auto mt-1">
                    @foreach($searchResults as $result)
                        <div 
                            wire:click="selectItem({{ $result['id'] }})"
                            class="px-4 py-2 hover:bg-blue-100 cursor-pointer border-b border-gray-100">
                            <div class="font-medium">{{ $result['code'] }}</div>
                            <div class="text-sm text-gray-500">{{ $result['item_description'] ?? 'No description' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        @if($errorMessage)
            <div class="mt-2 text-red-600 text-sm">{{ $errorMessage }}</div>
        @endif
        
        @if($selectedItemId)
            <div class="mt-2 text-green-600 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Product loaded: {{ $search }}
            </div>
        @elseif($search && !$selectedItemId && empty($searchResults))
            <div class="mt-2 text-blue-600 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                New item code prepared: {{ $search }} - Fill details below to create
            </div>
        @elseif($search && !$selectedItemId && !empty($searchResults))
            <div class="mt-2 text-amber-600 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.726-1.36 3.491 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                No exact match found. Select from suggestions above or continue typing to create new item
            </div>
        @endif
    </div>

    <!-- Tabs Header -->
    <div class="flex gap-4 border-b border-gray-200 mb-6">
        <button wire:click="setTab('items')" 
            class="pb-2 {{ $tab === 'items' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Items
        </button>
        <button wire:click="setTab('carton')" 
            class="pb-2 {{ $tab === 'carton' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Carton Item Mapping
        </button>
        <button wire:click="setTab('codes')" 
            class="pb-2 {{ $tab === 'codes' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Item Codes
        </button>
         <button wire:click="setTab('multi')" 
            class="pb-2 {{ $tab === 'multi' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Multi Packs
        </button>
        <button wire:click="setTab('history')" 
            class="pb-2 {{ $tab === 'history' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Price History
        </button>
    </div>

    <!-- Tabs Content -->
    <div>
        @if ($tab === 'items')
            <div class="p-4 bg-white rounded-xl shadow-sm">
                @livewire('item-component', ['selectedItemId' => $selectedItemId], key('items-'.$selectedItemId))
            </div>
        @elseif ($tab === 'carton')
            <div class="p-4 bg-white rounded-xl shadow-sm">
                @livewire('product.carton-item-mapping-component', ['selectedItemId' => $selectedItemId], key('carton-'.$selectedItemId))
            </div>
        @elseif ($tab === 'codes')
            <div class="p-4 bg-white rounded-xl shadow-sm">
                @livewire('product.item-code-component', ['selectedItemId' => $selectedItemId], key('codes-'.$selectedItemId))
            </div>
        @elseif ($tab === 'multi')
            <div class="p-4 bg-white rounded-xl shadow-sm">
                @livewire('product.multi-pack-component', ['selectedItemId' => $selectedItemId], key('multi-'.$selectedItemId))
            </div>
        @elseif ($tab === 'history')
            <div class="p-4 bg-white rounded-xl shadow-sm">
                @livewire('product.price-history-component', ['selectedItemId' => $selectedItemId], key('history-'.$selectedItemId))
            </div>
        @endif
    </div>
    <script>
        window.addEventListener('tab-error', event => {
            alert(event.detail.message);
        });
    </script>


</div>
