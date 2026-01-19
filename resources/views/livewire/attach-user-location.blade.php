<div class="p-4">

    {{-- Table Section --}}
    @if (!$showForm)
        <div class="card border-0 overflow-hidden">
            <div class="card-header flex items-center justify-between mb-4">
                <h6 class="card-title mb-0 text-lg">User Locations</h6>
                @can('attach location')
                <button wire:click="displayForm" class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium flex items-center">
                    <iconify-icon icon="lucide:plus" class="mr-1"></iconify-icon>
                    Attach User
                </button>
                @endcan
            </div>

            <div class="card-body">
                <table id="user-locations-table" 
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
                            <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">User</th>
                            <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Location</th>
                            <th class="px-4 py-2 text-center text-neutral-800 dark:text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attached as $index => $item)
                            <tr class="border-t border-neutral-200 dark:border-neutral-600">
                                <!-- Checkbox + Serial -->
                                <td class="px-4 py-2">
                                    <div class="form-check style-check flex items-center">
                                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}">
                                        <label class="ms-2 form-check-label">
                                            {{ $index + 1 }}
                                        </label>
                                    </div>
                                </td>

                                <!-- User Name -->
                                <td class="px-4 py-2 text-left">
                                    {{ $item->user_name }}
                                </td>

                                <!-- Location Name -->
                                <td class="px-4 py-2 text-left">
                                    {{ $item->location_name }}
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-2 text-left space-x-2">
                                    <button 
                                        wire:click="displayForm({{ $item->id }})"
                                        class="w-8 h-8 bg-yellow-400 text-white rounded-full inline-flex items-center justify-center hover:bg-yellow-500"
                                        title="Edit"
                                    >
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </button>
                                    <button 
                                        wire:click="delete({{ $item->id }})"
                                        onclick="return confirm('Are you sure you want to delete this user location?')"
                                        class="w-8 h-8 bg-red-600 text-white rounded-full inline-flex items-center justify-center hover:bg-red-700"
                                        title="Delete"
                                    >
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-left py-3 text-neutral-500">
                                    No user-location attached yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    @endif

    {{-- Form Section --}}
    @if ($showForm)
        <div class="flex justify-center items-center min-h-[60vh] bg-gray-50">
            <form wire:submit.prevent="attach" class="bg-white shadow-lg rounded-xl p-8 w-full max-w-xl">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Attach Location to User</h2>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select User</label>
                    <select wire:model.defer="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                        <option value="">-- Choose User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Location</label>
                    <select wire:model.defer="location_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                        <option value="">-- Choose Location --</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('location_id') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" wire:click="hideForm" class="px-5 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 font-medium shadow">Attach</button>
                </div>

                @if (session()->has('message'))
                    <div class="mt-3 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mt-3 bg-red-100 text-red-800 px-4 py-2 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    @endif

</div>
