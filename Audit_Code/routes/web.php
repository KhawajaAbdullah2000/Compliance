<?php

use App\Http\Controllers\ActionPlanController;
use App\Http\Controllers\ComplianceMap;
use App\Http\Controllers\CY_SAMA;
use App\Http\Controllers\RiskHeatmap;
use App\Http\Controllers\UAE_IA;
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
use App\Http\Controllers\KSA_NCA;
use App\Http\Controllers\PCI_Merchant_Sheet;
use App\Http\Controllers\PCI_Multi_Sheet;
use App\Http\Controllers\PCI_Single_Sheet;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SBP_ETGRMF;
use App\Http\Controllers\v3_2_s2_Controller;
use App\Http\Controllers\v3_2_s3_Controller;
use App\Http\Controllers\v3_2_s4_Controller;
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
// ROute::get('excel',[UserController::class,'excel']);
Route::get('ai',[UserController::class,'ai'])->name('ai');
//Route::post('ai',[UserController::class,'ask_pdf']);

Route::post('/upload-pdf', [UserController::class, 'uploadPdf'])->name('upload-pdf');
Route::post('/ask-pdf', [UserController::class, 'askPdf'])->name('ask-question');

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
Route::get('edit_org/{org_id}',[OrganizationController::class,'edit_org']);
Route::put('edit_org/{org_id}',[OrganizationController::class,'update_org']);
Route::get('delete_org/{org_id}',[OrganizationController::class,'delete_org']);
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
route::get("/mandatory_and_nonmandatory_controls/{proj_id}/{user_id}",[ProjectController::class,'mandatory_and_nonmandatory_controls'])->name('mandatory_and_nonmandatory_controls');



route::get("/risk_assessment_report/{proj_id}/{user_id}",[ProjectController::class,'risk_assessment_report']);
route::get("/risk_treatment_report/{proj_id}/{user_id}",[ProjectController::class,'risk_treatment']);
route::get("/dashboard/{proj_id}/{user_id}",[ProjectController::class,'dashBoard'])->name('dashboard');
route::get('delete_my_project/{proj_id}/{user_id}',[ProjectController::class,'delete_my_project']);
//perosnal dashooard on home
route::get("/my_personal_dashboard/{user_id}",[ProjectController::class,'my_personal_dashboard'])->name('my_personal_dashboard');
Route::get('risk_compliance_heatmap/{proj_id}/{user_id}',[ProjectController::class,'risk_compliance_heatmap'])->name('risk_compliance_heatmap');
Route::get('drill_down_by_service/{proj_id}/{user_id}',[ProjectController::class,'drill_down_by_service'])->name('drill_down_by_service');

Route::get('drill_down_by_asset_group/{proj_id}/{s_name}/{user_id}',[ProjectController::class,'drill_down_by_asset_group'])->name('drill_down_by_asset_group');

Route::get('drill_down_by_asset/{proj_id}/{s_name}/{user_id}',[ProjectController::class,'drill_down_by_asset'])->name('drill_down_by_asset');

Route::get('drill_down_by_asset_component/{proj_id}/{s_name}/{user_id}',[ProjectController::class,'drill_down_by_asset_component'])->name('drill_down_by_asset_component');


Route::get('drill_down_by_asset_from_asset_group/{proj_id}/{s_name}/{g_name}/{user_id}',[ProjectController::class,'drill_down_by_asset_from_asset_group'])->name('drill_down_by_asset_from_asset_group');

Route::get('drill_down_by_asset_component_from_asset/{proj_id}/{s_name}/{g_name}/{asset}/{user_id}',[ProjectController::class,'drill_down_by_asset_component_from_asset']);

Route::get('drill_down_by_asset_component_from_service_from_asset/{proj_id}/{s_name}/{asset}/{user_id}',[ProjectController::class,'drill_down_by_asset_component_from_service_from_asset']);


Route::get('risk_compliance_heatmap/{proj_id}/{s_name}/{user_id}',[ProjectController::class,'risk_compliance_service_heatmap'])->name('risk_compliance_service_heatmap');
Route::get('risk_compliance_heatmap_from_asset_group/{proj_id}/{s_name}/{g_name}/{user_id}',[ProjectController::class,'risk_compliance_heatmap_from_asset_group']);

Route::get('risk_compliance_heatmap_by_asset_from_asset_group/{proj_id}/{s_name}/{g_name}/{name}/{user_id}',[ProjectController::class,'risk_compliance_heatmap_by_asset_from_asset_group']);

