<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RootAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'first_name'=>'shahmeer',
                'last_name'=>'sheraz',
                'email'=>'shahmeer2@gmail.com',
                'telephone'=>'04448887643',
                'address'=>'Gulshan',
                'city'=>'karachi',
                'state'=>'Sindh',
                'country'=>'country',
                'zip_code'=>12,
                'password'=>Hash::make('12345'),
                'privilege_id'=>4,
                'status'=>'active',
                '2FA'=>'N'

            ]
            );
    }
}
