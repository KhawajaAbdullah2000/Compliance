<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class IsoSec2_4_A5 extends Controller
{
        //iso sec2.5 Appendix5 Organizational COntrols
        public function iso_sec2_4_a5($proj_id,$user_id){
            if($user_id==auth()->user()->id){
                $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
            'project_details.project_permissions','projects.project_name')
           -> join('projects','project_details.project_code','projects.project_id')
            ->join('project_types','projects.project_type','project_types.id')
            ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
            ->first();
            if($checkpermission){
                $permissions=json_decode($checkpermission->project_permissions);
                        if($checkpermission->type_id==4){
                           //reading excel file
                           $filepath=public_path('ISO_SOA_A5.xlsx');
                           $data = Excel::toArray([], $filepath); //with header
                           $rows = array_slice($data[0], 1); //without header(first row)
                           //dd($rows);
                           return view('iso.iso_sec2_4_a5',
                           ['project_id'=>$proj_id,
                           'project_name'=>$checkpermission->project_name,
                           'data'=>$rows
                           ]
                        );

                        }


            }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
        }
}
