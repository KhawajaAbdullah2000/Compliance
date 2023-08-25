<?php

use App\Http\Controllers\UserController;

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SuperUserController;
use App\Http\Controllers\EndUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\v3_2_s2_Controller;
use App\Http\Controllers\v3_2_s3_Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use function Ramsey\Uuid\v3;

//Excel cript
ROute::get('excel',[UserController::class,'excel']);


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
Route::get('add_new_user/{id}',[UserController::class,'add_new_user'])->name('add_new_user');
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
route::post('/fetch_suborg',[SuperUserController::class,'fetch_suborg'])->name('fetch_suborg');
Route::get('/add_end_user/{org_id}',[SuperUserController::class,'add_end_user']);
Route::post('/add_new_end_user',[SuperUserController::class,'add_end_user_form']);
Route::get('/end_users/{org_id}',[SuperUserController::class,'end_users'])->name('end_users');
Route::get('/end_user/edit/{id}',[SuperUserController::class,'edit_enduser']);
route::put('/edit_enduser/{id}',[SuperUserController::class,'edit_enduser_form_submit']);
route::get('/custom_roles',[SuperUserController::class,'custom_roles'])->name('custom_roles');
route::get('add_global_role',function(){
    return view('user.add_global_role');
});
route::post('add_new_role',[SuperUserController::class,'add_new_role'])->name('add_new_role');
route::get('/edit_global_role/{id}',[SuperUserController::class,'edit_global_role']);
route::put('edit_globalrole/{id}',[SuperUserController::class,'edit_globalrole']);


} );

//for project creator end user
Route::middleware(['auth','is_user','permission:Project Creator'])->group(function(){
route::get('create_project/{id}',[EndUserController::class,'create_project']);
route::post('create_project/{id}',[EndUserController::class,'submit_create_project']);
route::get('/projects/{user_id}',[EndUserController::class,'projects'])->name('projects');
route::get('edit_my_project/{id}',[EndUserController::class,'edit_my_project']);
route::put('/edit_project_submit/{id}',[EndUserController::class,'edit_project_submit']);
route::get('assigned_endusers/{id}',[EndUserController::class,'assigned_endusers'])->name('assigned_endusers');
route::get('/assign_end_user/{id}',[EndUserController::class,'assign_end_user']);
route::post('assign_enduser_to_project/{id}',[EndUserController::class,'submit_end_user']);
route::get('edit_permissions/{proj_id}/{user_id}',[EndUserController::class,'edit_permissions']);
route::put('edit_permissions/{proj_id}/{user_id}',[EndUserController::class,'edit_permissions_submit']);

}
);

//for all end users
Route::middleware(['auth','is_user','role:end user'])->group(function(){
    //Project controller for v3_2 section 1
route::get('assigned_projects/{user_id}',[ProjectController::class,'assigned_projects'])->name('assigned_projects');
route::get('v_3_2_section1_subsections/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_section1_subsections']);
route::get('v_3_2_sections/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_sections'])->name('v_3_2_sections');
route::get('v_3_2_section1/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_section1'])->name('v_3_2_section1');
route::post('v3_2_s1_clientinfo/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_clientinfo']);
route::get('edit_3_2_s1_clientinfo/{proj_id}/{user_id}',[ProjectController::class,'edit_3_2_s1_clientinfo']);
route::put('edit_3_2_s1_clientinfo/{proj_id}/{user_id}',[ProjectController::class,'edit_3_2_s1_clientinfo_form']);
route::post('v3_2_s1_assessorcompany/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_assessorcompany']);
route::get('edit_v_3_2_s1_assessorcomp/{proj_id}/{user_id}',[ProjectController::class,'edit_v_3_2_s1_assessorcomp']);
route::put('edit_v3_2_assessorcompany_form/{proj_id}/{user_id}',[ProjectController::class,'edit_v3_2_assessorcompany_form']);
route::post('v_3_2_s1_assessors/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_s1_assessors']);
route::get('edit_v3_2_s1_assesssor/{assessment_id}/{user_id}/{proj_id}',[ProjectController::class,'edit_v3_2_s1_assesssor']);
route::put('v3_2_s1_edit_assessors_form/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_edit_assessors_form']);
route::get('v3_2_s1_add_new_assessor/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_add_new_assessor']);
route::get('v3_2_s1_delete_assessor/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_delete_assessor']);
route::post('v3_2_s1_associate_qsa/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_associate_qsa']);
route::get('v3_2_s1_associateqsa_edit/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_associateqsa_edit']);
route::put('v3_2_editform_associate_qsa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_editform_associate_qsa']);
route::get('v3_2_s1_newassociate_qsa/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_newassociate_qsa']);
route::get('v3_2_s1_delete_associate_qsa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_delete_associate_qsa']);
route::post('v3_2_s1_qa_insert/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_qa_insert']);
route::get('v3_2_edit_qa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_edit_qa']);
route::put('v3_2_s1_qa_edit_form_submit/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_qa_edit_form_submit']);
route::get('v3_2_s1_add_new_qa/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_add_new_qa']);
route::get('v3_2_s1_delete_qa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_delete_qa']);

// section1.2
route::get('v3_2_s1_1_2/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_2'])->name('section1_2');
route::post('v3_2_s1_2_date/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_2_date']);
route::get('v3_2_s1_1_2_edit_timeframe/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_2_edit_timeframe']);
route::put('v3_2_s1_1_2_edit_timeframe_form/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_2_edit_timeframe_form']);
route::get('v3_2_s1_1_2_onsite/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_2_onsite']);
route::post('v3_2_s1_1_2_onsite_form/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_2_onsite_form']);
route::get('v3_2_s1_edit_date_onsite/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_edit_date_onsite']);
route::put('v3_2_s1_edit_submit_1_2_onsite/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_edit_submit_1_2_onsite']);
route::get('v3_2_s1_1_2_deleteonsite/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_2_deleteonsite']);

//section 1.4
route::get('v3_2_s1_1_4/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_4'])->name('section1_4');
route::post('v3_2_s1_1_4_services/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_4_services']);
route::get('v3_2_s1_1_4_edit/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_4_edit']);
route::put('v3_2_s1_1_4_services_edit_form/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_4_services_edit_form']);

//section 1.5
route::get('v3_2_s1_1_5/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_5'])->name('section1_5');
route::post('v3_2_s1_1_5_summary/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_5_summary']);
route::get('v3_2_s1_1_5_edit/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_5_edit']);
route::put('v3_2_s1_1_5_edit_form/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_1_5_edit_form']);

//section 2.1
route::get('v_3_2_section2_subsections/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v_3_2_section2_subsections']);
route::get('v3_2_s2_2_1/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_1'])->name('section2_1');
route::post('v3_2_s2_2_1_insert/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_1_insert']);
route::get('v3_2_s2_2_1_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_1_edit']);
route::put('v3_2_s2_2_1_edit_form/{assessment_id}/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_1_edit_form']);

//section2.2
route::get('v3_2_s2_2_2/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_2'])->name('section2_2');
route::post('v3_2_s2_2_2_form/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_2_form']);
route::get('v3_2_s2_2_2_add_diagram/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_2_add_diagram']);
route::delete('v3_2_s2_2_2_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s2_Controller::class,'v3_2_s2_2_2_delete']);

//Section 3
route::get('v3_2_section3_subsections/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_section3_subsections']);
route::get('v3_2_s3_3_1/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_1'])->name('section3_1');
route::post('v3_2_s3_3_1_form/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_1_form']);
}


);





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
