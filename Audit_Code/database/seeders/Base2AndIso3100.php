<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Base2AndIso3100 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_types')->insert([
    ['id' => 20, 'type' => 'Base II'],
    ['id' => 21, 'type' => 'ISO 31000:2018'],
    ]);
    
    }
}
