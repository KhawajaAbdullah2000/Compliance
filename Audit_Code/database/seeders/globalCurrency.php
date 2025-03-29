<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class globalCurrency extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_currency')->insert([
            ['currency' => 'None'],
            ['currency' => 'PKR'],
            ['currency' => 'USD'],
            ['currency' => 'SAR'],
            ['currency' => 'AED'],
            ['currency' => 'GBP']
        ]);
    }
}
