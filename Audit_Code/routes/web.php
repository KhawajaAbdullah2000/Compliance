<?php

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;



Route::get('/', function () {
    return view('login-view');
})->name('home')->middleware('guest');

Route::post('/login', [UserController::class,'login']);


//for root users
Route::middleware(['auth','is_root_user','role:root admin'])->group(function(){
Route::get('/root_home',[UserController::class,'root_home'])->name('root_home');
Route::get('/organizations',[OrganizationController::class,'organizations'])->name('organizations');
Route::get('/add_new_org',[OrganizationController::class,'add_new_org'])->name('add_new_org');
Route::post('/add_new_org',[OrganizationController::class,'register_new_org']);
Route::get('edit_org/{name}/{sub_org}',[OrganizationController::class,'edit_org']);
Route::put('edit_org/{name}/{sub_org}',[OrganizationController::class,'update_org']);
Route::get('delete_org/{name}/{sub_org}',[OrganizationController::class,'delete_org']);
Route::get('add_user',[UserController::class,'add_user'])->name('add_user');
Route::get('add_new_user/{name}/{sub_org}',[UserController::class,'add_new_user'])->name('add_new_user');
Route::post('add_new_user',[UserController::class,'register_new_user']);
Route::get('users',[UserController::class,'users'])->name('users');
Route::get('users/edit/{id}',[UserController::class,'user_edit_view']);
Route::post('users/edit/{id}',[UserController::class,'user_edit']);

}
);



//for home page of user
Route::middleware(['auth','is_user'])->group(function(){
     Route::get('/user_home',[UserController::class,'user_home'])->name('user_home');
    }
    );


//for super users roled
Route::middleware(['auth','is_user','role:super user'])->group(function(){
    Route::get('/super-user',function(){
        dd('hello super user');
    });
  } );



Route::get('/role',[UserController::class,'make_role']);



 Route::get('/logout',[UserController::class,'logout'])->name('logout');


//Route::get('/add-root-user', [UserController::class,'changepass'])->name('pass');






//got to reset password link 
Route::get('/forgot-password', function () {
    return view('forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');


//after user clicks on link
Route::get('/reset-password/{token}', function (string $token) {
     return view('reset-password', ['token' => $token]);
 })->middleware('guest')->name('password.reset');


 
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:5|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('home')->with('status', __($status))
                : back()->withErrors(['status' => [__($status)]]);
})->middleware('guest')->name('password.update');