<div class="">
    <div class="">
        
        {{-- Table Section --}}
        @if (!$showForm)
           <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <div class="card border-0 overflow-hidden">
                        <!-- Card Header -->
                        <div class="card-header flex items-center justify-between">
                            <h6 class="card-title mb-0 text-lg">Nacs Category</h6>
                            <input 
                                type="text" 
                                wire:model.live="search" 
                                placeholder="Search category..." 
                                class="form-input border border-neutral-200 rounded-lg px-3 py-2 text-sm w-64"
                            >
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- Top controls -->
                            <div class="flex items-center justify-between mb-4">
                                <!-- Add Button -->
                                <button 
                                    wire:click="displayForm" 
                                    class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium shadow flex items-center"
                                >
                                    <iconify-icon icon="lucide:plus" class="mr-1"></iconify-icon>
                                    Add Nacs Category
                                </button>

                                <!-- Per Page Selector (right side) -->
                                <div class="flex items-center gap-2">
                                    <label for="perPage" class="text-sm text-neutral-600">Show</label>
                                    <select id="perPage" wire:model.live="perPage" 
                                        class="form-select border border-neutral-200 rounded-md text-sm px-2 py-1">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span class="text-sm text-neutral-600">entries</span>
                                </div>
                            </div>

                            <!-- Table -->
                            <table id="categories-table" 
    class="table-auto w-full border border-neutral-200 dark:border-neutral-600 rounded-lg">
    <thead class="bg-neutral-100 dark:bg-neutral-700">
        <tr>
            <th class="px-4 py-2 text-left text-neutral-800 dark:text-white"> 
                <div class="form-check style-check flex items-center">
                    <input class="form-check-input" id="select-all" type="checkbox">
                    <label class="ms-2 form-check-label" for="select-all">
                        S.L
                    </label>
                </div>
            </th>
            <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Name</th>
            <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Status</th>
            <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $index => $category)
            <tr class="border-t border-neutral-200 dark:border-neutral-600">
                <!-- Checkbox + Serial -->
                <td class="px-4 py-2">
                    <div class="form-check style-check flex items-center">
                        <input class="form-check-input" type="checkbox" value="{{ $category->id }}">
                        <label class="ms-2 form-check-label">
                            {{ $index + 1 }}
                        </label>
                    </div>
                </td>

                <!-- category Name -->
                <td class="px-4 py-2 text-left">
                    {{ $category->name }}
                </td>

                <!-- Status -->
                <td class="px-4 py-2 text-left">
                    <span class="{{ $category->active 
                        ? 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400' 
                        : 'bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400' }}
                        px-4 py-1.5 rounded-full font-medium text-sm">
                        {{ $category->active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <!-- Actions -->
                <td class="px-4 py-2 text-left space-x-2">
                    <button 
                        wire:click="edit({{ $category->id }})"
                        class="w-8 h-8 bg-green-100 text-green-700 rounded-full inline-flex items-center justify-center hover:bg-green-200"
                    >
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                    </button>
                    <button 
                        wire:click="delete({{ $category->id }})"
                        onclick="return confirm('Are you sure you want to delete this category?')"
                        class="w-8 h-8 bg-red-600 text-white rounded-full inline-flex items-center justify-center hover:bg-red-700"
                    >
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-left py-3 text-neutral-500">
                    No category found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>


                            <!-- Pagination -->
                            <div class="mt-4 flex justify-between items-center">
    {{-- Showing entries --}}
    <div class="text-sm text-gray-600">
        Showing 
        <span class="font-medium">{{ $categories->firstItem() }}</span> 
        to 
        <span class="font-medium">{{ $categories->lastItem() }}</span> 
        of 
        <span class="font-medium">{{ $categories->total() }}</span> 
        entries
    </div>

    {{-- Pagination --}}
    <div>
        {{ $categories->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>


          

        @endif

        {{-- Form Section --}}
        @if ($showForm)
            <div class="flex justify-center items-center min-h-[60vh] bg-gray-50">
                <form wire:submit.prevent="save" class="bg-white shadow-lg rounded-xl p-8 w-full max-w-xl">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Nacs Category</h2>
                    <div class="mb-5">
                        <label for="nacsCategoryName" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                        <input id="nacsCategoryName" name="nacsCategoryName" type="text" wire:model.defer="name" placeholder="Enter category name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-gray-50 text-gray-800" />
                        @error('name') 
                            <small class="text-red-500">{{ $message }}</small> 
                        @enderror
                    </div>
                    <div class="mb-8">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" wire:model.defer="active"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-gray-50 text-gray-800">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" wire:click="hideForm" class="px-5 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium shadow">Save &amp; Close</button>
                    </div>
                    @if (session()->has('message'))
                        <div class="mt-3">
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        @endif

    </div>
</div>
