<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AddIso31000RiskFramework extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           DB::table('risk_management_framework')->insert([
            ['framework_name' => 'ISO 31000:2018 Risk Management'],
             

        ]);
    }
}
