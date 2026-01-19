<div class="">
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card border-0 overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-lg">Permission Management</h6>
                </div>

                <div class="card-body">
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Roles List -->
                        <div class="md:col-span-4 col-span-12">
                            <h5 class="text-md font-semibold mb-3">Roles</h5>
                            <div class="space-y-2">
                                @foreach($roles as $role)
                                    <button 
                                        wire:click="selectRole({{ $role->id }})"
                                        class="w-full text-left px-4 py-3 rounded-lg border {{ $selectedRole == $role->id ? 'bg-green-50 border-green-500 text-green-700' : 'bg-white border-gray-200 hover:bg-gray-50' }} transition-colors"
                                    >
                                        <div class="font-semibold">{{ $role->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $role->permissions->count() }} permission(s)
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Permissions List -->
                        <div class="md:col-span-8 col-span-12">
                            @if($selectedRole)
                                @php
                                    $role = \Spatie\Permission\Models\Role::find($selectedRole);
                                @endphp
                                <h5 class="text-md font-semibold mb-3">Permissions for: {{ $role->name }}</h5>
                                <div class="space-y-2">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="rolePermissions" 
                                                value="{{ $permission->id }}"
                                                class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500"
                                            >
                                            <span class="ml-3 text-sm font-medium text-gray-700">
                                                {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>

                                @if (session()->has('message'))
                                    <div class="mt-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-12 text-gray-500">
                                    <iconify-icon icon="solar:shield-user-bold" class="text-6xl mb-4"></iconify-icon>
                                    <p>Select a role to manage permissions</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

