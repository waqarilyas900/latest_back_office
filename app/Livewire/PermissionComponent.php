<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class PermissionComponent extends Component
{
    public $roles = [];
    public $permissions = [];
    public $selectedRole = null;
    public $rolePermissions = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function selectRole($roleId)
    {
        $this->selectedRole = $roleId;
        $role = Role::findOrFail($roleId);
        $this->rolePermissions = $role->permissions->pluck('id')->toArray();
    }

    public function updatedRolePermissions()
    {
        if ($this->selectedRole) {
            $role = Role::findOrFail($this->selectedRole);
            $permissionIds = array_filter($this->rolePermissions);
            $permissions = Permission::whereIn('id', $permissionIds)->get();
            $role->syncPermissions($permissions);
            
            session()->flash('message', 'Permissions updated successfully!');
        }
    }

    public function render()
    {
        return view('livewire.permission-component');
    }
}

