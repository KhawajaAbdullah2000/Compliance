<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class GlobalRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Data Inputter']);
        Permission::create(['name' => 'Project Creator']);
        Permission::create(['name' => 'Data Approver']);
        Permission::create(['name' => 'Data Viewer']);
    }
}
