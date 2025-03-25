<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(RootAdminSeeder::class);
        $this->call(PrivilegeSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(GlobalRoles::class);
        $this->call(ProjectTypes::class);
        $this->call(Organization::class);
        $this->call(Risk_Management_Frameworks::class);
        $this->call(GlobalAssetCategories::class);
        $this->call(GlobalAssetTypes::class);
        $this->call(frameworkApproachTypes::class);
        //$this->call(SuperUser::class);


    }
}
