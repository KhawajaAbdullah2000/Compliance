<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use App\Models\Risk;
use App\Models\ProjAssetsSelectedRiskSourceAndTarget;
use Illuminate\Support\Facades\File;


class IsoSec2_3_1 extends Controller
{

    public function iso_sec_2_3_1_risk_selection($asset_id,$proj_id,$user_id){
    
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
                $asset=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                    $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && $frameworkDetails['framework_approach']->framework_approach_types_id==1
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                        return view("iso_27005.consequence_on_service",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$asset,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach']
                        ]);

                     }

                     if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && $frameworkDetails['framework_approach']->framework_approach_types_id==2
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Quantitative Asset based

                        $consequence_scale=DB::table('org_quantitavie_consequence_scale')
                        ->join('global_currency','org_quantitavie_consequence_scale.currency_selected','global_currency.global_currency_id')
                        ->where('project_type_id',$project->project_type)
                        ->orderBy('org_quantitavie_consequence_scale.scale','desc')
                        ->get();

                        $global_currency=DB::table('global_currency')->get();
               
                        return view("iso_27005.consequence_on_service",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$asset,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'consequence_scale'=>$consequence_scale,
                        'global_currency'=>$global_currency
                        ]);

                     }



                    return view('iso_sec_2_3_1.iso_sec_2_3_1_risk_selection', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$asset
                    ]);

                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function iso_sec_2_3_1_risk_selection_qual_event($proj_id,$user_id){
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

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                 ->where('projects.project_id', $proj_id)->first();

                    $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && $frameworkDetails['framework_approach']->framework_approach_types_id==1
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                    ){
                        //ISo 27005:2022 Qualitative Event based
                         
                    $services = DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)
                        ->select('s_name')
                        ->distinct()
                        ->get();

                        $global_risk_sources=DB::table('qualitative_asset_based_risk_sources')->get();
                        $global_level_of_threats=DB::table('global_level_of_threats')
                        ->orderBy('global_level_of_threats_id','desc')
                        ->get();

                        $selected_level_of_threat=DB::table('proj_asset_selected_level_of_threat')
                        ->where('project_id',$proj_id)
                        ->value('threat_selected');


                        return view("iso_27005.risk_sources_qual_event",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'services'=>$services,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_sources'=>$global_risk_sources,
                        'global_level_of_threats'=>$global_level_of_threats,
                        'selected_level_of_threat'=>$selected_level_of_threat
                        ]);


            
                      
                       
                     }

                   

                  

                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }


    

    public function Risk_Selection_form_Submit(Request $req,$asset_id,$proj_id,$user_id){
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
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                    $service=  Db::table('iso_sec_2_1')
                    ->where('assessment_id',$asset_id)->first();


                  Db::table('iso_sec_2_1')
                  ->where('s_name',$service->s_name)
                  ->where('project_id',$proj_id)
                  ->update(
                    [
                        'risk_confidentiality'=>$req->risk_confidentiality,
                        'risk_integrity'=>$req->risk_integrity,
                        'risk_availability'=>$req->risk_availability

                    ]
                    );

                    if ($req->input('action') === 'save_and_stay') {
                        return redirect()->route('iso_sec_2_3_1_risk_selection',[
                            'asset_id'=>$asset_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                        ])->with('success', 'Data saved. Proceed to the next step.');
                                         
                    }

              
                    $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && ($frameworkDetails['framework_approach']->framework_approach_types_id==1)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                        $global_risk_sources=DB::table('qualitative_asset_based_risk_sources')->get();
                        $global_level_of_threats=DB::table('global_level_of_threats')
                        ->orderBy('global_level_of_threats_id','desc')
                        ->get();

                        $selected_level_of_threat=DB::table('proj_asset_selected_level_of_threat')
                        ->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)
                        ->value('threat_selected');


                        return view("iso_27005.risk_sources",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$service,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_sources'=>$global_risk_sources,
                        'global_level_of_threats'=>$global_level_of_threats,
                        'selected_level_of_threat'=>$selected_level_of_threat
                        ]);

                     }

                     if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && ($frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Quanitative Asset based
                    
                        $global_risk_sources=DB::table('qualitative_asset_based_risk_sources')->get();
                        $global_level_of_threats=DB::table('global_level_of_threats')
                        ->orderBy('global_level_of_threats_id','desc')
                        ->get();

                        $selected_level_of_threat=DB::table('proj_asset_selected_level_of_threat')
                        ->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)
                        ->value('threat_selected');


                        return view("iso_27005.risk_sources",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$service,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_sources'=>$global_risk_sources,
                        'global_level_of_threats'=>$global_level_of_threats,
                        'selected_level_of_threat'=>$selected_level_of_threat
                        ]);

                     }


                
                

                    return redirect()->route('iso_sec_2_3_1',[
                        'asset_id'=>$asset_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ]);

                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }


    public function target_objective_of_risk_source($proj_id,$user_id,$asset_id,$g_risk_source_num){
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
    
                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && (($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2))
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                        $global_risk_source=DB::table('qualitative_asset_based_risk_sources')
                        ->where('qualitative_asset_based_risk_sources_id',$g_risk_source_num)->first();
                        
                        $global_target_objects=DB::table('qualitative_asset_global_target_object_risk_source')->get();

                        $selected_target_object_ids = ProjAssetsSelectedRiskSourceAndTarget::where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)
                        ->where('risk_source_foreign', $g_risk_source_num)
                        ->pluck('target_object_foreign')
                        ->toArray();

                       
                        return view("iso_27005.target_objective_risk_source",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_source'=>$global_risk_source,
                        'global_target_objects'=>$global_target_objects,
                        'asset'=>$asset,
                        'selected_target_object_ids'=>$selected_target_object_ids
                        ]);

                     }
                



            
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    
    public function target_objective_of_risk_source_qual_event($proj_id,$user_id,$g_risk_source_num){
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
    
            $services = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();
                    

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && (($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2))
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                    ){
                        //ISo 27005:2022 Qualitative Event based
                        $global_risk_source=DB::table('qualitative_asset_based_risk_sources')
                        ->where('qualitative_asset_based_risk_sources_id',$g_risk_source_num)->first();
                        
                        $global_target_objects=DB::table('qualitative_asset_global_target_object_risk_source')->get();

                        $selected_target_object_ids = ProjAssetsSelectedRiskSourceAndTarget::where('project_id', $proj_id)
                        ->where('risk_source_foreign', $g_risk_source_num)
                        ->pluck('target_object_foreign')
                        ->toArray();

                       
                        return view("iso_27005.target_objective_risk_source_qual_event",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_source'=>$global_risk_source,
                        'global_target_objects'=>$global_target_objects,
                        'services'=>$services,
                        'selected_target_object_ids'=>$selected_target_object_ids
                        ]);

                     }
                



            
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function threat_posed_by_risk_source($proj_id,$user_id,$asset_id,$g_risk_source_num){
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
    
                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based

                        $global_risk_source=DB::table('qualitative_asset_based_risk_sources')
                        ->where('qualitative_asset_based_risk_sources_id',$g_risk_source_num)->first();
                   
                        $global_threat_and_descs = DB::table('global_threat_posed_by_risk_source')
                        ->join('threat_desc_for_global_threats', 'global_threat_posed_by_risk_source.global_threat_posed_by_risk_source_id', '=', 'threat_desc_for_global_threats.global_threat')
                        ->select(
                            'global_threat_posed_by_risk_source.global_threat_posed_by_risk_source_id',
                            'global_threat_posed_by_risk_source.global_threat_posed',
                            'threat_desc_for_global_threats.threat_desc_for_global_threats_id',
                            'threat_desc_for_global_threats.threat_description'
                        )
                        ->get()
                        ->groupBy('global_threat_posed_by_risk_source_id');

                        $selected_threat_ids=DB::table('proj_asset_threat_desc_selected')
                        ->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)
                        ->where('g_risk_source_num',$g_risk_source_num)
                        ->pluck('threat_desc_selected')->toArray();

            
                       
                       
                        return view("iso_27005.threat_desc_selected",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_source'=>$global_risk_source,
                        'asset'=>$asset,
                        'global_threat_and_descs'=>$global_threat_and_descs,
                        'selected_threat_ids'=>$selected_threat_ids
        
                        ]);

                     }
                



            
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

      public function threat_posed_by_risk_source_qual_event($proj_id,$user_id,$g_risk_source_num){
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
    
            $services = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->select('s_name')
                ->distinct()
                ->get();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                    ){
                        //ISo 27005:2022 Qualitative Event based

                        $global_risk_source=DB::table('qualitative_asset_based_risk_sources')
                        ->where('qualitative_asset_based_risk_sources_id',$g_risk_source_num)->first();
                   
                        $global_threat_and_descs = DB::table('global_threat_posed_by_risk_source')
                        ->join('threat_desc_for_global_threats', 'global_threat_posed_by_risk_source.global_threat_posed_by_risk_source_id', '=', 'threat_desc_for_global_threats.global_threat')
                        ->select(
                            'global_threat_posed_by_risk_source.global_threat_posed_by_risk_source_id',
                            'global_threat_posed_by_risk_source.global_threat_posed',
                            'threat_desc_for_global_threats.threat_desc_for_global_threats_id',
                            'threat_desc_for_global_threats.threat_description'
                        )
                        ->get()
                        ->groupBy('global_threat_posed_by_risk_source_id');

                        $selected_threat_ids=DB::table('proj_asset_threat_desc_selected')
                        ->where('project_id',$proj_id)
                        ->where('g_risk_source_num',$g_risk_source_num)
                        ->pluck('threat_desc_selected')->toArray();

            
                       
                       
                        return view("iso_27005.threat_desc_selected_qual_event",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_source'=>$global_risk_source,
                        'services'=>$services,
                        'global_threat_and_descs'=>$global_threat_and_descs,
                        'selected_threat_ids'=>$selected_threat_ids
        
                        ]);

                     }
                



            
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }


    public function select_vul_for_control($proj_id,$user_id,$asset_id,$control_num){
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
    
                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && $frameworkDetails['framework_approach']->framework_approach_types_id==1
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based

                 
                   
                        $global_vul_and_descs = DB::table('global_vulnerability_risk_assessment')
                        ->join('vul_desc_for_global_vul', 'global_vulnerability_risk_assessment.global_vulnerability_risk_assessment_id', '=', 'vul_desc_for_global_vul.global_vulnerability')
                        ->select(
                            'global_vulnerability_risk_assessment.global_vulnerability_risk_assessment_id',
                            'global_vulnerability_risk_assessment.global_vulnerability',
                            'vul_desc_for_global_vul.vul_desc_for_global_vul_id',
                            'vul_desc_for_global_vul.vulnerability_description'
                        )
                        ->get()
                        ->groupBy('global_vulnerability_risk_assessment_id');

                        //dd($global_vul_and_descs);

                        $selected_vul_ids=DB::table('proj_asset_control_vul_selected')
                        ->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)
                        ->where('control_num',$control_num)
                        ->pluck('vul_desc_selected')->toArray();

                       

            
                       
                       
                        return view("iso_27005.vulnerability_desc_selected",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'asset'=>$asset,
                        'global_vul_and_descs'=>$global_vul_and_descs,
                        'control_num'=>$control_num,
                        'selected_vul_ids'=>$selected_vul_ids
              
        
                        ]);

                     }
                



            
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

   

    public function proj_asset_selected_vulnerability_descriptions($proj_id,$user_id,$asset_id,$control_num,Request $req){
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

                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && $frameworkDetails['framework_approach']->framework_approach_types_id==1
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                        $selectedVulnerabilities = $req->input('selected', []); // Default to empty array if nothing selected

                        if (empty($selectedVulnerabilities)) {
                            // Optional: Flash a message if nothing was selected
                            return redirect()->back()->with('success', 'No Vulnerabilities were selected for this Control Number');
                        }

                        DB::table('proj_asset_control_vul_selected')->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)
                        ->where('control_num',$control_num)
                        ->delete();

                        foreach ($selectedVulnerabilities as $groupId => $vulnerabilities) {
                            foreach ($vulnerabilities as $vulId) {

                                DB::table('proj_asset_control_vul_selected')->insert([
                                    'project_id'=>$proj_id,
                                    'asset_id'=>$asset_id,
                                    'vul_desc_selected'=>$vulId,
                                    'last_edited_by'=>$user_id,
                                    'control_num'=>$control_num,
                                    'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                                    
                                ]);
                               
                            }
                        }

                        
                        return redirect()->back()->with('success', 'Vulnerabilities saved successfully');




                     }
                



            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function proj_asset_threat_desc_selected($proj_id,$user_id,$asset_id,$g_risk_source_num,Request $req){
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

                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                        $selectedThreats = $req->input('selected', []); // Default to empty array if nothing selected

                        if (empty($selectedThreats)) {
                            // Optional: Flash a message if nothing was selected
                            return redirect()->back()->with('success', 'No threats were selected. No Risk Source and its Threat Description added');
                        }

                        DB::table('proj_asset_threat_desc_selected')->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)
                        ->where('g_risk_source_num',$g_risk_source_num)
                        ->delete();

                        foreach ($selectedThreats as $groupId => $threats) {
                            foreach ($threats as $threatId) {

                                DB::table('proj_asset_threat_desc_selected')->insert([
                                    'project_id'=>$proj_id,
                                    'asset_id'=>$asset_id,
                                    'threat_desc_selected'=>$threatId,
                                    'last_edited_by'=>$user_id,
                                    'g_risk_source_num'=>$g_risk_source_num,
                                    'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                                    
                                ]);
                               
                            }
                        }

                        
             return redirect()->route('route_for_risk_source',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
                'asset_id'=>$asset_id
             ])->with('success', 'Threats posed by risk source saved successfully');




                     }
                



            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    
    public function proj_asset_threat_desc_selected_qual_event($proj_id,$user_id,$g_risk_source_num,Request $req){
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

        

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                    ){
                        //ISo 27005:2022 Qualitative Event based
                        $selectedThreats = $req->input('selected', []); // Default to empty array if nothing selected

                        if (empty($selectedThreats)) {
                            // Optional: Flash a message if nothing was selected
                            return redirect()->back()->with('success', 'No threats were selected. No Risk Source and its Threat Description added');
                        }

                        DB::table('proj_asset_threat_desc_selected')->where('project_id',$proj_id)
                        ->where('g_risk_source_num',$g_risk_source_num)
                        ->delete();

                        foreach ($selectedThreats as $groupId => $threats) {
                            foreach ($threats as $threatId) {

                                DB::table('proj_asset_threat_desc_selected')->insert([
                                    'project_id'=>$proj_id,
                                    'threat_desc_selected'=>$threatId,
                                    'last_edited_by'=>$user_id,
                                    'g_risk_source_num'=>$g_risk_source_num,
                                    'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                                    
                                ]);
                               
                            }
                        }

                        
             return redirect()->route('route_for_risk_source_qual_event',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
             
             ])->with('success', 'Threats posed by risk source saved successfully');




                     }
                



            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }


    public function proj_assets_selected_risk_source_and_target($proj_id,$user_id,$asset_id,$g_risk_source_num,Request $req){
        //dd($proj_id,$user_id,$asset_id,$g_risk_source_num, $req->all());
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

                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                      
                        //delete the old ones
                    DB::table('proj_assets_selected_risk_source_and_target')
                    ->where('project_id',$proj_id)
                    ->where('asset_id',$asset_id)
                    ->where('risk_source_foreign',$g_risk_source_num)
                    ->delete();

                    if($req->target_object){
                        foreach($req->target_object as $target_object_num){
                            DB::table('proj_assets_selected_risk_source_and_target')
                            ->insert([
                                'project_id'=>$proj_id,
                                'asset_id'=>$asset_id,
                                'risk_source_foreign'=>$g_risk_source_num,
                                'target_object_foreign'=>$target_object_num,
                                'last_edited_by' => $user_id,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        }
                    }else{
                        return redirect()->back()->with('error',"Select atleast 1 checkbox");
                    }

                   

                    return redirect()->route('route_for_risk_source',[
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id,
                        'asset_id'=>$asset_id
                    ])->with('success','Target objectives of risk source added successfully');
                     
                       
                     }
                



            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function proj_selected_risk_source_and_target_qual_event($proj_id,$user_id,$g_risk_source_num,Request $req){
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

                $services = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                    ){
                        //ISo 27005:2022 Qualitative Event based
                      
                        //delete the old ones
                    DB::table('proj_assets_selected_risk_source_and_target')
                    ->where('project_id',$proj_id)
                    ->where('risk_source_foreign',$g_risk_source_num)
                    ->delete();

                    if($req->target_object){
                        foreach($req->target_object as $target_object_num){
                            DB::table('proj_assets_selected_risk_source_and_target')
                            ->insert([
                                'project_id'=>$proj_id,
                                'risk_source_foreign'=>$g_risk_source_num,
                                'target_object_foreign'=>$target_object_num,
                                'last_edited_by' => $user_id,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        }
                    }else{
                        return redirect()->back()->with('error',"Select atleast 1 checkbox");
                    }

                   

                    return redirect()->route('route_for_risk_source_qual_event',[
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id,
                        
                    ])->with('success','Target objectives of risk source added successfully');
                     
                       
                     }
                



            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function proj_assets_level_of_threat ($proj_id,$user_id,$asset_id,Request $req){
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
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

          
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                if($frameworkDetails['complianceFramework']->framework_selected==2 
                 && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                 && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                ){
                    //ISo 27005:2022 Qualitative Asset based
                    DB::table('proj_asset_selected_level_of_threat')
                            ->updateOrInsert([
                                'project_id'=>$proj_id,
                                'asset_id'=>$asset_id,
                            ],
                        [
                            'threat_selected'=>$req->threat_level,
                            'last_edited_by'=>$user_id,
                            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
                        ]
                    );
        
                    if ($req->input('action') === 'save_and_next') {
                         return redirect()->route("iso_27005_risk_assessment",[
                    'proj_id' => $checkpermission->project_id,
                    'user_id'=>$user_id,
                    'asset_id'=>$asset->assessment_id
                    ]);

                    }
    
                
                                         
        
        if ($req->input('action') === 'save_and_stay') {
             return redirect()->route('route_for_risk_source',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
                'asset_id'=>$asset_id
             ])->with("success","Threat Level saved Successfully");
        
                                     
            }
                   

                   

                 }
            

                return redirect()->route('iso_sec_2_3_1',[
                    'asset_id'=>$asset_id,
                    'proj_id'=>$proj_id,
                    'user_id'=>$user_id
                ]);

            
        }
    
    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

        
    }

        public function proj_assets_level_of_threat_qual_event ($proj_id,$user_id,Request $req){
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
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

          
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                if($frameworkDetails['complianceFramework']->framework_selected==2 
                 && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                 && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                ){
                    //ISo 27005:2022 Qualitative Event based
                    DB::table('proj_asset_selected_level_of_threat')
                            ->updateOrInsert([
                                'project_id'=>$proj_id,
                            ],
                        [
                            'threat_selected'=>$req->threat_level,
                            'last_edited_by'=>$user_id,
                            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
                        ]
                    );
        
                    if ($req->input('action') === 'save_and_next') {
                         return redirect()->route("iso_27005_risk_assessment_qual_event",[
                    'proj_id' => $checkpermission->project_id,
                    'user_id'=>$user_id,
                    ]);

                    }
    
                
                                         
        
        if ($req->input('action') === 'save_and_stay') {
             return redirect()->route('route_for_risk_source_qual_event',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
        
             ])->with("success","Threat Level saved Successfully");
        
                                     
            }
                   

                   

                 }
            
        return redirect()->back();
            
        }
    
    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

        
    }

    public function route_for_risk_source($proj_id,$user_id,$asset_id){
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
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                    $asset=  Db::table('iso_sec_2_1')
                    ->where('assessment_id',$asset_id)->first();

              
                    $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 ||  $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                    ){
                        //ISo 27005:2022 Qualitative Asset based
                        $global_risk_sources=DB::table('qualitative_asset_based_risk_sources')->get();
                        $global_level_of_threats=DB::table('global_level_of_threats')
                        ->orderBy('global_level_of_threats_id','desc')
                        ->get();

                        $selected_level_of_threat=DB::table('proj_asset_selected_level_of_threat')
                        ->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)
                        ->value('threat_selected');


                        return view("iso_27005.risk_sources",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$asset,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_sources'=>$global_risk_sources,
                        'global_level_of_threats'=>$global_level_of_threats,
                        'selected_level_of_threat'=>$selected_level_of_threat
                        ]);

                     }
                

                    return redirect()->route('iso_sec_2_3_1',[
                        'asset_id'=>$asset_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ]);

                
            }
        
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

      public function route_for_risk_source_qual_event($proj_id,$user_id){
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
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            $services = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();

              
                    $frameworkDetails = $this->getProjectFrameworkDetails($project);

                    if($frameworkDetails['complianceFramework']->framework_selected==2 
                     &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 ||  $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                     && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                    ){
                        //ISo 27005:2022 Qualitative Event based
                        $global_risk_sources=DB::table('qualitative_asset_based_risk_sources')->get();
                        $global_level_of_threats=DB::table('global_level_of_threats')
                        ->orderBy('global_level_of_threats_id','desc')
                        ->get();

                        $selected_level_of_threat=DB::table('proj_asset_selected_level_of_threat')
                        ->where('project_id', $proj_id)
                        ->value('threat_selected');


                        return view("iso_27005.risk_sources_qual_event",[
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'services'=>$services,
                        'complianceFramework'=>$frameworkDetails['complianceFramework'],
                        'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                        'framework_approach'=>$frameworkDetails['framework_approach'],
                        'global_risk_sources'=>$global_risk_sources,
                        'global_level_of_threats'=>$global_level_of_threats,
                        'selected_level_of_threat'=>$selected_level_of_threat
                        ]);

                     }
                

               return redirect()->back();

                
            }
        
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function iso_27005_submit_risk_assessment($proj_id,$user_id,$asset_id,Request $req){
        //dd($req->all());
        foreach($req->control_num as $key=>$value){
            DB::table('iso27005_risk_assessment')->updateOrInsert(
                [
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,
                    'control_num' => $value,
                ],
                [
                    'vulnerability_due_to' => $req->vulnerability_due_to[$key],
                    'last_edited_by'=>$user_id,
                    'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );
      

        }

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
            ){
               return redirect()->route('iso_27005_risk_assessment',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
                'asset_id'=>$asset_id
               ])->with('success','Data Saved Successfully');
            }
      


       
    }

    public function iso_27005_submit_risk_assessment_qual_event($proj_id,$user_id,Request $req){
        //dd($req->all());
        foreach($req->control_num as $key=>$value){
            DB::table('iso27005_risk_assessment')->updateOrInsert(
                [
                    'project_id' => $proj_id,
                    'control_num' => $value,
                ],
                [
                    'vulnerability_due_to' => $req->vulnerability_due_to[$key],
                    'last_edited_by'=>$user_id,
                    'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );
      

        }

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();
      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
            ){
               return redirect()->route('iso_27005_risk_assessment_qual_event',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
                
               ])->with('success','Data Saved Successfully');
            }
      


       
    }

    public function iso_27005_risk_assessment($proj_id,$user_id,$asset_id){
        //route for risk assesment quality asset based with controls
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
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

          
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                if($frameworkDetails['complianceFramework']->framework_selected==2 
                 && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                 && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
                ){
                    //ISo 27005:2022 Qualitative Asset based
                    $filename = 'ISO27K1_2022_' . $asset->g_name . '.xlsx';
                    $filepath = public_path($filename);
                    
                    // Fallback to 'None' file if original doesn't exist
                    if (!File::exists($filepath)) {
                        $filename = 'ISO27K1_2022_None.xlsx';
                        $filepath = public_path($filename);
                    }
                    
                    $data2 = Excel::toArray([], $filepath); // Load Excel with header
                    $rows = array_slice($data2[0], 1); // Remove header row

                    foreach ($rows as &$row) {
                        if (isset($row[0])) {
                            $row[0] = trim((string) $row[0]); // keep it as-is
                        }
                
                    }
                    //dd($rows[0][0]);
                     

                
                    $savedDataRaw = DB::Table('iso27005_risk_assessment')
                    ->where('project_id', $project->project_id)
                    ->where('asset_id', $asset->assessment_id)
                    ->pluck('vulnerability_due_to', 'control_num');
                
                $savedData = [];
                foreach ($savedDataRaw as $key => $value) {
                    $normalizedKey = trim((string) $key); // only trim, no number_format
                    $savedData[$normalizedKey] = $value;
                }

                $global_level_of_vulnerabilities=DB::table('global_level_of_vulnerability')
                ->orderBy('global_level_of_vulnerability_id','desc')->get();

                $selected_level_of_vulnerability=DB::table('proj_asset_selected_level_of_vulnerability')
                ->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                ->value('vulnerability_selected');
               
              
         
    
                     return view("iso_27005.risk_assessment",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'controls'=>$rows,
                    'savedData'=>$savedData,
                    'global_level_of_vulnerabilities'=>$global_level_of_vulnerabilities,
                    'selected_level_of_vulnerability'=>$selected_level_of_vulnerability
                
                    ]);

                    
                 }
            

                return redirect()->route('iso_sec_2_3_1',[
                    'asset_id'=>$asset_id,
                    'proj_id'=>$proj_id,
                    'user_id'=>$user_id
                ]);


    }

    
}

    public function iso_27005_risk_assessment_qual_event($proj_id,$user_id){
        //route for risk assesment quality asset based with controls
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
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

                $services = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();

          
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                if($frameworkDetails['complianceFramework']->framework_selected==2 
                 && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
                 && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
                ){
                    //ISo 27005:2022 Qualitative Event based
                    $filename = 'ISO27K1_2022_Other.xlsx';
                    $filepath = public_path($filename);
                    
                    // Fallback to 'None' file if original doesn't exist
                    if (!File::exists($filepath)) {
                        $filename = 'ISO27K1_2022_None.xlsx';
                        $filepath = public_path($filename);
                    }
                    
                    $data2 = Excel::toArray([], $filepath); // Load Excel with header
                    $rows = array_slice($data2[0], 1); // Remove header row

                    foreach ($rows as &$row) {
                        if (isset($row[0])) {
                            $row[0] = trim((string) $row[0]); // keep it as-is
                        }
                
                    }
                    //dd($rows[0][0]);
                     

                
                    $savedDataRaw = DB::Table('iso27005_risk_assessment')
                    ->where('project_id', $project->project_id)
                    ->pluck('vulnerability_due_to', 'control_num');
                
                $savedData = [];
                foreach ($savedDataRaw as $key => $value) {
                    $normalizedKey = trim((string) $key); // only trim, no number_format
                    $savedData[$normalizedKey] = $value;
                }

                $global_level_of_vulnerabilities=DB::table('global_level_of_vulnerability')
                ->orderBy('global_level_of_vulnerability_id','desc')->get();

                $selected_level_of_vulnerability=DB::table('proj_asset_selected_level_of_vulnerability')
                ->where('project_id', $proj_id)
              
                ->value('vulnerability_selected');
               
              
         
    
                     return view("iso_27005.risk_assessment_qual_event",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'services'=>$services,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'controls'=>$rows,
                    'savedData'=>$savedData,
                    'global_level_of_vulnerabilities'=>$global_level_of_vulnerabilities,
                    'selected_level_of_vulnerability'=>$selected_level_of_vulnerability
                
                    ]);

                    
                 }
            

             return redirect()->back();


    }

    
}




