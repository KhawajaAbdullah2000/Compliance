<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;

class InternalAudit extends Controller
{
    public function internal_audit_level_1($level_num,$proj_id,$user_id){
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

                
                 $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();

                        
                    $filepath = public_path('internal_audit_sheet.xlsx');
                    $rows = Excel::toArray([], $filepath); //with header
                    $data = array_slice($rows[0], 1); //without header(first row)

           $filteredData = collect($data)->filter(function ($row) use ($level_num) {
            return isset($row[0]) && strval($row[0]) == $level_num;
        })->values()->all();

        return view('internal_audit.main_level2',[
            'project'=>$project,
            'project_permissions'=>$checkpermission->project_permissions,
            'data'=>$filteredData
        ]);

                    }

                }

                 return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            

    }

    public function internal_audit_level_2($level1_num,$level2_num,$proj_id,$user_id){
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

                
                 $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();

                        
                    $filepath = public_path('internal_audit_sheet.xlsx');
                    $rows = Excel::toArray([], $filepath); //with header
                    $data = array_slice($rows[0], 1); //without header(first row)

           $filteredData = collect($data)->filter(function ($row) use ($level1_num,$level2_num) {
            return (isset($row[0]) && strval($row[0]) == $level1_num) &&(isset($row[2]) && strval($row[02]) == $level2_num) ;
        })->values()->all();



        return view('internal_audit.form',[
            'project'=>$project,
            'project_permissions'=>$checkpermission->project_permissions,
            'data'=>$filteredData
        ]);


                    }

                }

                 return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            
    }
}
