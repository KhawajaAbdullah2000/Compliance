<?php

use App\Http\Controllers\ActionPlanController;
use App\Http\Controllers\Cobit;
use App\Http\Controllers\ComplianceMap;
use App\Http\Controllers\CY_SAMA;
use App\Http\Controllers\DataGovernanceController;
use App\Http\Controllers\InternalAudit;
use App\Http\Controllers\RiskHeatmap;
use App\Http\Controllers\UAE_IA;
use App\Http\Controllers\UserController;

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SuperUserController;
use App\Http\Controllers\EndUserController;
use App\Http\Controllers\ISAController;
use App\Http\Controllers\IsoSec2_1;
use App\Http\Controllers\IsoSec2_2;
use App\Http\Controllers\IsoSec2_3;
use App\Http\Controllers\IsoSec2_3_1;
use App\Http\Controllers\IsoSec2_4_A5;
use App\Http\Controllers\IsoSec2_4_A6;
use App\Http\Controllers\IsoSec2_4_A7;
use App\Http\Controllers\IsoSec2_4_A8;
use App\Http\Controllers\KSA_NCA;
use App\Http\Controllers\OrgAssets;
use App\Http\Controllers\PCI_Merchant_Sheet;
use App\Http\Controllers\PCI_Multi_Sheet;
use App\Http\Controllers\PCI_Single_Sheet;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RiskManagementFramework;
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
Route::get('add_department/{id}',[OrganizationController::class,'add_department']);
Route::post('add_new_dept/{id}',[OrganizationController::class,'add_new_dept']);
Route::get('departments/{id}',[OrganizationController::class,'departments'])->name('departments');

Route::get('add_user',[UserController::class,'add_user'])->name('add_user');
Route::get('add_new_user/{id}',[UserController::class,'add_new_user'])->name('add_new_user');
Route::post('add_new_user',[UserController::class,'register_new_user']);
Route::get('users',[UserController::class,'users'])->name('users');
Route::get('users/edit/{id}',[UserController::class,'user_edit_view']);
Route::post('users/edit/{id}',[UserController::class,'user_edit']);
Route::get('delete_user/{id}',[UserController::class,'delete_user']);


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
Route::get('/end_user/delete/{id}',[SuperUserController::class,'delete_enduser']);

route::put('/edit_enduser/{id}',[SuperUserController::class,'edit_enduser_form_submit']);
route::get('/custom_roles',[SuperUserController::class,'custom_roles'])->name('custom_roles');
route::get('add_global_role',function(){
    return view('user.add_global_role');
});
route::post('add_new_role',[SuperUserController::class,'add_new_role'])->name('add_new_role');
route::get('/edit_global_role/{id}',[SuperUserController::class,'edit_global_role']);
route::put('edit_globalrole/{id}',[SuperUserController::class,'edit_globalrole']);

route::get('select_projects_for_framework/{org_id}',[RiskManagementFramework::class,'select_projects_for_framework']);
route::get('selected_projects_for_framework/{org_id}',[RiskManagementFramework::class,'selected_projects_for_framework']);
route::post('selected_project_and_framework/{org_id}',[RiskManagementFramework::class,'selected_project_and_framework']);
route::post('selected_framework_approach/{org_id}',[RiskManagementFramework::class,'selected_framework_approach']);

route::get('qualititave_likelihood_scale/{org_id}',[RiskManagementFramework::class,'qualititave_likelihood_scale']);
route::get('qualitative_info_security_risk_criteria/{org_id}',[RiskManagementFramework::class,'qualitative_info_security_risk_criteria']);
route::post('qualitative_risk_acceptance_criteria/{org_id}',[RiskManagementFramework::class,'qualitative_risk_acceptance_criteria']);
route::post('risk_assessment_approach/{org_id}',[RiskManagementFramework::class,'risk_assessment_approach']);
route::post('quantitave_consequence_scale/{org_id}',[RiskManagementFramework::class,'quantitave_consequence_scale']);
route::get('quantitative_risk_acceptance/{org_id}',[RiskManagementFramework::class,'quantitative_risk_acceptance']);
route::post('save_risk_acceptance_quantitative/{org_id}',[RiskManagementFramework::class,'save_risk_acceptance_quantitative']);




