<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Nist_CSF extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('project_types')->insert([
            ['id' => 23, 'type' => 'NIST CSF 2.0'],
        ]);
    }
}