public function add_scenario_form($proj_id,$user_id,$asset_id){
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
      
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
            ){
            
                $riskSources = DB::table('proj_assets_selected_risk_source_and_target as ps')
                ->join('qualitative_asset_based_risk_sources as rs', 'ps.risk_source_foreign', '=', 'rs.qualitative_asset_based_risk_sources_id')
                ->where('ps.project_id', $proj_id)
                ->where('ps.asset_id', $asset_id)
                ->select('rs.qualitative_asset_based_risk_sources_id', 'rs.global_risk_source')
                ->distinct()
                ->get();
    

                $targetObjectives = DB::table('proj_assets_selected_risk_source_and_target as ps')
                ->join('qualitative_asset_global_target_object_risk_source as to', 'ps.target_object_foreign', '=', 'to.qualitative_asset_global_target_object_risk_source_id')
                ->where('ps.project_id', $proj_id)
                ->where('ps.asset_id', $asset_id)
                ->select('to.qualitative_asset_global_target_object_risk_source_id', 'to.target_objective', 'to.description')
                ->distinct()
                ->get();

                $threats = DB::table('proj_asset_threat_desc_selected')
                ->join('threat_desc_for_global_threats', 'proj_asset_threat_desc_selected.threat_desc_selected', '=', 'threat_desc_for_global_threats.threat_desc_for_global_threats_id')
                ->where('proj_asset_threat_desc_selected.project_id', $proj_id)
                ->where('proj_asset_threat_desc_selected.asset_id', $asset_id)
                ->select('proj_asset_threat_desc_selected.threat_desc_selected', 'threat_desc_for_global_threats.threat_description')
                ->distinct()
                ->get();

                $risk_scenarios=DB::table('proj_asset_risk_scenario')
                ->where('project_id',$proj_id)
                ->where('asset_id',$asset_id)
                ->get();


         

                return view("iso_27005.scenario_form",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'riskSources'=>$riskSources,
                    'asset'=>$asset,
                    'targetObjectives'=>$targetObjectives,
                    'threats'=>$threats,
                    'risk_scenarios'=>$risk_scenarios
    
                    ]);

                

                

            }
        }
    
}


