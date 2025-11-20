<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class global_multistandard_likelihood_adverse_events extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_multistandard_likelihood_adverse_events')->insert([
            ['event_name' => 'Confidentiality of Information'],
            ['event_name' => 'Integrity of Information'],
            ['event_name' => 'Availability of Information'],
            ['event_name' => 'All of the Above'],

        ]);
    }
}
