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


    public function v3_2_s3_3_2($proj_id,$user_id){

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){

                    if($checkpermission->type_id==2){
                       $data=DB::table('pci-dss v3_2_1 section3_2')->join('users','pci-dss v3_2_1 section3_2.last_edited_by',
                       'users.id')
                       ->where('project_id',$proj_id)->first();
                       return view('v3_2_section3.section3_2',[
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

    public function v3_2_s3_3_2_form(Request $req,$proj_id,$user_id){
        $req->validate([
            'requirement1'=>'required|max:800',
            'requirement2'=>'required|max:800',
            'requirement3'=>'required|max:800',
            'requirement4'=>'required|max:800',

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
                   DB::table('pci-dss v3_2_1 section3_2')->insert([
                    'project_id'=>$proj_id,
                    'requirement1'=>$req->requirement1,
                    'requirement2'=>$req->requirement2,
                    'requirement3'=>$req->requirement3,
                    'requirement4'=>$req->requirement4,
                    'other_details'=>$req->other_details,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                   ]);
                   return redirect()->route('section3_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record added successfully');

                }
            }


    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_2_edit($assessment_id,$proj_id,$user_id){

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
                  $data= DB::table('pci-dss v3_2_1 section3_2')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   return view('v3_2_section3.section3_2_edit',[
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

public function v3_2_s3_3_2_edit_form(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:800',
        'requirement2'=>'required|max:800',
        'requirement3'=>'required|max:800',
        'requirement4'=>'required|max:800',

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
               DB::table('pci-dss v3_2_1 section3_2')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
               ->update([
                'requirement1'=>$req->requirement1,
                'requirement2'=>$req->requirement2,
                'requirement3'=>$req->requirement3,
                'requirement4'=>$req->requirement4,
                'other_details'=>$req->other_details,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

               ]);
               return redirect()->route('section3_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
               ->with('success','Record edited successfully');

            }
        }


}

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_3($proj_id,$user_id){


    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 section3_3')->join('users','pci-dss v3_2_1 section3_3.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->first();
                   return view('v3_2_section3.section3_3',[
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

public function v3_2_s3_3_3_insert(Request $req,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required',
        'requirement6'=>'required'
    ],
[
    'requirement*.required'=>'The field is required'
]);

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

                if($req->requirement1=='no'){

               DB::table('pci-dss v3_2_1 section3_3')
               ->insert([
                'project_id'=>$proj_id,
                'requirement1'=>$req->requirement1,
                'segmentation_not_used'=>$req->segmentation_not_used,
                'requirement6'=>$req->requirement6,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

               ]);
               return redirect()->route('section3_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
               ->with('success','Record Added successfully');
            }
            if($req->requirement1=='yes'){

                DB::table('pci-dss v3_2_1 section3_3')
                ->insert([
                 'project_id'=>$proj_id,
                 'requirement1'=>$req->requirement1,
                 'segmentation_used'=>$req->segmentation_used,
                 'segmentation_used_req1'=>$req->segmentation_used_req1,
                 'segmentation_used_req2'=>$req->segmentation_used_req2,
                 'segmentation_used_req3'=>$req->segmentation_used_req3,
                 'segmentation_used_req4'=>$req->segmentation_used_req4,
                 'segmentation_used_req5'=>$req->segmentation_used_req5,
                 'requirement6'=>$req->requirement6,
                 'last_edited_by'=>$user_id,
                 'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                ]);
                return redirect()->route('section3_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Added successfully');
            }

            }
        }


}

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_3_edit($assessment_id,$proj_id,$user_id){

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
                  $data= DB::table('pci-dss v3_2_1 section3_3')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   return view('v3_2_section3.section3_3_edit',[
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

public function v3_2_s3_3_3_edit_form(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required',
        'requirement6'=>'required'
    ],
[
    'requirement*.required'=>'The field is required'
]);

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

                if($req->requirement1=='no'){

               DB::table('pci-dss v3_2_1 section3_3')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
               ->update([
                'requirement1'=>$req->requirement1,
                'segmentation_not_used'=>$req->segmentation_not_used,
                'requirement6'=>$req->requirement6,
                'segmentation_used'=>null,
                 'segmentation_used_req1'=>null,
                 'segmentation_used_req2'=>null,
                 'segmentation_used_req3'=>null,
                 'segmentation_used_req4'=>null,
                 'segmentation_used_req5'=>null,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

               ]);
               return redirect()->route('section3_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
               ->with('success','Record edited successfully');
            }
            if($req->requirement1=='yes'){
                DB::table('pci-dss v3_2_1 section3_3')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                ->update([
                 'requirement1'=>$req->requirement1,
                 'segmentation_not_used'=>null,
                 'segmentation_used'=>$req->segmentation_used,
                 'segmentation_used_req1'=>$req->segmentation_used_req1,
                 'segmentation_used_req2'=>$req->segmentation_used_req2,
                 'segmentation_used_req3'=>$req->segmentation_used_req3,
                 'segmentation_used_req4'=>$req->segmentation_used_req4,
                 'segmentation_used_req5'=>$req->segmentation_used_req5,
                 'requirement6'=>$req->requirement6,
                 'last_edited_by'=>$user_id,
                 'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                ]);
                return redirect()->route('section3_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record edited successfully');
            }

            }
        }


}

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_4($proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $dataone=DB::table('pci-dss v3_2_1 section3_4')->join('users','pci-dss v3_2_1 section3_4.last_edited_by',
                   'users.id')->where('network_type',1)
                   ->where('project_id',$proj_id)->get();

                   $datatwo=DB::table('pci-dss v3_2_1 section3_4')->join('users','pci-dss v3_2_1 section3_4.last_edited_by',
                   'users.id')->where('network_type',2)
                   ->where('project_id',$proj_id)->get();

                   $datathree=DB::table('pci-dss v3_2_1 section3_4')->join('users','pci-dss v3_2_1 section3_4.last_edited_by',
                   'users.id')->where('network_type',3)
                   ->where('project_id',$proj_id)->get();


                   return view('v3_2_section3.section3_4',[
                    'dataone'=>$dataone,
                    'datatwo'=>$datatwo,
                    'datathree'=>$datathree,
                    'project_id'=>$checkpermission->project_id,
                    'project_name'=>$checkpermission->project_name,
                    'project_permissions'=>$checkpermission->project_permissions
                   ]);
                }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_4_insert(Request $req,$proj_id,$user_id){
    $req->validate([
        'network_name'=>'required|max:200',
        'purpose_of_network'=>'required|max:800'

    ]);

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                   DB::table('pci-dss v3_2_1 section3_4')->insert([
                    'project_id'=>$proj_id,
                    'network_type'=>$req->network_type,
                    'network_name'=>$req->network_name,
                    'purpose_of_network'=>$req->purpose_of_network,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                   ]);

                   return redirect()->route('section3_4',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');



                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_4_edit($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    $data=DB::table('pci-dss v3_2_1 section3_4')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();
                    if($data){
                        return view('v3_2_section3.section3_4_edit',[
                            'data'=>$data,
                            'project_id'=>$checkpermission->project_id,
                            'project_name'=>$checkpermission->project_name,
                        ]);
                    }


                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_4_edit_form(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'network_name'=>'required|max:200',
        'purpose_of_network'=>'required|max:800'

    ]);

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                   DB::table('pci-dss v3_2_1 section3_4')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                   ->update([
                    'network_name'=>$req->network_name,
                    'purpose_of_network'=>$req->purpose_of_network,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                   ]);

                   return redirect()->route('section3_4',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');



                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_4_new($network_type,$proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

            return view('v3_2_section3.add_new_network',[
                'project_id'=>$checkpermission->project_id,
                'project_name'=>$checkpermission->project_name,
                'network_type'=>$network_type
            ]);




                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_4_delete($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                   DB::table('pci-dss v3_2_1 section3_4')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                   ->delete();

                   return redirect()->route('section3_4',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');



                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_5($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 section3_5')->join('users','pci-dss v3_2_1 section3_5.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->get();
                   return view('v3_2_section3.section3_5',[
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

public function v3_2_s3_3_5_insert(Request $req,$proj_id,$user_id){
            $req->validate([
                'requirement1'=>'required|max:200',
                'requirement2'=>'required',
                'requirement3'=>'required',
                'requirement4'=>'required|max:800'
            ],
        [
            'requirement*.required'=>'The field is required'
        ]);


    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_5')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>json_encode($req->requirement3),
                        'requirement4'=>$req->requirement4,
                       'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                    ]);


                   return redirect()->route('section3_5',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');



                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_5_new($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    return view('v3_2_section3.section3_5_new',[
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name
                       ]);

                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_5_edit($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                   $data= Db::table('pci-dss v3_2_1 section3_5')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();
                    if($data){
                        return view('v3_2_section3.section3_5_edit',[
                            'project_id'=>$checkpermission->project_id,
                            'project_name'=>$checkpermission->project_name,
                            'data'=>$data
                           ]);


                    }




                }
            }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_5_editform(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:200',
        'requirement2'=>'required',
        'requirement3'=>'required',
        'requirement4'=>'required|max:800'
    ],
[
    'requirement*.required'=>'The field is required'
]);


        if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_5')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>json_encode($req->requirement3),
                        'requirement4'=>$req->requirement4,
                    'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                    ]);


                return redirect()->route('section3_5',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Edited successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_5_delete($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_5')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();


                return redirect()->route('section3_5',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Deleted successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_6($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data1=DB::table('pci-dss v3_2_1 section3_6 wholly_owned')
                   ->join('users','pci-dss v3_2_1 section3_6 wholly_owned.last_edited_by','users.id')
                   ->where('project_id',$proj_id)->get();

                   $data2=Db::table('pci-dss v3_2_1 section3_6 international')
                   ->join('users','pci-dss v3_2_1 section3_6 international.last_edited_by','users.id')
                   ->where('project_id',$proj_id)->get();



                   return view('v3_2_section3.section3_6',[
                    'data1'=>$data1,
                    'data2'=>$data2,
                    'project_id'=>$checkpermission->project_id,
                    'project_name'=>$checkpermission->project_name,
                    'project_permissions'=>$checkpermission->project_permissions
                   ]);
                }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_6_insert(Request $req,$proj_id,$user_id){
$req->validate([
    'wholly_owned_entity'=>'required|max:100',
    'requirement1'=>'required|max:800',
    'requirement2'=>'required|max:800',
],[
    'requirement*.required'=>'The field is required'
]);


if($user_id==auth()->user()->id){
    $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
    ->join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){
    $permissions=json_decode($checkpermission->project_permissions);
    if(in_array('Data Inputter',$permissions)){
            if($checkpermission->type_id==2){
                Db::table('pci-dss v3_2_1 section3_6 wholly_owned')->insert([
                    'project_id'=>$proj_id,
                    'wholly_owned_entity'=>$req->wholly_owned_entity,
                    'requirement1'=>$req->requirement1,
                    'requirement2'=>$req->requirement2,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),


                ]);


            return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
            ->with('success','Record Added successfully');



            }
        }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}


public function v3_2_s3_3_5_add_new($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    return view('v3_2_section3.section3_6_addnew',[
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);



                return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Added successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_6_edit_wholly($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    $wholly=DB::table('pci-dss v3_2_1 section3_6 wholly_owned')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();

                    return view('v3_2_section3.section3_6_edit',[
                        'data1'=>$wholly,
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);

                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_6_edit_form(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'wholly_owned_entity'=>'required|max:100',
        'requirement1'=>'required|max:800',
        'requirement2'=>'required|max:800',
    ],[
        'requirement*.required'=>'The field is required'
    ]);



        if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_6 wholly_owned')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)
                    ->update([
                        'project_id'=>$proj_id,
                        'wholly_owned_entity'=>$req->wholly_owned_entity,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                    ]);


                return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Edited successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_6_delete_wholly($assessment_id,$proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_6 wholly_owned')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->delete();


                return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Deleted successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}


public function v3_2_s3_3_6_international(Request $req,$proj_id,$user_id){

    $req->validate([
        'entity_name'=>'required|max:100',
        'entity_country'=>'required|max:100',
        'requirement1'=>'required|max:800',
        'requirement2'=>'required|max:800',
    ],[
        'requirement*.required'=>'The field is required'
    ]);



        if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_6 international')
                    ->insert([
                        'project_id'=>$proj_id,
                        'entity_name'=>$req->entity_name,
                        'entity_country'=>$req->entity_country,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                    ]);


                return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record added successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_6_inter_new($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    return view('v3_2_section3.section3_6_inter_new',[
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);


                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_6_edit_inter($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    $data2=DB::table('pci-dss v3_2_1 section3_6 international')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();

                    return view('v3_2_section3.section3_6_inter_edit',[
                        'data2'=>$data2,
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);

                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_6_inter_editform(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'entity_name'=>'required|max:100',
        'entity_country'=>'required|max:100',
        'requirement1'=>'required|max:800',
        'requirement2'=>'required|max:800',
    ],[
        'requirement*.required'=>'The field is required'
    ]);



        if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_6 international')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)
                    ->update([
                        'entity_name'=>$req->entity_name,
                        'entity_country'=>$req->entity_country,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                    ]);


                return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Edited successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_6_delete_inter($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_6 international')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->delete();


                return redirect()->route('section3_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Deleted successfully');



                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s3_3_7($proj_id,$user_id){


    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 section3_7')->join('users','pci-dss v3_2_1 section3_7.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->first();
                   return view('v3_2_section3.section3_7',[
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

public function v3_2_s3_3_7_insert(Request $req,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:3',
        'if_no'=>'max:1000',
        'requirement2'=>'max:3',
        'requirement3'=>'max:3',
        'requirement4'=>'max:3'
    ],
    [
'requirement1.required'=>'The field is required'
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

                if($req->requirement1=='no'){

               DB::table('pci-dss v3_2_1 section3_7')
               ->insert([
                'project_id'=>$proj_id,
                'requirement1'=>$req->requirement1,
                'if_no'=>$req->if_no,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

               ]);
               return redirect()->route('section3_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
               ->with('success','Record Added successfully');
            }
            if($req->requirement1=='yes'){

                DB::table('pci-dss v3_2_1 section3_7')
                ->insert([
                 'project_id'=>$proj_id,
                 'requirement1'=>$req->requirement1,
                 'requirement2'=>$req->requirement2,
                 'requirement3'=>$req->requirement3,
                 'requirement4'=>$req->requirement4,
                 'last_edited_by'=>$user_id,
                 'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                ]);
                return redirect()->route('section3_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Added successfully');
            }

            }
        }


}

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_7_edit($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    $data=DB::table('pci-dss v3_2_1 section3_7')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();

                    return view('v3_2_section3.section3_7_edit',[
                        'data'=>$data,
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);

                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_7_editform(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:3',
        'if_no'=>'max:1000',
        'requirement2'=>'max:3',
        'requirement3'=>'max:3',
        'requirement4'=>'max:3'
    ],
    [
'requirement1.required'=>'The field is required'
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

                if($req->requirement1=='no'){

               DB::table('pci-dss v3_2_1 section3_7')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
               ->update([
                'requirement1'=>$req->requirement1,
                'if_no'=>$req->if_no,
                'requirement2'=>null,
                'requirement3'=>null,
                'requirement4'=>null,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

               ]);
               return redirect()->route('section3_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
               ->with('success','Record Edited successfully');
            }
            if($req->requirement1=='yes'){

                DB::table('pci-dss v3_2_1 section3_7')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                ->update([
                 'requirement1'=>$req->requirement1,
                 'if_no'=>'null',
                 'requirement2'=>$req->requirement2,
                 'requirement3'=>$req->requirement3,
                 'requirement4'=>$req->requirement4,
                 'last_edited_by'=>$user_id,
                 'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                ]);
                return redirect()->route('section3_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Edited successfully');
            }

            }
        }


}

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_8($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data1=DB::table('pci-dss v3_2_1 section3_8 in_scope')
                   ->join('users','pci-dss v3_2_1 section3_8 in_scope.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->get();

                   $data2=DB::table('pci-dss v3_2_1 section3_8 out_scope')
                   ->join('users','pci-dss v3_2_1 section3_8 out_scope.last_edited_by',
                   'users.id')->where('project_id',$proj_id)->get();


                   return view('v3_2_section3.section3_8',[
                    'data1'=>$data1,
                    'data2'=>$data2,
                    'project_id'=>$checkpermission->project_id,
                    'project_name'=>$checkpermission->project_name,
                    'project_permissions'=>$checkpermission->project_permissions
                   ]);
                }

    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_8_inscope(Request $req,$proj_id,$user_id){
        $req->validate([
        'wireless_technology'=>'required|max:200',
        'requirement1'=>'required|max:3',
        'requirement2'=>'required|max:3',
        'requirement3'=>'required|max:3',
        ]);

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
            'project_details.project_permissions','projects.project_name','projects.project_id')
            ->join('projects','project_details.project_code','projects.project_id')
            ->join('project_types','projects.project_type','project_types.id')
            ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
            ->first();
            if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                        Db::table('pci-dss v3_2_1 section3_8 in_scope')
                        ->insert([
                            'project_id'=>$proj_id,
                            'wireless_technology'=>$req->wireless_technology,
                            'requirement1'=>$req->requirement1,
                            'requirement2'=>$req->requirement2,
                            'requirement3'=>$req->requirement3,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                        ]);


                    return redirect()->route('section3_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                    ->with('success','Record Added successfully');

                    }
                }

            }

            }
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_8_wireless_edit($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    $data1=DB::table('pci-dss v3_2_1 section3_8 in_scope')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();

                    return view('v3_2_section3.section3_8_in_scope_edit',[
                        'data1'=>$data1,
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);

                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_8_inscope_edit(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'wireless_technology'=>'required|max:200',
        'requirement1'=>'required|max:3',
        'requirement2'=>'required|max:3',
        'requirement3'=>'required|max:3',
        ]);

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
            'project_details.project_permissions','projects.project_name','projects.project_id')
            ->join('projects','project_details.project_code','projects.project_id')
            ->join('project_types','projects.project_type','project_types.id')
            ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
            ->first();
            if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                        Db::table('pci-dss v3_2_1 section3_8 in_scope')->where('assessment_id',$assessment_id)
                        ->where('project_id',$proj_id)
                        ->update([
                            'wireless_technology'=>$req->wireless_technology,
                            'requirement1'=>$req->requirement1,
                            'requirement2'=>$req->requirement2,
                            'requirement3'=>$req->requirement3,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                        ]);


                    return redirect()->route('section3_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                    ->with('success','Record Edited successfully');

                    }
                }

            }

            }
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_8_inscope_new($proj_id,$user_id){

        if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){

                return view('v3_2_section3.section3_8_add_new_inscope',[
                    'project_id'=>$checkpermission->project_id,
                    'project_name'=>$checkpermission->project_name,
                ]);




                    }
                }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_3_8_outscope(Request $req,$proj_id,$user_id){

    $req->validate([
        'wireless_out_scope'=>'required|max:200',
        'description'=>'required|max:1000',

        ]);

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
            'project_details.project_permissions','projects.project_name','projects.project_id')
            ->join('projects','project_details.project_code','projects.project_id')
            ->join('project_types','projects.project_type','project_types.id')
            ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
            ->first();
            if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                        Db::table('pci-dss v3_2_1 section3_8 out_scope')
                        ->insert([
                            'project_id'=>$proj_id,
                            'wireless_out_scope'=>$req->wireless_out_scope,
                            'description'=>$req->description,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                        ]);


                    return redirect()->route('section3_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                    ->with('success','Record Added successfully');

                    }
                }

            }

            }
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}


public function v3_2_s3_3_8_out_scope_new($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){

                return view('v3_2_section3.section3_8_add_new_outscope',[
                    'project_id'=>$checkpermission->project_id,
                    'project_name'=>$checkpermission->project_name,
                ]);

                    }
                }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s3_3_8_wireless_out_edit($assessment_id,$proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                    $data2=DB::table('pci-dss v3_2_1 section3_8 out_scope')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->first();

                    return view('v3_2_section3.section3_8_out_scope_edit',[
                        'data2'=>$data2,
                        'project_id'=>$checkpermission->project_id,
                        'project_name'=>$checkpermission->project_name,
                       ]);

                }
            }

        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_8_outscope_edit(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'wireless_out_scope'=>'required|max:200',
        'description'=>'required|max:1000',

        ]);

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
            'project_details.project_permissions','projects.project_name','projects.project_id')
            ->join('projects','project_details.project_code','projects.project_id')
            ->join('project_types','projects.project_type','project_types.id')
            ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
            ->first();
            if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                        Db::table('pci-dss v3_2_1 section3_8 out_scope')->where('assessment_id',$assessment_id)
                        ->where('project_id',$proj_id)
                        ->update([

                            'wireless_out_scope'=>$req->wireless_out_scope,
                            'description'=>$req->description,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                        ]);


                    return redirect()->route('section3_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                    ->with('success','Record edited successfully');

                    }
                }

            }

            }
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s3_3_8_wireless_delete($assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
        ->join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    Db::table('pci-dss v3_2_1 section3_8 in_scope')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id)->delete();


                return redirect()->route('section3_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record Deleted successfully');

                }
            }

        }

        }

        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }
    public function v3_2_s3_3_8_wireless_out_delete($assessment_id,$proj_id,$user_id){
        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
            'project_details.project_permissions','projects.project_name','projects.project_id')
            ->join('projects','project_details.project_code','projects.project_id')
            ->join('project_types','projects.project_type','project_types.id')
            ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
            ->first();
            if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                        Db::table('pci-dss v3_2_1 section3_8 out_scope')->where('assessment_id',$assessment_id)
                        ->where('project_id',$proj_id)->delete();


                    return redirect()->route('section3_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                    ->with('success','Record Deleted successfully');

                    }
                }

            }

            }

            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


    }
}
