<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Step 3 - Select Location</h2>

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

        <!-- Two Column Layout: Available Locations and Selected Locations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Available Locations Box -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Available Locations
                    </h3>
                    <span class="text-xs font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full">
                        {{ count($locations) }} locations
                    </span>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 p-4 max-h-96 overflow-y-auto">
                    @if(count($locations) > 0)
                        <!-- Select All Checkbox at Top -->
                        <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-600">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model.live="selectAllLocations" 
                                       class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Select All
                                </span>
                            </label>
                        </div>

                        <div class="flex flex-col gap-2">
                            @foreach($locations as $location)
                                <label class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-blue-300 hover:shadow-sm transition-all cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model.live="selectedLocations" 
                                           value="{{ $location->id }}" 
                                           class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $location->name }}
                                        </p>
                                        @if($location->address)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $location->address }}
                                            </p>
                                        @endif
                                    </div>
                                    @if(in_array($location->id, $selectedLocations))
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Selected
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No locations available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Selected Locations Box -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Selected Locations
                    </h3>
                    <span class="text-xs font-medium text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                        {{ count($selectedLocations) }} selected
                    </span>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl border border-dashed border-green-300 dark:border-green-600 p-4 max-h-96 overflow-y-auto">
                    @if(count($selectedLocations) > 0)
                        <div class="flex flex-col gap-2">
                            @foreach($selectedLocationsData as $location)
                                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg border border-green-200 dark:border-green-600 hover:shadow-sm transition">
                                    <div class="flex items-center flex-1">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $location->name }}
                                            </p>
                                            @if($location->address)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $location->address }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" 
                                            wire:click="toggleLocation({{ $location->id }})"
                                            class="ml-2 p-1 text-red-500 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                            title="Remove location">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No locations selected</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Select locations from the left panel</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <button type="button" 
                    wire:click="backToGroups"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                Back
            </button>
            <button type="button" 
                    wire:click="saveLocations"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Save Locations
            </button>
        </div>
    </div>
</div>
