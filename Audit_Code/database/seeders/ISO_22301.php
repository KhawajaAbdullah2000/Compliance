<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ISO_22301 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('project_types')->insert([
            ['id' => 29, 'type' => 'ISO 22301:2019']
        ]);
    }
    
}
