<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class frameworkApproachTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('framework_approach_types')->insert([
            ['approach_name' => 'Qualitative'],
            ['approach_name' => 'Quantitave'],
           
          
        ]);
    }
}
