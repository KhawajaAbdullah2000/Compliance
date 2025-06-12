<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Risk_Management_Frameworks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('risk_management_framework')->insert([
            ['framework_name' => 'Default'],
             ['framework_name'=>'ISO 27005:2022'],
             ['framework_name'=>'UAE Information Assurance'],
             ['framework_name'=>'KSA NCA'],
             ['framework_name'=>'Custom Framework'],

        ]);
    }
}
