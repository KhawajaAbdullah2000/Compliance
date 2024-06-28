<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivilegeSeeder extends Seeder
{
    public function run()
    {
        DB::table('privileges')->insert([
            ['id' => 1, 'privilege_name' => 'Super User', 'created_at' => '2023-07-08 13:01:23', 'updated_at' => '2023-07-08 13:01:23'],
            ['id' => 2, 'privilege_name' => 'Primary Contact', 'created_at' => '2023-07-08 13:01:39', 'updated_at' => '2023-07-08 13:01:39'],
            ['id' => 3, 'privilege_name' => 'Secondary Contact', 'created_at' => '2023-07-08 13:01:40', 'updated_at' => '2023-07-08 13:01:40'],
            ['id' => 4, 'privilege_name' => 'Root Admin', 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'privilege_name' => 'End User', 'created_at' => null, 'updated_at' => null]
        ]);
    }
}
