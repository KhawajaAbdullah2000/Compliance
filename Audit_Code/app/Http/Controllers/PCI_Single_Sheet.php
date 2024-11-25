<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use App\Models\User;
class PCI_Single_Sheet extends Controller
{
    public function pci_single_sheet_subsections($proj_id, $user_id, $asset_id, Request $req)
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

                if ($checkpermission->type_id == 1) {
                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    if ($req->evidenceLevel != null) {
                        $req->session()->forget('evidenceLevel');
                        $req->session()->put('evidenceLevel', $req->evidenceLevel);
                    }

                    $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();



                    return view('pci_single_sheet.sec_2_2_subsections', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_section_2_2($title_num, $proj_id, $user_id, $asset_id)
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

                if ($checkpermission->type_id == 1) {
                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $filteredData = collect($data[0])->filter(function ($row) use ($title_num) {
                        return strval($row[0]) === $title_num;
                    })->values()->all();


                    return view('pci_single_sheet.pci_sec_2_2_main', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'title' => $title_num,
                        'project' => $project,
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_sec_2_2_req(Request $req, $main_req_num, $title, $proj_id, $user_id, $asset_id)
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
                if ($req->session()->exists('main_req_num')) {
                    $req->session()->forget('main_req_num');
                    $req->session()->put('main_req_num', $main_req_num);

                } else {
                    $req->session()->put('main_req_num', $main_req_num);

                }

                if ($checkpermission->type_id == 1) {



                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {

                        return strval($row[1]) === $main_req_num;
                    })->values()->all();


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $asset = Db::table(table: 'iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                    return view('pci_single_sheet.pci_2_2_sub_reqs', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'main_req_num' => $main_req_num,
                        'title' => $title,
                        'project' => $project,
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_sec2_2_sub_req_edit($sub_req, $title, $proj_id, $user_id, $asset_id)
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

                if ($checkpermission->type_id == 1) {
                    $result = Db::table('iso_sec_2_2')->join('users', 'iso_sec_2_2.last_edited_by', 'users.id')
                    ->where('project_id', $proj_id)->where('sub_req', $sub_req)->where('asset_id',$asset_id)
                    ->first();
                }

                $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                $data = Excel::toArray([], $filepath); //with header
                $rows = array_slice($data[0], 1); //without header(first row)


                $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                    return strval($row[3]) === $sub_req;
                })->values()->all();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                $asset = Db::table(table: 'iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                //superusers of that organization
                $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                    ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                // dd($superusers_of_that_org);

                //organziatons of those superusers
                $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);


                return view('pci_single_sheet.pci_sec_2_2_sub_reqs_form', [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'title' => $title,
                    'sub_req' => $sub_req,
                    'result' => $result,
                    'filteredData' => $filteredData,
                    'project' => $project,
                    'asset' => $asset,
                    'users' => $users
                ]);

            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }
    public function pci_sec_2_2_form(Request $req, $sub_req, $title, $proj_id, $user_id,$asset_id)
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
                if ($checkpermission->type_id == 1) {

                    $evidenceLevel = $req->session()->get('evidenceLevel');

                  
                    if (in_array('Data Inputter', $permissions)) {

                        $fileName=null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                        }

                        $data=[
                                    'comp_status' => $req->comp_status,
                                    'comments' => $req->comments,
                                    'attachment' => $fileName,
                                    'treatment_action' => $req->treatment_action,
                                    'treatment_target_date' => $req->treatment_target_date,
                                    'treatment_comp_date' => $req->treatment_comp_date,
                                    'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                    'acceptance_actual_date'=>$req->acceptance_actual_date,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];

                        if ($evidenceLevel == 'component') {

                            // If evidence level is 'component', just insert or update for the specific asset
                            DB::table('iso_sec_2_2')->updateOrInsert(
                                [
                                    'project_id' => $proj_id, 
                                    'asset_id' => $asset_id,
                                    'title_num' => $title,
                                    'sub_req' => $sub_req,
                                ], 
                                $data
                            );
                        
                            // Redirect after updating the specific asset
                            $mysessionreq = $req->session()->get('main_req_num');
                            return redirect()->route(
                                'pci_sec_2_2_req',
                                ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
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

                

                        foreach($assets as $ass){ 
                            DB::table('iso_sec_2_2')->updateOrInsert(
                                [
                                    'project_id' => $proj_id, 
                                    'asset_id' => $ass->assessment_id, 
                                    'title_num' => $title,
                                    'sub_req' => $sub_req,
                                ], 
                                $data
                            );
                        }
                            
                    }
                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'pci_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id,'asset_id'=>$asset_id]
                        )
                            ->with('success', 'Record Updated SUccessfully');
                    
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }
    public function pci_sec_2_2_edit_form(Request $req, $sub_req, $title, $proj_id, $user_id,$asset_id)
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
                if ($checkpermission->type_id == 1) {

                    $evidenceLevel = $req->session()->get('evidenceLevel');

                  
                    if (in_array('Data Inputter', $permissions)) {

                        $fileName=null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                            $data=[
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                           
                                'attachment' => $fileName,
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date'=>$req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ];
                    }
                    else{
                            $data=[
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                        
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date'=>$req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ];

                        }


                        if($evidenceLevel=='component'){
                           
                            DB::table('iso_sec_2_2')->updateOrInsert(
                                [
                                    'project_id' => $proj_id, 
                                    'asset_id' => $asset_id, 
                                    'title_num' => $title,
                                    'sub_req' => $sub_req,
                                ], 
                                $data
                            );
                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'pci_sec_2_2_req',
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
                            DB::table('iso_sec_2_2')->updateOrInsert(
                                [
                                    'project_id' => $proj_id, 
                                    'asset_id' => $ass->assessment_id, 
                                    'title_num' => $title,
                                    'sub_req' => $sub_req,
                                ], 
                                $data
                            );
                        }
                            
                    }
                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'pci_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id,'asset_id'=>$asset_id]
                        )
                            ->with('success', 'Record Updated SUccessfully');
                    
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


}

