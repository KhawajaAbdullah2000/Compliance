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
}
