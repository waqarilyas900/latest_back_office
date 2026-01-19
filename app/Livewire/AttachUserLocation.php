<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class AttachUserLocation extends Component
{
    public $showForm = false;
    public $editId = null; // Track edit
    public $user_id;
    public $location_id;

    public $users = [];
    public $locations = [];

    public function mount()
    {
        $this->loadUsers();
        $this->locations = Location::all();
    }

    public function loadUsers()
    {
        // Load only users who don't have any location OR editing current user
        if ($this->editId) {
            $attached = DB::table('location_user')->find($this->editId);
            $currentUserId = $attached->user_id ?? null;

            $this->users = User::whereDoesntHave('locations')
                ->orWhere('id', $currentUserId)
                ->get();
        } else {
            $this->users = User::whereDoesntHave('locations')->get();
        }
    }

    public function displayForm($editId = null)
    {
        if (!auth()->user()->can('attach location')) {
            session()->flash('error', 'You do not have permission to attach locations to users.');
            return;
        }
        $this->showForm = true;
        $this->editId = $editId;

        if ($editId) {
            $attached = DB::table('location_user')->find($editId);
            $this->user_id = $attached->user_id;
            $this->location_id = $attached->location_id;
        } else {
            $this->reset(['user_id', 'location_id']);
        }

        $this->loadUsers();
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->editId = null;
        $this->reset(['user_id', 'location_id']);
        $this->loadUsers();
    }

    public function attach()
    {
        if (!auth()->user()->can('attach location')) {
            session()->flash('error', 'You do not have permission to attach locations to users.');
            return;
        }

        $this->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
        ]);

        if ($this->editId) {
            DB::table('location_user')->where('id', $this->editId)
                ->update([
                    'user_id' => $this->user_id,
                    'location_id' => $this->location_id,
                    'updated_at' => now(),
                ]);

            session()->flash('message', 'User location updated successfully!');
        } else {
            DB::table('location_user')->insert([
                'user_id' => $this->user_id,
                'location_id' => $this->location_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('message', 'Location attached to user successfully!');
        }

        $this->hideForm();
    }

    public function delete($id)
    {
        DB::table('location_user')->where('id', $id)->delete();
        session()->flash('message', 'User location deleted successfully!');
        $this->loadUsers(); // Reload users to reflect changes
    }

    public function render()
    {
        $attached = DB::table('location_user')
            ->join('users', 'users.id', '=', 'location_user.user_id')
            ->join('locations', 'locations.id', '=', 'location_user.location_id')
            ->select('location_user.id', 'users.name as user_name', 'locations.name as location_name')
            ->get();

        return view('livewire.attach-user-location', [
            'attached' => $attached
        ]);
    }
}
