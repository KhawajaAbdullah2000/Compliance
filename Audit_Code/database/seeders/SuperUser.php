<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data= [
            'first_name'=>'Super',
            'last_name'=>'User 1',
            'email'=>'banks1@gmail.com',
            'org_id'=>1,
            'telephone'=>'04448887643',
            'address'=>'Azizabad',
            'city'=>'karachi',
            'state'=>'Sindh',
            'country'=>'country',
            'zip_code'=>75950,
            'password'=>Hash::make('12345'),
            'privilege_id'=>1, //super user
            'status'=>'active',
            '2FA'=>'N'

        ];
        
        $user= User::create($data);
    
         $user->assignRole('super user');
    }
}

