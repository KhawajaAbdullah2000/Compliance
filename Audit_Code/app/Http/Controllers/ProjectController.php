<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


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

//go to subsections of section 1 for v3_2
    public function v_3_2_section1_subsections($proj_id,$user_id){
        if($user_id==auth()->user()->id){
            $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
        'project_details.project_permissions','projects.project_name')
       -> join('projects','project_details.project_code','projects.project_id')
        ->join('project_types','projects.project_type','project_types.id')
        ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
        ->first();
        if($checkpermission){
            $permissions=json_decode($checkpermission->project_permissions);
                    if($checkpermission->type_id==2){
                        return view('assigned_projects.v_3_2_section1_subsections',
                        ['project_id'=>$proj_id,'project_name'=>$checkpermission->project_name]);
                    }


        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

//section 1.1
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

                    $clientinfo= Db::table('pci-dss v3_2_1 client info')->join('users','pci-dss v3_2_1 client info.last_edited_by','users.id')
                       ->where('pci-dss v3_2_1 client info.project_id',$proj_id)->first();

                    $assessorComapany=Db::table('pci-dss v3_2_1 assessor company')->join('users','pci-dss v3_2_1 assessor company.last_edited_by','users.id')
                    ->where('pci-dss v3_2_1 assessor company.project_id',$proj_id)->first();

                    $assessors=Db::table('pci-dss v3_2_1 assessors')
                    ->join('users','pci-dss v3_2_1 assessors.last_edited_by','users.id')
                    ->where('pci-dss v3_2_1 assessors.project_id',$proj_id)->get();

                    $associate_qsas=Db::table('pci-dss v3_2_1 associate_qsa')
                    ->join('users','pci-dss v3_2_1 associate_qsa.last_edited_by','users.id')
                    ->where('pci-dss v3_2_1 associate_qsa.project_id',$proj_id)->get();

                    $qas=Db::table('pci_dss v3_2_1 qa')
                    ->join('users','pci_dss v3_2_1 qa.last_edited_by','users.id')
                    ->where('pci_dss v3_2_1 qa.project_id',$proj_id)->get();



                       return view('assigned_projects.v_3_2_section1',
                       ['clientinfo'=>$clientinfo,
                       'assessorCompany'=>$assessorComapany,
                       'associate_qsas'=>$associate_qsas,
                       'assessors'=>$assessors,
                       'qas'=>$qas,
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
        'assessor_email'=>'required|max:100',
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
        'assessor_email' => 'required|max:100|email'

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


public function v3_2_s1_associate_qsa(Request $req,$proj_id,$user_id){
    $req->validate([
        'qsa_name'=>'required|max:100'
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

                        Db::table('pci-dss v3_2_1 associate_qsa')->insert([
                            'project_id'=>$proj_id,
                            'qsa_name'=>$req->qsa_name,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Associate QSA Added successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s1_associateqsa_edit($assessment_id,$proj_id,$user_id){
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

                       $ass_qsa= Db::table('pci-dss v3_2_1 associate_qsa')->where('assessment_id',$assessment_id)->first();
                        return view('assigned_projects.v3_2s1_edit_associate_qsa',['ass_qsa'=>$ass_qsa]);

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_editform_associate_qsa(Request $req,$assessment_id,$proj_id,$user_id){

    $req->validate([
        'qsa_name'=>'required'
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

                        Db::table('pci-dss v3_2_1 associate_qsa')->where('assessment_id',$assessment_id)
                        ->update([
                            'qsa_name'=>$req->qsa_name,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Associate QSA edited successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s1_newassociate_qsa($proj_id,$user_id){
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
                    return view('assigned_projects.add_new_qsa_assessor',['project_id'=>$checkpermission->project_id]);
                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>$user_id]);
}

public function v3_2_s1_delete_associate_qsa($assessment_id,$proj_id,$user_id){
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

                        Db::table('pci-dss v3_2_1 associate_qsa')->where('assessment_id',$assessment_id)->delete();

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Record deleted');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


public function v3_2_s1_qa_insert(Request $req,$proj_id,$user_id){

    $req->validate([
        'reviewer_name'=>'required|max:100',
        'reviewer_email'=>'required|max:100|email',
        'reviewer_phone'=>'required|numeric'
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

                        Db::table('pci_dss v3_2_1 qa')->insert([
                            'project_id'=>$proj_id,
                            'reviewer_name'=>$req->reviewer_name,
                            'reviewer_email'=>$req->reviewer_email,
                            'reviewer_phone'=>$req->reviewer_phone,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','QA Added successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_edit_qa($assessment_id,$proj_id,$user_id){

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

                       $qa= Db::table('pci_dss v3_2_1 qa')->where('assessment_id',$assessment_id)->first();
                        return view('assigned_projects.v3_2s1_edit_qa',['qa'=>$qa]);

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}
public function v3_2_s1_qa_edit_form_submit(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'reviewer_name'=>'required|max:100',
        'reviewer_email' =>'required|max:100|email',
        'reviewer_phone'=>'required|numeric'
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

                        Db::table('pci_dss v3_2_1 qa')->where('assessment_id',$assessment_id)
                        ->update([
                            'reviewer_name'=>$req->reviewer_name,
                            'reviewer_email'=>$req->reviewer_email,
                            'reviewer_phone'=>$req->reviewer_phone,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','QA edited successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s1_add_new_qa($proj_id,$user_id){
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
                    return view('assigned_projects.add_new_qa',['project_id'=>$checkpermission->project_id]);
                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>$user_id]);

}

//delete QA
public function v3_2_s1_delete_qa($assessment_id,$proj_id,$user_id){
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

                        Db::table('pci_dss v3_2_1 qa')->where('assessment_id',$assessment_id)->delete();

                        return redirect()->route('v_3_2_section1',['proj_id'=>$proj_id,'user_id'=>$user_id])
                        ->with('success','Record deleted');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}


//section1.2
public function v3_2_s1_1_2($proj_id,$user_id){

    if($user_id==auth()->user()->id){

    $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    'project_details.project_permissions','projects.project_name')
   -> join('projects','project_details.project_code','projects.project_id')
    ->join('project_types','projects.project_type','project_types.id')
    ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    ->first();


    if($checkpermission){
        $permissions=json_decode($checkpermission->project_permissions);
                if($checkpermission->type_id==2){

                    $timeframe=Db::table('pci-dss v3_2_1 section1_2')->join('users','pci-dss v3_2_1 section1_2.last_edited_by','users.id')
                    ->where('project_id',$proj_id)->first();


                    $date_onsite=Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')
                    ->join('users','pci-dss v3_2_1 section1_2_dates_spent_onsite.last_edited_by','users.id')
                    ->where('project_id',$proj_id)->get();


                    return view('assigned_projects.v_3_2_s1_1_2',
                    ['project_id'=>$proj_id,
                    'project_name'=>$checkpermission->project_name,
                    'project_permissions'=>$checkpermission->project_permissions,
                    'timeframe'=>$timeframe,
                    'date_onsite'=>$date_onsite
                    ]
                );
                }

    }else{
        return redirect()->route('assigned_projects',['user_id'=>$user_id]);
    }

}
return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s1_2_date(Request $req,$proj_id,$user_id){
    $req->validate([
        'date_of_report'=>'required',
        'start_date'=>'required',
        'end_date'=>'required',
        'time_onsite'=>'required|numeric',
        'time_remote'=>'required|numeric',
        'time_remediation'=>'required|numeric'
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

                        Db::table('pci-dss v3_2_1 section1_2')->insert([
                            'project_id'=>$proj_id,
                            'date_of_report'=>$req->date_of_report,
                            'start_date'=>$req->start_date,
                            'end_date'=>$req->end_date,
                            'time_onsite'=>$req->time_onsite,
                            'time_remote'=>$req->time_remote,
                            'time_remediation'=>$req->time_remediation,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                         return redirect()->route('section1_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                         ->with('success','Record Added successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);



}

public function v3_2_s1_1_2_edit_timeframe($proj_id,$user_id){

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

                $timeframe=Db::table('pci-dss v3_2_1 section1_2')->where('project_id',$proj_id)->first();
                if($timeframe){
                    return view('assigned_projects.v3_2_s1_1_2_edit_timeframe',['timeframe'=>$timeframe]);
                }

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);



}

public function v3_2_s1_1_2_edit_timeframe_form(Request $req,$proj_id,$user_id){
    $req->validate(
    [
        'date_of_report'=>'required',
        'start_date'=>'required',
        'end_date'=>'required',
        'time_onsite'=>'required|numeric',
        'time_remote'=>'required|numeric',
        'time_remediation'=>'required|numeric'
    ]
    );


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

                        Db::table('pci-dss v3_2_1 section1_2')->where('project_id',$proj_id)
                        ->update([
                            'date_of_report'=>$req->date_of_report,
                            'start_date'=>$req->start_date,
                            'end_date'=>$req->end_date,
                            'time_onsite'=>$req->time_onsite,
                            'time_remote'=>$req->time_remote,
                            'time_remediation'=>$req->time_remediation,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                         return redirect()->route('section1_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                         ->with('success','Record Edited successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);





}

public function v3_2_s1_1_2_onsite($proj_id,$user_id){

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
                        return view('assigned_projects.add_new_onsite_date_section1_2',[
                            'project_id'=>$checkpermission->project_id
                        ]);

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s1_1_2_onsite_form(Request $req,$proj_id,$user_id){
    $req->validate([
        'date_spent_onsite'=>'required'
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

                        Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->insert([
                            'project_id'=>$proj_id,
                            'date_spent_onsite'=>$req->date_spent_onsite,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                         return redirect()->route('section1_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                         ->with('success','Record Added successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s1_edit_date_onsite($assessment_id,$proj_id,$user_id){

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
                 $onsite=Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->where('assessment_id',$assessment_id)->first();
                 return view('assigned_projects.v3_2_s1_1_2_edit_onsite',['onsite'=>$onsite]);

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);

}

public function v3_2_s1_edit_submit_1_2_onsite(Request $req,$assessment_id,$proj_id,$user_id){
    $req->validate([
        'date_spent_onsite'=>'required'
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

                        Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->where('assessment_id',$assessment_id)
                        ->update([
                            'date_spent_onsite'=>$req->date_spent_onsite,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                         return redirect()->route('section1_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                         ->with('success','Date Edited successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}

public function v3_2_s1_1_2_deleteonsite($assessment_id,$proj_id,$user_id){
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

                        Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->where('assessment_id',$assessment_id)
                        ->delete();

                         return redirect()->route('section1_2',['proj_id'=>$proj_id,'user_id'=>$user_id])
                         ->with('success','Date Deleted successfully');

                }
            }

        }

    }
    return redirect()->route('assigned_projects',['user_id'=>auth()->user()->id]);


}
}
