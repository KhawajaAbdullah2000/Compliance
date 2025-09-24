<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NonStandardAndMultiStandard extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('project_types')->insert([
            ['id' => 27, 'type' => 'Non-Standard'],
            ['id' => 28, 'type' => 'Multi-Standard'],
        ]);
    }
}