// public function add_scenario_form_qual_event($proj_id,$user_id,$asset_id){
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
      
//         $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
//         ->where('projects.project_id', $proj_id)->first();

//        $services = DB::table('iso_sec_2_1')
//         ->where('project_id', $proj_id)
//         ->select('s_name')
//         ->distinct()
//         ->get();

      
//             $frameworkDetails = $this->getProjectFrameworkDetails($project);

//             if($frameworkDetails['complianceFramework']->framework_selected==2 
//              && ($frameworkDetails['framework_approach']->framework_approach_types_id==1 || $frameworkDetails['framework_approach']->framework_approach_types_id==2)
//              && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
//             ){
            
//                 $riskSources = DB::table('proj_assets_selected_risk_source_and_target as ps')
//                 ->join('qualitative_asset_based_risk_sources as rs', 'ps.risk_source_foreign', '=', 'rs.qualitative_asset_based_risk_sources_id')
//                 ->where('ps.project_id', $proj_id)
       
//                 ->select('rs.qualitative_asset_based_risk_sources_id', 'rs.global_risk_source')
//                 ->distinct()
//                 ->get();
    

//                 $targetObjectives = DB::table('proj_assets_selected_risk_source_and_target as ps')
//                 ->join('qualitative_asset_global_target_object_risk_source as to', 'ps.target_object_foreign', '=', 'to.qualitative_asset_global_target_object_risk_source_id')
//                 ->where('ps.project_id', $proj_id)
            
