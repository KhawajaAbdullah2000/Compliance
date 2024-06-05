<?php

use App\Http\Controllers\UserController;

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SuperUserController;
use App\Http\Controllers\EndUserController;
use App\Http\Controllers\IsoSec2_1;
use App\Http\Controllers\IsoSec2_2;
use App\Http\Controllers\IsoSec2_3;
use App\Http\Controllers\IsoSec2_3_1;
use App\Http\Controllers\IsoSec2_4_A5;
use App\Http\Controllers\IsoSec2_4_A6;
use App\Http\Controllers\IsoSec2_4_A7;
use App\Http\Controllers\IsoSec2_4_A8;
use App\Http\Controllers\PCI_Merchant_Sheet;
use App\Http\Controllers\PCI_Multi_Sheet;
use App\Http\Controllers\PCI_Single_Sheet;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\v3_2_s2_Controller;
use App\Http\Controllers\v3_2_s3_Controller;
use App\Http\Controllers\v3_2_s4_Controller;
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
Route::post('add_new_org',[OrganizationController::class,'register_new_org']);
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

route::get("/edit_project/{id}",[EndUserController::class,'editProject'])->name('edit_project');
route::get("/delete_user/{proj_id}/{user_id}",[EndUserController::class,'deleteUser'])->name('delete_user');



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

//ISO Project
route::get('iso_sections/{proj_id}/{user_id}',[ProjectController::class,'iso_sections'])->name('iso_sections');
// route::get("/meta_data/{proj_id}/{user_id}",[ProjectController::class,'metaData'])->name('meta_data');
route::get("/reports/{proj_id}/{user_id}",[ProjectController::class,'reports'])->name('reports');
route::get("/assets_in_scope/{proj_id}/{user_id}",[ProjectController::class,'assets_in_scope'])->name('assets_in_scope');
route::get("/risk_assessment_report/{proj_id}/{user_id}",[ProjectController::class,'risk_assessment_report']);
route::get("/risk_treatment/{proj_id}/{user_id}",[ProjectController::class,'risk_treatment']);
route::get("/dashboard/{proj_id}/{user_id}",[ProjectController::class,'dashBoard'])->name('dashboard');
route::get('delete_my_project/{proj_id}/{user_id}',[ProjectController::class,'delete_my_project']);
//perosnal dashooard on home
route::get("/my_personal_dashboard/{user_id}",[ProjectController::class,'my_personal_dashboard'])->name('my_personal_dashboard');

//ai wizard
route::get("ai_wizard/{proj_id}/{user_id}",[ProjectController::class,'ai_wizard'])->name('ai_wizard');



route::get('iso_section2_4_subsections/{proj_id}/{user_id}',[ProjectController::class,'iso_section2_4_subsections']);



