<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GlobalAssetCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_asset_categories')->insert([
            ['asset_category' => 'Data','is_manual'=>'no'],
            ['asset_category' => 'Technology','is_manual'=>'no'],
            ['asset_category' => 'Organization','is_manual'=>'no'],
            ['asset_category' => 'People','is_manual'=>'no'],
            ['asset_category' => 'Physical','is_manual'=>'no'],
            ['asset_category' => 'Service Provider','is_manual'=>'no'],
            ['asset_category' => 'Other','is_manual'=>'no'],
          
        ]);
    }
}
