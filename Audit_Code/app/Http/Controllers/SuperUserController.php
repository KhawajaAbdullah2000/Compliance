<?php

namespace App\Http\Controllers;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class SuperUserController extends Controller
{
    public function add_end_user($name,$sub_org){
        $org=Organization::select('name','sub_org')->where('name',$name)->where('sub_org',$sub_org)->first();
        $permissions=Permission::all();
         if($org){
                return view('user.add_end_user',['org'=>$org,'permissions'=>$permissions]);
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
            'status'=>'required',
            'roles'=>'required'
        ]

 );
        $data=$req->only(['first_name',
        'last_name',
        'email',
        'organization_name',
        'organizations_sub_org',
        'national_id',
        'telephone',
        'password',
        'state',
        'address',
        'country',
        'zip_code',
        'city',
        '2FA',
        'status',
        'privilege_id'
        ]
        );
        $data['password']=Hash::make($req->password);
    
       $user= User::create($data);
       $user->assignRole('end user');

       $global_roles = $req->input('roles', []);
$user->givePermissionTo($global_roles);

       return redirect()->route('end_users',
       ['org'=>auth()->user()->organization_name,'sub_org'=>auth()->user()->organizations_sub_org]
        )->with('success','End user added successfully');
}



public function end_users($org,$suborg){
$end_users=User::where('organization_name',$org)->where('organizations_sub_org',$suborg)
->where('privilege_id',5)->get();
return view('user.end_users',['end_users'=>$end_users]);
}


public function edit_enduser($id){
    $user=User::where('id',$id)->where('organization_name',auth()->user()->organization_name)
    ->where('organizations_sub_org',auth()->user()->organizations_sub_org)->first();
    $permissions=Permission::all();
    if($user){
        return view('user.edit_enduser',['user'=>$user,'permissions'=>$permissions]);
        

    }else{
        return redirect()->route('end_users',
        ['org'=>auth()->user()->organization_name,'sub_org'=>auth()->user()->organizations_sub_org]
         )->with('error','User not found');
         }

}

public function edit_enduser_form_submit(Request $req,$id){
    $req->validate(
        [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email' => ['required',Rule::unique('users')->ignore($id,'id')],
            'telephone'=>'required|numeric',
            'address'=>'required|max:100',
            'city'=>'required|max:100',
            'state'=>'required|max:100',
            'country'=>'required|max:100',
            'zip_code'=>'required|numeric',
            'status'=>'required',
            'roles'=>'required'
        ]
 );

    $user=User::where('id',$id)->where('organization_name',auth()->user()->organization_name)
    ->where('organizations_sub_org',auth()->user()->organizations_sub_org)->first();
    if($user){
        $user->first_name=$req->first_name;
        $user->last_name=$req->last_name;
        $user->email=$req->email;
        $user->telephone=$req->telephone;
        $user->address=$req->address;
        $user->city=$req->city;
        $user->state=$req->state;
        $user->country=$req->country;
        $user->zip_code=$req->zip_code;
        $user->status=$req->status;
        $user->save();
        $global_roles = $req->input('roles', []);
$user->syncPermissions($global_roles);
        return redirect()->route('end_users',
        ['org'=>auth()->user()->organization_name,'sub_org'=>auth()->user()->organizations_sub_org]
         )->with('success','User Updated');

    }else{
        return redirect()->route('end_users',
        ['org'=>auth()->user()->organization_name,'sub_org'=>auth()->user()->organizations_sub_org]
         )->with('error','User not found');
         }
    
}

public function custom_roles(){
    $permissions=Permission::all();
    return view('user.global_roles',['permissions'=>$permissions]);

}

public function add_new_role(Request $req){
    $req->validate([
        'name'=>'required|unique:permissions|min:5|max:50'
    ],
    [
        'name.unique'=>'This role already exists'
    ]
);
    Permission::create(['name' => $req->name]);
    return redirect()->route('custom_roles')->with('success','Role added successfully');

}
public function edit_global_role($id){
 $permission =   Permission::where('id',$id)->first();
 if($permission){
    return view('user.edit_global_role',['permission'=>$permission]);
 }
    
}

public function edit_globalrole(Request $req,$id){
        $req->validate([
            'name'=>'required|unique:permissions|min:5|max:50'
        ],
        [
            'name.unique'=>'This role already exists'
        ]
     
        );
 
        $permission = Permission::where('id',$id)->first();
        if($permission){

     
        $users=$permission->users;
        foreach ($users as $user) {
            $user->revokePermissionTo($permission->name);
    
        }

        $permission->update(['name' => $req->name]);
        foreach ($users as $user) {
            $user->givePermissionTo($req->name);
    
        }
        return redirect()->route('custom_roles')->with('success','Role edited successfully');

    }
       

      
      


}


}