//Iso sec2.4 A5 Organzation
//assets
route::get('iso_sec2_4_a5_assets/{proj_id}/{user_id}',[IsoSec2_4_A5::class,'iso_sec2_4_a5_assets'])->name('iso_sec2_4_a5_assets');
route::get('iso_sec2_4_a5/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A5::class,'iso_sec2_4_a5'])->name('iso_sec2_4_a5');
//route::Post('iso_sec2_4_a5_new/{proj_id}/{user_id}',[IsoSec2_4_A5::class,'iso_sec2_4_a5_new']);
route::get('iso_sec2_4_a5_edit/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A5::class,'iso_sec2_4_a5_edit']);
route::put('submit_edit_sec2_4_a5/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A5::class,'submit_edit_sec2_4_a5']);



//Iso sec2.4 A6 People
route::get('iso_sec2_4_a6_assets/{proj_id}/{user_id}',[IsoSec2_4_A6::class,'iso_sec2_4_a6_assets'])->name('iso_sec2_4_a6_assets');
route::get('iso_sec2_4_a6/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A6::class,'iso_sec2_4_a6'])->name('iso_sec2_4_a6');
route::get('iso_sec2_4_a6_edit/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A6::class,'iso_sec2_4_a6_edit']);
route::put('submit_edit_sec2_4_a6/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A6::class,'submit_edit_sec2_4_a6']);



//Iso sec2.4 A7 Physical
route::get('iso_sec2_4_a7_assets/{proj_id}/{user_id}',[IsoSec2_4_A7::class,'iso_sec2_4_a7_assets'])->name('iso_sec2_4_a7_assets');
route::get('iso_sec2_4_a7/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A7::class,'iso_sec2_4_a7'])->name('iso_sec2_4_a7');
route::get('iso_sec2_4_a7_edit/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A7::class,'iso_sec2_4_a7_edit']);
route::put('submit_edit_sec2_4_a7/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A7::class,'submit_edit_sec2_4_a7']);




//Iso sec2.4 A8 Technlogical
route::get('iso_sec2_4_a8_assets/{proj_id}/{user_id}',[IsoSec2_4_A8::class,'iso_sec2_4_a8_assets'])->name('iso_sec2_4_a8_assets');
route::get('iso_sec2_4_a8/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A8::class,'iso_sec2_4_a8'])->name('iso_sec2_4_a8');
route::get('iso_sec2_4_a8_edit/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A8::class,'iso_sec2_4_a8_edit']);
route::put('submit_edit_sec2_4_a8/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_4_A8::class,'submit_edit_sec2_4_a8']);





//ISO sec2.1
route::get('iso_section2_1/{proj_id}/{user_id}',[IsoSec2_1::class,'iso_section2_1'])->name('iso_section2_1');
route::get('iso_section2_3/{proj_id}/{user_id}',[IsoSec2_1::class,'iso_section2_3'])->name('iso_section2_3');
route::get('risk_treatment/{proj_id}/{user_id}',[IsoSec2_1::class,'risk_treatment'])->name('risk_treatment');

route::post('new_iso_sec_2_1/{proj_id}/{user_id}',[IsoSec2_1::class,'new_iso_sec_2_1']);
route::get('iso_sec_2_1_new/{proj_id}/{user_id}',[IsoSec2_1::class,'iso_sec_2_1_new']);
route::get('iso_sec_2_1_edit/{assessment_id}/{proj_id}/{user_id}',[IsoSec2_1::class,'iso_sec_2_1_edit']);
route::put('iso_sec_2_1_submit_edit/{assessment_id}/{proj_id}/{user_id}',[IsoSec2_1::class,'iso_sec_2_1_submit_edit']);
route::get('iso_sec_2_1_delete/{assessment_id}/{proj_id}/{user_id}',[IsoSec2_1::class,'iso_sec_2_1_delete']);

//copy assets gage to open the services of the selected project
route::get("copy_assets/{proj_id}/{user_id}",[IsoSec2_1::class,'ShowServices'])->name('services');
//show asset groups of those services
route::get('show_groups/{proj_id}/{user_id}/{proj_to_copy}/{servicename}',[IsoSec2_1::class,'ShowGroups']);
route::post('copy_groups/{proj_id}/{user_id}/{proj_to_copy}/{servicename}',[IsoSec2_1::class,'CopyGroups']);
//download exceltemplate
route::get('/download_asset_template',[IsoSec2_1::class,'download_asset_template'])->name('download_asset_template');
route::post('upload_assets/{proj_id}/{user_id}',[IsoSec2_1::class,'upload_assets']);


//Iso Sec2.3
route::get('iso_sec_2_3/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3'])->name('iso_sec_2_3');

//ISosec2.3.1
route::get('iso_sec_2_3_1/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_1'])->name('iso_sec_2_3_1');
route::Post('iso_sec2_3_1_initial_add/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec2_3_1_initial_add']);

//editing risk assesment view
route::get("edit_risk_assessment/{proj_id}/{user_id}/{asset_id}/{control_num}",[IsoSec2_3_1::class,'edit_risk_assessment']);
route::put("edit_risk_assessment/{proj_id}/{user_id}/{asset_id}/{control_num}",[IsoSec2_3_1::class,'edit_risk_assessment_update']);

//route::get('iso_sec_2_3_1_risk/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_1_risk'])->name('iso_sec_2_3_1_risk');
route::get('iso_sec2_3_1_risk_treat_controls/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec2_3_1_risk_treat_controls'])->name('iso_sec2_3_1_risk_treat_controls');
//for compoenet select only


route::get('iso_sec_2_3_2_risk_treat_form/{control_num}/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_2_risk_treat_form'])->name('iso_sec_2_3_2_risk_treat_form');
route::put('iso_sec_2_3_2_treat_form_submit/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_2_treat_form_submit']);
route::put('iso_sec_2_3_2_treat_form1_submit/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_2_treat_form1_submit']);
route::get('risk_treatment_edit_action_plan_form/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'risk_treatment_edit_action_plan_form'])->name('risk_treatment_edit_action_plan_form');

route::post('iso_sec2_3_1_new/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec2_3_1_new']);

route::get('iso_sec_2_3_edit/{assessment_id}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit'])->name('iso_sec_2_3_edit');
route::post('iso_sec_2_3_new_asset_value/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_new_asset_value']);
route::put('iso_sec_2_3_edit_asset_value/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit_asset_value']);

route::get('iso_sec_2_3_table_insert/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_table_insert']);
route::post('iso_sec_2_3_table_submit/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_table_submit']);
route::get('iso_sec_2_3_edit_table/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit_table']);
route::put('iso_sec_2_3_edit_table_submit/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit_table_submit']);

