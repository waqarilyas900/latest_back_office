<div class="p-6">
    {{-- @include('layouts.partial.productnav') --}}

    <!-- Main Tabs Header (Promotion and Combo) -->
    <div class="flex gap-4 border-b border-gray-200 mb-6 mt-5">
        <button wire:click="setMainTab('promotion')" 
            class="pb-2 {{ $mainTab === 'promotion' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Promotion
        </button>
        <button wire:click="setMainTab('combo')" 
            class="pb-2 {{ $mainTab === 'combo' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
            Combo
        </button>
    </div>

    <!-- Main Tabs Content -->
    <div>
        @if ($mainTab === 'promotion')
            <!-- Promotion Tab with Sub-tabs (Wizard Style) -->
            <div>
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Promotion Sub-tabs Header (Wizard Steps) -->
                <div class="flex gap-4 border-b border-gray-200 mb-6">
                    <button wire:click="setPromotionTab('setup')" 
                        class="pb-2 {{ $promotionTab === 'setup' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        Step 1 - Promotion Setup
                    </button>
                    @php
                        $promotionId = session()->get('current_promotion_id');
                        $promotionExists = $promotionId && \App\Models\Promotion::find($promotionId);
                    @endphp
                    <button wire:click="setPromotionTab('items')" 
                        class="pb-2 {{ $promotionTab === 'items' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : ($promotionExists ? 'text-gray-600 hover:text-blue-600' : 'text-gray-400 cursor-not-allowed') }}"
                        @if(!$promotionExists) disabled @endif>
                        Step 2 - Add Items
                    </button>
                    <button wire:click="setPromotionTab('location')" 
                        class="pb-2 {{ $promotionTab === 'location' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : ($promotionExists ? 'text-gray-600 hover:text-blue-600' : 'text-gray-400 cursor-not-allowed') }}"
                        @if(!$promotionExists) disabled @endif>
                        Step 3 - Select Location
                    </button>
                </div>

                <!-- Promotion Sub-tabs Content -->
                <div>
                    @if ($promotionTab === 'setup')
                        <div class="p-4 bg-white rounded-xl shadow-sm">
                            @livewire('promotion.promotion-setup-component', key('promotion-setup'))
                        </div>
                    @elseif ($promotionTab === 'items')
                        <div class="p-4 bg-white rounded-xl shadow-sm">
                            @livewire('promotion.add-items-component', key('promotion-items'))
                        </div>
                    @elseif ($promotionTab === 'location')
                        <div class="p-4 bg-white rounded-xl shadow-sm">
                            @livewire('promotion.select-location-component', key('promotion-location'))
                        </div>
                    @endif
                </div>
            </div>
        @elseif ($mainTab === 'combo')
            <!-- Combo Tab with Sub-tabs (Wizard Style) -->
            <div>
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Combo Sub-tabs Header (Wizard Steps) -->
                <div class="flex gap-4 border-b border-gray-200 mb-6">
                    <button wire:click="setComboTab('setup')" 
                        class="pb-2 {{ $comboTab === 'setup' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        Step 1 - Combo Setup
                    </button>
                    @php
                        $comboId = session()->get('current_combo_id');
                        $comboExists = $comboId && \App\Models\Combo::find($comboId);
                    @endphp
                    <button wire:click="setComboTab('group')" 
                        class="pb-2 {{ $comboTab === 'group' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : ($comboExists ? 'text-gray-600 hover:text-blue-600' : 'text-gray-400 cursor-not-allowed') }}"
                        @if(!$comboExists) disabled @endif>
                        Step 2 - Add Group
                    </button>
                    @php
                        $hasGroups = $comboId && \App\Models\ComboGroup::where('combo_id', $comboId)->exists();
                    @endphp
                    <button wire:click="setComboTab('location')" 
                        class="pb-2 {{ $comboTab === 'location' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : ($hasGroups ? 'text-gray-600 hover:text-blue-600' : 'text-gray-400 cursor-not-allowed') }}"
                        @if(!$hasGroups) disabled @endif>
                        Step 3 - Select Location
                    </button>
                </div>

                <!-- Combo Sub-tabs Content -->
                <div>
                    @if ($comboTab === 'setup')
                        <div class="p-4 bg-white rounded-xl shadow-sm">
                            @livewire('promotion.combo-setup-component', key('combo-setup'))
                        </div>
                    @elseif ($comboTab === 'group')
                        <div class="p-4 bg-white rounded-xl shadow-sm">
                            @livewire('promotion.add-group-component', key('combo-group'))
                        </div>
                    @elseif ($comboTab === 'location')
                        <div class="p-4 bg-white rounded-xl shadow-sm">
                            @livewire('promotion.combo-select-location-component', key('combo-location'))
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
