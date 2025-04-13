<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalLikelihoodValue extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_likelihood_value')->insert([
            ['global_likelihood' => 'UnLikely'],
            ['global_likelihood' => 'Rather Unlikely'],
            ['global_likelihood' => 'Likely'],
            ['global_likelihood' => 'Very Likely'],
            ['global_likelihood' => 'Almost Certain']
         
          
        ]);
    }
}