//ISO sec2.2
route::get('iso_sec_2_2_subsections/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_sec_2_2_subsections'])->name('iso_sec_2_2_subsections');
route::get('iso_section2_2/{title_num}/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_section2_2'])->name('iso_sec_2_2_main');
route::get('iso_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_sec_2_2_req'])->name('iso_sec_2_2_req');
route::get('iso_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_sec2_2_sub_req_edit'])->name('iso_sec2_2_sub_req_edit');
route::post('iso_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_sec_2_2_form']);
route::put('iso_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_sec_2_2_edit_form']);


//PCI single sheet
route::get("pci_single_sheet_subsections/{proj_id}/{user_id}",[PCI_Single_Sheet::class,'pci_single_sheet_subsections'])->name('pci_single_sheet_subsections');
route::get("pci_section_2_2/{title_num}/{proj_id}/{user_id}",[PCI_Single_Sheet::class,'pci_section_2_2'])->name('pci_section_2_2_main');
route::get("pci_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}",[PCI_Single_Sheet::class,'pci_sec_2_2_req'])->name('pci_sec_2_2_req');
route::get('pci_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Single_Sheet::class,'pci_sec2_2_sub_req_edit'])->name('pci_sec2_2_sub_req_edit');
route::post('pci_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Single_Sheet::class,'pci_sec_2_2_form']);
route::put('pci_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Single_Sheet::class,'pci_sec_2_2_edit_form']);


//PCI Multi sheet
route::get("pci_multi_sheet_subsections/{proj_id}/{user_id}",[PCI_Multi_Sheet::class,'pci_multi_sheet_subsections'])->name('pci_multi_sheet_subsections');
route::get("pci_multi_section_2_2/{title_num}/{proj_id}/{user_id}",[PCI_Multi_Sheet::class,'pci_multi_section_2_2'])->name('pci_multi_section_2_2_main');
route::get("pci_multi_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}",[PCI_Multi_Sheet::class,'pci_multi_sec_2_2_req'])->name('pci_multi_sec_2_2_req');
route::get('pci_multi_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Multi_Sheet::class,'pci_multi_sec2_2_sub_req_edit'])->name('pci_multi_sec2_2_sub_req_edit');
route::post('pci_multi_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Multi_Sheet::class,'pci_multi_sec_2_2_form']);
route::put('pci_multi_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Multi_Sheet::class,'pci_multi_sec_2_2_edit_form']);


//for merchant
route::get("pci_merchant_sheet_subsections/{proj_id}/{user_id}",[PCI_Merchant_Sheet::class,'pci_merchant_subsections'])->name('pci_merchant_sheet_subsections');
route::get("pci_merchant_section_2_2/{title_num}/{proj_id}/{user_id}",[PCI_Merchant_Sheet::class,'pci_merchant_section_2_2'])->name('pci_merchant_section_2_2_main');
route::get("pci_merchant_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}",[PCI_Merchant_Sheet::class,'pci_merchant_sec_2_2_req'])->name('pci_merchant_sec_2_2_req');
route::get('pci_merchant_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Merchant_Sheet::class,'pci_merchant_sec2_2_sub_req_edit'])->name('pci_merchant_sec2_2_sub_req_edit');
route::post('pci_merchant_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Merchant_Sheet::class,'pci_merchant_sec_2_2_form']);
route::put('pci_merchant_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}',[PCI_Merchant_Sheet::class,'pci_merchant_sec_2_2_edit_form']);


// route::get('v_3_2_section1_subsections/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_section1_subsections']);
// route::get('v_3_2_sections/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_sections'])->name('v_3_2_sections');

// route::get('v_3_2_section1/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_section1'])->name('v_3_2_section1');
// route::post('v3_2_s1_clientinfo/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_clientinfo']);
// route::get('edit_3_2_s1_clientinfo/{proj_id}/{user_id}',[ProjectController::class,'edit_3_2_s1_clientinfo']);
// route::put('edit_3_2_s1_clientinfo/{proj_id}/{user_id}',[ProjectController::class,'edit_3_2_s1_clientinfo_form']);
// route::post('v3_2_s1_assessorcompany/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_assessorcompany']);
// route::get('edit_v_3_2_s1_assessorcomp/{proj_id}/{user_id}',[ProjectController::class,'edit_v_3_2_s1_assessorcomp']);
// route::put('edit_v3_2_assessorcompany_form/{proj_id}/{user_id}',[ProjectController::class,'edit_v3_2_assessorcompany_form']);
// route::post('v_3_2_s1_assessors/{proj_id}/{user_id}',[ProjectController::class,'v_3_2_s1_assessors']);
// route::get('edit_v3_2_s1_assesssor/{assessment_id}/{user_id}/{proj_id}',[ProjectController::class,'edit_v3_2_s1_assesssor']);
// route::put('v3_2_s1_edit_assessors_form/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_edit_assessors_form']);
// route::get('v3_2_s1_add_new_assessor/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_add_new_assessor']);
// route::get('v3_2_s1_delete_assessor/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_delete_assessor']);
// route::post('v3_2_s1_associate_qsa/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_associate_qsa']);
// route::get('v3_2_s1_associateqsa_edit/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_associateqsa_edit']);
// route::put('v3_2_editform_associate_qsa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_editform_associate_qsa']);
// route::get('v3_2_s1_newassociate_qsa/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_newassociate_qsa']);
// route::get('v3_2_s1_delete_associate_qsa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_delete_associate_qsa']);
// route::post('v3_2_s1_qa_insert/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_qa_insert']);
// route::get('v3_2_edit_qa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_edit_qa']);
// route::put('v3_2_s1_qa_edit_form_submit/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_qa_edit_form_submit']);
// route::get('v3_2_s1_add_new_qa/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_add_new_qa']);
// route::get('v3_2_s1_delete_qa/{assessment_id}/{proj_id}/{user_id}',[ProjectController::class,'v3_2_s1_delete_qa']);

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
//3.1
route::get('v3_2_section3_subsections/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_section3_subsections']);
route::get('v3_2_s3_3_1/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_1'])->name('section3_1');
route::post('v3_2_s3_3_1_form/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_1_form']);
route::get('v3_2_s3_3_1_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_1_edit']);
route::put('v3_2_s3_3_1_edit_submit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_1_edit_submit']);

//3.2
route::get('v3_2_s3_3_2/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_2'])->name('section3_2');
route::post('v3_2_s3_3_2_form/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_2_form']);
route::get('v3_2_s3_3_2_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_2_edit']);
route::put('v3_2_s3_3_2_edit_form/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_2_edit_form']);

