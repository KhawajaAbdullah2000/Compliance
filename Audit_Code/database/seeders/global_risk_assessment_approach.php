<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class global_risk_assessment_approach extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_risk_assessment_approach')->insert([
            ['global_assessment_approach' => 'Event-based with strategic risk scenarios'],
            ['global_assessment_approach' => 'Asset-based with operational risk scenarios'],
           
          
        ]);
    }
}
