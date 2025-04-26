<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypes2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_types')->insert([
       
        ['id'=>14,'type'=>'DAMA DMBOK'],
        ['id'=>15,'type'=>'Audit Standard']

        ]);
    }
}
