<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
class UserForm extends Component
{
    use WithPagination;
    
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $location_id;
    public $role_id;
    public $userId = null;
    
    public $locations = [];
    public $roles = [];
    public $showForm = false;
    public $search = '';
    public $perPage = 10;

    public function mount()
    {
        $this->locations = Location::all();
        $this->roles = Role::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        
        // Get the user's location if exists
        $userLocation = DB::table('location_user')
            ->where('user_id', $user->id)
            ->first();
        $this->location_id = $userLocation->location_id ?? null;
        
        // Get the user's role
        $userRole = $user->roles->first();
        $this->role_id = $userRole->id ?? null;
        
        $this->showForm = true;
    }

    public function save()
    {
        if (!$this->userId && !auth()->user()->can('add user')) {
            session()->flash('error', 'You do not have permission to add users.');
            return;
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',
        ];

        if ($this->userId) {
            // Update: email must be unique except for current user
            $rules['email'] .= '|unique:users,email,' . $this->userId;
            // Password is optional on update
            if ($this->password) {
                $rules['password'] = 'required|string|min:8|confirmed';
            }
        } else {
            // Create: email must be unique, password is required
            $rules['email'] .= '|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->userId) {
            // Update existing user
            $user = User::findOrFail($this->userId);
            // Only update password if provided
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }
            $user->update($data);
            session()->flash('message', 'User updated successfully.');
        } else {
            // Create new user - password is required
            $data['password'] = Hash::make($this->password);
            $user = User::create($data);
            $this->userId = $user->id;
            session()->flash('message', 'User created successfully.');
        }

        // Handle location attachment/update
        if ($this->location_id) {
            // Delete existing location_user entry for this user
            DB::table('location_user')->where('user_id', $user->id)->delete();
            
            // Insert new location_user entry
            DB::table('location_user')->insert([
                'user_id' => $user->id,
                'location_id' => $this->location_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // If no location selected, remove existing location_user entry
            DB::table('location_user')->where('user_id', $user->id)->delete();
        }

        // Handle role assignment
        if ($this->role_id) {
            $role = Role::findOrFail($this->role_id);
            $user->syncRoles([$role->name]);
        } else {
            // If no role selected, remove all roles
            $user->syncRoles([]);
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function displayForm()
    {
        if (!auth()->user()->can('add user')) {
            session()->flash('error', 'You do not have permission to add users.');
            return;
        }
        $this->resetForm();
        $this->showForm = true;
    }

    public function hideForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete($id)
    {
        // Delete location_user entries first
        DB::table('location_user')->where('user_id', $id)->delete();
        
        // Delete user
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
    }

    protected function resetForm()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->location_id = null;
        $this->role_id = null;
        $this->userId = null;
    }

    public function render()
    {
        $users = User::where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // Get locations and roles for each user
        $usersWithLocations = $users->map(function ($user) {
            $locationUser = DB::table('location_user')
                ->join('locations', 'locations.id', '=', 'location_user.location_id')
                ->where('location_user.user_id', $user->id)
                ->select('locations.name as location_name', 'locations.id as location_id')
                ->first();
            
            $user->location_name = $locationUser->location_name ?? null;
            $user->location_id = $locationUser->location_id ?? null;
            
            // Get user's role
            $userRole = $user->roles->first();
            $user->role_name = $userRole->name ?? 'N/A';
            
            return $user;
        });

        return view('livewire.user-form', [
            'users' => $users,
            'usersWithLocations' => $usersWithLocations,
            'locations' => Location::all(),
        ]);
    }
}

