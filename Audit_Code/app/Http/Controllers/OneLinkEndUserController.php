<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;
use APP\Models\Organization;
use APP\Models\Department;
use App\Models\SubEntity;

class OneLinkEndUserController extends Controller
{
    public function create_one_link_erm_project($user_id, $org_id)
    {
        $project_types = DB::table('project_types')->where('id', 22)->get();
        return view('project.create_project', ['types' => $project_types]);
    }

    public function one_link_inherent_risk_main($proj_id, $user_id)
    {

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
            $permissions = json_decode($checkpermission->project_permissions);

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();



            return view('one_link_inherent_risk.risk_records', [
                'project' => $project,
                'project_permissions' => $checkpermission->project_permissions,
            ]);
        }
        dd("njd");
    }

    public function add_new_risk_record($proj_id,$user_id){
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

       $functions=SubEntity::where('org_id',$project->org_id)->where('department_id',$project->dept_id)
       ->where('sub_entity_type','functions')
       ->get();

       dd($functions);
      

    }
}