//3.3
route::get('v3_2_s3_3_3/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_3'])->name('section3_3');
route::post('v3_2_s3_3_3_insert/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_3_insert']);
route::get('v3_2_s3_3_3_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_3_edit']);
route::Put('v3_2_s3_3_3_edit_form/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_3_edit_form']);

//3.4
route::get('v3_2_s3_3_4/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_4'])->name('section3_4');
route::post('v3_2_s3_3_4_insert/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_4_insert']);
route::get('v3_2_s3_3_4_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_4_edit']);
route::put('v3_2_s3_3_4_edit_form/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_4_edit_form']);
route::get('v3_2_s3_3_4_new/{network_type}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_4_new']);
route::get('v3_2_s3_3_4_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_4_delete']);

//3.5
route::get('v3_2_s3_3_5/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5'])->name('section3_5');
route::post('v3_2_s3_3_5_insert/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5_insert']);
route::get('v3_2_s3_3_5_new/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5_new']);
route::get('v3_2_s3_3_5_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5_edit']);
route::put('v3_2_s3_3_5_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5_editform']);
route::get('v3_2_s3_3_5_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5_delete']);


//3,6
route::get('v3_2_s3_3_6/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6'])->name('section3_6');
route::post('v3_2_s3_3_6_insert/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_insert']);
route::get('v3_2_s3_3_6_add_new/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_5_add_new']);
route::get('v3_2_s3_3_6_edit_wholly/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_edit_wholly']);
route::put('v3_2_s3_3_6_edit_form/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_edit_form']);
route::get('v3_2_s3_3_6_delete_wholly/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_delete_wholly']);
route::post('v3_2_s3_3_6_international/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_international']);
route::get('v3_2_s3_3_6_inter_new/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_inter_new']);
route::get('v3_2_s3_3_6_edit_inter/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_edit_inter']);
route::put('v3_2_s3_3_6_inter_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_inter_editform']);
route::get('v3_2_s3_3_6_delete_inter/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_6_delete_inter']);
//section 3.7
route::get('v3_2_s3_3_7/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_7'])->name('section3_7');
route::post('v3_2_s3_3_7_insert/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_7_insert']);
route::get('v3_2_s3_3_7_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_7_edit']);
route::put('v3_2_s3_3_7_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_7_editform']);
//section3.8
route::get('v3_2_s3_3_8/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8'])->name('section3_8');
route::Post('v3_2_s3_3_8_inscope/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_inscope']);
route::get('v3_2_s3_3_8_wireless_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_wireless_edit']);
route::put('v3_2_s3_3_8_inscope_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_inscope_edit']);
route::get('v3_2_s3_3_8_inscope_new/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_inscope_new']);
route::post('v3_2_s3_3_8_outscope/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_outscope']);
route::get('v3_2_s3_3_8_out_scope_new/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_out_scope_new']);
route::get('v3_2_s3_3_8_wireless_out_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_wireless_out_edit']);
route::put('v3_2_s3_3_8_outscope_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_outscope_edit']);
route::get('v3_2_s3_3_8_wireless_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_wireless_delete']);
route::get('v3_2_s3_3_8_wireless_out_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s3_Controller::class,'v3_2_s3_3_8_wireless_out_delete']);

//section 4
//4.1
route::get('v3_2_section4_subsections/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_section4_subsections']);
route::get('v3_2_s4_4_1/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_1'])->name('section4_1');
route::post('v3_2_s4_4_1_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_1_insert']);
route::get('v3_2_s4_4_1_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_1_new']);
route::delete('v3_2_s4_4_1_del/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_1_del']);

