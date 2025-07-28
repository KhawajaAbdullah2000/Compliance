<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ISO_27701_2029 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('project_types')->insert([
            ['id' => 24, 'type' => 'ISO 27701 2019'],
        ]);
    }
}
