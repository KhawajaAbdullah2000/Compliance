<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AddInternalAuditProjectType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('project_types')->insert([
            ['id'=>17,'type'=>'Internal Audit']
    
            ]);
    }
}
