<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class v3_2_s3_Controller extends Controller
{
    public function v3_2_section3_subsections($proj_id,$user_id){
        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){

                    if($checkpermission->type_id==2){
                        return view('v3_2_section3.section3_subsections',
                        ['project_id'=>$checkpermission->project_id,'project_name'=>$checkpermission->project_name]);
                    }


        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
    }

    public function v3_2_s3_3_1($proj_id,$user_id){

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){

                    if($checkpermission->type_id==2){
                       $data=DB::table('pci-dss v3_2_1 section3_1')->join('users','pci-dss v3_2_1 section3_1.last_edited_by',
                       'users.id')
                       ->where('project_id',$proj_id)->first();
                       return view('v3_2_section3.section3_1',[
                        'data'=>$data,
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                        'project_permissions'=>$checkpermission->project_permissions
                       ]);
                    }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }

    public function v3_2_s3_3_1_form(Request $req,$proj_id,$user_id){
        $req->validate([
            'requirement1'=>'required|max:800',
            'requirement2'=>'required|max:800',
            'requirement3'=>'required|max:800',
            'requirement4'=>'required|max:800',
            'requirement5'=>'required|max:800',
            'requirement6'=>'required|max:800',
        ],[
            'requirement*.required'=>'The field is required'
        ]

    );

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                   DB::table('pci-dss v3_2_1 section3_1')->insert([
                    'project_id'=>$proj_id,
                    'requirement1'=>$req->requirement1,
                    'requirement2'=>$req->requirement2,
                    'requirement3'=>$req->requirement3,
                    'requirement4'=>$req->requirement4,
                    'requirement5'=>$req->requirement5,
                    'requirement6'=>$req->requirement6,
                    'other_details'=>$req->other_details,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                   ]);
                   return redirect()->route('section3_1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record added successfully');

                }
            }


    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
    }


    public function v3_2_s3_3_1_edit($assessment_id,$proj_id,$user_id){
        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                      $data= DB::table('pci-dss v3_2_1 section3_1')->where('assessment_id',$assessment_id)
                       ->where('project_id',$proj_id)->first();
                       return view('v3_2_section3.section3_1_edit',[
                        'project_id'=>$checkpermission->project_id,
                       'project_name'=>$checkpermission->project_name,
                       'data'=>$data
                    ]);


                    }
                }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }

    public function v3_2_s3_3_1_edit_submit(Request $req,$assessment_id,$proj_id,$user_id){

        $req->validate([
            'requirement1'=>'required|max:800',
            'requirement2'=>'required|max:800',
            'requirement3'=>'required|max:800',
            'requirement4'=>'required|max:800',
            'requirement5'=>'required|max:800',
            'requirement6'=>'required|max:800',
        ],[
            'requirement*.required'=>'The field is required'
        ]

    );

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                   DB::table('pci-dss v3_2_1 section3_1')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                   ->update([
                    'requirement1'=>$req->requirement1,
                    'requirement2'=>$req->requirement2,
                    'requirement3'=>$req->requirement3,
                    'requirement4'=>$req->requirement4,
                    'requirement5'=>$req->requirement5,
                    'requirement6'=>$req->requirement6,
                    'other_details'=>$req->other_details,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                   ]);
                   return redirect()->route('section3_1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record edited successfully');

                }
            }


    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }
}
