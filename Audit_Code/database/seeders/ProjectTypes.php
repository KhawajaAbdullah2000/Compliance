<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProjectTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_types')->insert([
            ['id' => 1, 'type' => 'PCI-DSS v4-Single-Tenant Service Provider (stSP)'],
            ['id'=>4,'type'=>'ISO 27001:2022']

        ]);
    }
}
