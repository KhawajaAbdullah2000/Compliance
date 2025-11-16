<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ISO_27701_2025 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('project_types')->insert([
            ['id' => 30, 'type' => 'ISO 27701:2025']
        ]);
    }
}
