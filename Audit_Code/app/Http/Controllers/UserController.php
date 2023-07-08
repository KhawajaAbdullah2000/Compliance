<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    return redirect()->route('home')->with('error','Logged out successfully');

}
    
}
