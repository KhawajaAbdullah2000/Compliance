<?php

namespace App\Http\Controllers;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class SuperUserController extends Controller
{
    public function add_end_user($name,$sub_org){
        $org=Organization::select('name','sub_org')->where('name',$name)->where('sub_org',$sub_org)->first();
         if($org){
                return view('user.add_end_user',['org'=>$org]);
        }else{
            return redirect()->route('user_home')->with('error','Organization not found');
        }
      
}


public function add_end_user_form(Request $req){
    $req->validate(
        [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>'required|email|unique:users',
            'telephone'=>'required|numeric',
            'address'=>'required|max:100',
            'city'=>'required|max:100',
            'state'=>'required|max:100',
            'country'=>'required|max:100',
            'zip_code'=>'required|numeric',
            'password'=>'required|max:30',
            'status'=>'required'
        ]

 );
        $data=$req->all();
        $data['password']=Hash::make($req->password);
    
       $user= User::create($data);
       $user->assignRole('end user');
       return redirect()->route('user_home')->with('success','End user added successfully');
}
}
