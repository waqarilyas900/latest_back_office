<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Step 1 - Promotion Setup</h2>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- First Row: Name and POS Description -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Promotion Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Name
                    </label>
                    <input type="text" 
                           wire:model="promotion_name" 
                           placeholder="Enter promotion name"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('promotion_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- POS Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        POS Description
                    </label>
                    <input type="text" 
                           wire:model="pos_description" 
                           placeholder="Enter POS description"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('pos_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Second Row: Funded By -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    By Retailer
                </label>
                <select wire:model="funded_by" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Select Retailer</option>
                    @foreach($payees as $payee)
                        <option value="{{ $payee->id }}">{{ $payee->vendor_name }}</option>
                    @endforeach
                </select>
                @error('funded_by') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Third Row: Mix-N-Match Radio Buttons -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Mix-N-Match
                </label>
                <div class="flex items-center gap-6">
                    <!-- New Price Option -->
                    <div class="flex items-center gap-2">
                        <input type="radio" 
                               wire:model="mix_n_match" 
                               value="new_price" 
                               id="new_price"
                               class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <label for="new_price" class="text-sm text-gray-700 dark:text-gray-300">
                            New Price
                        </label>
                    </div>

                    <!-- Price Reduction Option -->
                    <div class="flex items-center gap-2">
                        <input type="radio" 
                               wire:model="mix_n_match" 
                               value="price_reduction" 
                               id="price_reduction"
                               class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <label for="price_reduction" class="text-sm text-gray-700 dark:text-gray-300">
                            Price Reduction
                        </label>
                    </div>
                </div>
            </div>

            <!-- Fourth Row: Mix-N-Match Fields -->
            <div>
                <div class="grid grid-cols-3 gap-4">
                    <!-- New Price Field -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            New Price
                        </label>
                        <input type="number" 
                               wire:model="new_price" 
                               step="0.01" 
                               min="0"
                               placeholder="0.00"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('new_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price Reduction Field -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Price Reduction
                        </label>
                        <input type="number" 
                               wire:model="price_reduction" 
                               step="0.01" 
                               min="0"
                               placeholder="0.00"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('price_reduction') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Quantity Field -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Quantity Customer Bought
                        </label>
                        <input type="number" 
                               wire:model="quantity" 
                               min="0"
                               placeholder="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Schedule Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Schedule
                </label>
                <!-- First Row: Date Fields -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Start Date -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Start Date</label>
                        <div class="relative">
                            <input type="date" 
                                   wire:model="start_date" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <i class="ri-calendar-line absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">End Date</label>
                        <div class="relative">
                            <input type="date" 
                                   wire:model="end_date" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <i class="ri-calendar-line absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Second Row: Time Fields -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Start Time -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Start Time</label>
                        <div class="relative">
                            <input type="time" 
                                   wire:model="start_time" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <i class="ri-time-line absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">End Time</label>
                        <div class="relative">
                            <input type="time" 
                                   wire:model="end_time" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <i class="ri-time-line absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Offer Image and Offer Description in One Row -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Offer Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Offer Image
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                        @if($offer_image_path && !$offer_image)
                            <img src="{{ asset('storage/' . $offer_image_path) }}" alt="Offer Image" class="mx-auto max-h-48 mb-4">
                        @elseif($offer_image)
                            <img src="{{ $offer_image->temporaryUrl() }}" alt="Preview" class="mx-auto max-h-48 mb-4">
                        @else
                            <i class="ri-add-line text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-500 dark:text-gray-400">Add Image</p>
                        @endif
                        <input type="file" 
                               wire:model="offer_image" 
                               accept="image/*"
                               class="hidden" 
                               id="offer_image_input">
                        <label for="offer_image_input" 
                               class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600">
                            {{ $offer_image_path || $offer_image ? 'Change Image' : 'Upload Image' }}
                        </label>
                        @if($offer_image_path || $offer_image)
                            <button type="button" 
                                    wire:click="$set('offer_image', null); $set('offer_image_path', null)"
                                    class="mt-2 ml-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Remove
                            </button>
                        @endif
                    </div>
                    @error('offer_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @if($offer_image)
                        <div wire:loading wire:target="offer_image" class="text-sm text-gray-500 mt-2">Uploading...</div>
                    @endif
                </div>

                <!-- Cartzie Offer Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cartzie Offer Description
                    </label>
                    <textarea wire:model.live="offer_description" 
                              maxlength="60"
                              rows="5"
                              placeholder="Enter offer description (max 60 characters)"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    <div class="text-right text-sm text-gray-500 mt-1">
                        <span>{{ $characterCount }}/60</span>
                    </div>
                    @error('offer_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Add deal to Cartzie -->
            <div class="border-t pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <input type="checkbox" 
                           wire:model="add_to_deal" 
                           id="add_to_deal"
                           class="w-4 h-4 text-blue-600 focus:ring-blue-500 rounded">
                    <label for="add_to_deal" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Add deal to Cartzie
                    </label>
                </div>
                @if($add_to_deal)
                    <div class="ml-7 space-y-2 text-sm">
                        <div class="text-gray-600 dark:text-gray-400">
                            <span class="font-medium">Cartzie Status:</span> Pending
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">
                            <span class="font-medium">Reason:</span> Verification Pending
                        </div>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" 
                        wire:click="close"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Close
                </button>
                <button type="button" 
                        wire:click="save"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Save
                </button>
                <button type="button" 
                        wire:click="saveAndNext"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Save & Next
                </button>
            </div>
        </form>
    </div>
</div>
