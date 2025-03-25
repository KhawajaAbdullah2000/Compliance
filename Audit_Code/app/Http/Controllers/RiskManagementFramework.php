<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;

class RiskManagementFramework extends Controller
{
    public function select_projects_for_framework($org_id){
        $org_projects=DB::table('organization_project_types')
        ->join('project_types','organization_project_types.project_type_id','project_types.id')
        ->where('org_id',$org_id)
        ->select('project_type_id','type','org_id')
        ->get();
      
        return view('risk_management.select_projects',[
            'org_projects'=>$org_projects
        ]);
    }

    public function selected_projects_for_framework($org_id,Request $req){
        $req->validate([
            'risk_management_methodology'=>'required'
         ]);
        $project_types_selected = [];
        foreach ($req->risk_management_methodology as $proj_type) {
            $project_types_selected[] = $proj_type; // append to array
        }

        $projects=DB::table('project_types')->whereIn("id",$project_types_selected)->get();
        $frameworks=DB::table('risk_management_framework')->get();
        
        return view("risk_management.select_framework",[
            'projects'=>$projects,
            'frameworks'=>$frameworks
        ]);

    }

    public function selected_project_and_framework($org_id,Request $req){
         $req->validate([
            'framework'=>'required'
         ]);

         foreach($req->selected_projects as $proj){
            DB::table('org_projects_framework_selected')
            ->updateOrInsert([
                'org_id'=>$org_id,
                'project_type_id'=>$proj,
            ],
        [
            'framework_selected'=>$req->framework
        ]
    );
         }

    $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

    $risk_management_framework=DB::table('org_projects_framework_selected')
    ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
    'risk_management_framework.framework_id')
    ->where('org_id',$org_id)->first();
 
    
$framework_approaches=DB::table('framework_approach_types')->get();

      return view("risk_management.choose_framework_approach",[
        'projects'=>$projects,
        'framework_approaches'=>$framework_approaches,
        'framework_name'=>$risk_management_framework->framework_name

      ]);

    }

    public function selected_framework_approach($org_id,Request $req){
        $req->validate([
            'framework_approach'=>'required'
        ]);

        foreach($req->selected_projects as $proj){
            DB::table('org_framework_approach_selected')
            ->updateOrInsert([
                'org_projects_framework_selected'=>$proj,
                'framework_approach_types'=>$req->framework_approach,
            ],
        [
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
        ]
    );
         }

         $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

         $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();

            $framework_approach=Db::table('framework_approach_types')
            ->where('framework_approach_types_id',$req->framework_approach)
            ->first();
         //Qualitative
         if($req->framework_approach==1){
         
            return view('risk_management.consequence_scale_qualitative',[
                'projects'=>$projects,
                'framework_name'=>$risk_management_framework->framework_name,
                'framework_approach'=>$framework_approach->approach_name
            ]);

         }

    }
}