//4.2
route::get('v3_2_s4_4_2/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2'])->name('section4_2');
route::post('v3_2_s4_2_2_dataflows/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_2_2_dataflows']);
route::get('v3_2_s4_4_2_insert_dataflow/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2_insert_dataflow']);
route::get('v3_2_s4_4_2_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2_edit']);
route::put('v3_2_s4_2_2_edit_dataflows/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_2_2_edit_dataflows']);
route::get('v3_2_s4_4_2_delete_dataflow/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2_delete_dataflow']);
route::post('v3_2_s4_4_2_insert_diagram/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2_insert_diagram']);
route::get('v3_2_s4_4_2_new_diagram/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2_new_diagram']);
route::delete('v3_2_s4_4_2_dia_del/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_2_dia_del']);

//4.3
route::get('v3_2_s4_4_3/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_3'])->name('section4_3');
route::post('v3_2_s4_4_3_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_3_insert']);
route::get('v3_2_s4_4_3_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_3_new']);
route::get('v3_2_s4_4_3_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_3_edit']);
route::put('v3_2_s4_4_3_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_3_editform']);
route::get('v3_2_s4_4_3_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_3_delete']);

//4.4
route::get('v3_2_s3_4_4/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s3_4_4'])->name('section4_4');
route::Post('v3_2_s4_4_4_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_4_insert']);
route::get('v3_2_s4_4_4_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_4_new']);
route::get('v3_2_s4_4_4_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_4_edit']);
route::put('v3_2_s4_4_4_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_4_editform']);
route::get('v3_2_s4_4_4_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_4_delete']);

