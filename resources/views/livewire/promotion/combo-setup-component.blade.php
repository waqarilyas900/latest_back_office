<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Step 1 - Combo Setup</h2>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Combo Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Combo Description
                </label>
                <input type="text" 
                       wire:model="description" 
                       placeholder="Enter combo description"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- When? (Date/Time Selection) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    When?
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Start Date</label>
                        <div class="relative">
                            <input type="datetime-local" 
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
                            <input type="datetime-local" 
                                   wire:model="end_date" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <i class="ri-calendar-line absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Image and Deal Description in One Row -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Add Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Add Image
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                        @if($image_path && !$image)
                            <img src="{{ asset('storage/' . $image_path) }}" alt="Combo Image" class="mx-auto max-h-48 mb-4">
                        @elseif($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="mx-auto max-h-48 mb-4">
                        @else
                            <i class="ri-add-line text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-500 dark:text-gray-400">Add Image</p>
                        @endif
                        <input type="file" 
                               wire:model="image" 
                               accept="image/*"
                               class="hidden" 
                               id="combo_image_input">
                        <label for="combo_image_input" 
                               class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600">
                            {{ $image_path || $image ? 'Change Image' : 'Upload Image' }}
                        </label>
                        @if($image_path || $image)
                            <button type="button" 
                                    wire:click="$set('image', null); $set('image_path', null)"
                                    class="mt-2 ml-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Remove
                            </button>
                        @endif
                    </div>
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @if($image)
                        <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-2">Uploading...</div>
                    @endif
                </div>

                <!-- Deal Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Deal Description
                    </label>
                    <textarea wire:model="deal_description" 
                              rows="5"
                              placeholder="Enter deal description"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    @error('deal_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Add deal to Cartzie -->
            <div class="border-t pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <input type="checkbox" 
                           wire:model="add_to_deal" 
                           id="add_to_deal_combo"
                           class="w-4 h-4 text-blue-600 focus:ring-blue-500 rounded">
                    <label for="add_to_deal_combo" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Add deal to Cartzie
                    </label>
                </div>
                @if($add_to_deal)
                    <div class="ml-7 space-y-2 text-sm">
                        <div class="text-orange-600 dark:text-orange-400">
                            <span class="font-medium">Cartzie Status:</span> Pending
                        </div>
                        <div class="text-orange-600 dark:text-orange-400">
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
                        wire:click="delete"
                        wire:confirm="Are you sure you want to delete this combo?"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Delete
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
