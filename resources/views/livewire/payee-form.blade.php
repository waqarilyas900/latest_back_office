<div class="">
    <div class="">
        
        {{-- Table Section --}}
        @if (!$showForm)
            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <div class="card border-0 overflow-hidden">
                        <!-- Card Header -->
                        <div class="card-header flex items-center justify-between">
                            <h6 class="card-title mb-0 text-lg">Payees</h6>
                            <input 
                                type="text" 
                                wire:model.live="search" 
                                placeholder="Search payee..." 
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
                                    Add Payee
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
                            <table id="payees-table" 
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
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Vendor Name</th>
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Contact</th>
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Email</th>
                                        <th class="px-4 py-2 text-left text-neutral-800 dark:text-white">Phone</th>
                                        <th class="px-4 py-2 text-center text-neutral-800 dark:text-white">Status</th>
                                        <th class="px-4 py-2 text-center text-neutral-800 dark:text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payees as $index => $payee)
                                        <tr class="border-t border-neutral-200 dark:border-neutral-600">
                                            <!-- Checkbox + Serial -->
                                            <td class="px-4 py-2">
                                                <div class="form-check style-check flex items-center">
                                                    <input class="form-check-input" type="checkbox" value="{{ $payee->id }}">
                                                    <label class="ms-2 form-check-label">
                                                        {{ $index + 1 }}
                                                    </label>
                                                </div>
                                            </td>

                                            <!-- payee Name -->
                                            <td class="px-4 py-2 text-left">
                                                {{ $payee->vendor_name }}
                                            </td>
                                            <td class="px-4 py-2 text-left">
                                                {{ $payee->contact_name }}
                                            </td>
                                            <td class="px-4 py-2 text-left">
                                                {{ $payee->email }}
                                            </td>
                                            <td class="px-4 py-2 text-left">
                                                {{ $payee->phone }}
                                            </td>

                                            <!-- Status -->
                                            <td class="px-4 py-2 text-left">
                                                <span class="{{ $payee->active 
                                                    ? 'bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400' 
                                                    : 'bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400' }}
                                                    px-4 py-1.5 rounded-full font-medium text-sm">
                                                    {{ $payee->active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-4 py-2 text-left space-x-2">
                                                <button 
                                                    wire:click="edit({{ $payee->id }})"
                                                    class="w-8 h-8 bg-green-100 text-green-700 rounded-full inline-flex items-center justify-center hover:bg-green-200"
                                                >
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </button>
                                                <button 
                                                    wire:click="delete({{ $payee->id }})"
                                                    onclick="return confirm('Are you sure you want to delete this payee?')"
                                                    class="w-8 h-8 bg-red-600 text-white rounded-full inline-flex items-center justify-center hover:bg-red-700"
                                                >
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-left py-3 text-neutral-500">
                                                No payee found.
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
                                <span class="font-medium">{{ $payees->firstItem() }}</span> 
                                to 
                                <span class="font-medium">{{ $payees->lastItem() }}</span> 
                                of 
                                <span class="font-medium">{{ $payees->total() }}</span> 
                                entries
                            </div>

                            {{-- Pagination --}}
                            <div>
                                {{ $payees->onEachSide(1)->links('vendor.pagination.tailwind') }}
                            </div>
            </div>

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
                        <h5 class="text-xl font-semibold text-neutral-800">Add Payee</h5>
                    </div>

                    <form wire:submit.prevent="save" class="grid grid-cols-12 gap-6">

                        {{-- Vendor Name --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Vendor Name</label>
                            <input type="text" wire:model.defer="vendor_name"
                                placeholder="Enter vendor name"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('vendor_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Contact Name --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Contact Name</label>
                            <input type="text" wire:model.defer="contact_name"
                                placeholder="Enter contact name"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('contact_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Phone --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Phone</label>
                            <input type="text" wire:model.defer="phone"
                                placeholder="Enter phone"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                            <input type="email" wire:model.defer="email"
                                placeholder="Enter email"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Fax --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Fax</label>
                            <input type="text" wire:model.defer="fax"
                                placeholder="Enter fax number"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('fax')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- State --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">State</label>
                            <input type="text" wire:model.defer="state"
                                placeholder="Enter state"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('state')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- City --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">City</label>
                            <input type="text" wire:model.defer="city"
                                placeholder="Enter city"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('city')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Zip Code --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Zip Code</label>
                            <input type="text" wire:model.defer="zip_code"
                                placeholder="Enter zip code"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('zip_code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Account Number --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Account Number</label>
                            <input type="text" wire:model.defer="account_number"
                                placeholder="Enter account number"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('account_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Payment Method --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Payment Method</label>
                            <input type="text" wire:model.defer="payment_method"
                                placeholder="Enter payment method"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('payment_method')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- POS ID --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">POS ID</label>
                            <input type="text" wire:model.defer="pos_id"
                                placeholder="Enter POS ID"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('pos_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Default Margin --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Default Margin</label>
                            <input type="text" wire:model.defer="default_margin"
                                placeholder="Enter default margin"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('default_margin')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Fintech Vendor Code --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Fintech Vendor Code</label>
                            <input type="text" wire:model.defer="fintech_vendor_code"
                                placeholder="Enter fintech vendor code"
                                class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('fintech_vendor_code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Terms --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Terms</label>
                            <select wire:model="term_id"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Term</option>
                                @foreach($termOptions as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                                @endforeach
                            </select>
                            @error('term_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Department --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Department</label>
                            <select wire:model="department_id"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Department</option>
                                @foreach($departmentOptions as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Default Bank --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Default Bank Account</label>
                            <select wire:model="default_bank_account_id"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">Select Bank</option>
                                @foreach($bankOptions as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->account_name }}</option>
                                @endforeach
                            </select>
                            @error('default_bank_account_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        {{-- Status --}}
                        <div class="md:col-span-4 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Status</label>
                            <select wire:model.defer="active"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        {{-- Address 1 --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Address 1</label>
                            <textarea wire:model.defer="address_1" rows="3"
                                    placeholder="Enter address 1"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                            @error('address_1')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Address 2 --}}
                        <div class="md:col-span-6 col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Address 2</label>
                            <textarea wire:model.defer="address_2" rows="3"
                                    placeholder="Enter address 2"
                                    class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                            @error('address_2')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Payee Types --}}
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Payee Types</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach(['employee','expense','customer','misc','mpos','vendor'] as $type)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" wire:model="types" value="{{ $type }}"
                                            class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm">{{ ucfirst($type) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('types')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
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