//4.5
route::get('v3_2_s4_4_5/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_5'])->name('section4_5');
route::post('v3_2_s4_4_5_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_5_insert']);
route::get('v3_2_s4_4_5_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_5_edit']);
route::put('v3_2_s4_4_5_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_5_editform']);

//4.6
route::get('v3_2_s4_4_6/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_6'])->name('section4_6');
route::Post('v3_2_s4_4_6_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_6_insert']);
route::get('v3_2_s4_4_6_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_6_new']);
route::get('v3_2_s4_4_6_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_6_edit']);
route::put('v3_2_s4_4_6_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_6_editform']);
route::get('v3_2_s4_4_6_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_6_delete']);
route::get('v3_2_s4_4_7/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_7'])->name('section4_7');
route::post('v3_2_s4_4_7_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_7_insert']);
route::get('v3_2_s4_4_7_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_7_new']);
route::get('v3_2_s4_4_7_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_7_edit']);
route::put('v3_2_s4_4_7_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_7_editform']);
route::get('v3_2_s4_4_7_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_7_delete']);

//section4.8
route::get('v3_2_s4_4_8/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8'])->name('section4_8');
route::post('v3_2_s4_4_8_insert_party/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_insert_party']);
route::get('v3_2_s4_4_8_new_party/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_new_party']);
route::get('v3_2_s4_4_8_party_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_party_edit']);
route::put('v3_2_s4_4_8_editform_party/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_editform_party']);
route::get('v3_2_s4_4_8_party_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_party_delete']);
route::post('v3_2_s4_4_8_asses/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_asses']);
route::get('v3_2_s4_4_8_asses_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_asses_edit']);
route::put('v3_2_s4_4_8_asses_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_asses_editform']);
route::get('v3_2_s4_4_8_asses_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_8_asses_delete']);

//section4.9
route::get('v3_2_s4_4_9/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_9'])->name('section4_9');
route::Post('v3_2_s4_4_9_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_9_insert']);
route::get('v3_2_s4_4_9_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_9_new']);
route::get('v3_2_s4_4_9_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_9_edit']);
route::put('v3_2_s4_4_9_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_9_editform']);
route::get('v3_2_s4_4_9_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_9_delete']);

//section4.10
route::get('v3_2_s4_4_10/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_10'])->name('section4_10');
route::post('v3_2_s4_4_10_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_10_insert']);
route::get('v3_2_s4_4_10_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_10_new']);
route::get('v3_2_s4_4_10_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_10_edit']);
route::put('v3_2_s4_4_10_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_10_editform']);
route::get('v3_2_s4_4_10_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_10_delete']);

//section4.11
route::get('v3_2_s4_4_11/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_11'])->name('section4_11');
route::post('v3_2_s4_4_11_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_11_insert']);
route::get('v3_2_s4_4_11_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_11_edit']);
route::put('v3_2_s4_4_11_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_11_editform']);

//section4.12
route::get('v3_2_s4_4_12/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12'])->name('section4_12');
route::Post('v3_2_s4_4_12_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_insert']);
route::get('v3_2_s4_4_12_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_new']);
route::post('v3_2_s4_4_12_insert_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_insert_new']);
route::get('v3_2_s4_4_12_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_edit']);
route::put('v3_2_s4_4_12_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_editform']);
route::get('v3_2_s4_4_12_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_delete']);
route::get('v3_2_s4_4_12_edit_yes_no/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_edit_yes_no']);
route::put('v3_2_s4_4_12_yes_no_editform/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_12_yes_no_editform']);

//4.13

route::get('v3_2_s4_4_13/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13'])->name('section4_13');
route::Post('v3_2_s4_4_13_insert/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_insert']);
route::get('v3_2_s4_4_13_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_new']);
route::post('v3_2_s4_4_13_insert_new/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_insert_new']);
route::get('v3_2_s4_4_13_edit/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_edit']);
route::put('v3_2_s4_4_13_editform/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_editform']);
route::get('v3_2_s4_4_13_delete/{assessment_id}/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_delete']);
route::get('v3_2_s4_4_13_edit_yes_no/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_edit_yes_no']);
route::put('v3_2_s4_4_13_yes_no_editform/{proj_id}/{user_id}',[v3_2_s4_Controller::class,'v3_2_s4_4_13_yes_no_editform']);


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
