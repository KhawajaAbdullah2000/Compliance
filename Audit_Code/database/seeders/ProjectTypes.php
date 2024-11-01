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
            // ['id'=>2,'type'=>'PCI-DSS v4-Multi-Tenant Service Provider (mtSP)'],
            // ['id'=>3,'type'=>'PCI-DSS v4-Merchant'],
            ['id'=>4,'type'=>'ISO 27001:2022']
            // ['id'=>5,'type'=>'Cyber Security Framework - SAMA'],
              // ['id'=>6,'type'=>'SBP ETGRMF'],
             // ['id'=>7,'type'=>'KSA NCA ECC'],

        ]);
    }
}