route::get('select_assets/{org_id}',[OrgAssets::class,'select_assets'])->name('select_assets');
route::get('add_new_category_in_org/{org_id}',[OrgAssets::class,'add_new_category_in_org']);
route::post('add_new_asset_category/{org_id}',[OrgAssets::class,'add_new_asset_category']);
route::post('add_asset_categories_in_org/{org_id}',[OrgAssets::class,'add_asset_categories_in_org']);
route::get('edit_custom_category/{category_id}',[OrgAssets::class,'edit_custom_category']);
route::put('update_asset_category/{category_id}',[OrgAssets::class,'update_asset_category']);
route::delete('delete_custom_category/{category_id}',[OrgAssets::class,'delete_custom_category']);

route::get('select_asset_types_for_category/{category_id}',[OrgAssets::class,'select_asset_types_for_category'])->name('select_asset_types_for_category');
route::get('add_new_asset_type_in_org/{org_id}/{category_id}',[OrgAssets::class,'add_new_asset_type_in_org']);
route::post('add_new_asset_type/{org_id}/{category_id}',[OrgAssets::class,'add_new_asset_type']);
route::post('add_asset_types_in_org/{org_id}/{category_id}',[OrgAssets::class,'add_asset_types_in_org']);
route::get('edit_custom_asset_type/{category_id}',[OrgAssets::class,'edit_custom_asset_type']);
route::put('update_asset_type/{category_id}',[OrgAssets::class,'update_asset_type']);

route::delete('delete_custom_asset_type/{category_id}',[OrgAssets::class,'delete_custom_asset_type']);






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

route::get('generate_pdf',[InternalAudit::class,'generate_pdf']);

//Internal Audit
route::get('internal_audit_level_1/{level_num}/{proj_id}/{user_id}',[InternalAudit::class,'internal_audit_level_1'])->name('internal_audit_level_1');
//route::get('internal_audit_level_2/{level1_num}/{level2_num}/{proj_id}/{user_id}',[InternalAudit::class,'internal_audit_level_2'])->name('internal_audit_level_2');
route::post('audit_strategy_department/{proj_id}/{user_id}',[InternalAudit::class,'audit_strategy_department']);
route::get('select_internal_audit_fields_for_report/{interal_audit_strategy_id}/{proj_id}/{user_id}',[InternalAudit::class,'select_internal_audit_fields_for_report']);
route::get('select_risk_based_plan_audit_for_report/{role_based_plan_id}/{proj_id}/{user_id}',[InternalAudit::class,'select_risk_based_plan_audit_for_report']);

route::post('select_fields_generate_report/{strategy_id}/{proj_id}/{user_id}',[InternalAudit::class,'select_fields_generate_report']);
route::post('submit_strategy_time_period/{proj_id}/{user_id}',[InternalAudit::class,'submit_strategy_time_period']);
route::post('submit_risk_based_plan_audit/{proj_id}/{user_id}',[InternalAudit::class,'submit_risk_based_plan_audit']);

route::get('audit_universe/{risk_based_plan_id}/{proj_id}/{user_id}',[InternalAudit::class,'audit_universe'])->name('audit_universe');
route::get('audit_universe_risk_assessment/{risk_based_plan_id}/{proj_id}/{user_id}',[InternalAudit::class,'audit_universe_risk_assessment'])->name('audit_universe_risk_assessment');

