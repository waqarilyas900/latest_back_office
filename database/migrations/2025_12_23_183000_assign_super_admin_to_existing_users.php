<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Assign Super Admin role to all existing users
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        
        // Get all users and assign Super Admin role
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            if (!$user->hasRole('Super Admin')) {
                $user->assignRole('Super Admin');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove Super Admin role from all users
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $user->removeRole('Super Admin');
        }
    }
};