Route::get('risk_compliance_heatmap_for_asset_component_by_asset/{proj_id}/{s_name}/{g_name}/{name}/{c_name}/{user_id}',[ProjectController::class,'risk_compliance_heatmap_for_asset_component_by_asset']);
Route::get('risk_compliance_heatmap_by_service_and_asset/{proj_id}/{s_name}/{name}/{user_id}',[ProjectController::class,'risk_compliance_heatmap_by_service_and_asset']);
Route::get('risk_compliance_heatmap_by_service_asset_component/{proj_id}/{s_name}/{name}/{c_name}/{user_id}',[ProjectController::class,'risk_compliance_heatmap_by_service_asset_component']);

Route::get('risk_compliance_heatmap_by_service_and_component/{proj_id}/{s_name}/{c_name}/{user_id}',[ProjectController::class,'risk_compliance_heatmap_by_service_and_component']);

Route::get('compliance_status/{proj_id}/{user_id}',[ProjectController::class,'compliance_status'])->name('compliance_status');

Route::get('download_excel_compliance_status/{proj_id}/{user_id}',[ProjectController::class,'download_excel_compliance_status']);

Route::post('duplicate_project/{proj_id}/{user_id}',[ProjectController::class,'duplicate_project']);

//ai wizard
route::get("ai_wizard/{proj_id}/{user_id}",[ProjectController::class,'ai_wizard'])->name('ai_wizard');
route::get('dashboard_services_and_components/{proj_id}/{user_id}',[ProjectController::class,'dashboard_services_and_components']);
route::get('services_controls_dashboard/{proj_id}/{user_id}/{s_name}',[ProjectController::class,'services_controls_dashboard']);
route::get('components_control_dashboard/{proj_id}/{user_id}/{s_name}',[ProjectController::class,'components_control_dashboard']);
route::get('risk_profile_graphical/{proj_id}/{user_id}',[ProjectController::class,'risk_profile_graphical']);
route::get("risk_computation/{proj_id}/{user_id}",[ProjectController::class,'risk_computation'])->name('risk_computation');




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

route::get('iso_sec_2_3_1_risk_selection/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_1_risk_selection'])->name('iso_sec_2_3_1_risk_selection');
route::put('iso_sec2_3_1_risk_selection/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'Risk_Selection_form_Submit']);
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
route::put('iso_sec_2_3_2_justification_form_submit/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_2_justification_form_submit']);



route::put('iso_sec_2_3_2_treat_form1_submit/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_2_treat_form1_submit']);
route::get('risk_treatment_edit_action_plan_form/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'risk_treatment_edit_action_plan_form'])->name('risk_treatment_edit_action_plan_form');
route::get('risk_treatment_justification/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'risk_treatment_justification'])->name('risk_treatment_justification');

route::post('iso_sec2_3_1_new/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec2_3_1_new']);

route::get('iso_sec_2_3_edit/{assessment_id}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit'])->name('iso_sec_2_3_edit');
route::post('iso_sec_2_3_new_asset_value/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_new_asset_value']);
route::put('iso_sec_2_3_edit_asset_value/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit_asset_value']);

route::get('iso_sec_2_3_table_insert/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_table_insert']);
route::post('iso_sec_2_3_table_submit/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_table_submit']);
route::get('iso_sec_2_3_edit_table/{asset_id}/{control_num}/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit_table']);
route::put('iso_sec_2_3_edit_table_submit/{proj_id}/{user_id}',[IsoSec2_3::class,'iso_sec_2_3_edit_table_submit']);

//ISO sec2.2

