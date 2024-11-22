<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;

class IsoSec2_2 extends Controller
{

    public function iso_section2_2_from_main($proj_id,$user_id){
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

                    $data = DB::table('iso_sec_2_1')->join(
                        'users',
                        'iso_sec_2_1.last_edited_by',
                        'users.id'
                    )
                        ->where('project_id', $proj_id)->get();

                 $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();




                    $org_projects=Db::table('projects')->where('org_id',auth()->user()->org_id)
                    ->where('project_id','!=',$proj_id)->get();

                    $distinctServices= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.s_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.s_name')
                     // Ensures distinct s_name values
                    ->get();

                    $distinctGroups= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.g_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.g_name')
                    ->get();

                    $distinctAssets= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.name')
                    ->get();


                    $distinctComponents= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.c_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.c_name')
                    ->get();





                    return view('iso_sec_2_1.iso_sec_2_1_from_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project,
                        'org_projects'=>$org_projects,
                        'distinctServices'=>$distinctServices,
                        'distinctGroups'=>$distinctGroups,
                        'distinctAssets'=>$distinctAssets,
                        'distinctComponents'=>$distinctComponents
                    ]);

            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
public function iso_sec_2_2_evidence($asset_id,$proj_id,$user_id){
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

            
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                $asset=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();
              
                //ISO 
                if ($checkpermission->type_id == 4) {
                    return view('iso_sec_2_2.iso_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset'=>$asset
                       
                    ]);
                }

