<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalAssetTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_asset_types')->insert([
        ['asset_category' => 1,'is_manual'=>'no','asset_type'=>'PII'],
        ['asset_category' => 1,'is_manual'=>'no','asset_type'=>'PCI CHD'],
        ['asset_category' => 1,'is_manual'=>'no','asset_type'=>'PCI SAD'],
        ['asset_category' => 1,'is_manual'=>'no','asset_type'=>'Transaction Data'],
        ['asset_category' => 1,'is_manual'=>'no','asset_type'=>'Other datatype'],

        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Application'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Database Application'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Operating System'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Virtual Resource'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Hardware Resource'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Container'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Storage Device'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Network Device'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Security Device'],
        ['asset_category' => 2,'is_manual'=>'no','asset_type'=>'Other Technology'],

        ['asset_category' => 3,'is_manual'=>'no','asset_type'=>'Policy Document'],
        ['asset_category' => 3,'is_manual'=>'no','asset_type'=>'Process Document'],
        ['asset_category' => 3,'is_manual'=>'no','asset_type'=>'Procedure Document'],

        ['asset_category' => 4,'is_manual'=>'no','asset_type'=>'Privileged Business User'],
        ['asset_category' => 4,'is_manual'=>'no','asset_type'=>'Ordinary Business User'],
        ['asset_category' => 4,'is_manual'=>'no','asset_type'=>'Privileged Technology User'],
        ['asset_category' => 4,'is_manual'=>'no','asset_type'=>'Ordinary Technology User'],


        ['asset_category' => 5,'is_manual'=>'no','asset_type'=>'Building Facility'],
        ['asset_category' => 5,'is_manual'=>'no','asset_type'=>'Data Center Facility'],
        ['asset_category' => 5,'is_manual'=>'no','asset_type'=>'Remote Work Location'],
        ['asset_category' => 5,'is_manual'=>'no','asset_type'=>'Data Storage Location'],
        ['asset_category' => 5,'is_manual'=>'no','asset_type'=>'Other Physical Location'],

        ['asset_category' => 6,'is_manual'=>'no','asset_type'=>'On-prem Service Provider'],
        ['asset_category' => 6,'is_manual'=>'no','asset_type'=>'Cloud Service Provider'],
        ['asset_category' => 6,'is_manual'=>'no','asset_type'=>'Hybrid Service Provider'],

        ['asset_category' => 7,'is_manual'=>'no','asset_type'=>'Other'],











         
          
        ]);
        
    }
}
