<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuantitativeGlobalLikelihoodScale extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_quantitative_likelihood_scale')->insert([
            ['global_likelihood' => 'Once a decade'],
            ['global_likelihood' => 'Once a year'],
            ['global_likelihood' => 'Once a month'],
            ['global_likelihood' => 'Twice a week'],
            ['global_likelihood' => 'Every 8 hours'],
            ['global_likelihood' => 'Every Hour'],

           
        ]);
    }
}
