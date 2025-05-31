<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use App\Models\User;
use App\Exports\AssetCategoryExport;


class IsoSec2_1 extends Controller
{
    public function iso_section2_1($proj_id, $user_id)
    {
        
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {



$data = DB::table('iso_sec_2_1')
    ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
    ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
    ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
    ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
    ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
    ->select(
        'iso_sec_2_1.*',
        DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
        DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
        DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
        DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
        DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name")
    )
    ->where('project_id', $proj_id)
    ->get();

  
         

                 $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();
            

    


                $frameworkDetails = $this->getProjectFrameworkDetails($project);

          

                    $org_projects=Db::table('projects')->where('org_id',auth()->user()->org_id)
                    ->where('project_id','!=',$proj_id)->get();

                    $distinctServices= DB::table('iso_sec_2_1')
                    ->select('iso_sec_2_1.s_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.s_name')
                     // Ensures distinct s_name values
                    ->get();

                    $distinctGroups= DB::table('iso_sec_2_1')
                    ->select('iso_sec_2_1.g_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.g_name')
                    ->get();

                    $distinctAssets= DB::table('iso_sec_2_1')
                    ->select('iso_sec_2_1.name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.name')
                    ->get();


                    $distinctComponents= DB::table('iso_sec_2_1')
                    ->select('iso_sec_2_1.c_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.c_name')
                    ->get();


        


                    return view('iso_sec_2_1.iso_sec_2_1_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project,
                        'org_projects'=>$org_projects,
                        'distinctServices'=>$distinctServices,
                        'distinctGroups'=>$distinctGroups,
                        'distinctAssets'=>$distinctAssets,
                        'distinctComponents'=>$distinctComponents,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                    ]);

            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_section2_3($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {

                if ($checkpermission->type_id == 4) {
                    $data = DB::table('iso_sec_2_1')->join(
                        'users',
                        'iso_sec_2_1.last_edited_by',
                        'users.id'
                    )
                        ->where('project_id', $proj_id)->get();


                 $project=Project::join('project_types','projects.project_type','project_types.id')
                 ->where('projects.project_id',$proj_id)->first();


                 $org_projects=Db::table('projects')->where('org_id',auth()->user()->org_id)
                 ->where('project_id','!=',$proj_id)->get();

                 $distinctServices= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.s_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.s_name')
                     // Ensures distinct s_name values
                    ->get();

                    $distinctGroups= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.g_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.g_name')
                    ->get();

                    $distinctAssets= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.name')
                    ->get();


                    $distinctComponents= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.c_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.c_name')
                    ->get();


                    return view('iso_sec_2_1.iso_sec_2_3_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project,
                        'org_projects'=>$org_projects,
                        'distinctServices'=>$distinctServices,
                        'distinctGroups'=>$distinctGroups,
                        'distinctAssets'=>$distinctAssets,
                        'distinctComponents'=>$distinctComponents
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function risk_treatment($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                    $data = DB::table('iso_sec_2_1')->join(
                        'users',
                        'iso_sec_2_1.last_edited_by',
                        'users.id'
                    )
                        ->where('project_id', $proj_id)->get();


                 $project=Project::join('project_types','projects.project_type','project_types.id')
                 ->where('projects.project_id',$proj_id)->first();

                    return view('risk_treatment.serviceslist', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project
                    ]);
                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function new_iso_sec_2_1(Request $req, $proj_id, $user_id)
    {
      
        $req->validate(
            [
                'g_name'=>'required',
                'name'=>'required',
                's_name' => 'required|string',
               'c_name' => 'required|array|min:1',
               'c_name.*' => 'required|string|max:255'
            ],
            [ 
                    '*.required' => 'This field is required',
                    'c_name.min' => 'You must add at least one component.',
                    'c_name.*.required' => 'Need atleast 1 component',
                
            ]
        );

     


        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {

                        try {

                            foreach ($req->c_name as $component) {

                                $assessment_id = Db::table('iso_sec_2_1')->insertGetId([
                                'project_id' => $proj_id,
                                'g_name' => $req->g_name,
                                'name' => $req->name,
                                'c_name' => $component,
                                'owner_dept' => $req->owner_dept,
                                'physical_loc' => $req->physical_loc,
                                'logical_loc' => $req->logical_loc,
                                's_name' => $req->s_name,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'service_risk_owner'=>$req->service_risk_owner,
                                'component_risk_owner'=>$req->component_risk_owner,
                                'service_custodian'=>$req->service_custodian,
                                'component_custodian'=>$req->component_custodian
                            ]);

                            Db::table('audit_trail_for_services')->insert([
                                'asset_id' => $assessment_id,
                                'project_id' => $proj_id,
                                'last_edited_by' => $user_id,
                                'operation_type' => 'insert',
                                'g_name' => $req->g_name,
                                'name' => $req->name,
                                'c_name' => $component,
                                's_name' => $req->s_name,
                                'owner_dept' => $req->owner_dept,
                                'physical_loc' => $req->physical_loc,
                                'logical_loc' => $req->logical_loc,
                                'risk_confidentiality' => 10,
                                'risk_integrity' => 10,
                                'risk_availability' => 10,
                                'performed_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        }



                        } catch (\Exception $e) {
                            $error=$e->getMessage();
                        
                            return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('error', $error);

                        }


                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');

                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_1_new($proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {

                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();


                        $selectedCategories=DB::table('org_assets_categories')
                        ->join('global_asset_categories','org_assets_categories.asset_category_selected','global_asset_categories.asset_category_id')
                        ->where('org_assets_categories.org_id',auth()->user()->organization->id)
                        ->get();
                       // dd($selectedCategories);

                         $frameworkDetails = $this->getProjectFrameworkDetails($project);

                           $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

        //superusers of that organization
        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
      

        //organziatons of those superusers
        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);
          
    
                        return view('iso_sec_2_1.iso_sec_2_1_new', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'project'=>$project,
                            'selectedCategories'=>$selectedCategories,
                            'complianceFramework'=>$frameworkDetails['complianceFramework'],
                            'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                            'framework_approach'=>$frameworkDetails['framework_approach'],
                            'users'=>$users

                        ]);

                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function getAssetTypes($category_id)
{
    $types = DB::table('global_asset_types')
    ->join('org_assets_types','global_asset_types.asset_type_id','org_assets_types.asset_type_selected')
    ->join('global_asset_categories','global_asset_types.asset_category','global_asset_categories.asset_category_id')
    ->where('org_assets_types.org_id',auth()->user()->organization->id)
        ->where('global_asset_categories.asset_category', $category_id)
        ->get();


    return response()->json($types);
}


    public function iso_sec_2_1_edit($assessment_id, $proj_id, $user_id)
    {
    
      
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                   
                        $data = Db::table('iso_sec_2_1')->where('assessment_id', $assessment_id)->where('project_id', $proj_id)->first();
                 
                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();

                        $selectedCategories=DB::table('org_assets_categories')
                        ->join('global_asset_categories','org_assets_categories.asset_category_selected','global_asset_categories.asset_category_id')
                        ->where('org_assets_categories.org_id',auth()->user()->organization->id)
                        ->get();

                        $selected_type= Db::table('iso_sec_2_1')->where('assessment_id', $assessment_id)->where('project_id', $proj_id)->first();

                           $frameworkDetails = $this->getProjectFrameworkDetails($project);

                            $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

        //superusers of that organization
        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
      

        //organziatons of those superusers
        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);
          
                  
      
                        return view('iso_sec_2_1.iso_sec_2_1_edit', [
                            'data' => $data,
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'project'=>$project,
                            'selectedCategories'=>$selectedCategories,
                            'selected_type'=>$selected_type->name,
                            'selected_category'=>$selected_type->g_name,
                            'complianceFramework'=>$frameworkDetails['complianceFramework'],
                            'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                            'framework_approach'=>$frameworkDetails['framework_approach'],
                            'users'=>$users
                        ]);
                    
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_1_submit_edit(Request $req, $assessment_id, $proj_id, $user_id)
    {
       

        $req->validate(
            [
                's_name' => 'required|string',
               'c_name' => 'required',
               
            ],
            [
                '*.required' => 'This field is required',

            ]
        );


        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {

                    try{
                   
                        Db::table('iso_sec_2_1')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                        ->update([
                            'project_id' => $proj_id,
                            'g_name' => $req->g_name,
                            'name' => $req->name,
                            'c_name' => $req->c_name,
                            'owner_dept' => $req->owner_dept,
                            'physical_loc' => $req->physical_loc,
                            'logical_loc' => $req->logical_loc,
                            's_name' => $req->s_name,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                             'service_risk_owner'=>$req->service_risk_owner,
                                'component_risk_owner'=>$req->component_risk_owner,
                                'service_custodian'=>$req->service_custodian,
                                'component_custodian'=>$req->component_custodian
                        ]);

                        Db::table('audit_trail_for_services')->insert([
                            'asset_id' => $assessment_id,
                            'project_id' => $proj_id,
                            'last_edited_by' => $user_id,
                            'operation_type' => 'update',
                            'g_name' => $req->g_name,
                            'name' => $req->name,
                            'c_name' => $req->c_name,
                            's_name' => $req->s_name,
                            'owner_dept' => $req->owner_dept,
                            'physical_loc' => $req->physical_loc,
                            'logical_loc' => $req->logical_loc,
                            'risk_confidentiality' => 10,
                            'risk_integrity' => 10,
                            'risk_availability' => 10,
                            'performed_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);


                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Updated successfully');
                    }catch (\Exception $e) {
                        $error=$e->getMessage();
                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('error', $error);

                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_1_delete($assessment_id,$proj_id,$user_id){
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {

                    $asset=Db::table('iso_sec_2_1')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->first();
                    
                    
                    Db::table('audit_trail_for_services')->insert([
                        'asset_id' => $assessment_id,
                        'project_id' => $proj_id,
                        'last_edited_by' => $user_id,
                        'operation_type' => 'delete',
                        'g_name' => $asset->g_name,
                        'name' => $asset->name,
                        'c_name' => $asset->c_name,
                        's_name' => $asset->s_name,
                        'owner_dept' => $asset->owner_dept,
                        'physical_loc' => $asset->physical_loc,
                        'logical_loc' => $asset->logical_loc,
                        'risk_confidentiality' => $asset->risk_confidentiality,
                        'risk_integrity' => $asset->risk_integrity,
                        'risk_availability' => $asset->risk_availability,
                        'performed_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    
                        Db::table('iso_sec_2_1')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                        ->delete();

                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Deleted successfully');
                    
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }


    public function download_asset_template(){
        $path=public_path("assets_template.xlsx");
//  $org_categories = DB::table('org_assets_categories')
//             ->join('global_asset_categories', 'org_assets_categories.asset_category_selected', '=', 'global_asset_categories.asset_category_id')
//             ->where('org_assets_categories.org_id', auth()->user()->organization->id)
//             ->where('global_asset_categories.is_manual', 'no')
//             ->select('org_assets_categories.*', 'global_asset_categories.asset_category', 'global_asset_categories.asset_category_id')
//             ->get();

//                   $custom_org_categories = DB::table('org_assets_categories')
//             ->join('global_asset_categories', 'org_assets_categories.asset_category_selected', '=', 'global_asset_categories.asset_category_id')
//             ->where('org_assets_categories.org_id', auth()->user()->organization->id)
//             ->where('global_asset_categories.is_manual', 'yes')
//             ->select('org_assets_categories.*', 'global_asset_categories.asset_category', 'global_asset_categories.asset_category_id')
//             ->get();

        

//   $categoryNames = $org_categories
//     ->merge($custom_org_categories)
//     ->pluck('asset_category')
//     ->unique()
//     ->values()
//     ->all();

$orgId = auth()->user()->organization->id;

$orgCategories = DB::table('org_assets_categories')
    ->join('global_asset_categories', 'org_assets_categories.asset_category_selected', '=', 'global_asset_categories.asset_category_id')
    ->where('org_assets_categories.org_id', $orgId)
    ->select(
        'global_asset_categories.asset_category_id',
        'global_asset_categories.asset_category'
    )
    ->get();


  $orgAssetTypes = DB::table('org_assets_types')
    ->join('global_asset_types', 'org_assets_types.asset_type_selected', '=', 'global_asset_types.asset_type_id')
    ->where('org_assets_types.org_id', $orgId)
    ->select(
        'global_asset_types.asset_type_id',
        'global_asset_types.asset_type',
        'global_asset_types.asset_category' // category_id
    )
    ->get();

 

    $excelData = [];

foreach ($orgCategories as $category) {
    $typesForCategory = $orgAssetTypes->where('asset_category', $category->asset_category_id);

    foreach ($typesForCategory as $type) {
        $excelData[] = ['', $category->asset_category, $type->asset_type];
    }
}




           return Excel::download(new AssetCategoryExport($excelData), 'assets_template_with_assets_and_sub_types.xlsx');



      //  return response()->download($path);

    }

    public function upload_assets(Request $req,$proj_id,$user_id)  {
        $req->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {

                        $file = $req->file('file');
                        $data = Excel::toArray([], $file);
                        $rows = array_slice($data[0], 1);

                        $g_name=[];
                        $name=[];
                        $c_name=[];
                        $owner_dept=[];
                        $physical_loc=[];
                        $logical_loc=[];
                        $s_name=[];
                        $error=null;



                        foreach($rows as $row){

                            if($row[0]!=null){
                                $s_name[]=$row[0];
                            }else{
                                $error="Service Name of an asset Missing";
                                break;
                            }

                            if($row[1]!=null){
                                $g_name[]=$row[1];
                            }else{
                                $g_name[]=null;
                            }

                            if($row[2]!=null){
                                $name[]=$row[2];
                            }else{
                                $name[]=null;
                            }


                            if($row[3]!=null){
                                $c_name[]=$row[3];
                            }else{
                                $error="Asset component name of an asset Missing";
                                break;
                            }

                            if($row[4]!=null){
                                $owner_dept[]=$row[4];
                            }else{
                                $owner_dept[]=null;
                            }

                            if($row[5]!=null){
                                $physical_loc[]=$row[5];
                            }else{
                                $physical_loc[]=null;
                            }

                            if($row[6]!=null){
                                $logical_loc[]=$row[6];
                            }else{
                                $logical_loc[]=null;
                            }


                        }


                        if($error!=null){
                            return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('error', $error);
                        }

                        try {
                            for($i=0;$i<count($rows);$i++){
                                $asset_id_inserting=DB::table('iso_sec_2_1')->insertGetId([
                                    'project_id'=>$proj_id,
                                    'g_name'=>$g_name[$i],
                                    'name'=>$name[$i],
                                    'c_name'=>$c_name[$i],
                                    'owner_dept'=>$owner_dept[$i],
                                    'physical_loc'=>$physical_loc[$i],
                                    'logical_loc'=>$logical_loc[$i],
                                    's_name'=>$s_name[$i],
                                    'last_edited_by'=>$user_id,
                                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                                ]);

                                $asset = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id_inserting)->first();
                                Db::table('audit_trail_for_services')->insert([
                                    'asset_id' => $asset->assessment_id,
                                    'project_id' => $proj_id,
                                    'last_edited_by' => $user_id,
                                    'operation_type' => 'insert',
                                    'g_name' => $asset->g_name,
                                    'name' => $asset->name,
                                    'c_name' => $asset->c_name,
                                    's_name' => $asset->s_name,
                                    'owner_dept' => $asset->owner_dept,
                                    'physical_loc' => $asset->physical_loc,
                                    'logical_loc' => $asset->logical_loc,
                                    'risk_confidentiality' => $asset->risk_confidentiality,
                                    'risk_integrity' => $asset->risk_integrity,
                                    'risk_availability' => $asset->risk_availability,
                                    'performed_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]);
                            }

                        } catch (\Exception $e) {

                            $error=$e->getMessage();
                           
                            return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('error', $error);
                        }


                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('success', 'Assets Uploaded Successfully');






                    
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }


    public function ShowServices(Request $req,$proj_id,$user_id){


        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {


                $project=Project::join('project_types','projects.project_type','project_types.id')
                ->where('projects.project_id',$proj_id)->first();

                $services = DB::table('iso_sec_2_1')
              ->where('project_id', $req->query('project_to_copy'))
              ->select('s_name')
              ->distinct('s_name')
              ->get();

                $project_to_copy=Project::where('project_id',$req->query('project_to_copy'))->first();


                        return view('iso_sec_2_1.services_to_copy',[
                            'services'=>$services,
                            'project'=>$project,
                            'project_to_copy'=>$project_to_copy

                        ]);



                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function ShowGroups(Request $request){
        // if ($user_id == auth()->user()->id) {
        //     $checkpermission = Db::table('project_details')->select(
        //         'project_types.id as type_id',
        //         'project_details.project_code',
        //         'project_details.project_permissions',
        //         'projects.project_name',
        //         'projects.project_id'
        //     )
        //         ->join('projects', 'project_details.project_code', 'projects.project_id')
        //         ->join('project_types', 'projects.project_type', 'project_types.id')
        //         ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
        //         ->first();
        //     if ($checkpermission) {
        //         $permissions = json_decode($checkpermission->project_permissions);
        //         if (in_array('Data Inputter', $permissions)) {


        //                 $project=Project::join('project_types','projects.project_type','project_types.id')
        //                 ->where('projects.project_id',$proj_id)->first();

                     
        //                 $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_to_copy)->where('s_name',$servicename)
        //             ->get();
                    
        //             try {
        //                 foreach($assets as $ass){


        //                 Db::table('iso_sec_2_1')->insert([
        //                     'project_id' => $proj_id,
        //                     'g_name' => $ass->g_name,
        //                     'name' => $ass->name,
        //                     'c_name' => $ass->c_name,
        //                     'owner_dept' => $ass->owner_dept,
        //                     'physical_loc' => $ass->physical_loc,
        //                     'logical_loc' => $ass->logical_loc,
        //                     's_name' => $ass->s_name,
        //                     'last_edited_by' => $user_id,
        //                     'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //                 ]);

        //                 }

        //             } catch (\Exception $e) {
                       
        //                 $error=$e->getCode();
                        
        //                 return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
        //             ->with('error', $error);
        //             }

        //             return redirect()->route('iso_section2_1',[
        //                 'proj_id'=>$proj_id,
        //                 'user_id'=>auth()->user()->id

        //             ])->with('success','Assets copied successfully');



        //         }
        //     }
        // }
        // return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        $proj_id = $request->proj_id;
        $user_id = $request->user_id;
        $proj_to_copy = $request->proj_to_copy;
        $services = $request->services; // Array of selected services
    
        if (!$services || count($services) == 0) {
            return redirect()->back()->with('error', 'No services selected.');
        }
    
        if ($user_id == auth()->user()->id) {
            $checkpermission = DB::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)
            ->where('assigned_enduser', $user_id)
            ->first();
    
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    try {
                        foreach ($services as $servicename) {
                            $assets = DB::table('iso_sec_2_1')
                                ->where('project_id', $proj_to_copy)
                                ->where('s_name', $servicename)
                                ->get();
    
                            foreach ($assets as $ass) {
                                DB::table('iso_sec_2_1')->insert([
                                    'project_id' => $proj_id,
                                    'g_name' => $ass->g_name,
                                    'name' => $ass->name,
                                    'c_name' => $ass->c_name,
                                    'owner_dept' => $ass->owner_dept,
                                    'physical_loc' => $ass->physical_loc,
                                    'logical_loc' => $ass->logical_loc,
                                    's_name' => $ass->s_name,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        return redirect()->route('iso_section2_1', [
                            'proj_id' => $proj_id,
                            'user_id' => $user_id
                        ])->with('error', 'Error copying assets: ' . $e->getMessage());
                    }
    
                    return redirect()->route('iso_section2_1', [
                        'proj_id' => $proj_id,
                        'user_id' => auth()->user()->id
                    ])->with('success', 'Selected services copied successfully.');
                }
            }
        }
    
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    // public function CopyGroups(Request $req,$proj_id,$user_id,$proj_to_copy,$servicename){
    //     $req->validate([
    //         'group_to_copy'=>'required'
    //     ],[
    //         'required'=>"Please select atleast one group"
    //     ]);


    //     if ($user_id == auth()->user()->id) {
    //         $checkpermission = Db::table('project_details')->select(
    //             'project_types.id as type_id',
    //             'project_details.project_code',
    //             'project_details.project_permissions',
    //             'projects.project_name',
    //             'projects.project_id'
    //         )
    //             ->join('projects', 'project_details.project_code', 'projects.project_id')
    //             ->join('project_types', 'projects.project_type', 'project_types.id')
    //             ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
    //             ->first();
    //         if ($checkpermission) {
    //             $permissions = json_decode($checkpermission->project_permissions);
    //             if (in_array('Data Inputter', $permissions)) {


    //                 $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_to_copy)->where('s_name',$servicename)
    //                 ->whereIn('g_name',$req->group_to_copy)->get();

    //                 try {
    //                     foreach($assets as $ass){


    //                     Db::table('iso_sec_2_1')->insert([
    //                         'project_id' => $proj_id,
    //                         'g_name' => $ass->g_name,
    //                         'name' => $ass->name,
    //                         'c_name' => $ass->c_name,
    //                         'owner_dept' => $ass->owner_dept,
    //                         'physical_loc' => $ass->physical_loc,
    //                         'logical_loc' => $ass->logical_loc,
    //                         's_name' => $ass->s_name,
    //                         'last_edited_by' => $user_id,
    //                         'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
    //                     ]);

    //                     }

    //                 } catch (\Exception $e) {
                       
    //                     $error=$e->getCode();
                        
    //                     return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
    //                 ->with('error', $error);
    //                 }

    //                 return redirect()->route('iso_section2_1',[
    //                     'proj_id'=>$proj_id,
    //                     'user_id'=>$user_id
    //                 ])->with('success','Record Added successfully');




    //             }
    //         }
    //     }
    //     return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    // }
    function getProjectFrameworkDetails($project)
    {
        $orgId = auth()->user()->organization->id;
    
        $complianceFramework = DB::table('org_projects_framework_selected')
            ->join('risk_management_framework','org_projects_framework_selected.framework_selected', '=', 'risk_management_framework.framework_id')
            ->where('org_id', $orgId)
            ->where('project_type_id', $project->project_type)
            ->first();
    
        $risk_assessment_approach = DB::table('org_risk_assessment_approach')
            ->join('global_risk_assessment_approach', 'org_risk_assessment_approach.assessment_approach_selected', '=', 'global_risk_assessment_approach.global_risk_assessment_approach_id')
            ->where('org_risk_assessment_approach.org_id', $orgId)
            ->where('project_type_id', $project->project_type)
            ->first();
    
        $framework_approach = DB::table('org_framework_approach_selected')
            ->join('framework_approach_types', 'org_framework_approach_selected.framework_approach_types', '=', 'framework_approach_types.framework_approach_types_id')
            ->where('org_framework_approach_selected.org_id', $orgId)
            ->where('project_type_id', $project->project_type)
            ->first();
    
        return compact('complianceFramework', 'risk_assessment_approach', 'framework_approach');
    }


}
