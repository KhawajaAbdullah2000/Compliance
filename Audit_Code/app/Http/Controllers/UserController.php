<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Http;
class UserController extends Controller
{

    public function ai(){
        return view('ai');
    }

    public function uploadPdf(Request $request)
    {
    
            // Handle PDF upload
            $request->validate([
                'file' => 'required|file|max:10240', 
            ]);
            // Send the file to Flask API
            $file = $request->file('file');
            $response = Http::attach(
                'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
            )->post('http://127.0.0.1:8080/upload_pdf');

            if ($response->successful()) {
                $fileName = $file->getClientOriginalName();
                return view('ai', ['fileName' => $fileName, 'success' => true]);
            } else {
                return view('ai', ['error' => 'Failed to upload the PDF.']);
            }
        

       
    }

    public function askPdf(Request $request)
    {
        if ($request->isMethod('post')) {
            // Handle question submission
            $request->validate([
                'question' => 'required|string',
            ]);

            // Send the question to Flask API
            $response = Http::post('http://127.0.0.1:8080/ask_pdf', [
                'query' => $request->input('question'),
            ]);

            if ($response->successful()) {
                return view('ai', ['response' => $response->json()['answer'], 'question' => $request->input('question')]);
            } else {
                return view('ai', ['error' => 'Failed to fetch the response.']);
            }
        }

       
    }
    public function login(Request $req){
        
        $req->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            $user = Auth::user();
            $user->last_logged_in_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();
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

public function add_new_user($id){
    $org=Organization::select('id','name')->where('id',$id)->first();
    $privileges=Privilege::where('privilege_name','!=','Root Admin')->where('privilege_name','!=','End User')->get();
   $departments=DB::table('departments')->where('org_id',$id)->get();
    if($org){
        return view('root_user.add_new_user_form',['org'=>$org,'privilege'=>$privileges,'departments'=>$departments]);
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
'password' => 'required|min:12|max:30|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]+$/',
        'privilege_id'=>'required',
        'status'=>'required'
    ],
    [
        'password.required' => 'Please enter a password.',
        'password.min' => 'Password must be at least 12 characters.',
        'password.max' => 'Password cannot exceed 30 characters.',
        'password.regex' => 'Password must include at least one letter, one number, and one special character (@, $, !, %, *, ?, &, .), and must contain only allowed characters.'    ]

    );
    $data=$req->only( ['first_name',
    'last_name',
    'email',
    'department_id',
    'national_id',
    'telephone',
    'password',
    'org_id',
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
   if($user->privilege_id==1){
    $user->assignRole('super user');
    $check= Db::table('superusers')->where('user_id',$user->id)->where('org_id',$req->org_id)->first();
    if(!$check){
        Db::table('superusers')->insert([
            'user_id'=>$user->id,
            'org_id'=>$req->org_id
        ]);
    }

   }
   if($user->privilege_id==2){
    $user->assignRole('primary contact');
   }
   if($user->privilege_id==3){
    $user->assignRole('secondary contact');
   }

   return redirect()->route('add_user')->with('success','User added successfully');


}

public function users(){
    $users=User::select('users.id','users.first_name','users.last_name',
    'users.email','users.privilege_id','privileges.privilege_name','organizations.name','departments.name as dept_name')
    ->join('organizations','users.org_id','organizations.id')
    ->join('privileges','users.privilege_id','privileges.id')
    ->leftjoin('departments','users.department_id','departments.id')
    ->where('users.privilege_id','!=',4)->get();
    return view('root_user.users',['users'=>$users]);
    
}

public function user_edit_view($id){
    $privileges=Privilege::where('privilege_name','!=','Root Admin')
    ->where('privilege_name','!=','End User')->get();
    $user=User::where('id',$id)->first();
    $departments=DB::table('departments')->where('org_id',$user->org_id)->get();
    if($user){
        return view('root_user.edit_user',['user'=>$user,'privileges'=>$privileges,'departments'=>$departments]);
    }
    else{
        return redirect()->route('users')->with('error','Student not found');
    }

}


public function user_edit(Request $req,$id){
    
    $req->validate(
        [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email' => ['required',Rule::unique('users')->ignore($id,'id')],
            'privilege_id'=>'required',
            'status'=>'required'
        ]
 );


$user=User::where('id',$id)->first();

$user->roles()->detach();

// if($user->privilege_id==1){
//     $user->removeRole('super user');
// }

// if($user->privilege_id==2){
//     $user->removeRole('primary contact');
// }
// if($user->privilege_id==3){
//     $user->removeRole('secondary contact');
// }


if($req->privilege_id!=1){
    $check= Db::table('superusers')->where('user_id',$id)->get();
    if($check){
        Db::table('superusers')->where([
            'user_id'=>$user->id,
        ])->delete();
        
    }
}

if($req->privilege_id==1){
    $check= Db::table('superusers')->where('user_id',$id)->get();
    
    if($check->count()==0){
        Db::table('superusers')->insert([
            'user_id'=>$user->id,
            'org_id'=>$user->org_id
        ]);
      
        
    }
}

 $user->first_name=$req->first_name;
 $user->last_name=$req->last_name;
 $user->email=$req->email;
 $user->telephone=$req->telephone;
 $user->address=$req->address;
 $user->city=$req->city;
 $user->state=$req->state;
 $user->country=$req->country;
 $user->zip_code=$req->zip_code;
 $user->privilege_id=$req->privilege_id;
 $user->status=$req->status;
 $user->department_id=$req->department_id;


if($req->privilege_id==1){
    $user->assignRole('super user');
   }
   if($req->privilege_id==2){
    $user->assignRole('primary contact');
   }
   if($req->privilege_id==3){
    $user->assignRole('secondary contact');
   }

   $user->save();

   return redirect()->route('users')->with('success','Record Updated Successfully');


}

public function delete_user($id){
    DB::table('users')->where('id',$id)->delete();
    return redirect()->route('users');
}

// public function excel(){
//     $filePath = storage_path('app/excel_files/PCI.xlsx');
//     $data = Excel::toArray([], $filePath);
//     $filteredData = collect($data[0])->filter(function ($row) {
//         return $row[0] == '1.1.1.a';
//     })->values()->all();


//    dd($filteredData); 

// }


}
