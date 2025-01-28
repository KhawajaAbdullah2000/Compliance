<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RiskHeatmap extends Controller
{
    public function severity_impact($proj_id,$user_id){
        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
        )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
            ->first();

        if ($checkpermission) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                $results = Db::table('iso_sec_2_1')
                ->select('s_name', 'risk_integrity', 'risk_availability', 'risk_confidentiality')
                ->where('project_id', $proj_id)
                ->groupBy('s_name', 'risk_integrity', 'risk_availability', 'risk_confidentiality')
                ->get();               
                

                return view('heatmap.severity_impact',[
                    'project'=>$project,
                    'results'=>$results
                ]);

        }

    }

    public function heatmap_all_services_all_risks($proj_id,$user_id){
        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
        )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
            ->first();

        if ($checkpermission) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

    $results_data_confidentiality = DB::table('iso_sec_2_3_1')
    ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
    ->where('iso_sec_2_3_1.project_id', $proj_id)
    ->selectRaw("
        iso_sec_2_1.risk_confidentiality,
        CASE 
            WHEN iso_sec_2_3_1.risk_level >= 0.0 AND iso_sec_2_3_1.risk_level < 0.9999 THEN 'low'
            WHEN iso_sec_2_3_1.risk_level >= 0.999 AND iso_sec_2_3_1.risk_level < 7.2 THEN 'medium'
            WHEN iso_sec_2_3_1.risk_level >= 7.2 AND iso_sec_2_3_1.risk_level <= 10.0 THEN 'high'
        END AS risk_category,
        COUNT(*) as count,
        MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
        MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    ")
    ->groupBy('iso_sec_2_1.risk_confidentiality', 'risk_category')
    ->get();

        
    $results_data_integrity = DB::table('iso_sec_2_3_1')
    ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
    ->where('iso_sec_2_3_1.project_id', $proj_id)
    ->selectRaw("
        iso_sec_2_1.risk_integrity,
        CASE 
            WHEN iso_sec_2_3_1.risk_integrity >= 0.0 AND iso_sec_2_3_1.risk_integrity < 0.9999 THEN 'low'
            WHEN iso_sec_2_3_1.risk_integrity >= 0.999 AND iso_sec_2_3_1.risk_integrity < 7.2 THEN 'medium'
            WHEN iso_sec_2_3_1.risk_integrity >= 7.2 AND iso_sec_2_3_1.risk_integrity <= 10.0 THEN 'high'
        END AS risk_category,
        COUNT(*) as count,
        MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
        MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    ")
    ->groupBy('iso_sec_2_1.risk_integrity', 'risk_category')
    ->get();

    $results_data_availability = DB::table('iso_sec_2_3_1')
    ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
    ->where('iso_sec_2_3_1.project_id', $proj_id)
    ->selectRaw("
        iso_sec_2_1.risk_availability,
        CASE 
            WHEN iso_sec_2_3_1.risk_availability >= 0.0 AND iso_sec_2_3_1.risk_availability < 0.9999 THEN 'low'
            WHEN iso_sec_2_3_1.risk_availability >= 0.999 AND iso_sec_2_3_1.risk_availability < 7.2 THEN 'medium'
            WHEN iso_sec_2_3_1.risk_availability >= 7.2 AND iso_sec_2_3_1.risk_availability <= 10.0 THEN 'high'
        END AS risk_category,
        COUNT(*) as count,
        MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
        MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    ")
    ->groupBy('iso_sec_2_1.risk_availability', 'risk_category')
    ->get();



        }
    }
}
