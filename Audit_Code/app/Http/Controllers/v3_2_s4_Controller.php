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
}