route::get('add_new_audit_universe_form/{risk_based_plan_id}/{proj_id}/{user_id}',[InternalAudit::class,'add_new_audit_universe_form']);
route::post('save_audit_universe/{risk_based_plan_id}/{proj_id}/{user_id}',[InternalAudit::class,'save_audit_universe']);
route::get('edit_audit_universe/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'edit_audit_universe']);
route::post('submit_audit_universe_edit/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'submit_audit_universe_edit']);
route::get('delete_audit_universe/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'delete_audit_universe']);
route::get('data_records/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'data_records'])->name('data_records');
route::get('data_records_risk_assessment/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'data_records_risk_assessment'])->name('data_records_risk_assessment');




route::get('add_new_data_record_form/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'add_new_data_record_form']);
route::post('save_data_record/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'save_data_record']);

route::get('edit_data_record/{data_record_id}/{proj_id}/{user_id}',[InternalAudit::class,'edit_data_record']);
route::post('update_data_record/{data_record_id}/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'update_data_record']);
route::get('delete_data_record/{data_record_id}/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'delete_data_record']);
route::get('attachments_data_record/{data_record_id}/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'attachments_data_record'])->name('attachments_data_record');
route::get('attachments_data_record_risk_assessment/{data_record_id}/{unit_id}/{proj_id}/{user_id}',[InternalAudit::class,'attachments_data_record_risk_assessment'])->name('attachments_data_record_risk_assessment');

route::get('risk_assessment_start_testing/{data_record_id}/{proj_id}/{user_id}',[InternalAudit::class,'risk_assessment_start_testing'])->name('risk_assessment_start_testing');



route::post('upload_data_record_attachments/{data_record_id}/{proj_id}/{user_id}',[InternalAudit::class,'upload_data_record_attachments']);
route::delete('delete_record_attachment/{file_id}',[InternalAudit::class,'delete_record_attachment']);

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


//Data GOvernance
route::get('data_catalog_sections/{proj_id}/{user_id}',[DataGovernanceController::class,'data_catalog_sections'])->name('data_catalog_sections');

route::get('data_catalog_list/{proj_id}/{user_id}',[DataGovernanceController::class,'data_catalog_list'])->name('data_catalog_list');
route::get('data_catalog_new/{proj_id}/{user_id}',[DataGovernanceController::class,'data_catalog_new']);
route::post('new_data_catalog_submit/{proj_id}/{user_id}',[DataGovernanceController::class,'new_data_catalog_submit']);
route::get('delete_data_catalog/{catalog_id}/{proj_id}/{user_id}',[DataGovernanceController::class,'delete_data_catalog']);
route::get('datasets_list/{catalog_id}/{proj_id}/{user_id}',[DataGovernanceController::class,'datasets_list'])->name('datasets_list');
route::get('dataset_attributes/{catalog_id}/{proj_id}/{user_id}',[DataGovernanceController::class,'dataset_attributes']);
route::post('dataset_attributes_submit/{proj_id}/{user_id}',[DataGovernanceController::class,'dataset_attributes_submit']);
route::get('delete_dataset/{dataset_id}/{catalog_id}/{proj_id}/{user_id}',[DataGovernanceController::class,'delete_dataset']);
Route::get('/edit_dataset/{dataset_id}/{catalog_id}/{project_id}/{user_id}', [DataGovernanceController::class, 'edit_dataset_form']);
route::post('update_dataset/{dataset_id}/{proj_id}/{user_id}',[DataGovernanceController::class,'update_dataset']);
route::get('calculate_quality_score/{catalog_id}/{proj_id}/{user_id}',[DataGovernanceController::class,'calculate_quality_score']);
route::get('dama_main_policies/{proj_id}/{user_id}',[DataGovernanceController::class,'dama_main_policies'])->name('dama_main_policies');
route::get('dama_main_section/{policy_num}/{proj_id}/{user_id}',[DataGovernanceController::class,'dama_main_section'])->name('dama_main_section');
route::post('dama_kpi_submit/{proj_id}/{user_id}',[DataGovernanceController::class,'dama_kpi_submit']);
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
Route::get('/get-asset-types/{category_id}', [IsoSec2_1::class, 'getAssetTypes']);

//copy assets gage to open the services of the selected project
route::get("copy_assets/{proj_id}/{user_id}",[IsoSec2_1::class,'ShowServices'])->name('services');
//show asset groups of those services
route::post('show_groups',[IsoSec2_1::class,'ShowGroups'])->name('show_groups');
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
route::get("iso_27005_risk_assessment/{proj_id}/{user_id}/{asset_id}",[IsoSec2_3_1::class,'iso_27005_risk_assessment'])->name('iso_27005_risk_assessment');
route::get("iso_27005_risk_assessment_qual_event/{proj_id}/{user_id}",[IsoSec2_3_1::class,'iso_27005_risk_assessment_qual_event'])->name('iso_27005_risk_assessment_qual_event');
route::post('save_likelihood_qual_event_form/{proj_id}/{user_id}',[IsoSec2_3_1::class,'save_likelihood_qual_event_form']);

//IOS 27005 quality Asset based
route::get("target_objective_of_risk_source/{proj_id}/{user_id}/{asset_id}/{g_risk_source_num}",[IsoSec2_3_1::class,'target_objective_of_risk_source']);
route::get('target_objective_of_risk_source_qual_event/{proj_id}/{user_id}/{g_risk_source_num}',[IsoSec2_3_1::class,'target_objective_of_risk_source_qual_event']);

route::get("threat_posed_by_risk_source/{proj_id}/{user_id}/{asset_id}/{g_risk_source_num}",[IsoSec2_3_1::class,'threat_posed_by_risk_source']);
route::get('threat_posed_by_risk_source_qual_event/{proj_id}/{user_id}/{g_risk_source_num}',[IsoSec2_3_1::class,'threat_posed_by_risk_source_qual_event']);
route::post('proj_asset_threat_desc_selected/{proj_id}/{user_id}/{asset_id}/{g_risk_source_num}',[IsoSec2_3_1::class,'proj_asset_threat_desc_selected']);
route::post('proj_asset_threat_desc_selected_qual_event/{proj_id}/{user_id}/{g_risk_source_num}',[IsoSec2_3_1::class,'proj_asset_threat_desc_selected_qual_event']);

route::get("select_vul_for_control/{proj_id}/{user_id}/{asset_id}/{control_num}",[IsoSec2_3_1::class,'select_vul_for_control'])->name('select_vul_for_control');
route::get("select_vul_for_control_qual_event/{proj_id}/{user_id}/{control_num}",[IsoSec2_3_1::class,'select_vul_for_control_qual_event'])->name('select_vul_for_control_qual_event');

route::post('proj_asset_selected_vulnerability_descriptions/{proj_id}/{user_id}/{asset_id}/{control_num}',[IsoSec2_3_1::class,'proj_asset_selected_vulnerability_descriptions']);
route::get('iso_sec_2_3_1_risk_selection_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_1_risk_selection_qual_event'])->name('iso_sec2_3_1_risk_selection_qual_event');
//ISO 27005 Qualitative Event based
route::get('initiaite_risk_assessment_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'initiaite_risk_assessment_qual_event'])->name('initiaite_risk_assessment_qual_event');

route::get('new_party/{proj_id}/{user_id}',[IsoSec2_3_1::class,'new_party']);
route::post('submit_new_party/{proj_id}/{user_id}',[IsoSec2_3_1::class,'submit_new_party']);
route::get('edit_party/{party_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'edit_party']);
route::put('edit_party_submit/{party_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'edit_party_submit']);
route::get('delete_party/{party_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'delete_party']);

route::get('iso_sec_2_3_1_qual_event_scenarios/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_sec_2_3_1_qual_event_scenarios'])->name('iso_sec_2_3_1_qual_event_scenarios');
route::get('qual_event_add_scenario_form/{proj_id}/{user_id}',[IsoSec2_3_1::class,'qual_event_add_scenario_form']);
route::post('submit_new_scenario/{proj_id}/{user_id}',[IsoSec2_3_1::class,'submit_new_scenario']);
route::get('strategic_scenarios/{party_id}/{risk_type}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'strategic_scenarios'])->name('strategic_scenarios');
route::post('party_strategic_scenario_submit/{proj_id}/{user_id}',[IsoSec2_3_1::class,'party_strategic_scenario_submit']);
route::get('delete_strategic_scenario/{scenario_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'delete_strategic_scenario']);

route::post('proj_assets_selected_risk_source_and_target/{proj_id}/{user_id}/{asset_id}/{g_risk_source_num}',[IsoSec2_3_1::class,'proj_assets_selected_risk_source_and_target']);
route::post('proj_selected_risk_source_and_target_qual_event/{proj_id}/{user_id}/{g_risk_source_num}',[IsoSec2_3_1::class,'proj_selected_risk_source_and_target_qual_event']);
route::post('proj_assets_level_of_threat/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'proj_assets_level_of_threat']);
route::post('proj_assets_level_of_threat_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'proj_assets_level_of_threat_qual_event']);


route::get('route_for_risk_source/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'route_for_risk_source'])->name('route_for_risk_source');

route::get('route_for_risk_source_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'route_for_risk_source_qual_event'])->name('route_for_risk_source_qual_event');
route::post('iso_27005_submit_risk_assessment/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'iso_27005_submit_risk_assessment']);
route::post('iso_27005_submit_risk_assessment_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_27005_submit_risk_assessment_qual_event']);
route::get('ai_input_submit_risk_assessment_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'ai_input_submit_risk_assessment_qual_event']);


route::post('proj_asset_selected_level_of_vulnerability/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'proj_asset_selected_level_of_vulnerability']);
route::post('proj_asset_selected_level_of_vulnerability_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'proj_asset_selected_level_of_vulnerability_qual_event']);


route::get('add_scenario_form/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'add_scenario_form'])->name('add_scenario_form');
route::get('add_scenario_form_qual_event/{proj_id}/{user_id}/{risk_type}',[IsoSec2_3_1::class,'add_scenario_form_qual_event'])->name('add_scenario_form_qual_event');


route::get('add_risk_scenario/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'add_risk_scenario']);
route::post('proj_asset_risk_scenario/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'proj_asset_risk_scenario']);
route::get('iso_27005_likelihood_value/{proj_id}/{user_id}/{asset_id}/{risk_type?}',[IsoSec2_3_1::class,'iso_27005_likelihood_value'])->name('iso_27005_likelihood_value');
route::get('iso_27005_likelihood_value_qual_event/{proj_id}/{user_id}',[IsoSec2_3_1::class,'iso_27005_likelihood_value_qual_event'])->name('iso_27005_likelihood_value_qual_event');


route::post('qualitative_asset_likelihood_confidentiality_timeframe/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'qualitative_asset_likelihood_confidentiality_timeframe']);
route::post('save_likelihood_value/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'save_likelihood_value']);


route::get('likelihood_and_consequence/{risk_type}/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'likelihood_and_consequence'])->name('likelihood_and_consequence');

route::get('iso_27005_likelihood_value_all/{proj_id}/{user_id}/{asset_id}',[IsoSec2_3_1::class,'iso_27005_likelihood_value_all'])->name('iso_27005_likelihood_value_all');


route::Post('quantitave_consequence_scale_amount_entered/{asset_id}/{proj_id}/{user_id}',[IsoSec2_3_1::class,'quantitave_consequence_scale_amount_entered']);



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

//COBIT
route::get("cobit_subsections/{proj_id}/{user_id}/{asset_id}",[Cobit::class,'cobit_subsections'])->name('cobit_subsections');
route::get("cobit_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[Cobit::class,'cobit_section_2_2'])->name('cobit_section_2_2');
route::get("cobit_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[Cobit::class,'cobit_sec_2_2_req'])->name('cobit_sec_2_2_req');
route::get('cobit_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[Cobit::class,'cobit_sec2_2_sub_req_edit'])->name('cobit_sec2_2_sub_req_edit');
route::post('cobit_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[Cobit::class,'cobit_sec_2_2_form']);


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
route::get('ksa_nca_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}/{main_req?}',[KSA_NCA::class,'ksa_nca_sec2_2_sub_req_edit'])->name('ksa_nca_sec2_2_sub_req_edit');
route::post('ksa_nca_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'ksa_nca_sec_2_2_form']);
route::post('add_mandatory_all_title/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'add_mandatory_all_title'])->name('add_mandatory_all_title');
route::post('add_mandatory_all_domain/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'add_mandatory_all_domain'])->name('add_mandatory_all_domain');
route::post('add_mandatory_all_sub_req/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'add_mandatory_all_sub_req'])->name('add_mandatory_all_sub_req');

route::post('approve_sec_2_2/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'approve_sec_2_2']);
route::post('approve_sec_2_3_1/{control_num}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'approve_sec_2_3_1']);
route::post('approve_risk_treatment/{control_num}/{proj_id}/{user_id}/{asset_id}',[KSA_NCA::class,'approve_risk_treatment']);


//ISA 62443
route::get("isa_sec_2_2_subsections/{proj_id}/{user_id}/{asset_id}",[ISAController::class,'isa_subsections'])->name('isa_subsections');
route::get("isa_section_2_2/{title_num}/{proj_id}/{user_id}/{asset_id}",[ISAController::class,'isa_section_2_2'])->name('isa_section_2_2');
route::get("isa_sec_2_2_req/{main_req_num}/{title}/{proj_id}/{user_id}/{asset_id}",[ISAController::class,'isa_sec_2_2_req'])->name('isa_sec_2_2_req');
route::get('isa_sec2_2_sub_req_edit/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[ISAController::class,'isa_sec2_2_sub_req_edit'])->name('isa_sec2_2_sub_req_edit');
route::post('isa_sec_2_2_form/{sub_req}/{title}/{proj_id}/{user_id}/{asset_id}',[ISAController::class,'isa_sec_2_2_form']);





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

route::get('heatmap_select_services_and_risks/{proj_id}/{user_id}',[RiskHeatmap::class,'heatmap_select_services_and_risks'])->name('heatmap_select_services_and_risks');
route::get('heatmap_all_services_all_risks/{proj_id}/{user_id}',[RiskHeatmap::class,'heatmap_all_services_all_risks'])->name('heatmap_all_services_all_risks');
Route::get('heatmap_select_assets/{proj_id}',[RiskHeatmap::class,'select_assets'])->name('heatmap.select_assets');

Route::get('/heatmap_services/{service}/{proj_id}', [RiskHeatmap::class, 'getGroups'])->name('heatmap.service.groups');


Route::get('heatmap_no_groups_for_compliance_map/{proj_id}/{service}',[RiskHeatmap::class,'no_groups_for_compliance_map'])->name('heatmap_no_groups_for_compliance_map');

Route::get('/heatmap_services/{service}/{group}/{proj_id}', [RiskHeatmap::class, 'getSubgroups'])->name('heatmap.service.groups.subgroups');


Route::get('heatmap_service_subgroups_to_components/{service}/{subgroup}/{proj_id}',[RiskHeatmap::class,'service_subgroups_to_components'])->name('heatmap_service_subgroups_to_components');

Route::get('/heatmap_services_groups_subgroups/{service}/{group?}/{subgroup?}/{proj_id}', [RiskHeatmap::class, 'getComponents'])->name('heatmap.service.groups.subgroups.components');

// Route::get('heatmap_single_risk/{service}/{component}/{proj_id}',[RiskHeatmap::class,'heatmap_single_risk'])->name('heatmap_single_risk');
Route::get('heatmap_single_risk/{proj_id}',[RiskHeatmap::class,'heatmap_single_risk'])->name('heatmap_single_risk');

Route::get('risk_register_single_type/{service}/{component}/{proj_id}',[RiskHeatmap::class,'risk_register_single_type'])->name('risk_register_single_type');

Route::get('download_excel_risk_register_single_type/{service}/{component}/{proj_id}',[RiskHeatmap::class,'download_excel_risk_register_single_type'])->name('download_excel_risk_register_single_type');


Route::get('user_action_all_projects_in_org/{org_id}',[OrganizationController::class,'user_action_all_projects_in_org']);
Route::get('projects_created_by/{org_id}/{user_id}',[OrganizationController::class,'projects_created_by']);
Route::get('projects_assigned/{org_id}/{user_id}',[OrganizationController::class,'projects_assigned']);
Route::get('user_actions_on_project/{proj_id}/{user_id}',[ProjectController::class,'user_actions_on_project']);
Route::get('total_activities_on_project_sec_2_2/{proj_id}/{user_id}',[ProjectController::class,'total_activities_on_project_sec_2_2']);
Route::get('total_activities_on_project/{proj_id}/{user_id}',[ProjectController::class,'total_activities_on_project']);
Route::get('total_activities_on_project_sec_2_3_1/{proj_id}/{user_id}',[ProjectController::class,'total_activities_on_project_sec_2_3_1']);

Route::get('compliances_all_projects_in_org/{org_id}',[ComplianceMap::class,'compliances_all_projects_in_org']);

Route::get('action_plan_all_projects_in_org/{org_id}',[ActionPlanController::class,'action_plan_all_projects_in_org']);
Route::get('all_projects_action_plan/{risk_type}/{org_id}',[ActionPlanController::class,'all_projects_action_plan']);
Route::get('all_projects_action_plan_download/{risk_type}/{org_id}',[ActionPlanController::class,'all_projects_action_plan_download']);




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
