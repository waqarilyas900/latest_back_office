
<div>
    @include('layouts.partial.productnav')
    
    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 shadow-sm mt-5 mb-5">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button wire:click="setActiveTab('price-book')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'price-book' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Price Book
                </button>
                <button wire:click="setActiveTab('compare-price-book')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'compare-price-book' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Compare Price Book
                </button>
                <button wire:click="setActiveTab('central-department')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'central-department' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Central Department
                </button>
                <button wire:click="setActiveTab('scheduled-items')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'scheduled-items' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Scheduled Items
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        @if($activeTab === 'price-book')
            <livewire:item-table />
            
        @elseif($activeTab === 'compare-price-book')
            <livewire:compare-price-book-component />
        @elseif($activeTab === 'central-department')
            <livewire:central-department-component />
        @elseif($activeTab === 'scheduled-items')
            <livewire:scheduled-items-component />
        @endif
    </div>

    {{-- Item Code Modal --}}
    @if($showItemCodeModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeItemCodeModal">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    {{-- Modal Header --}}
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

                    {{-- Item Code Component --}}
                    @if($selectedItemId)
                        <livewire:product.item-code-component :itemId="$selectedItemId" :itemCode="$selectedItemCode" :allowAddNew="false" />
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Item Edit Modal --}}
    @if($showItemModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeItemModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    {{-- Modal Header --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Edit Item: {{ $selectedItemCode }}
                        </h3>
                        <button wire:click="closeItemModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Item Component --}}
                    @if($selectedItemId)
                        <livewire:item-component :selectedItemId="$selectedItemId" />
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>