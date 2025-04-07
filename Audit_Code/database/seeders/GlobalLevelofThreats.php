<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalLevelofThreats extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_level_of_threats')->insert([
            ['global_threat' => 'Very Low'],
            ['global_threat' => 'Low'],
            ['global_threat' => 'Medium'],
            ['global_threat' => 'High'],
            ['global_threat' => 'Very High']
        ]);
    }
}
