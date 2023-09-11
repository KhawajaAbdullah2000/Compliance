<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class v3_2_s4_Controller extends Controller
{
    public function v3_2_section4_subsections($proj_id,$user_id){
        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){

                    if($checkpermission->type_id==2){
                        return view('v3_2_section4.section4_subsections',
                        ['project_id'=>$checkpermission->project_id,'project_name'=>$checkpermission->project_name]);
                    }


        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
    }


    public function v3_2_s4_4_1($proj_id,$user_id){

        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){

                    if($checkpermission->type_id==2){
                       $data=DB::table('pci-dss v3_2_1 section4_1')->join('users','pci-dss v3_2_1 section4_1.last_edited_by',
                       'users.id')
                       ->where('project_id',$proj_id)->get();
                       return view('v3_2_section4.section4_1',[
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

    public function v3_2_s4_4_1_insert(Request $req,$proj_id,$user_id){

        $req->validate([
            'network_diagrams' => 'required|image|mimes:jpeg,png,jpg,svg',
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

                        $imageName = time().'.'.$req->network_diagrams->extension();
                        $req->network_diagrams->move(public_path('v3_2_s4_4_1'), $imageName);
                        Db::table('pci-dss v3_2_1 section4_1')->insert([
                            'project_id'=>$proj_id,
                            'network_diagrams'=>$imageName,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                       return redirect()->route('section4_1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                       ->with('success','Diagram Uploaded successfully');

                    }
                }


        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }

    public function v3_2_s4_4_1_new($proj_id,$user_id){

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
                    return view('v3_2_section4.section4_1_new',[
                        'project_id'=>$proj_id,
                        'project_name'=>$checkpermission->project_name

                    ]);

                    }
                }


        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }

    public function v3_2_s4_4_1_del($assessment_id,$proj_id,$user_id){

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
                        $check=Db::table('pci-dss v3_2_1 section4_1')->where('assessment_id',$assessment_id)
                        ->where('project_id',$proj_id);
                        $image = $check->first();
                        if($image){
                            unlink(public_path('/v3_2_s4_4_1'.'/'.$image->network_diagrams) );
                            $check->delete();

                   return redirect()->route('section4_1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Diagram Deleted successfully');

                        }


                    }
                }


        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }



public function v3_2_s4_4_2($proj_id,$user_id){


    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data1=DB::table('pci-dss v3_2_1 sec4_2_dataflows')->join('users','pci-dss v3_2_1 sec4_2_dataflows.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->get();

                   $data2=Db::table('pci-dss v3_2_1 sec4_2_diagrams')
                   ->join('users','pci-dss v3_2_1 sec4_2_diagrams.last_edited_by','users.id')->get();
                   return view('v3_2_section4.section4_2',[
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

public function v3_2_s4_2_2_dataflows(Request $req,$proj_id,$user_id){
    $req->validate([
        'dataflows'=>'required|max:200',
        'types_of_chd'=>'required|max:200',
        'description'=>'required|max:1000'
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


                    Db::table('pci-dss v3_2_1 sec4_2_dataflows')->insert([
                        'project_id'=>$proj_id,
                        'dataflows'=>$req->dataflows,
                        'types_of_chd'=>$req->types_of_chd,
                        'description'=>$req->description,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s4_4_2_insert_dataflow($proj_id,$user_id){
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
                return view('v3_2_section4.section4_2_dataflow_new',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s4_4_2_edit($assessment_id,$proj_id,$user_id){

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
                   $data=DB::table('pci-dss v3_2_1 sec4_2_dataflows')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_2_edit',[
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
public function v3_2_s4_2_2_edit_dataflows(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'dataflows'=>'required|max:200',
        'types_of_chd'=>'required|max:200',
        'description'=>'required|max:1000'
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

                    Db::table('pci-dss v3_2_1 sec4_2_dataflows')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'dataflows'=>$req->dataflows,
                        'types_of_chd'=>$req->types_of_chd,
                        'description'=>$req->description,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_2_delete_dataflow($assessment_id,$proj_id,$user_id){
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

                    Db::table('pci-dss v3_2_1 sec4_2_dataflows')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();


                   return redirect()->route('section4_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s4_4_2_insert_diagram(Request $req,$proj_id,$user_id){
        $req->validate([
            'data_flow_diagram'=>'required|image|mimes:jpeg,png,jpg,svg'
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

                        $imageName = time().'.'.$req->data_flow_diagram->extension();
                        $req->data_flow_diagram->move(public_path('v3_2_s4_4_2'), $imageName);
                        Db::table('pci-dss v3_2_1 sec4_2_diagrams')->insert([
                            'project_id'=>$proj_id,
                            'data_flow_diagram'=>$imageName,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                       return redirect()->route('section4_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                       ->with('success','Image Uploaded successfully');

                    }
                }


        }

        }
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s4_4_2_new_diagram($proj_id,$user_id){
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
                return view('v3_2_section4.section4_2_diag_new',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_2_dia_del($assessment_id,$proj_id,$user_id){

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
                    $check=Db::table('pci-dss v3_2_1 sec4_2_diagrams')->where('assessment_id',$assessment_id)
                    ->where('project_id',$proj_id);
                    $image = $check->first();

                    if($image){
                        unlink(public_path('/v3_2_s4_4_2'.'/'.$image->data_flow_diagram) );
                        $check->delete();

               return redirect()->route('section4_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
               ->with('success','Diagram Deleted successfully');

                    }


                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_3($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 section4_3')->join('users','pci-dss v3_2_1 section4_3.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->get();

                   return view('v3_2_section4.section4_3',[
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

public function v3_2_s4_4_3_insert(Request $req,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:100',
        'requirement2'=>'required|max:100',
        'requirement3'=>'required|max:100',
        'requirement4'=>'required|max:200',
        'requirement5'=>'required|max:1000',

    ],[
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


                    Db::table('pci-dss v3_2_1 section4_3')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_3_new($proj_id,$user_id){
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
                return view('v3_2_section4.section4_3_new',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s4_4_3_edit($assessment_id,$proj_id,$user_id){

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
                   $data=DB::table('pci-dss v3_2_1 section4_3')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_3_edit',[
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


public function v3_2_s4_4_3_editform(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:100',
        'requirement2'=>'required|max:100',
        'requirement3'=>'required|max:100',
        'requirement4'=>'required|max:200',
        'requirement5'=>'required|max:1000',

    ],[
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
                    Db::table('pci-dss v3_2_1 section4_3')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_3_delete($assessment_id,$proj_id,$user_id){
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
                    Db::table('pci-dss v3_2_1 section4_3')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();


                   return redirect()->route('section4_3',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s3_4_4($proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 sec4_4')->join('users','pci-dss v3_2_1 sec4_4.last_edited_by',
                   'users.id')
                   ->where('project_id',$proj_id)->get();

                   return view('v3_2_section4.section4_4',[
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

public function v3_2_s4_4_4_insert(Request $req,$proj_id,$user_id){

    $req->validate([
        'requirement2'=>'required|max:300',
        'requirement3'=>'required|max:300',
        'requirement4'=>'required|max:300',
        'requirement1'=>'required|max:300',
        'requirement5'=>'required|max:300',
        'requirement6'=>'required|max:1000',

    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_4')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'requirement6'=>$req->requirement6,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_4',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s4_4_4_new($proj_id,$user_id){

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
                return view('v3_2_section4.section4_4_new',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_4_edit($assessment_id,$proj_id,$user_id){

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
                   $data=DB::table('pci-dss v3_2_1 sec4_4')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_4_edit',[
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

public function v3_2_s4_4_4_editform(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'requirement2'=>'required|max:300',
        'requirement3'=>'required|max:300',
        'requirement4'=>'required|max:300',
        'requirement1'=>'required|max:300',
        'requirement5'=>'required|max:300',
        'requirement6'=>'required|max:1000',

    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_4')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'requirement6'=>$req->requirement6,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_4',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_4_delete($assessment_id,$proj_id,$user_id){

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
                    Db::table('pci-dss v3_2_1 sec4_4')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();

                   return redirect()->route('section4_4',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


//section4.5
public function v3_2_s4_4_5($proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 sec4_5')->join('users','pci-dss v3_2_1 sec4_5.last_edited_by',
                   'users.id')->where('project_id',$proj_id)->first();

                   return view('v3_2_section4.section4_5',[
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

public function v3_2_s4_4_5_insert(Request $req,$proj_id,$user_id){
    $req->validate([
        'selection'=>'required|max:3',
        'if_no'=>'max:300',
        'requirement2'=>'max:300',
        'requirement3'=>'max:1000',
        'requirement4'=>'max:1000'
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

                    if($req->selection=='no'){
                        Db::table('pci-dss v3_2_1 sec4_5')->insert([
                            'project_id'=>$proj_id,
                            'selection'=>$req->selection,
                            'if_no'=>$req->if_no,

                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }

                    if($req->selection=='yes'){
                        Db::table('pci-dss v3_2_1 sec4_5')->insert([
                            'project_id'=>$proj_id,
                            'selection'=>$req->selection,
                            'requirement2'=>$req->requirement2,
                            'requirement3'=>$req->requirement3,
                            'requirement4'=>$req->requirement4,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }


                   return redirect()->route('section4_5',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_5_edit($assessment_id,$proj_id,$user_id){

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
                   $data=DB::table('pci-dss v3_2_1 sec4_5')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_5_edit',[
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

public function v3_2_s4_4_5_editform(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'selection'=>'required|max:3',
        'if_no'=>'max:300',
        'requirement2'=>'max:300',
        'requirement3'=>'max:1000',
        'requirement4'=>'max:1000'
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

                    if($req->selection=='no'){
                        Db::table('pci-dss v3_2_1 sec4_5')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                        ->update([
                            'selection'=>$req->selection,
                            'if_no'=>$req->if_no,
                            'requirement2'=>null,
                            'requirement3'=>null,
                            'requirement4'=>null,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }

                    if($req->selection=='yes'){
                        Db::table('pci-dss v3_2_1 sec4_5')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                        ->update([
                            'selection'=>$req->selection,
                            'if_no'=>null,
                            'requirement2'=>$req->requirement2,
                            'requirement3'=>$req->requirement3,
                            'requirement4'=>$req->requirement4,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }


                   return redirect()->route('section4_5',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

//section 4.6
public function v3_2_s4_4_6($proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 sec4_6')->join('users','pci-dss v3_2_1 sec4_6.last_edited_by',
                   'users.id')->where('project_id',$proj_id)->get();

                   return view('v3_2_section4.section4_6',[
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

public function v3_2_s4_4_6_insert(Request $req,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:300',
        'requirement2'=>'required|max:500',
        'requirement3'=>'required|max:300',
        'requirement4'=>'required|max:300',
        'requirement5'=>'required|max:300',
        'requirement6'=>'required|max:300'

    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_6')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'requirement6'=>$req->requirement6,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_6_new($proj_id,$user_id){

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
                return view('v3_2_section4.section4_6_new',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s4_4_6_edit($assessment_id,$proj_id,$user_id){
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
                   $data=DB::table('pci-dss v3_2_1 sec4_6')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_6_edit',[
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

public function v3_2_s4_4_6_editform(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:300',
        'requirement2'=>'required|max:500',
        'requirement3'=>'required|max:300',
        'requirement4'=>'required|max:300',
        'requirement5'=>'required|max:300',
        'requirement6'=>'required|max:300'

    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_6')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'requirement6'=>$req->requirement6,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_6_delete($assessment_id,$proj_id,$user_id){
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
                    Db::table('pci-dss v3_2_1 sec4_6')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();

                   return redirect()->route('section4_6',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}


//section4.7
public function v3_2_s4_4_7($proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 sec4_7')->join('users','pci-dss v3_2_1 sec4_7.last_edited_by',
                   'users.id')->where('project_id',$proj_id)->get();

                   return view('v3_2_section4.section4_7',[
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

public function v3_2_s4_4_7_insert(Request $req,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:300',
        'requirement2'=>'required|max:300',
        'requirement3'=>'required|max:1000',
        'requirement4'=>'required|max:300',


    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_7')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s4_4_7_new($proj_id,$user_id){

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
                return view('v3_2_section4.section4_7_new',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_7_edit($assessment_id,$proj_id,$user_id){
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
                   $data=DB::table('pci-dss v3_2_1 sec4_7')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_7_edit',[
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

public function v3_2_s4_4_7_editform(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:300',
        'requirement2'=>'required|max:300',
        'requirement3'=>'required|max:1000',
        'requirement4'=>'required|max:300',


    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_7')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_7_delete($assessment_id,$proj_id,$user_id){
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
                    Db::table('pci-dss v3_2_1 sec4_7')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();

                   return redirect()->route('section4_7',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

//section4.8
public function v3_2_s4_4_8($proj_id,$user_id) {

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();
    if($checkpermission){

                if($checkpermission->type_id==2){
                   $data=DB::table('pci-dss v3_2_1 sec4_8_party')->join('users','pci-dss v3_2_1 sec4_8_party.last_edited_by',
                   'users.id')->where('project_id',$proj_id)->get();

                   $data2=DB::table('pci-dss v3_2_1 sec4_8_assessor')->join('users','pci-dss v3_2_1 sec4_8_assessor.last_edited_by',
                   'users.id')->where('project_id',$proj_id)->get();


                   return view('v3_2_section4.section4_8',[
                    'data'=>$data,
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

public function v3_2_s4_4_8_insert_party(Request $req,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:100',
        'requirement2'=>'required|max:100',
        'requirement3'=>'required|max:5',
        'requirement4'=>'required|max:5',
        'requirement5'=>'required|max:100'


    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_8_party')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'requirement6'=>$req->requirement6,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s4_4_8_new_party($proj_id,$user_id){

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
                return view('v3_2_section4.section4_8_new_party',[
                    'project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name

                ]);

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_8_party_edit($assessment_id,$proj_id,$user_id){

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
                   $data=DB::table('pci-dss v3_2_1 sec4_8_party')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data){
                    return view('v3_2_section4.section4_8_party_edit',[
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

public function v3_2_s4_4_8_editform_party(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:100',
        'requirement2'=>'required|max:100',
        'requirement3'=>'required|max:5',
        'requirement4'=>'required|max:5',
        'requirement5'=>'required|max:100'


    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_8_party')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([

                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'requirement5'=>$req->requirement5,
                        'requirement6'=>$req->requirement6,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_8_party_delete($assessment_id,$proj_id,$user_id){
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
                    Db::table('pci-dss v3_2_1 sec4_8_party')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();

                   return redirect()->route('section4_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }

    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

//inserting
public function v3_2_s4_4_8_asses(Request $req,$proj_id,$user_id){

    $req->validate([
        'requirement1'=>'required|max:200',
        'requirement2'=>'required|max:200',
        'requirement3'=>'required|max:500',
        'requirement4'=>'max:1000',


    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_8_assessor')->insert([
                        'project_id'=>$proj_id,
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Added successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s4_4_8_asses_edit($assessment_id,$proj_id,$user_id){


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
                   $data2=DB::table('pci-dss v3_2_1 sec4_8_assessor')->where('assessment_id',$assessment_id)
                   ->where('project_id',$proj_id)->first();
                   if($data2){
                    return view('v3_2_section4.section4_8_asses_edit',[
                        'data2'=>$data2,
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

public function v3_2_s4_4_8_asses_editform(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'requirement1'=>'required|max:200',
        'requirement2'=>'required|max:200',
        'requirement3'=>'required|max:500',
        'requirement4'=>'max:1000',


    ],[
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

                    Db::table('pci-dss v3_2_1 sec4_8_assessor')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->update([
                        'requirement1'=>$req->requirement1,
                        'requirement2'=>$req->requirement2,
                        'requirement3'=>$req->requirement3,
                        'requirement4'=>$req->requirement4,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                   return redirect()->route('section4_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Edited successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}

public function v3_2_s4_4_8_asses_delete($assessment_id,$proj_id,$user_id){
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

                    Db::table('pci-dss v3_2_1 sec4_8_assessor')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                    ->delete();


                   return redirect()->route('section4_8',['proj_id'=>$proj_id,'user_id'=>$user_id])
                   ->with('success','Record Deleted successfully');

                }
            }


    }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);
}
}