//                 ->select('to.qualitative_asset_global_target_object_risk_source_id', 'to.target_objective', 'to.description')
//                 ->distinct()
//                 ->get();

//                 $threats = DB::table('proj_asset_threat_desc_selected')
//                 ->join('threat_desc_for_global_threats', 'proj_asset_threat_desc_selected.threat_desc_selected', '=', 'threat_desc_for_global_threats.threat_desc_for_global_threats_id')
//                 ->where('proj_asset_threat_desc_selected.project_id', $proj_id)
         
//                 ->select('proj_asset_threat_desc_selected.threat_desc_selected', 'threat_desc_for_global_threats.threat_description')
//                 ->distinct()
//                 ->get();

//                 $risk_scenarios=DB::table('proj_asset_risk_scenario')
//                 ->where('project_id',$proj_id)
//                 ->where('asset_id',$asset_id)
//                 ->get();


         

//                 return view("iso_27005.scenario_form",[
//                     'project_id' => $checkpermission->project_id,
//                     'project_name' => $checkpermission->project_name,
//                     'project_permissions' => $checkpermission->project_permissions,
//                     'project' => $project,
//                     'complianceFramework'=>$frameworkDetails['complianceFramework'],
//                     'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
//                     'framework_approach'=>$frameworkDetails['framework_approach'],
//                     'riskSources'=>$riskSources,
//                     'asset'=>$asset,
//                     'targetObjectives'=>$targetObjectives,
//                     'threats'=>$threats,
//                     'risk_scenarios'=>$risk_scenarios
    
//                     ]);

                

                

//             }
//         }
    
// }

public function add_risk_scenario($proj_id,$user_id,$asset_id){
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
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

                $asset=  Db::table('iso_sec_2_1')
                ->where('assessment_id',$asset_id)->first();

          
                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                return view("iso_27005.add_risk_scenario_form_view",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach']
                    ]);
            
        }
    }
}

public function proj_asset_risk_scenario($proj_id,$user_id,$asset_id,Request $req){

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
                $req->validate([
                    'scenario'=>'required'
                ]);
                DB::table('proj_asset_risk_scenario')->insert([
                    'project_id'=>$proj_id,
                    'asset_id'=>$asset_id,
                    'scenario'=>$req->scenario,
                    'last_edited_by'=>$user_id,
                    'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
                ]);
                return redirect()->route('add_scenario_form',[
                    'proj_id'=>$proj_id,
                    'user_id'=>$user_id,
                    'asset_id'=>$asset_id
                ])->with('success','Scenario Added Successfully');
            }
            return redirect()->back()->with('error','Not Allowed');
        }
   
}

public function proj_asset_selected_level_of_vulnerability($proj_id,$user_id,$asset_id,Request $req){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 ||  $frameworkDetails['framework_approach']->framework_approach_types_id==2)
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
            ){
                
                DB::table('proj_asset_selected_level_of_vulnerability')
                        ->updateOrInsert([
                            'project_id'=>$proj_id,
                            'asset_id'=>$asset_id,
                        ],
                    [
                        'vulnerability_selected'=>$req->vulnerability_level,
                        'last_edited_by'=>$user_id,
                        'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
                    ]
                );
    
                if ($req->input('action') === 'save_and_stay') {
                     return redirect()->route("iso_27005_risk_assessment",[
                'proj_id' => $checkpermission->project_id,
                'user_id'=>$user_id,
                'asset_id'=>$asset->assessment_id
                ])->with('success','Data Saved Successfully');

                }

            
                                     
    
    if ($req->input('action') === 'save_and_next') {
    
        return redirect()->route("iso_27005_likelihood_value",[
            'proj_id' => $checkpermission->project_id,
            'user_id'=>$user_id,
            'asset_id'=>$asset->assessment_id,
            'risk_type'=>'risk_confidentiality'
            ])->with('success','Data Saved Successfully');
                                 
        }
               

               

             }
        

            return redirect()->route('iso_sec_2_3_1',[
                'asset_id'=>$asset_id,
                'proj_id'=>$proj_id,
                'user_id'=>$user_id
            ]);

        
    }

return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


}

public function proj_asset_selected_level_of_vulnerability_qual_event($proj_id,$user_id,Request $req){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

          $services = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->select('s_name')
        ->distinct()
        ->get();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1 ||  $frameworkDetails['framework_approach']->framework_approach_types_id==2)
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
            ){
                
                DB::table('proj_asset_selected_level_of_vulnerability')
                        ->updateOrInsert([
                            'project_id'=>$proj_id,
                        ],
                    [
                        'vulnerability_selected'=>$req->vulnerability_level,
                        'last_edited_by'=>$user_id,
                        'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
                    ]
                );
    
                if ($req->input('action') === 'save_and_stay') {
                     return redirect()->route("iso_27005_risk_assessment_qual_event",[
                'proj_id' => $checkpermission->project_id,
                'user_id'=>$user_id,
                ])->with('success','Data Saved Successfully');

                }

            
                                     
    
    if ($req->input('action') === 'save_and_next') {
    
        return redirect()->route("iso_27005_likelihood_value_qual_event",[
            'proj_id' => $checkpermission->project_id,
            'user_id'=>$user_id,
            'risk_type'=>'risk_confidentiality'
            ])->with('success','Data Saved Successfully');
                                 
        }
               

               

             }
        
return redirect()->back();

        
    }

return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


}