                //PCI SIngle tenant
                if ($checkpermission->type_id == 1) {
                    return view('pci_single_sheet.pci_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset'=>$asset
                       
                    ]);
                }

                 //PCI Multi tenant
                 if ($checkpermission->type_id == 2) {
                    return view('pci_multi_sheet.pci_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset'=>$asset
                       
                    ]);
                }

                 //PCI Merchant tenant
                 if ($checkpermission->type_id == 3) {
                    return view('pci_merchant_sheet.pci_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset'=>$asset
                       
                    ]);
                }

                 //CY SAMA
                 if ($checkpermission->type_id == 5) {
                    return view('CY_SAMA.cy_sama_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset'=>$asset
                       
                    ]);
                }


                
            
        }
    }
    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
}

    public function iso_sec_2_2_subsections(Request $req, $proj_id, $user_id,$asset_id)
    {

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

                if ($checkpermission->type_id == 4) {
                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                        if ($req->evidenceLevel!=null) {
                            $req->session()->forget('evidenceLevel');
                            $req->session()->put('evidenceLevel', $req->evidenceLevel);
                        } 

                  $asset=Db::table(table: 'iso_sec_2_1')->where('assessment_id',$asset_id)->first();
              
                

                    return view('iso_sec_2_2.iso_sec_2_2_subsections', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset'=>$asset
                        
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function iso_section2_2($title_num, $proj_id, $user_id,$asset_id)
    {
   
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

                if ($checkpermission->type_id == 4) {

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                        $asset=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();



                                            
                        
                    if ($title_num == 11) {
                        //non mandatory controls
                        return view('iso_sec_2_2.iso_sec_2_2_main_with_non_mandatory', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'title' => $title_num,
                            'project' => $project,
                            'asset'=>$asset
                        ]);
                    }


                    $filepath = public_path('ISO_SEC_2_2.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)
                    //dd($rows);


                    $filteredData = collect($data[0])->filter(function ($row) use ($title_num) {
                        return strval($row[0]) === $title_num;
                    })->values()->all();



                    return view('iso_sec_2_2.iso_sec_2_2_main', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'title' => $title_num,
                        'project' => $project,
                        'asset'=>$asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_2_req(Request $req, $main_req_num, $title, $proj_id, $user_id,$asset_id)
    {
     
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

                if ($checkpermission->type_id == 4) {

                    if ($req->session()->exists('main_req_num')) {
                        $req->session()->forget('main_req_num');
                        $req->session()->put('main_req_num', $main_req_num);
                    } else {
                        $req->session()->put('main_req_num', $main_req_num);
                    }

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                        $asset=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();

                    if ($title == 11) {
                        //non mandatory requirements
                        if( $main_req_num == 5){
                            $filepath = public_path('ISO_SOA_A5.xlsx');
                        }

                        if( $main_req_num == 6){
                            $filepath = public_path('ISO_SOA_A6.xlsx');
                        }

                        if( $main_req_num == 7){
                            $filepath = public_path('ISO_SOA_A7.xlsx');
                        }

                        if( $main_req_num == 8){
                            $filepath = public_path('ISO_SOA_A8.xlsx');
                        }

                        $data = Excel::toArray([], $filepath);
                        $rows = array_slice($data[0], 1);

                        $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {
                            $value = $row[0];
                            return substr($value, 0, 1) === $main_req_num;
                        })->values()->all();


                        return view('iso_sec_2_2.iso_sec_2_2_sub_reqs_user_req', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'data' => $filteredData,
                            'main_req_num' => $main_req_num,
                            'title' => $title,
                            'project' => $project,
                            'asset'=>$asset
                        ]);
                    }


                    $filepath = public_path('ISO_SEC_2_2.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {

                        $my_main_req = explode(' ', $row[2]);

                        return strval($my_main_req[0]) === $main_req_num;
                    })->values()->all();




                    return view('iso_sec_2_2.iso_sec_2_2_sub_reqs', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'main_req_num' => $main_req_num,
                        'title' => $title,
                        'project' => $project,
                        'asset'=>$asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_2_sub_req_edit($sub_req, $title, $proj_id, $user_id,$asset_id)
    {
  

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

                if ($checkpermission->type_id == 4) {
                    $result = Db::table('iso_sec_2_2')->join('users', 'iso_sec_2_2.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->where('sub_req', $sub_req)->where('asset_id',$asset_id)
                        ->first();
                }


                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                    $asset=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();

                    if($title==11){

                        if($sub_req[0]==5){
                            $filepath = public_path('ISO_SOA_A5.xlsx');
                        }
                        if($sub_req[0]==6){
                            $filepath = public_path('ISO_SOA_A6.xlsx');
                        }

                        if($sub_req[0]==7){
                            $filepath = public_path('ISO_SOA_A7.xlsx');
                        }
                        if($sub_req[0]==8){
                            $filepath = public_path('ISO_SOA_A8.xlsx');
                        }
                            $data = Excel::toArray([], $filepath);
                            $rows = array_slice($data[0], 1);

                            $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                                return strval($row[0]) === $sub_req;
                            })->values()->all();

                            return view('iso_sec_2_2.iso_sec_2_2_sub_reqs_form_user_req', [
                                'project_id' => $checkpermission->project_id,
                                'project_name' => $checkpermission->project_name,
                                'project_permissions' => $checkpermission->project_permissions,
                                'title' => $title,
                                'sub_req' => $sub_req,
                                'result' => $result,
                                'filteredData' => $filteredData,
                                'project' => $project,
                                'asset'=>$asset
                            ]);




                    }



                $filepath = public_path('ISO_SEC_2_2.xlsx');
                $data = Excel::toArray([], $filepath); //with header
                $rows = array_slice($data[0], 1); //without header(first row)
                //  dd($rows);

                $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                    return strval($row[3]) === $sub_req;
                })->values()->all();



                return view('iso_sec_2_2.iso_sec_2_2_sub_reqs_form', [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'title' => $title,
                    'sub_req' => $sub_req,
                    'result' => $result,
                    'filteredData' => $filteredData,
                    'project' => $project,
                    'asset'=>$asset
                ]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    //new insert in sec2_2
    public function iso_sec_2_2_form(Request $req, $sub_req, $title, $proj_id, $user_id,$asset_id)
    {
        $req->validate([
            'comp_status' => 'required'
        ]);
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
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 4) {

                    $evidenceLevel = $req->session()->get('evidenceLevel');

                  
                    if (in_array('Data Inputter', $permissions)) {

                        $fileName=null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                        }

                        if($evidenceLevel=='component'){
                           
    
                                Db::table('iso_sec_2_2')->insert([
                                    'asset_id'=>$asset_id,
                                    'project_id' => $proj_id,
                                    'comp_status' => $req->comp_status,
                                    'comments' => $req->comments,
                                    'title_num' => $title,
                                    'sub_req' => $sub_req,
                                    'attachment' => $fileName,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]);
                                $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'iso_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id,'asset_id'=>$asset_id]
                        )
                            ->with('success', 'Record Updated SUccessfully');

                        }

                        $assetDetails=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();

                        $assets=null;

                        if($evidenceLevel=='name'){
                            $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('name',$assetDetails->name)->get();
                        }

                        if($evidenceLevel=='group'){
                            $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('g_name',$assetDetails->g_name)->get();
                        }
                        if($evidenceLevel=='service'){
                            $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('s_name',$assetDetails->s_name)->get();
                        }

                        if($evidenceLevel=='project'){
                            $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->get();
                        }

                

                        foreach($assets as $ass){ 
                            Db::table('iso_sec_2_2')->insert([
                                'asset_id'=>$ass->assessment_id,
                                'project_id' => $proj_id,
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'title_num' => $title,
                                'sub_req' => $sub_req,
                                'attachment' => $fileName,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        }
                            
                    }
                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'iso_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id,'asset_id'=>$asset_id]
                        )
                            ->with('success', 'Record Updated SUccessfully');
                    
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }
    public function iso_sec_2_2_edit_form(Request $req, $sub_req, $title, $proj_id, $user_id,$asset_id)
    {
        $req->validate([
            'comp_status' => 'required',
            'attachment' => 'file|mimes:jpg,png,pdf,doc,docx,xlsx|max:5096', 
        ]);
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
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 4) {
                    $evidenceLevel = $req->session()->get('evidenceLevel');
                    if (in_array('Data Inputter', $permissions)) {



                        if($evidenceLevel=='component'){

                            
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                            Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                            ->where('asset_id',$asset_id)
                            ->update([
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'attachment' => $fileName,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);

                        }else{
                            Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                            ->where('asset_id',$asset_id)
                            ->update([
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);

                        }

                        
                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'iso_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id,'asset_id'=>$asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                            
                        }
                       

            
                           

                     $assetDetails=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();

                     $assets=null;
        
                     if($evidenceLevel=='name'){
                    $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('name',$assetDetails->name)->get();
                         }
        
                                if($evidenceLevel=='group'){
                                    $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('g_name',$assetDetails->g_name)->get();
                                }
                                if($evidenceLevel=='service'){
                                    $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('s_name',$assetDetails->s_name)->get();
                                }
        
                                if($evidenceLevel=='project'){
                                    $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->get();
                                }

                                if ($req->attachment != null) {
                                    $fileName = time() . '.' . $req->attachment->extension();
                                    $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                                    foreach($assets as $ass){ 
                                        Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                                        ->where('asset_id',$asset_id)->update([
                                            'comp_status' => $req->comp_status,
                                            'comments' => $req->comments,
                                            'title_num' => $title,
                                            'sub_req' => $sub_req,
                                            'attachment' => $fileName,
                                            'last_edited_by' => $user_id,
                                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                        ]);
            
                                    }

                                }else{
                                    foreach($assets as $ass){ 
                                        Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                                        ->where('asset_id',$asset_id)->update([
                                            'comp_status' => $req->comp_status,
                                            'comments' => $req->comments,
                                            'title_num' => $title,
                                            'sub_req' => $sub_req,
                                            'last_edited_by' => $user_id,
                                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                        ]);
            
                                    }

                                }
        
                               
                        

                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'iso_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id,'asset_id'=>$asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }
}
