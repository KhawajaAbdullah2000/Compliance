<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function assigned_projects($user_id){
        $projects=Project::join('project_details','projects.project_id','project_details.project_code')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_details.assigned_enduser',$user_id)->get(
            [
            'project_details.project_code',
            'projects.project_name',
            'project_types.type',
            'project_types.id as type_id',
            'projects.status',
            'project_details.project_permissions'

        ]);
        return view('assigned_projects.my_projects',['projects'=>$projects]);

    }

    public function v_3_2_sections($proj_id,$user_id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();


        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                    if($checkpermission->type_id==2){
                        return view('assigned_projects.v_3_2_sections',
                        ['project_id'=>$proj_id,'project_name'=>$checkpermission->project_name]);
                    }



        }else{
            return redirect()->route('assigned_projects',['user_id'=>$user_id]);
        }

    }

    public function v_3_2_section1($proj_id,$user_id){
        if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();


    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
                if($checkpermission->type_id==2){
                        //v3.2 pci
                       $clientinfo= Db::table('pci-dss v3_2_1 client info')->join('users','pci-dss v3_2_1 client info.last_edited_by','users.id')
                       ->where('pci-dss v3_2_1 client info.project_id',$proj_id)->first();

                    $assessorComapany=Db::table('pci-dss v3_2_1 assessor company')->join('users','pci-dss v3_2_1 assessor company.last_edited_by','users.id')
                    ->where('pci-dss v3_2_1 assessor company.project_id',$proj_id)->first();

                    $assessors=Db::table('pci-dss v3_2_1 assessors')
                    ->join('users','pci-dss v3_2_1 assessors.last_edited_by','users.id')
                    ->where('pci-dss v3_2_1 assessors.project_id',$proj_id)->get();


                       return view('assigned_projects.v_3_2_section1',
                       ['clientinfo'=>$clientinfo,
                       'assessorCompany'=>$assessorComapany,
                       'assessors'=>$assessors,
                       'project_id'=>$checkpermission->project_id,
                       'project_name'=>$checkpermission->project_name,
                        'project_permissions'=>$checkpermission->project_permissions]);

                }



    }else{
        return redirect()->route('assigned_projects',['user_id'=>$user_id]);

        }

    }

}

public function v3_2_s1_clientinfo(Request $req,$proj_id,$user_id){

    $req->validate([
        'company_name'=>'required|max:50',
        'company_address'=>'required|max:100',
        'company_url'=>'required|max:50',
        'company_contact_name'=>'required|max:50',
        'company_number'=>'required|numeric',
        'company_email'=>'required|max:100'
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
                    //v3.2 pci
                   $clientinfo= Db::table('pci-dss v3_2_1 client info')->where('project_id',$proj_id)->first();
                   if(!$clientinfo){
                        Db::table('pci-dss v3_2_1 client info')->insert([
                            'project_id'=>$proj_id,
                            'company_name'=>$req->company_name,
                            'company_address'=>$req->company_address,
                            'company_url'=>$req->company_url,
                            'company_contact_name'=>$req->company_contact_name,
                            'company_contact_number'=>$req->company_number,
                            'company_email'=>$req->company_email,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                        ]);
                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Record added successfully');
                   }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>$user_id]);

        }

}else{
    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

}

}

    }else{
        return redirect()->route('assigned_projects',['user_id'=>$user_id]);

    }

}


public function edit_3_2_s1_clientinfo($proj_id,$user_id){
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
                    //v3.2 pci
                   $clientinfo= Db::table('pci-dss v3_2_1 client info')->where('project_id',$proj_id)->first();
                   if($clientinfo){
                    return view('assigned_projects.edit_3_2_s1_clientinfo',['clientinfo'=>$clientinfo]);
                   }else{
                    return redirect()->route('assigned_projects',['user_id'=>$user_id]);
                   }

            }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>$user_id]);

        }

}else{
    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

}

    }else{
        return redirect()->route('assigned_projects',['user_id'=>$user_id]);

    }

}

public function edit_3_2_s1_clientinfo_form(Request $req,$proj_id,$user_id){
    $req->validate([
        'company_name'=>'required|max:50',
        'company_address'=>'required|max:100',
        'company_url'=>'required|max:50',
        'company_contact_name'=>'required|max:50',
        'company_number'=>'required|numeric',
        'company_email'=>'required|max:100'
    ]);

    $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_id')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();

if($checkpermission){
    $permissions=json_decode($checkpermission->project_permissions);
        if(in_array('Data Inputter',$permissions)){
            if($checkpermission->type_id==2){
                    //v3.2 pci
                $clientinfo= Db::table('pci-dss v3_2_1 client info')->where('project_id',$proj_id)->update([
                    'company_name'=>$req->company_name,
                    'company_address'=>$req->company_address,
                    'company_url'=>$req->company_url,
                    'company_contact_name'=>$req->company_contact_name,
                    'company_contact_number'=>$req->company_number,
                    'company_email'=>$req->company_email,
                    'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                 ]);

                return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                ->with('success','Record updated successfully');

            }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>$user_id]);

        }

}else{
    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

}


}