public function iso_27005_likelihood_value($proj_id,$user_id,$asset_id,$risk_type=''){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

    
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

        
            if($frameworkDetails['complianceFramework']->framework_selected==2 
            &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1)
            && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
           ){
            //Qualitative Asset Based
            $likelihood_value=DB::table('proj_asset_likelihood_value')
            ->where('project_id',$proj_id)
            ->where('asset_id',$asset_id)
            ->value('qualitative_likelihood_'.$risk_type.'_selected');
           }
        
    
               //ISo 27005:2022 Qualitative and Quantitiave Asset based
                $threat=DB::table('proj_asset_selected_level_of_threat')
                ->join('global_level_of_threats','proj_asset_selected_level_of_threat.threat_selected','global_level_of_threats.global_level_of_threats_id')
                ->where('project_id',$proj_id)
                ->where('asset_id',$asset_id)
                ->value('global_threat');

                $vulnerability=DB::table('proj_asset_selected_level_of_vulnerability')
                ->join('global_level_of_vulnerability','proj_asset_selected_level_of_vulnerability.vulnerability_selected','global_level_of_vulnerability.global_level_of_vulnerability_id')
                ->where('project_id',$proj_id)
                ->where('asset_id',$asset_id)
                ->value('global_vulnerability');

                $likelihood_timeframe=DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id',$proj_id)
                ->where('asset_id',$asset_id)
                ->value('timeframe_'.$risk_type);

        


                if($frameworkDetails['complianceFramework']->framework_selected==2 
                && $frameworkDetails['framework_approach']->framework_approach_types_id==1
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
               ){
                return view("iso_27005.likelihood_value",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'threat'=>$threat,
                    'vulnerability'=>$vulnerability,
                    'likelihood_timeframe'=>$likelihood_timeframe,
                    'likelihood_value'=>$likelihood_value,
                    'risk_type'=>$risk_type
                    ]);

            }

            if($frameworkDetails['complianceFramework']->framework_selected==2 
            && $frameworkDetails['framework_approach']->framework_approach_types_id==2
            && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
           ){
           
            //Quantitative Asset based
            $likelihood_value=DB::table('proj_asset_likelihood_value')
            ->where('project_id',$proj_id)
            ->where('asset_id',$asset_id)
            ->value('quantitative_likelihood_'.$risk_type.'_selected');
        
            return view("iso_27005.quantitative_likelihood_value",[
                'project_id' => $checkpermission->project_id,
                'project_name' => $checkpermission->project_name,
                'project_permissions' => $checkpermission->project_permissions,
                'project' => $project,
                'asset'=>$asset,
                'complianceFramework'=>$frameworkDetails['complianceFramework'],
                'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                'framework_approach'=>$frameworkDetails['framework_approach'],
                'threat'=>$threat,
                'vulnerability'=>$vulnerability,
                'likelihood_timeframe'=>$likelihood_timeframe,
                'likelihood_value'=>$likelihood_value,
                'risk_type'=>$risk_type
                ]);

            
           }
        }

    
}

public function iso_27005_likelihood_value_qual_event($proj_id,$user_id,$asset_id,$risk_type=''){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

    
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

        
            if($frameworkDetails['complianceFramework']->framework_selected==2 
            &&( $frameworkDetails['framework_approach']->framework_approach_types_id==1)
            && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==1
           ){
            //Qualitative Event Based
            $likelihood_value=DB::table('proj_asset_likelihood_value')
            ->where('project_id',$proj_id)
         
            ->value('qualitative_likelihood_'.$risk_type.'_selected');
           }
        

               //ISo 27005:2022 Qualitative and Quantitiave Event based
                $threat=DB::table('proj_asset_selected_level_of_threat')
                ->join('global_level_of_threats','proj_asset_selected_level_of_threat.threat_selected','global_level_of_threats.global_level_of_threats_id')
                ->where('project_id',$proj_id)
              
                ->value('global_threat');

                $vulnerability=DB::table('proj_asset_selected_level_of_vulnerability')
                ->join('global_level_of_vulnerability','proj_asset_selected_level_of_vulnerability.vulnerability_selected','global_level_of_vulnerability.global_level_of_vulnerability_id')
                ->where('project_id',$proj_id)
             
                ->value('global_vulnerability');

                $likelihood_timeframe=DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id',$proj_id)
             
                ->value('timeframe_'.$risk_type);

        


                if($frameworkDetails['complianceFramework']->framework_selected==2 
                && $frameworkDetails['framework_approach']->framework_approach_types_id==1
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
               ){
                return view("iso_27005.likelihood_value",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'threat'=>$threat,
                    'vulnerability'=>$vulnerability,
                    'likelihood_timeframe'=>$likelihood_timeframe,
                    'likelihood_value'=>$likelihood_value,
                    'risk_type'=>$risk_type
                    ]);

            }

            if($frameworkDetails['complianceFramework']->framework_selected==2 
            && $frameworkDetails['framework_approach']->framework_approach_types_id==2
            && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
           ){
           
            //Quantitative Asset based
            $likelihood_value=DB::table('proj_asset_likelihood_value')
            ->where('project_id',$proj_id)
            ->where('asset_id',$asset_id)
            ->value('quantitative_likelihood_'.$risk_type.'_selected');
        
            return view("iso_27005.quantitative_likelihood_value",[
                'project_id' => $checkpermission->project_id,
                'project_name' => $checkpermission->project_name,
                'project_permissions' => $checkpermission->project_permissions,
                'project' => $project,
                'asset'=>$asset,
                'complianceFramework'=>$frameworkDetails['complianceFramework'],
                'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                'framework_approach'=>$frameworkDetails['framework_approach'],
                'threat'=>$threat,
                'vulnerability'=>$vulnerability,
                'likelihood_timeframe'=>$likelihood_timeframe,
                'likelihood_value'=>$likelihood_value,
                'risk_type'=>$risk_type
                ]);

            
           }
        }

    
}

public function iso_27005_likelihood_value_all($proj_id,$user_id,$asset_id){
    
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             && $frameworkDetails['framework_approach']->framework_approach_types_id==1
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
            ){
                //QUalitative Asset based

                $consequence_value_confidentiality=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value('risk_confidentiality');

                
                $consequence_value_integrity=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value('risk_integrity');

                
                $consequence_value_availability=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value('risk_availability');

                $likelihood_value_confidentiality=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('qualitative_likelihood_risk_confidentiality_selected');

                
                $likelihood_value_integrity=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('qualitative_likelihood_risk_integrity_selected');

                
                $likelihood_value_availability=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('qualitative_likelihood_risk_availability_selected');
               
                return view("iso_27005.all_likelihood_and_consequence_value",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'consequence_value_confidentiality'=>$consequence_value_confidentiality,
                    'consequence_value_integrity'=>$consequence_value_integrity,
                    'consequence_value_availability'=>$consequence_value_availability,
                    'likelihood_value_confidentiality'=>$likelihood_value_confidentiality,
                    'likelihood_value_integrity'=>$likelihood_value_integrity,
                    'likelihood_value_availability'=>$likelihood_value_availability
                
                    ]);


            }

            if($frameworkDetails['complianceFramework']->framework_selected==2 
            && $frameworkDetails['framework_approach']->framework_approach_types_id==2
            && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
           ){
               //Quantitatve Asset based

               $consequence_value_confidentiality=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value('risk_confidentiality');

               
               $consequence_value_integrity=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value('risk_integrity');

               
               $consequence_value_availability=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value('risk_availability');

               $likelihood_value_confidentiality=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('quantitative_likelihood_risk_confidentiality_selected');

               
               $likelihood_value_integrity=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('quantitative_likelihood_risk_integrity_selected');

               
               $likelihood_value_availability=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('quantitative_likelihood_risk_availability_selected');
              
               return view("iso_27005.quantitative_all_likelihood_and_consequence_value",[
                   'project_id' => $checkpermission->project_id,
                   'project_name' => $checkpermission->project_name,
                   'project_permissions' => $checkpermission->project_permissions,
                   'project' => $project,
                   'asset'=>$asset,
                   'complianceFramework'=>$frameworkDetails['complianceFramework'],
                   'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                   'framework_approach'=>$frameworkDetails['framework_approach'],
                   'consequence_value_confidentiality'=>$consequence_value_confidentiality,
                   'consequence_value_integrity'=>$consequence_value_integrity,
                   'consequence_value_availability'=>$consequence_value_availability,
                   'likelihood_value_confidentiality'=>$likelihood_value_confidentiality,
                   'likelihood_value_integrity'=>$likelihood_value_integrity,
                   'likelihood_value_availability'=>$likelihood_value_availability
               
                   ]);


           }

        }
}

public function quantitave_consequence_scale_amount_entered($asset_id,$proj_id,$user_id,Request $req){

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
                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                    $currency_selected = $req->input('currency_selected');
                    $log_expressions = $req->input('log_expression');
                    $scales = $req->input('scale');
                    $amounts = $req->input('consequence_amount');
                
                    foreach ($scales as $index => $scale) {
                        DB::table('org_quantitavie_consequence_scale')->updateOrInsert(
                            [
                                'org_id' => auth()->user()->organization->id,
                                'project_type_id' => $project->project_type,
                                'scale' => $scale,
                                'log_expression' => $log_expressions[$index],
                            ],
                            [
                                'consequence_amount' => $amounts[$index],
                                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                            
                            ]
                        );
                    }

                    return redirect()->route('iso_sec_2_3_1_risk_selection',[
                        'asset_id'=>$asset_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ])->with('success','Consequence Scale updated Successfully');

                }
          
        }
    }

    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);



}

