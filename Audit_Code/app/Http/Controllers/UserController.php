<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function changepass(){
       $super=User::where('id',2)->first();
       $super->password=Hash::make('12345');
       $super->save();
    }

    public function login(Request $req){
        
        $req->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            if(auth()->user()->privilege_id==4){
                return redirect()->route('root_home');
            }else{
                return redirect()->route('user_home');
            }
      
        } else {
            return redirect()->route('home')->with('error','Invalid credentials');
        
    }
}

//return root user home view
public function root_home(){
    return view('root_user.root_home');
}

//return user home
public function user_home(){
    return view('user.user_home');
}
//logout
public function logout(){
    Auth::logout();

    return redirect()->route('home')->with('sweetalert','Logged out successfully');

}

public function make_role(){
    //  $role = Role::create(['name' => 'primary contact']);
    //  $role = Role::create(['name' => 'secondary contact']);
    //  dd("done");
    // $role = Role::create(['name' => 'end user']);

//    $user=User::where('id',2)->first();
//     $user->assignRole('super user');

   //$user=User::role('root admin')->get();
   //dd($user);

}

public function add_user(){
    $orgs=Organization::all();
    return view('root_user.add_user',['orgs'=>$orgs]);
}

public function add_new_user($name,$sub_org){
    $org=Organization::select('name','sub_org')->where('name',$name)->where('sub_org',$sub_org)->first();
    $privileges=Privilege::where('privilege_name','!=','Root Admin')->where('privilege_name','!=','End User')->get();
    if($org){
        return view('root_user.add_new_user_form',['org'=>$org,'privilege'=>$privileges]);
    }
    else{
        return redirect()->route('add_user')->with('status','No such organization found');
    }
}

public function register_new_user(Request $req){
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
        'privilege_id'=>'required',
        'status'=>'required'
    ]

    );
    $data=$req->all();
    $data['password']=Hash::make($req->password);

   $user= User::create($data);
   if($user->privilege_id==1){
    $user->assignRole('super user');
   }
   if($user->privilege_id==2){
    $user->assignRole('primary contact');
   }
   if($user->privilege_id==3){
    $user->assignRole('secondary contact');
   }

   return redirect()->route('add_user')->with('success','User added successfully');


}
}