public function v3_2_s1_assessorcompany(Request $req,$proj_id,$user_id){
    $req->validate([
        'comp_name'=>'required|max:50',
        'comp_address'=>'required|max:100',
        'comp_website'=>'required|max:50',

    ]);

    if($user_id==auth()->user()->id){

        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();

        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                            //v3.2 pci
                        Db::table('pci-dss v3_2_1 assessor company')->insert([
                            'project_id'=>$proj_id,
                            'comp_name'=>$req->comp_name,
                            'comp_address'=>$req->comp_address,
                            'comp_website'=>$req->comp_website,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                         ]);

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Record added successfully');

                    }

                }else{
                    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

                }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

        }



    }else{
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }
}


public function edit_v_3_2_s1_assessorcomp($proj_id,$user_id){

    if($user_id==auth()->user()->id){

        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();

        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                            //v3.2 pci
                       $assessor_comp= Db::table('pci-dss v3_2_1 assessor company')->where('project_id',$proj_id)->first();
                       if($assessor_comp){
                        return view('assigned_projects.v_3_2_edit_sec1_assessorcomp',['assessor_company'=>$assessor_comp]);

                       }else{
                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id]);
                       }



                    }

                }else{
                    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

                }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

        }



    }else{
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }


}

public function edit_v3_2_assessorcompany_form(Request $req,$proj_id,$user_id){
    $req->validate([
        'comp_name'=>'required|max:50',
        'comp_address'=>'required|max:100',
        'comp_website'=>'required|max:50',

    ]);

    if($user_id==auth()->user()->id){

        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();

        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                            //v3.2 pci
                       $assessor_comp= Db::table('pci-dss v3_2_1 assessor company')->where('project_id',$proj_id)->first();
                       if($assessor_comp){
                        Db::table('pci-dss v3_2_1 assessor company')->where('project_id',$proj_id)->update(
                            [
                            'comp_name'=>$req->comp_name,
                            'comp_address'=>$req->comp_address,
                            'comp_website'=>$req->comp_website,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                            ]
                            );

                            return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id]);

                       }else{
                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Record updated successfully');
                       }


                    }

                }else{
                    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

                }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

        }



    }else{
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }
}



public function v_3_2_s1_assessors(Request $req,$proj_id,$user_id){
    $req->validate([
        'assessor_name'=>'required|max:50',
        'assessor_pci_cred'=>'required|max:100',
        'assessor_phone'=>'required|numeric',
        'assessor_email'=>'required|max:100|unique:pci-dss v3_2_1 assessors',
    ]);

    if($user_id==auth()->user()->id){

        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();

        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                            //v3.2 pci
                            Db::table('pci-dss v3_2_1 assessors')->insert([
                                'project_id'=>$proj_id,
                                'assessor_name'=>$req->assessor_name,
                                'assessor_pci_cred'=>$req->assessor_pci_cred,
                                'assessor_phone'=>$req->assessor_phone,
                                'assessor_email'=>$req->assessor_email,
                                'last_edited_by'=>$user_id,
                                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                            ]);


                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id]);

                       }else{
                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id]);
                       }


                    }else{
                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id]);

                    }

                }else{
                    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

                }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

        }



}



public function edit_v3_2_s1_assesssor($assessment_id,$user_id,$proj_id){
    if($user_id==auth()->user()->id){


        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    //v3_2
                    $assessor=Db::table('pci-dss v3_2_1 assessors')->where('assessment_id',$assessment_id)->first();
                    if($assessor){
                        return view('assigned_projects.edit_3_2_s1_assessor',['assessor'=>$assessor]);

                    }else{
                        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

                    }


                }else{
                    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

                }


            }else{
                return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

            }



        }else{
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

        }








    }else{
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }
}



public function v3_2_s1_edit_assessors_form(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'assessor_name'=>'required|max:50',
        'assessor_pci_cred'=>'required|max:100',
        'assessor_phone'=>'required|numeric',
        'assessor_email' => ['required','max:100',Rule::unique('pci-dss v3_2_1 assessors')->ignore($assessment_id,'assessment_id')]

    ]);


    if($user_id==auth()->user()->id){

        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();

        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                if(in_array('Data Inputter',$permissions)){
                    if($checkpermission->type_id==2){
                            //v3.2 pci
                       $assessor= Db::table('pci-dss v3_2_1 assessors')->where('assessment_id',$assessment_id)->first();
                       if($assessor){
                        Db::table('pci-dss v3_2_1 assessors')->where('assessment_id',$assessment_id)->update(
                            [
                            'assessor_name'=>$req->assessor_name,
                            'assessor_pci_cred'=>$req->assessor_pci_cred,
                            'assessor_phone'=>$req->assessor_phone,
                            'assessor_email'=>$req->assessor_email,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                            ]
                            );

                            return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                            ->with('success','Assessor Info completed successfully');

                       }else{
                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id]);
                       }


                    }

                }else{
                    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

                }

        }else{
            return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

        }



    }else{
        return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

    }


}


public function v3_2_s1_add_new_assessor($proj_id,$user_id){
    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){
                    return view('assigned_projects.add_new_assessor',['project_id'=>$checkpermission->project_id]);
                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

}



public function v3_2_s1_delete_assessor(Request $req,$assessment_id,$proj_id,$user_id){

    if($user_id==auth()->user()->id){
        $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_id')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();

        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
            if(in_array('Data Inputter',$permissions)){
                if($checkpermission->type_id==2){

                        Db::table('pci-dss v3_2_1 assessors')->where('assessment_id',$assessment_id)->delete();

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Record deleted');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}
}
