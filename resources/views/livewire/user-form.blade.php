<div class="">
    <div class="">
        
        {{-- Table Section --}}
        @if (!$showForm)
            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <div class="card border-0 overflow-hidden">
                        <!-- Card Header -->
                        <div class="card-header flex items-center justify-between">
                            <h6 class="card-title mb-0 text-lg">Users</h6>
                            <input 
                                type="text" 
                                wire:model.live="search" 
                                placeholder="Search users..." 
                                class="form-input border border-neutral-200 rounded-lg px-3 py-2 text-sm w-64"
                            >
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- Top controls -->
                            <div class="flex items-center justify-between mb-4">
                                <!-- Add Button -->
                                @can('add user')
                                <button 
                                    wire:click="displayForm" 
                                    class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium shadow flex items-center"
                                >
                                    <iconify-icon icon="lucide:plus" class="mr-1"></iconify-icon>
                                    Add User
                                </button>
                                @endcan

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
                            <table id="users-table" 
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
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Email</th>
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Role</th>
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Location</th>
                                        <th class="px-4 py-2 text-center text-neutral-800 dark:text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($usersWithLocations as $index => $user)
                                        <tr class="border-t border-neutral-200 dark:border-neutral-600">
                                            <!-- Checkbox + Serial -->
                                            <td class="px-4 py-2">
                                                <div class="form-check style-check flex items-center">
                                                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}">
                                                    <label class="ms-2 form-check-label">
                                                        {{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}
                                                    </label>
                                                </div>
                                            </td>

                                            <!-- Name -->
                                            <td class="px-4 py-2 text-left">
                                                {{ $user->name }}
                                            </td>

                                            <!-- Email -->
                                            <td class="px-4 py-2 text-left">
                                                {{ $user->email }}
                                            </td>

                                            <!-- Role -->
                                            <td class="px-4 py-2 text-left">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->role_name == 'Super Admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                                    {{ $user->role_name }}
                                                </span>
                                            </td>

                                            <!-- Location -->
                                            <td class="px-4 py-2 text-left">
                                                {{ $user->location_name ?? 'N/A' }}
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-4 py-2 text-left space-x-2">
                                                <button 
                                                    wire:click="edit({{ $user->id }})"
                                                    class="w-8 h-8 bg-green-100 text-green-700 rounded-full inline-flex items-center justify-center hover:bg-green-200"
                                                >
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </button>
                                                <button 
                                                    wire:click="delete({{ $user->id }})"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                                    class="w-8 h-8 bg-red-600 text-white rounded-full inline-flex items-center justify-center hover:bg-red-700"
                                                >
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-left py-3 text-neutral-500">
                                                No users found.
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
                                    <span class="font-medium">{{ $users->firstItem() }}</span> 
                                    to 
                                    <span class="font-medium">{{ $users->lastItem() }}</span> 
                                    of 
                                    <span class="font-medium">{{ $users->total() }}</span> 
                                    entries
                                </div>

                                {{-- Pagination --}}
                                <div>
                                    {{ $users->onEachSide(1)->links('vendor.pagination.tailwind') }}
                                </div>
                            </div>

                            {{-- Success Message --}}
                            @if (session()->has('message'))
                                <div class="mt-3 rounded-lg bg-green-50 text-green-700 px-4 py-2 text-sm">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session()->has('error'))
                                <div class="mt-3 rounded-lg bg-red-50 text-red-700 px-4 py-2 text-sm">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Section --}}
        @if ($showForm)
            <div class="col-span-12">
                <div class="bg-white shadow-sm rounded-2xl p-6 border border-neutral-200">
                    <div class="mb-6 flex items-center justify-between">
                        <h5 class="text-xl font-semibold text-neutral-800">{{ $userId ? 'Edit User' : 'Add User' }}</h5>
                    </div>

                    <form wire:submit.prevent="save" class="grid grid-cols-12 gap-6">

                        {{-- Name --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Name</label>
                            <input type="text" wire:model.defer="name"
                                placeholder="Enter name"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                            <input type="email" wire:model.defer="email"
                                placeholder="Enter email"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">
                                Password {{ $userId ? '(leave blank to keep current password)' : '' }}
                            </label>
                            <input type="password" wire:model.defer="password"
                                placeholder="Enter password"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Confirm Password</label>
                            <input type="password" wire:model.defer="password_confirmation"
                                placeholder="Confirm password"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        {{-- Location --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Location</label>
                            <select wire:model.defer="location_id"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('location_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Role --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Role</label>
                            <select wire:model.defer="role_id"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="col-span-12 flex justify-end gap-3 pt-4">
                            <button type="button" wire:click="hideForm"
                                    class="px-5 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium">Cancel</button>
                            <button type="submit" class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium shadow">Save &amp; Close</button>
                        </div>

                        {{-- Success Message --}}
                        @if (session()->has('message'))
                            <div class="col-span-12">
                                <div class="rounded-lg bg-green-50 text-green-700 px-4 py-2 text-sm mt-3">
                                    {{ session('message') }}
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>

