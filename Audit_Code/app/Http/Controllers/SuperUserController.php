<?php

namespace App\Http\Controllers;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class SuperUserController extends Controller
{
    public function add_end_user($org_id){
        $org=Organization::select('name','type','id')->where('id',$org_id)->first();
       $allorgs=Organization::all();
        $permissions=Permission::all();
        $departments=Db::table('departments')->where('org_id',$org->id)->get();
         if($org){
                return view('user.add_end_user',['org'=>$org,'permissions'=>$permissions,'allorgs'=>$allorgs,'departments'=>$departments]);
        }else{
            return redirect()->route('user_home')->with('error','Organization not found');
        }
      
}
// public function fetch_suborg(Request $req){
//     $data['sub_org'] = Organization::select('sub_org')->where('name',$req->org_name)->get();
//     return response()->json($data);
// }

public function add_end_user_form(Request $req){

    $req->validate(
        [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'org_id'=>'required',
    'password' => 'required|min:12|max:30|regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/',
        'privilege_id'=>'required',
        'status'=>'required'
            // 'roles'=>'required'
        ],
        [
            'org_id.required'=>'Select an organization',
            'password.regex' => 'The password must be alphanumeric and include at least one letter and one number.',
        ]

 );
        $data=$req->only(['first_name',
        'last_name',
        'email',
        'org_id',
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
        'privilege_id',
        'department_id'
        ]
        );
        $data['password']=Hash::make($req->password);
    
       $user= User::create($data);
       $user->assignRole('end user');

       $global_roles = $req->input('roles', []);

        $user->givePermissionTo($global_roles);

        if($req->org_id!=auth()->user()->org_id){
            $check= Db::table('superusers')->where('user_id',auth()->user()->id)->where('org_id',$req->org_id)->first();
            if(!$check){
                Db::table('superusers')->insert([
                    'user_id'=>auth()->user()->id,
                    'org_id'=>$req->org_id
                ]);
            }

         
        }else{ //if guest super user is making nd user for its own organization
            $check= Db::table('superusers')->where('user_id',auth()->user()->id)->where('org_id',$req->org_id)->first();
            if(!$check){
                Db::table('superusers')->insert([
                    'user_id'=>auth()->user()->id,
                    'org_id'=>$req->org_id
                ]);
            }

        }

       return redirect()->route('end_users',
       ['org_id'=>auth()->user()->org_id]
        )->with('success','End user added successfully');
}



public function end_users($org_id){

    $organ=Organization::where('id',$org_id)->first();

    if($organ->type=="host"){
        $check=Db::table('superusers')->where('user_id',auth()->user()->id)->pluck('org_id');
       $orgs=$check->toArray();

         $end_users=User::join('organizations','users.org_id','organizations.id')
         ->leftJoin('departments','users.department_id','departments.id')
         ->where('users.privilege_id',5)->whereIn('users.org_id',$orgs)
         ->select('users.id','users.first_name','users.last_name','organizations.name','users.email','users.status','users.updated_at',
          'departments.name as dept_name')
         ->get();
   
        return view('user.end_users',['end_users'=>$end_users]);
    }


     if($organ->type=="guest"){
         $end_users=User::join('organizations','users.org_id','organizations.id')
         ->leftjoin('departments','users.department_id','departments.id')
         ->where('users.org_id',$org_id)
          ->where('privilege_id',5)
          ->select('users.id','users.first_name','users.last_name','organizations.name','users.email','users.status','users.updated_at',
          'departments.name as dept_name')
          ->get();


    
      
    
       
          return view('user.end_users',['end_users'=>$end_users]);

    }
   

}


public function edit_enduser($id){
    $user=User::where('id',$id)->first();
    $permissions=Permission::all();
    $departments=Db::table('departments')->where('org_id',$user->org_id)->get();
    if($user){
        return view('user.edit_enduser',['user'=>$user,'permissions'=>$permissions,'departments'=>$departments]);
        

    }else{
        return redirect()->route('end_users',
        ['org'=>auth()->user()->org_id]
         )->with('error','User not found');
         }

}

public function edit_enduser_form_submit(Request $req,$id){
    $req->validate(
        [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email' => ['required',Rule::unique('users')->ignore($id,'id')],
         
        ]
 );

    $user=User::where('id',$id)->first();
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
        $user->department_id=$req->department_id;
        $user->save();
        $global_roles = $req->input('roles', []);
        $user->syncPermissions($global_roles);
        return redirect()->route('end_users',['org_id'=>auth()->user()->org_id])->with('success','End user added successfully');
    }
    else{
        return redirect()->route('end_users',
        ['org_id'=>auth()->user()->org_id]
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
