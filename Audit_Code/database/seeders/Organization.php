<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Organization extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert(

            [
                'name'=>'Askari Bank',
                'type'=>'guest',
                'city'=>'karachi',
                'state'=>'Sindh',
                'country'=>'country',
                'zip_code'=>12,
                'address'=>'Clifton',
                'status'=>'active',

            ]
            
        
            );
    }
}