route::get('iso_section2_2_from_main/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_section2_2_from_main']);
route::get('iso_sec_2_2_evidence/{asset_id}/{proj_id}/{user_id}',[IsoSec2_2::class,'iso_sec_2_2_evidence'])->name('iso_sec_2_2_evidence');
route::get('iso_sec_2_2_subsections/{proj_id}/{user_id}/{asset_id}',[IsoSec2_2::class,'iso_sec_2_2_subsections'])->name('iso_sec_2_2_subsections');
route::get('iso_section2_2/{title_num}/{proj_id}/{user_id}/{asset_id}',[IsoSec2_2::class,'iso_section2_2'])->name('iso_sec_2_2_main');
route::get('iso_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}',[IsoSec2_2::class,'iso_sec_2_2_req'])->name('iso_sec_2_2_req');
route::get('iso_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[IsoSec2_2::class,'iso_sec2_2_sub_req_edit'])->name('iso_sec2_2_sub_req_edit');
route::post('iso_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[IsoSec2_2::class,'iso_sec_2_2_form']);
route::post('iso_sec_2_2_form_user_req/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[IsoSec2_2::class,'iso_sec_2_2_form_user_req']);


//PCI single sheet
route::get("pci_single_sheet_subsections/{proj_id}/{user_id}/{asset_id}",[PCI_Single_Sheet::class,'pci_single_sheet_subsections'])->name('pci_single_sheet_subsections');
route::get("pci_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[PCI_Single_Sheet::class,'pci_section_2_2'])->name('pci_section_2_2_main');
route::get("pci_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[PCI_Single_Sheet::class,'pci_sec_2_2_req'])->name('pci_sec_2_2_req');
route::get('pci_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Single_Sheet::class,'pci_sec2_2_sub_req_edit'])->name('pci_sec2_2_sub_req_edit');
route::post('pci_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Single_Sheet::class,'pci_sec_2_2_form']);
route::put('pci_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Single_Sheet::class,'pci_sec_2_2_edit_form']);


//PCI Multi sheet
route::get("pci_multi_sheet_subsections/{proj_id}/{user_id}/{asset_id}",[PCI_Multi_Sheet::class,'pci_multi_sheet_subsections'])->name('pci_multi_sheet_subsections');
route::get("pci_multi_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[PCI_Multi_Sheet::class,'pci_multi_section_2_2'])->name('pci_multi_section_2_2_main');
route::get("pci_multi_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[PCI_Multi_Sheet::class,'pci_multi_sec_2_2_req'])->name('pci_multi_sec_2_2_req');
route::get('pci_multi_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Multi_Sheet::class,'pci_multi_sec2_2_sub_req_edit'])->name('pci_multi_sec2_2_sub_req_edit');
route::post('pci_multi_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Multi_Sheet::class,'pci_multi_sec_2_2_form']);
//route::put('pci_multi_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Multi_Sheet::class,'pci_multi_sec_2_2_edit_form']);


//uae_ia
route::get("uae_ia_sheet_subsections/{proj_id}/{user_id}/{asset_id}",[UAE_IA::class,'uae_ia_sheet_subsections'])->name('uae_ia_sheet_subsections');
route::get("uae_ia_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[UAE_IA::class,'uae_ia_section_2_2'])->name('uae_ia_section_2_2');
route::get("uae_ia_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[UAE_IA::class,'uae_ia_sec_2_2_req'])->name('uae_ia_sec_2_2_req');
route::get('uae_ia_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[UAE_IA::class,'uae_ia_sec2_2_sub_req_edit'])->name('uae_ia_sec2_2_sub_req_edit');
route::post('uae_ia_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[UAE_IA::class,'uae_ia_sec_2_2_form']);




//CY SAMA
route::get("cy_sama_subsections/{proj_id}/{user_id}/{asset_id}",[CY_SAMA::class,'cy_sama_subsections'])->name('cy_sama_subsections');
route::get("cy_sama_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[CY_SAMA::class,'cy_sama_section_2_2'])->name('cy_sama_section_2_2');
route::get("cy_sama_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[CY_SAMA::class,'cy_sama_sec_2_2_req'])->name('cy_sama_sec_2_2_req');
route::get('cy_sama_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[CY_SAMA::class,'cy_sama_sec2_2_sub_req_edit'])->name('cy_sama_sec2_2_sub_req_edit');
route::post('cy_sama_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[CY_SAMA::class,'cy_sama_sec_2_2_form']);
route::put('cy_sama_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[CY_SAMA::class,'cy_sama_sec_2_2_edit_form']);

//for KSA NCA ECC
route::get("ksa_nca_sec_2_2_subsections/{proj_id}/{user_id}/{asset_id}",[KSA_NCA::class,'ksa_nca_subsections'])->name('ksa_nca_subsections');
route::get("ksa_nca_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[KSA_NCA::class,'ksa_nca_section_2_2'])->name('ksa_nca_section_2_2');
route::get("ksa_nca_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[KSA_NCA::class,'ksa_nca_sec_2_2_req'])->name('ksa_nca_sec_2_2_req');
route::get('ksa_nca_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'ksa_nca_sec2_2_sub_req_edit'])->name('ksa_nca_sec2_2_sub_req_edit');
route::post('ksa_nca_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'ksa_nca_sec_2_2_form']);
route::post('add_mandatory_all_title/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'add_mandatory_all_title'])->name('add_mandatory_all_title');
route::post('add_mandatory_all_domain/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'add_mandatory_all_domain'])->name('add_mandatory_all_domain');
route::post('add_mandatory_all_sub_req/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'add_mandatory_all_sub_req'])->name('add_mandatory_all_sub_req');

route::post('approve_sec_2_2/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'approve_sec_2_2']);
route::post('approve_sec_2_3_1/{control_num}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'approve_sec_2_3_1']);





//sbp etgrmf
route::get("sbp_etgrmf_subsections/{proj_id}/{user_id}/{asset_id}",[SBP_ETGRMF::class,'sbp_etgrmf_subsections'])->name('sbp_etgrmf_subsections');
route::get("sbp_etgrmf_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[SBP_ETGRMF::class,'sbp_etgrmf_section_2_2'])->name('sbp_etgrmf_section_2_2');
route::get("sbp_etgrmf_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[SBP_ETGRMF::class,'sbp_etgrmf_sec_2_2_req'])->name('sbp_etgrmf_sec_2_2_req');
route::get('sbp_etgrmf_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[SBP_ETGRMF::class,'sbp_etgrmf_sec2_2_sub_req_edit'])->name('sbp_etgrmf_sec2_2_sub_req_edit');
route::post('sbp_etgrmf_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[SBP_ETGRMF::class,'sbp_etgrmf_sec_2_2_form']);


//for merchant
route::get("pci_merchant_sheet_subsections/{proj_id}/{user_id}/{asset_id}",[PCI_Merchant_Sheet::class,'pci_merchant_sheet_subsections'])->name('pci_merchant_sheet_subsections');
route::get("pci_merchant_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[PCI_Merchant_Sheet::class,'pci_merchant_section_2_2'])->name('pci_merchant_section_2_2_main');
route::get("pci_merchant_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[PCI_Merchant_Sheet::class,'pci_merchant_sec_2_2_req'])->name('pci_merchant_sec_2_2_req');
route::get('pci_merchant_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Merchant_Sheet::class,'pci_merchant_sec2_2_sub_req_edit'])->name('pci_merchant_sec2_2_sub_req_edit');
route::post('pci_merchant_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Merchant_Sheet::class,'pci_merchant_sec_2_2_form']);
route::put('pci_merchant_sec_2_2_edit_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[PCI_Merchant_Sheet::class,'pci_merchant_sec_2_2_edit_form']);


//Compliance Map

route::get('compliance_map_dashboard_all_services/{proj_id}/{user_id}',[ComplianceMap::class,'compliance_map_dashboard_all_services'])->name('compliance_map_dashboard_all_services');

route::get('compliance_map_all_services/{proj_id}/{user_id}',[ComplianceMap::class,'compliance_map_all_services'])->name('compliance_map_all_services');


Route::get('download_excel_compliance_map/{proj_id}/{user_id}',[ComplianceMap::class,'download_excel_compliance_map']);



Route::get('select_assets_for_subdomain_map/{domain}/{proj_id}/{user_id}',[ComplianceMap::class,'select_assets_for_subdomain_map'])->name('select_assets_for_subdomain_map');

Route::get('/services/{domain}/{service}/{proj_id}', [ComplianceMap::class, 'getGroups'])->name('service.groups');
Route::get('/services/{domain}/{service}/{group}/{proj_id}', [ComplianceMap::class, 'getSubgroups'])->name('service.groups.subgroups');
Route::get('/services/{domain}/{service}/{group?}/{subgroup?}/{proj_id}', [ComplianceMap::class, 'getComponents'])->name('service.groups.subgroups.components');

Route::get('no_groups_for_compliance_map/{proj_id}/{service}/{domainName}/{domain}',[ComplianceMap::class,'no_groups_for_compliance_map'])->name('no_groups_for_compliance_map');

Route::get('service_subgroups_to_components/{domain}/{domainName}/{service}/{subgroup}/{proj_id}',[ComplianceMap::class,'service_subgroups_to_components'])->name('service_subgroups_to_components');

Route::get('compliance_map_subdomain/{domain}/{service}/{component}/{proj_id}',[ComplianceMap::class,'compliance_map_subdomain'])->name('compliance_map_subdomain');

Route::get('download_excel_compliance_map_subdomain/{proj_id}/{user_id}',[ComplianceMap::class,'download_excel_compliance_map_subdomain']);

Route::get('compliance_map_sub_req/{domain}/{service}/{component}/{proj_id}',[ComplianceMap::class,'compliance_map_sub_req'])->name('compliance_map_sub_req');

Route::get('download_excel_compliance_map_subreq/{proj_id}/{user_id}',[ComplianceMap::class,'download_excel_compliance_map_subreq']);


//Action Plan

Route::get('action_plan/{proj_id}/{user_id}',[ActionPlanController::class,'action_plan'])->name('action_plan');

Route::get('select_assets/{action_plan_type}/{proj_id}',[ActionPlanController::class,'select_assets'])->name('action_plan.select_assets');

Route::get('/action_plan_services/{service}/{proj_id}', [ActionPlanController::class, 'getGroups'])->name('action_plan.service.groups');



Route::get('action_plan_no_groups_for_compliance_map/{proj_id}/{service}',[ActionPlanController::class,'no_groups_for_compliance_map'])->name('action_plan_no_groups_for_compliance_map');

Route::get('/action_plan_services/{service}/{group}/{proj_id}', [ActionPlanController::class, 'getSubgroups'])->name('action_plan.service.groups.subgroups');


Route::get('action_plan_service_subgroups_to_components/{service}/{subgroup}/{proj_id}',[ActionPlanController::class,'service_subgroups_to_components'])->name('action_plan_service_subgroups_to_components');

Route::get('/action_plan_services_groups_subgroups/{service}/{group?}/{subgroup?}/{proj_id}', [ActionPlanController::class, 'getComponents'])->name('action_plan.service.groups.subgroups.components');

Route::get('action_plan_show/{service}/{component}/{proj_id}',[ActionPlanController::class,'action_plan_show'])->name('action_plan_show');


Route::get('action_plan_download/{proj_id}/{service}/{component}',[ActionPlanController::class,'action_plan_download'])->name('action_plan_download');


//RIsk Heatmap
route::get('heatmap_all_services_all_risks/{proj_id}/{user_id}',[RiskHeatmap::class,'heatmap_all_services_all_risks'])->name('heatmap_all_services_all_risks');
Route::get('heatmap_select_assets/{proj_id}',[RiskHeatmap::class,'select_assets'])->name('heatmap.select_assets');

Route::get('/heatmap_services/{service}/{proj_id}', [RiskHeatmap::class, 'getGroups'])->name('heatmap.service.groups');


Route::get('heatmap_no_groups_for_compliance_map/{proj_id}/{service}',[RiskHeatmap::class,'no_groups_for_compliance_map'])->name('heatmap_no_groups_for_compliance_map');

Route::get('/heatmap_services/{service}/{group}/{proj_id}', [RiskHeatmap::class, 'getSubgroups'])->name('heatmap.service.groups.subgroups');


Route::get('heatmap_service_subgroups_to_components/{service}/{subgroup}/{proj_id}',[RiskHeatmap::class,'service_subgroups_to_components'])->name('heatmap_service_subgroups_to_components');

Route::get('/heatmap_services_groups_subgroups/{service}/{group?}/{subgroup?}/{proj_id}', [RiskHeatmap::class, 'getComponents'])->name('heatmap.service.groups.subgroups.components');

Route::get('heatmap_single_risk/{service}/{component}/{proj_id}',[RiskHeatmap::class,'heatmap_single_risk'])->name('heatmap_single_risk');

Route::get('risk_register_single_type/{service}/{component}/{proj_id}',[RiskHeatmap::class,'risk_register_single_type'])->name('risk_register_single_type');

Route::get('download_excel_risk_register_single_type/{service}/{component}/{proj_id}',[RiskHeatmap::class,'download_excel_risk_register_single_type'])->name('download_excel_risk_register_single_type');


Route::get('user_action_all_projects_in_org/{org_id}',[OrganizationController::class,'user_action_all_projects_in_org']);
Route::get('projects_created_by/{org_id}/{user_id}',[OrganizationController::class,'projects_created_by']);
Route::get('projects_assigned/{org_id}/{user_id}',[OrganizationController::class,'projects_assigned']);
Route::get('user_actions_on_project/{proj_id}/{user_id}',[ProjectController::class,'user_actions_on_project']);



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
