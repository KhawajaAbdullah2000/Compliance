<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'root admin']);
        Role::create(['name' => 'super user']);
        Role::create(['name' => 'end user']);
        Role::create(['name' => 'primary contact ']);
        Role::create(['name' => 'secondary contact']);

        $user = User::where('privilege_id', 4)->first();

        // Check if the user exists
        if ($user) {
            // Assign role by name
            $user->assignRole('root admin');
        }
    }
}