public function qualitative_asset_likelihood_confidentiality_timeframe($proj_id,$user_id,$asset_id,Request $req){
    $req->validate([
        'timeframe'=>'required'
    ]);

    DB::table('proj_asset_likelihood_timeframe')->updateOrInsert([
        'project_id'=>$proj_id,
        'asset_id'=>$asset_id
    ],
    [
        'timeframe_'.$req->risk_type_input=>$req->timeframe,
        'last_edited_by'=>$user_id,
        'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')

    ]);

    
        return redirect()->route('iso_27005_likelihood_value',[
            'proj_id'=>$proj_id,
            'user_id'=>$user_id,
            'asset_id'=>$asset_id,
            'risk_type'=>$req->risk_type_input
        ])->with('success','Data Saved Successfully');

    
    
    
}

public function save_likelihood_value($proj_id,$user_id,$asset_id,Request $req){
    $req->validate([
        'likelihood_value'=>'required'
    ]);


    DB::table('proj_asset_likelihood_value')->updateOrInsert([
        'project_id'=>$proj_id,
        'asset_id'=>$asset_id
    ],[
        $req->approach_type.'_likelihood_'.$req->risk_type_input.'_selected'=>$req->likelihood_value,
        'last_edited_by'=>$user_id,
         'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
         'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
    ]);


        return redirect()->route('iso_27005_likelihood_value',[
            'proj_id'=>$proj_id,
            'user_id'=>$user_id,
            'asset_id'=>$asset_id,
            'risk_type'=>$req->risk_type_input
        ])->with('success','Data Saved Successfully');
    
   
}

public function likelihood_and_consequence($risk_type,$proj_id,$user_id,$asset_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

            $asset=  Db::table('iso_sec_2_1')
            ->where('assessment_id',$asset_id)->first();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

      

                $consequence_value=DB::table('iso_sec_2_1')->where('assessment_id',$asset_id)->value($risk_type);

                     if($frameworkDetails['complianceFramework']->framework_selected==2 
             && $frameworkDetails['framework_approach']->framework_approach_types_id==1
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
            ){
                //QUalitative asset based
                $likelihood_value=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('qualitative_likelihood_'.$risk_type.'_selected');

                return view("iso_27005.likelihood_and_consequence_value",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'consequence_value'=>$consequence_value,
                    'likelihood_value'=>$likelihood_value,
                    'risk_type'=>$risk_type
                    ]);

            }

            if($frameworkDetails['complianceFramework']->framework_selected==2 
             && $frameworkDetails['framework_approach']->framework_approach_types_id==2
             && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected==2
            ){
                //Quantitative Asset based
                $likelihood_value=DB::table('proj_asset_likelihood_value')->where('asset_id',$asset_id)->value('quantitative_likelihood_'.$risk_type.'_selected');

                return view("iso_27005.quantitative_likelihood_and_consequence_value",[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset'=>$asset,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'consequence_value'=>$consequence_value,
                    'likelihood_value'=>$likelihood_value,
                    'risk_type'=>$risk_type
                    ]);

            }

        }
}

public function initiaite_risk_assessment_qual_event($proj_id,$user_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();


            $party=DB::table('party')->where('project_id',$proj_id)
            ->where('party_name','!=','None')->where('party_name','!=','All')
            ->get();
        

            $frameworkDetails = $this->getProjectFrameworkDetails($project);
            return view('iso_27005.initiate_risk_qual_event',[
               'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'party'=>$party
                   
            ]);
    }


}

public function new_party($proj_id,$user_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);
            return view('iso_27005.add_new_party',[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
           
                   
            ]);
    }

}

public function submit_new_party($proj_id,$user_id,Request $req){

        DB::table('party')->insert([
            'project_id'=>$proj_id,
            'party_name'=>$req->party_name,
            'party_type'=>$req->party_type,
            'party_category'=>$req->party_category,
            'last_edited_by'=>$user_id,
            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('initiaite_risk_assessment_qual_event',[
            'proj_id'=>$proj_id,
            'user_id'=>$user_id
        ])->with('success','Party Added Successfully');

      
          
}

public function edit_party($party_id,$proj_id,$user_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

        $party=DB::table('party')->where('id',$party_id)->first();
    
      
            $frameworkDetails = $this->getProjectFrameworkDetails($project);
            return view('iso_27005.edit_form_party',[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'party'=>$party
           
                   
            ]);
    }

}

public function edit_party_submit($party_id,$proj_id,$user_id,Request $req){
    DB::table('party')->where('id',$party_id)->update([
        'party_name'=>$req->party_name,
         'party_type'=>$req->party_type,
          'party_category'=>$req->party_category,
          'last_edited_by'=>$user_id,
          'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
    ]);
           return redirect()->route('initiaite_risk_assessment_qual_event',[
            'proj_id'=>$proj_id,
            'user_id'=>$user_id
        ])->with('success','Party Details Edited Successfully');
}


public function delete_party($party_id,$proj_id,$user_id){
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
             DB::table('party')->where('id',$party_id)->delete();
return redirect()->route('initiaite_risk_assessment_qual_event',[
            'proj_id'=>$proj_id,
            'user_id'=>$user_id
        ])->with('success','Party Deleted Successfully');
                }

          
    }

            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    

}

public function strategic_scenarios($party_id,$risk_type,$proj_id,$user_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

        $party=DB::table('party')->where('id',$party_id)->first();

   
        $scenarios=DB::table('party_scenarios')->where('party_type',$party_id)
        ->where('risk_type',$risk_type)
        ->get();
    
            $frameworkDetails = $this->getProjectFrameworkDetails($project);
           
            return view('iso_27005.strategic_scenarios',[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'party'=>$party,
                    'risk_type_selected'=>$risk_type,
                    'scenarios'=>$scenarios
           
                   
            ]);
    }
}

public function iso_sec_2_3_1_qual_event_scenarios($proj_id,$user_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

              $scenarios = DB::table('party_scenarios')
            ->join('party', 'party_scenarios.party_type', '=', 'party.id')
            ->where('party_scenarios.project_id', $proj_id)
            ->select(
                'party_scenarios.id as scenario_id',
                'party_scenarios.*',
                'party.party_name' ,
                'party.party_type as party_type_party',
                'party.party_category'
            )
            ->get();

                  //  dd($scenarios);
             

       
       
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            $services = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();
           
            return view('iso_27005.qual_event_strategic_scenarios',[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'services'=>$services,
                    'scenarios'=>$scenarios
                   
            ]);
    }
}

public function qual_event_add_scenario_form($proj_id,$user_id){
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
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();
   
        $party=DB::table('party')->where('project_id',$proj_id)
        ->get();

    
            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            $services = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();
           
            return view('iso_27005.qual_event_add_form_strategic_scenarios',[
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'services'=>$services,
                    'party'=>$party
                   
            ]);
    }

}

public function submit_new_scenario($proj_id,$user_id,Request $req){

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
       Db::table('party_scenarios')->insert([
            'title'=>$req->title,
            'risk_type'=>$req->risk_type,
            'party_type'=>$req->party_type,
            'last_edited_by'=>$user_id,
            'project_id'=>$proj_id,
            'scenario'=>$req->scenario
            // 'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
       ]);

       return redirect()->route('iso_sec_2_3_1_qual_event_scenarios',[
        'proj_id'=>$proj_id,
        'user_id'=>$user_id
       ])->with('success','Scenario Added Successfully');
       

    

         
    }

}

public function party_strategic_scenario_submit($proj_id,$user_id,Request $req){
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
             
            DB::table('party_scenarios')->insert([
                'party_type'=>$req->party_type,
                'risk_type'=>$req->risk_type,
                'scenario'=>$req->scenario
            ]);

            return redirect()->route('strategic_scenarios',[
                'party_id'=>$req->party_type,
                'risk_type'=>$req->risk_type,
                'proj_id'=>$proj_id,
                'user_id'=>$user_id
            ])->with('success','Scenario Added Successfully');

          
        }


    }
    
    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    
}

