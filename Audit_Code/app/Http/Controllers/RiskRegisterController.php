<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RiskRegisterController extends Controller
{
    public function risk_register_dashboard($proj_id, $user_id)
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

                $assets = DB::table('iso_sec_2_1')
                    ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                    ->join('proj_asset_likelihood_value', 'iso_sec_2_1.assessment_id', 'proj_asset_likelihood_value.asset_id')
                    ->join('proj_asset_likelihood_timeframe', 'iso_sec_2_1.assessment_id', 'proj_asset_likelihood_timeframe.asset_id')
                    ->join('proj_asset_selected_level_of_threat', 'iso_sec_2_1.assessment_id', 'proj_asset_selected_level_of_threat.asset_id')
                    ->join('global_level_of_threats', 'proj_asset_selected_level_of_threat.threat_selected', 'global_level_of_threats.global_level_of_threats_id')
                    ->join('proj_asset_selected_level_of_vulnerability', 'iso_sec_2_1.assessment_id', 'proj_asset_selected_level_of_vulnerability.asset_id')
                    ->join('global_level_of_vulnerability', 'proj_asset_selected_level_of_vulnerability.vulnerability_selected', 'global_level_of_vulnerability.global_level_of_vulnerability_id')

                    ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                    ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                    ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                    ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                    ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                    ->select(
                        'iso_sec_2_1.*',
                        'proj_asset_likelihood_value.*',
                        'proj_asset_likelihood_timeframe.*',
                        'proj_asset_selected_level_of_threat.*',
                        'global_level_of_threats.*',
                        'proj_asset_selected_level_of_vulnerability.*',
                        'global_level_of_vulnerability.*',
                        DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                        DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                        DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                        DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                        DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                        DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                    )
                    ->where('iso_sec_2_1.project_id', $proj_id)
                    ->get();


                //dd($assets);

                $frameworkDetails = $this->getProjectFrameworkDetails($project);
                //dd($frameworkDetails);

                return view('risk_register.risk_register_dashboard', [

                    'project' => $project,
                    'assets' => $assets,
                    'project_permissions' => $checkpermission->project_permissions,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach']

                ]);
            }
        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
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
