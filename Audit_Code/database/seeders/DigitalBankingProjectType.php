<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DigitalBankingProjectType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('project_types')->insert([
            ['id' => 25, 'type' => 'Digital Banking Security (BPRD Cir. No. 4 of 2023)'],
        ]);
    }
}