public function delete_strategic_scenario($scenario_id,$proj_id,$user_id){
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
             
            DB::table('party_scenarios')->where('id',$scenario_id)->delete();
            return redirect()->back()->with('success','Deleted Successfully');
        

           
          
        }


    }
    
    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

}

    public function iso_sec_2_3_1($asset_id, $proj_id, $user_id)
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


                    $assetData = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                    $filepath = public_path('ISO_SOA_A5.xlsx');
                    $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                    $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)

                   
                    $filepath2 = public_path('ISO_SOA_A6.xlsx');
                    $sec2_4_a6_data = Excel::toArray([], $filepath2); //with header
                    $sec2_4_a6_rows = array_slice($sec2_4_a6_data[0], 1); //without header(first row)

                    $filepath3 = public_path('ISO_SOA_A7.xlsx');
                    $sec2_4_a7_data = Excel::toArray([], $filepath3); //with header
                    $sec2_4_a7_rows = array_slice($sec2_4_a7_data[0], 1); //without header(first row)


                    $filepath4 = public_path('ISO_SOA_A8.xlsx');
                    $sec2_4_a8_data = Excel::toArray([], $filepath4); //with header
                    $sec2_4_a8_rows = array_slice($sec2_4_a8_data[0], 1); //without header(first row)

                    $a5_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '5%')
                        ->get();

    

                    $a6_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '6%')
                        ->get();

            
        

                    $a7_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '7%')
                        ->get();

                    $a8_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '8%')
                        ->get();

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $global_asset_value = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)->first();

                 

                    return view('iso_sec_2_3_1.iso_sec_2_3_1_main', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'assetData' => $assetData,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows,
                        'sec2_4_a6_rows' => $sec2_4_a6_rows,
                        'sec2_4_a7_rows' => $sec2_4_a7_rows,
                        'sec2_4_a8_rows' => $sec2_4_a8_rows,
                        'a5_results' => $a5_results,
                        'a6_results' => $a6_results,
                        'a7_results' => $a7_results,
                        'a8_results' => $a8_results,
                        'project' => $project,
                        'global_asset_value' => $global_asset_value
                    ]);
                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_3_1_initial_add(Request $req, $asset_id, $proj_id, $user_id)
    {


        $risk=Risk::where('asset_id',$asset_id)->get();
        $req->validate([

            'applicability' => ['required', 'array', 'min:1'],
            'control_compliance' => ['required', 'array', 'min:1'],
           // 'vulnerability' => ['required', 'array', 'min:1'],
            'threat' => ['required', 'array', 'min:1'],
           // 'risk_level' => ['required', 'array', 'min:1']
        ]);



        $my_filter = array_filter($req->input('applicability'));
        $req->merge(['applicability' => $my_filter]);
        $applicability = $req->input('applicability');
        $filtered_applicability = array_filter($applicability);



        $my_filter = array_filter($req->input('control_compliance'), function($value) {
            return $value !== null;
        });
        $req->merge(['control_compliance' => $my_filter]);
        $control_compliance = $req->input('control_compliance');
        $filtered_control_compliance = array_filter($control_compliance, function($value) {
            return $value !== null;
        });



        $my_filter = array_filter($req->input('vulnerability'), function($value) {
            return $value !== null;
        });
        $req->merge(['vulnerability' => $my_filter]);
        $vulnerability = $req->input('vulnerability');
        $filtered_vulnerability= array_filter($vulnerability, function($value) {
            return $value !== null;
        });




        $my_filter = array_filter($req->input('threat'), function($value) {
            return $value !== null;
        });
        $req->merge(['threat' => $my_filter]);
        $threat = $req->input('threat');
        $filtered_threat= array_filter($threat, function($value) {
            return $value !== null;
        });



        //  $my_filter = array_filter($req->input('risk_level'), function($value) {
        //     return $value !== null;
        // });
        // $req->merge(['risk_level' => $my_filter]);
        // $risk_level = $req->input('risk_level');
        // $filtered_risk_confidentiality= array_filter($risk_level, function($value) {
        //     return $value !== null;
        // });


        // $my_filter = array_filter($req->input('risk_integrity'), function($value) {
        //     return $value !== null;
        // });
        // $req->merge(['risk_integrity' => $my_filter]);
        // $risk_level = $req->input('risk_integrity');
        // $filtered_risk_integrity= array_filter($risk_level, function($value) {
        //     return $value !== null;
        // });


        // $my_filter = array_filter($req->input('risk_availability'), function($value) {
        //     return $value !== null;
        // });
        // $req->merge(['risk_availability' => $my_filter]);
        // $risk_level = $req->input('risk_availability');
        // $filtered_risk_availability= array_filter($risk_level, function($value) {
        //     return $value !== null;
        // });




        $inputArray = $filtered_applicability;
        $yesNoArray = [];
        $numberArray = [];

        foreach ($inputArray as $key => $value) {
            $parts = explode('+', $value);

            if (count($parts) === 2) {
                $yesNoArray[$key] = $parts[0]; // "yes" or "no" part
                $numberArray[$key] = $parts[1]; // "5.1" or "5.2" part
            }
        }


  


        // try {
        foreach ($yesNoArray as $key => $value) {


                 //only to this asset component
                 $risk_level=((100-$filtered_control_compliance[$key]) / 100.0) * ($filtered_threat[$key] / 100.0) * $req->risk_confidentiality_value;
                 $risk_integrity=((100-$filtered_control_compliance[$key]) / 100.0) * ($filtered_threat[$key] / 100.0) * $req->risk_integrity_value;
 
                 $risk_availability=((100-$filtered_control_compliance[$key]) / 100.0) * ($filtered_threat[$key] / 100.0) * $req->risk_availability_value;

            if(in_array($numberArray[$key],array(8.6,8.13,8.14))){
                       $risk_level=0;  

            }

            if(in_array($numberArray[$key],array(8.6,8.13,8.14,6.6,8.11,8,12))){
                $risk_integrity=0;  

     }

     if(in_array($numberArray[$key],array(6.6,8.11,8,12))){
        $risk_availability=0;  

}




           

                if ($value == "yes") {

                if (isset($filtered_control_compliance[$key]) && isset($filtered_threat[$key]))
                 {

                    // if($numberArray[$key]=='6.6'){
                
                    //    dd($filtered_control_compliance[$key]);
                    // }
                


                    $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->first();

                


                    if($check){ 
                        //if record already exists

                    
                

                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])
                        ->update([
                            'applicability' => "yes",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])->update([

                            'applicability' => "yes",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }else{
                        //record inserting first time

                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,

                            'applicability' => "yes",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,

                       'control_num'=>$numberArray[$key],
                            'applicability' => "yes",
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }




                }
            }
            if ($value == "no") {
                //not to this asset component


                $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                ->where('control_num', $numberArray[$key])->first();

                if($check){

                    DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->update([

                        'applicability' => "no",
                        'control_num'=>$numberArray[$key],
                        'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                        'risk_level' => 0,
                        'risk_integrity'=>0,
                        'risk_availability'=>0,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->update([

                        'applicability' => "no",
                        'control_num'=>$numberArray[$key],
                   'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' => 0,
                        'risk_integrity'=>0,
                        'risk_availability'=>0,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);


                }else{
                    //new record

                DB::table('iso_sec_2_3_1')->insert([
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,

                    'control_num' => $numberArray[$key],
                    'applicability' => "no",
                   'control_compliance' => $filtered_control_compliance[$key],
                     'vulnerability' => 100-$filtered_control_compliance[$key],
                      'threat' => $filtered_threat[$key],
                      'risk_level' => 0,
                      'risk_integrity'=>0,
                      'risk_availability'=>0,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                DB::table('iso_risk_treatment')->insert([
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,

                    'control_num' => $numberArray[$key],
                    'applicability' => "no",
                    'control_compliance' => $filtered_control_compliance[$key],
                    'vulnerability' => 100-$filtered_control_compliance[$key],
                    'threat' => $filtered_threat[$key],
                    'risk_level' => 0,
                    'risk_integrity'=>0,
                    'risk_availability'=>0,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

            }
            }
            if($value=='yes_to_all'){
                if (isset($filtered_control_compliance[$key]) && isset($filtered_threat[$key])){
                    $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->first();

                    if($check){ //if record already exists
                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])
                        ->update([

                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])->update([

                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }else{
                        //record inserting first time

                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,
                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,             
                           'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,
                       'control_num'=>$numberArray[$key],
                            'applicability' => "yes_to_all",
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                         'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }

                $service=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();


                //other assets in this service
            $otherAssets= Db::table('iso_sec_2_1')->where('project_id',$proj_id)
            ->where('s_name',$service->s_name)
            ->where('assessment_id','!=',$asset_id)
            ->get();

            if($otherAssets->count()>0){
                foreach($otherAssets as $other){
                    $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                    ->where('asset_id',$other->assessment_id)->where('control_num', $numberArray[$key])->first();
                    if($check){ //if record already exists
                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$other->assessment_id)
                        ->where('control_num', $numberArray[$key])
                        ->update([
                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                             'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$other->assessment_id)
                        ->where('control_num', $numberArray[$key])->update([
                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }else{

                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $other->assessment_id,
                         'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $other->assessment_id,
                       'control_num'=>$numberArray[$key],
                            'applicability' => "yes",
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                             'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }




                }
            }






                }
            }
        }




        return redirect()->route('iso_sec_2_3_1', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])->with('success', 'Record Added');
    }



    //editing risk assessment
    public function edit_risk_assessment($proj_id, $user_id, $asset_id, $control_num)
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


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $assetData = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                        ->where('control_num', $control_num)->first();

                        $riskData=Db::table('iso_sec_2_1')->where('project_id',$proj_id)
                        ->where('assessment_id',$asset_id)->first();

          


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_edit', [
                        'project' => $project,
                        'assetData' => $assetData,
                        'riskData'=>$riskData,
                        'project_permissions'=>$checkpermission->project_permissions
                    ]);
                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function edit_risk_assessment_update(Request $req, $proj_id, $user_id, $asset_id, $control_num)
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

                    $req->validate([

                        'desc_vulnerability' => 'required',

                         'desc_threat' => 'required', // Ensure the radio button is selected

                       'desc_risk' => 'required|array|min:1',

                    ]);

                     $desc_risk = $req->desc_risk;
                    $desc_risk_json = json_encode($desc_risk);

        

                     Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->update(
                                [
                                    'desc_vulnerability'=>$req->desc_vulnerability,
                                    'desc_vulnerability_other'=>$req->desc_vulnerability_other,
                                    'desc_threat'=>$req->desc_threat,
                                    'desc_threat_other'=>$req->desc_threat_other,
                                    'desc_risk' => $desc_risk_json, // Save as JSON
                                    'desc_risk_other' => $req->desc_risk_other,

                                ]
                            );



                    return redirect()->route('iso_sec_2_3_1', [
                        'asset_id' => $asset_id,
                        'proj_id' => $proj_id,
                        'user_id' => auth()->user()->id
                    ])->with('success', 'Record Updated');
                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function iso_sec_2_3_1_risk($asset_id, $proj_id, $user_id)
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
                    $assets = DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->get();

                    $group = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();
                    //dd($group->g_name);

                    $name = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)
                        ->first();
                    //dd($names);

                    //assume a group willl have unique component names
                    $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $name->name)
                        ->get();
                    //dd($components);



                    $filepath = public_path('ISO_SOA_A5.xlsx');
                    $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                    $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_risk', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'assets' => $assets,
                        'group' => $group->g_name,
                        'name' => $name->name,
                        'components' => $components,
                        'asset_id' => $asset_id,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows

                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function iso_sec2_3_1_risk_treat_controls($asset_id, $proj_id, $user_id)
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

                    $filepath = public_path('ISO_SOA_A5.xlsx');
                    $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                    $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)

                    //dd($sec2_4_a5_rows);

                    $filepath2 = public_path('ISO_SOA_A6.xlsx');
                    $sec2_4_a6_data = Excel::toArray([], $filepath2); //with header
                    $sec2_4_a6_rows = array_slice($sec2_4_a6_data[0], 1); //without header(first row)


                    $filepath3 = public_path('ISO_SOA_A7.xlsx');
                    $sec2_4_a7_data = Excel::toArray([], $filepath3); //with header
                    $sec2_4_a7_rows = array_slice($sec2_4_a7_data[0], 1); //without header(first row)



                    $filepath4 = public_path('ISO_SOA_A8.xlsx');
                    $sec2_4_a8_data = Excel::toArray([], $filepath4); //with header
                    $sec2_4_a8_rows = array_slice($sec2_4_a8_data[0], 1); //without header(first row)


                    $check = DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)->where('applicability', 'yes')
                        ->first();

                       if($check==null){
                        return redirect()->route('risk_treatment',['proj_id'=>$proj_id,'user_id'=>$user_id])->with('error',"No Risk Assessment Done Yet");
                       }

                    //controls wherer applicability is yes
                    $controls = DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                        ->pluck('control_num')->toArray();



                    $assetData = Db::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();


                    $assetDataForFive = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->get();



                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    return view('iso_sec_2_3_1.risk_treatment', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows,
                        'sec2_4_a6_rows' => $sec2_4_a6_rows,
                        'sec2_4_a7_rows' => $sec2_4_a7_rows,
                        'sec2_4_a8_rows' => $sec2_4_a8_rows,
                        'controls' => $controls,
                        'assetData' => $assetData,
                        'check' => $check,
                        'project' => $project,
                        'assetDataForFive' => $assetDataForFive,


                    ]);
                
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_3_2_risk_treat_form($control_num, $asset_id, $proj_id, $user_id)
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
    
                    if ($checkpermission->type_id) {

                        $asset_risk_assess = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();

                        $after_risk_treatment = Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();

                        // dd($asset_risk_assess);

                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                            ->where('projects.project_id', $proj_id)->first();


                            //dd($after_risk_treatment);
                    

                        return view('iso_sec_2_3_1.iso_sec_2_3_2_treatform', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'users' => $users,
                            'treatmentData' => $asset_risk_assess,
                            'assetData' => $assetData,
                            'project' => $project,
                            'after_risk_treatment' => $after_risk_treatment


                        ]);
                    }
                
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_2_treat_form_submit(Request $req, $asset_id, $control_num, $proj_id, $user_id)
    {

        $req->validate([
            'treatment_action' => '',
            'treatment_target_date' => '',
            'treatment_comp_date' => '',
            'responsibility_for_treatment' => '',
            'acceptance_actual_date'
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
                    if ($checkpermission->type_id) {

                        DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->update([
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date'=>$req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        return redirect()->route('iso_sec_2_3_2_risk_treat_form', [
                            'control_num' => $control_num, 'asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id
                        ])->with('success', 'Treatment Action Plan Updated');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function iso_sec_2_3_2_treat_form1_submit(Request $req, $asset_id, $control_num, $proj_id, $user_id)
    {
        $req->validate([
            'applicability'=>'required',
            'residual_risk_treatment' => "required|string",
            'control_compliance' => 'required',
            'vulnerability' => 'required',
            'threat' => 'required',
            'risk_level' => 'required',
            'risk_integrity'=>'required',
            'risk_availability'=>'required'

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

                        if ($req->applicability != "no") {

                            if($req->residual_risk_treatment=="retain and accept risk"){
                            $risk_assessment=DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->first();

                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->update([
                                'residual_risk_treatment' => $req->residual_risk_treatment,
                                'control_compliance' => $risk_assessment->control_compliance,
                                'vulnerability' => $risk_assessment->vulnerability,
                                'threat' => $risk_assessment->threat,
                                'risk_level' => $risk_assessment->risk_level,
                                'risk_integrity' => $risk_assessment->risk_integrity,
                                'risk_availability' => $risk_assessment->risk_availability,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                            ]);


                            }else{


                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                                ->where('asset_id', $asset_id)->update([
                                    'residual_risk_treatment' => $req->residual_risk_treatment,
                                    'control_compliance' => $req->control_compliance,
                                    'vulnerability' => $req->vulnerability,
                                    'threat' => $req->threat,
                                    'risk_level' => $req->risk_level,
                                    'risk_integrity' => $req->risk_integrity,
                                    'risk_availability' => $req->risk_availability,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                                ]);

                            }
                        }

                        if ($req->applicability == "no") {
                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                                ->where('asset_id', $asset_id)->update([
                                    'residual_risk_treatment' => $req->residual_risk_treatment,
                                    'control_compliance' => $req->control_compliance,
                                    'vulnerability' => $req->vulnerability,
                                    'threat' => $req->threat,
                                    'risk_level' => $req->risk_level,
                                    'risk_integrity' => $req->risk_integrity,
                                    'risk_availability' => $req->risk_availability,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                                ]);
                        }

                            return redirect()->route('risk_treatment_edit_action_plan_form', [
                                'asset_id' => $asset_id,  'control_num' => $control_num,
                                 'proj_id' => $proj_id, 'user_id' => $user_id
                            ])->with('success', 'Risk Treatment completed');





                    
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function iso_sec_2_3_2_justification_form_submit(Request $req, $asset_id, $control_num, $proj_id, $user_id){
        $req->validate([
             'acceptance_justification' => '',
            'acceptance_target_date' => '',
             'acceptance_actual_date' => '',
             'acceptance_proposed_responsibility' => '',
            'accepted_by' => ''
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
                    if ($checkpermission->type_id) {

                        DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->update([
                                'acceptance_justification' => $req->acceptance_justification,
                                'acceptance_target_date' => $req->acceptance_target_date,
                                'acceptance_actual_date' => $req->acceptance_actual_date,
                                'acceptance_proposed_responsibility' => $req->acceptance_proposed_responsibility,
                                'accepted_by'=>$req->accepted_by,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        return redirect()->route('iso_sec_2_3_2_risk_treat_form', [
                            'control_num' => $control_num, 'asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id
                        ])->with('success', 'Justification Updated');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }


    }



    public function risk_treatment_edit_action_plan_form($asset_id, $control_num, $proj_id, $user_id)
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
                    if ($checkpermission->type_id) {

                $risk_assessment= Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                    ->where('control_num', $control_num)->first();

                 $asset_risk_assess = Db::table('iso_risk_treatment')->where('project_id', $proj_id)
                 ->where('asset_id', $asset_id)
                     ->where('control_num', $control_num)->first();



                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                            ->where('projects.project_id', $proj_id)->first();



                        return view('iso_sec_2_3_1.iso_sec_2_3_2_actionplanform', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'users' => $users,
                            'treatmentData' => $asset_risk_assess,
                            'risk_assessment'=>$risk_assessment,
                            'assetData' => $assetData,
                            'project' => $project


                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function risk_treatment_justification($asset_id, $control_num, $proj_id, $user_id){
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
              
                    if ($checkpermission->type_id ) {

                        $asset_risk_assess = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();


                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                            ->where('projects.project_id', $proj_id)->first();

                     $after_risk_treatment = Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();


                        return view('iso_sec_2_3_1.iso_sec_2_3_2_justification', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'users' => $users,
                            'treatmentData' => $asset_risk_assess,
                            'assetData' => $assetData,
                            'project' => $project,
                            'after_risk_treatment'=>$after_risk_treatment

                        ]);
                    }
                
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

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
