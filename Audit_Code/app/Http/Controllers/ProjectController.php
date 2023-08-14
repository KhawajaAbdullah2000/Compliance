<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function assigned_projects($user_id){
        $projects=Project::join('project_details','projects.project_id','project_details.project_code')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_details.assigned_enduser',$user_id)->get(
            ['projects.project_name',
            'project_types.type',
            'projects.status',
            'project_details.project_permissions'
            
        ]);
        return view('assigned_projects.my_projects',['projects'=>$projects]);
       
    }
}
