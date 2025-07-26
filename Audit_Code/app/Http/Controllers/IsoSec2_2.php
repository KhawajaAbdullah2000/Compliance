<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class IsoSec2_2 extends Controller
{

    public function iso_section2_2_from_main($proj_id, $user_id)
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

                $data = DB::table('iso_sec_2_1')->join(
                    'users',
                    'iso_sec_2_1.last_edited_by',
                    'users.id'
                )
                    ->where('project_id', $proj_id)->get();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();




                $org_projects = Db::table('projects')->where('org_id', auth()->user()->org_id)
                    ->where('project_id', '!=', $proj_id)->get();

                $distinctServices = DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.s_name')
                    ->where('iso_sec_2_1.project_id', $proj_id)
                    ->distinct('iso_sec_2_1.s_name')
                    // Ensures distinct s_name values
                    ->get();

                $distinctGroups = DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.g_name')
                    ->where('iso_sec_2_1.project_id', $proj_id)
                    ->distinct('iso_sec_2_1.g_name')
                    ->get();

                $distinctAssets = DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.name')
                    ->where('iso_sec_2_1.project_id', $proj_id)
                    ->distinct('iso_sec_2_1.name')
                    ->get();


                $distinctComponents = DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.c_name')
                    ->where('iso_sec_2_1.project_id', $proj_id)
                    ->distinct('iso_sec_2_1.c_name')
                    ->get();





                return view('iso_sec_2_1.iso_sec_2_1_from_main', [
                    'data' => $data,
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'org_projects' => $org_projects,
                    'distinctServices' => $distinctServices,
                    'distinctGroups' => $distinctGroups,
                    'distinctAssets' => $distinctAssets,
                    'distinctComponents' => $distinctComponents
                ]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
    public function iso_sec_2_2_evidence($asset_id, $proj_id, $user_id)
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


                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                $asset = DB::table('iso_sec_2_1')
                    ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                    ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                    ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                    ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                    ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                    ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                    ->select(
                        'iso_sec_2_1.*',
                        DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                        DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                        DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                        DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                        DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                        DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                    )
                    ->where('iso_sec_2_1.assessment_id', $asset_id)
                    ->first();


                //ISO 
                // if ($checkpermission->type_id == 4) {
                //     return view('iso_sec_2_2.iso_sec_2_2_evidence_selection', [
                //         'project_id' => $checkpermission->project_id,
                //         'project_name' => $checkpermission->project_name,
                //         'project' => $project,
                //         'asset' => $asset

                //     ]);
                // }

                //PCI SIngle tenant
                if ($checkpermission->type_id == 1) {
                    return view('pci_single_sheet.pci_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }

                //PCI Multi tenant
                if ($checkpermission->type_id == 2) {
                    return view('pci_multi_sheet.pci_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }

                //PCI Merchant tenant
                if ($checkpermission->type_id == 3) {
                    return view('pci_merchant_sheet.pci_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }

                //CY SAMA
                if ($checkpermission->type_id == 5) {
                    return view('CY_SAMA.cy_sama_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }

                //SBP ETGRMF
                if ($checkpermission->type_id == 6) {
                    return view('SBP_ETGRMF.sbp_etgrmf_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }

                //KSA NCA , COSO , Soc2_type2
                if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19 || $checkpermission->type_id == 4 || $checkpermission->type_id==23) {

                    return view('KSA_NCA.ksa_nca_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }



                //UAE IA
                if ($checkpermission->type_id == 8) {
                    return view('uae_ia.uae_ia_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset

                    ]);
                }

                //ISa 62443 
                if ($checkpermission->type_id == 10 || $checkpermission->type_id == 12 || $checkpermission->type_id == 13 || $checkpermission->type_id == 11 || $checkpermission->type_id == 9) {

                    return view('isa.isa_2_1_sec_2_2_evidence_selection', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset,
                        'project_type' => $checkpermission->type_id

                    ]);
                }

                //CObit 2019
                if ($checkpermission->type_id == 16) {

                    return view('cobit.cobit_sec_2_2_evidence_selection', [
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

    public function iso_sec_2_2_subsections(Request $req, $proj_id, $user_id, $asset_id)
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

                    if ($req->evidenceLevel != null) {
                        $req->session()->forget('evidenceLevel');
                        $req->session()->put('evidenceLevel', $req->evidenceLevel);
                    }

                    $asset = Db::table(table: 'iso_sec_2_1')->where('assessment_id', $asset_id)->first();



                    return view('iso_sec_2_2.iso_sec_2_2_subsections', [
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


    public function iso_section2_2($title_num, $proj_id, $user_id, $asset_id)
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

                    $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();





                    if ($title_num == 11) {
                        //non mandatory controls
                        return view('iso_sec_2_2.iso_sec_2_2_main_with_non_mandatory', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'title' => $title_num,
                            'project' => $project,
                            'asset' => $asset
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
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_2_req(Request $req, $main_req_num, $title, $proj_id, $user_id, $asset_id)
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

                    $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();

                    if ($title == 11) {
                        //non mandatory requirements
                        if ($main_req_num == 5) {
                            $filepath = public_path('ISO_SOA_A5.xlsx');
                        }

                        if ($main_req_num == 6) {
                            $filepath = public_path('ISO_SOA_A6.xlsx');
                        }

                        if ($main_req_num == 7) {
                            $filepath = public_path('ISO_SOA_A7.xlsx');
                        }

                        if ($main_req_num == 8) {
                            $filepath = public_path('ISO_SOA_A8.xlsx');
                        }

                        $data = Excel::toArray([], $filepath);
                        $rows = array_slice($data[0], 1);

                        $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {
                            $value = $row[0];
                            return substr($value, 0, 1) === $main_req_num;
                        })->values()->all();

                        $fetchedData = DB::table('iso_Sec_2_2')->where('project_id', $proj_id)
                            ->where('subdomain', $main_req_num)
                            ->get();




                        return view('iso_sec_2_2.iso_sec_2_2_sub_reqs_user_req', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'data' => $filteredData,
                            'main_req_num' => $main_req_num,
                            'title' => $title,
                            'project' => $project,
                            'asset' => $asset,
                            'fetchedData' => $fetchedData
                        ]);
                    }


                    $filepath = public_path('ISO_SEC_2_2.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {

                        $my_main_req = explode(' ', $row[2]);

                        return strval($my_main_req[0]) === $main_req_num;
                    })->values()->all();

                    $fetchedData = DB::table('iso_Sec_2_2')->where('project_id', $proj_id)
                        ->where('subdomain', $main_req_num)
                        ->get();




                    return view('iso_sec_2_2.iso_sec_2_2_sub_reqs', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'main_req_num' => $main_req_num,
                        'title' => $title,
                        'project' => $project,
                        'asset' => $asset,
                        'fetchedData' => $fetchedData
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_2_sub_req_edit($sub_req, $title, $proj_id, $user_id, $asset_id)
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
                        ->where('project_id', $proj_id)->where('sub_req', $sub_req)->where('asset_id', $asset_id)
                        ->first();
                }




                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();

                $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                //superusers of that organization
                $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                    ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                // dd($superusers_of_that_org);

                //organziatons of those superusers
                $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                if ($title == 11) {

                    if ($sub_req[0] == 5) {
                        $filepath = public_path('ISO_SOA_A5.xlsx');
                    }
                    if ($sub_req[0] == 6) {
                        $filepath = public_path('ISO_SOA_A6.xlsx');
                    }

                    if ($sub_req[0] == 7) {
                        $filepath = public_path('ISO_SOA_A7.xlsx');
                    }
                    if ($sub_req[0] == 8) {
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
                        'asset' => $asset,
                        'users' => $users
                    ]);
                }



                $filepath = public_path('ISO_SEC_2_2.xlsx');
                $data = Excel::toArray([], $filepath); //with header
                $rows = array_slice($data[0], 1); //without header(first row)
                //  dd($rows);

                $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                    return strval($row[3]) === $sub_req;
                })->values()->all();


                $words = explode(" ", $filteredData[0][2]);
                $subdomain = $words[0];

                return view('iso_sec_2_2.iso_sec_2_2_sub_reqs_form', [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'title' => $title,
                    'sub_req' => $sub_req,
                    'result' => $result,
                    'filteredData' => $filteredData,
                    'project' => $project,
                    'asset' => $asset,
                    'users' => $users,
                    'subdomain' => $subdomain
                ]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_2_form(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id)
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

                        $fileName = null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                            $data = [
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'attachment' => $fileName,
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date' => $req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
                        } else {

                            $data = [
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date' => $req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
                        }




                        if ($evidenceLevel == 'component') {


                            if ($req->action == 2) {
                                $filepath = public_path('ISO_SEC_2_2.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                //all controls in this domain
                                //  $filteredData = collect($rows)->filter(function ($row) use ($req) {
                                //             return strval($row[2]) === $req->subdomain;
                                //         })->values()->all();
                                $filteredData = collect($rows)->filter(function ($row) use ($req) {
                                    $value = isset($row[2]) ? trim($row[2]) : '';

                                    // Get only the first word before the space
                                    $firstPart = explode(' ', $value)[0];

                                    return $firstPart === $req->subdomain;
                                })->values()->all();

                                foreach ($filteredData as $innerArray) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray['3'];
                                    $fetch_title = $innerArray['0'];

                                    $words = explode(" ", $innerArray[2]);
                                    $subdomain = $words[0];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $fetch_title,
                                            'sub_req' => $fetch_sub_req,
                                            'subdomain' => $subdomain
                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 3) {

                                $filepath = public_path('ISO_SEC_2_2.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                $filteredData = collect($rows)->filter(function ($row) use ($title) {
                                    return strval($row[0]) === $title;
                                })->values()->all();

                                //all controls in this domain

                                foreach ($filteredData as $innerArray2) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray2['3'];
                                    $fetch_title = $innerArray2['0'];
                                    $words = explode(" ", $innerArray2[2]);
                                    $subdomain = $words[0];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $fetch_title,
                                            'sub_req' => $fetch_sub_req,
                                            'subdomain' => $subdomain
                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 1) {

                                // If evidence level is 'component', just insert or update for the specific asset
                                DB::table('iso_sec_2_2')->updateOrInsert(
                                    [
                                        'project_id' => $proj_id,
                                        'asset_id' => $asset_id,
                                        'title_num' => $title,
                                        'sub_req' => $sub_req,
                                        'subdomain' => $req->subdomain
                                    ],
                                    $data
                                );
                            }



                            // Redirect after updating the specific asset
                            $mysessionreq = $req->session()->get('main_req_num');
                            return redirect()->route(
                                'iso_sec_2_2_req',
                                ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');
                        }




                        $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $assets = null;

                        if ($evidenceLevel == 'name') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get();
                        }

                        if ($evidenceLevel == 'group') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get();
                        }
                        if ($evidenceLevel == 'service') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get();
                        }

                        if ($evidenceLevel == 'project') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->get();
                        }



                        foreach ($assets as $ass) {
                            if ($req->action == 2) {
                                $filepath = public_path('ISO_SEC_2_2.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                //all controls in this domain
                                $filteredData = collect($rows)->filter(function ($row) use ($title) {
                                    return strval($row[0]) === $title;
                                })->values()->all();




                                foreach ($filteredData as $innerArray) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray['3'];
                                    $fetch_title = $innerArray['0'];
                                    $words = explode(" ", $innerArray[2]);
                                    $subdomain = $words[0];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'title_num' => $fetch_title,
                                            'sub_req' => $fetch_sub_req,
                                            'subdomain' => $subdomain
                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 3) {
                                //all controls in all  domains

                                $filepath = public_path('ISO_SEC_2_2.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)


                                foreach ($rows as $innerArray) {

                                    // Access specific value from the inner array
                                    $fetch_title = $innerArray['0'];
                                    $fetch_sub_req = $innerArray['3'];
                                    $words = explode(" ", $innerArray[2]);
                                    $subdomain = $words[0];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'sub_req' => $fetch_sub_req,
                                            'title_num' => $fetch_title,
                                            'subdomain' => $subdomain

                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 1) {

                                DB::table('iso_sec_2_2')->updateOrInsert(
                                    [
                                        'project_id' => $proj_id,
                                        'asset_id' => $ass->assessment_id,
                                        'title_num' => $title,
                                        'sub_req' => $sub_req,
                                        'subdomain' => $req->subdomain

                                    ],
                                    $data
                                );
                            }
                        }
                    }
                }
                $mysessionreq = $req->session()->get('main_req_num');

                return redirect()->route(
                    'iso_sec_2_2_req',
                    ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                )
                    ->with('success', 'Record Updated Successfully');
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_2_form_user_req(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id)
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
                if ($checkpermission->type_id == 4 and $title == 11) {


                    $evidenceLevel = $req->session()->get('evidenceLevel');


                    if (in_array('Data Inputter', $permissions)) {

                        $fileName = null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                            $data = [
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'attachment' => $fileName,
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date' => $req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
                        } else {

                            $data = [
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'acceptance_actual_date' => $req->acceptance_actual_date,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
                        }



                        if ($evidenceLevel == 'component') {

                            if ($req->action == 2) {
                                $file = 'ISO_SOA_A' . $sub_req[0];
                                $filepath = public_path($file . '.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)


                                foreach ($rows as $innerArray) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray['0'];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $title,
                                            'sub_req' => $fetch_sub_req,
                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 3) {

                                $filepath = public_path('ISO_SOA_A5.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                foreach ($rows as $innerArray2) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray2['0'];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $title,
                                            'sub_req' => $fetch_sub_req,
                                        ],
                                        $data
                                    );
                                }

                                $filepath = public_path('ISO_SOA_A6.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                foreach ($rows as $innerArray2) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray2['0'];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $title,
                                            'sub_req' => $fetch_sub_req,
                                        ],
                                        $data
                                    );
                                }

                                $filepath = public_path('ISO_SOA_A7.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                foreach ($rows as $innerArray2) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray2['0'];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $title,
                                            'sub_req' => $fetch_sub_req,
                                        ],
                                        $data
                                    );
                                }

                                $filepath = public_path('ISO_SOA_A8.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                foreach ($rows as $innerArray2) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray2['0'];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $asset_id,
                                            'title_num' => $title,
                                            'sub_req' => $fetch_sub_req,
                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 1) {

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
                            }



                            // Redirect after updating the specific asset
                            $mysessionreq = $req->session()->get('main_req_num');
                            return redirect()->route(
                                'iso_sec_2_2_req',
                                ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully for Annex A');
                        }




                        $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $assets = null;

                        if ($evidenceLevel == 'name') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get();
                        }

                        if ($evidenceLevel == 'group') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get();
                        }
                        if ($evidenceLevel == 'service') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get();
                        }

                        if ($evidenceLevel == 'project') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->get();
                        }



                        foreach ($assets as $ass) {
                            if ($req->action == 2) {
                                $file = 'ISO_SOA_A' . $sub_req[0];
                                $filepath = public_path($file . '.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                foreach ($rows as $innerArray) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray['0'];

                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'title_num' => $title,
                                            'sub_req' => $fetch_sub_req
                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 3) {
                                //all controls in all  domains

                                $filepath = public_path('ISO_SOA_A5.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)


                                foreach ($rows as $innerArray) {
                                    $fetch_sub_req = $innerArray['0'];


                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'sub_req' => $fetch_sub_req,
                                            'title_num' => $title

                                        ],
                                        $data
                                    );
                                }

                                $filepath = public_path('ISO_SOA_A6.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)


                                foreach ($rows as $innerArray) {
                                    $fetch_sub_req = $innerArray['0'];


                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'sub_req' => $fetch_sub_req,
                                            'title_num' => $title

                                        ],
                                        $data
                                    );
                                }

                                $filepath = public_path('ISO_SOA_A7.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)


                                foreach ($rows as $innerArray) {
                                    $fetch_sub_req = $innerArray['0'];


                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'sub_req' => $fetch_sub_req,
                                            'title_num' => $title

                                        ],
                                        $data
                                    );
                                }


                                $filepath = public_path('ISO_SOA_A8.xlsx');
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)


                                foreach ($rows as $innerArray) {
                                    $fetch_sub_req = $innerArray['0'];


                                    DB::table('iso_sec_2_2')->updateOrInsert(
                                        [
                                            'project_id' => $proj_id,
                                            'asset_id' => $ass->assessment_id,
                                            'sub_req' => $fetch_sub_req,
                                            'title_num' => $title

                                        ],
                                        $data
                                    );
                                }
                            }

                            if ($req->action == 1) {

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
                    }
                }
                $mysessionreq = $req->session()->get('main_req_num');

                return redirect()->route(
                    'iso_sec_2_2_req',
                    ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                )
                    ->with('success', 'Record Updated Successfully for Annex A');
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }



    public function upload_file_for_compliance_api_proj($proj_id, $user_id, Request $req)
    {
        $req->validate([
            'data_record_attachments' => 'required|file|mimes:pdf|max:20480',
        ]);

        if ($req->hasFile('data_record_attachments')) {
            $file = $req->file('data_record_attachments');

            // Generate unique filename
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

            // Store the file in public/data_record_attachments
            $file->move(public_path('data_record_attachments'), $filename);

            // Insert record into database
            DB::table('attachment_for_compliance_project_level')->insert([
                'filename' => $filename,
                'project_id' => $proj_id,
                'uploaded_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'File uploaded successfully.');
        }

        return back()->withErrors(['data_record_attachments' => 'File upload failed.']);
    }


    public function get_ai_data_for_compliance($asset_id, $domain, $subdomain, $proj_id, $user_id)
    {
        $attachments = DB::table('attachment_for_compliance_project_level')->where('project_id', $proj_id)->pluck('filename')->toArray();

        if ($attachments == null) {
            return redirect()->route('iso_sec_2_2_subsections', [
                'proj_id' => $proj_id,
                'user_id' => $user_id,
                'asset_id' => $asset_id
            ])->with('error', 'Please add atleast one document');
        }

        $proj = DB::table('projects')->where('project_id', $proj_id)->first();
        $proj_type = DB::table('project_types')->where('id', $proj->project_type)->first();
        $asset = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();


        $org = auth()->user()->organization->name;
        $sub_org = auth()->user()->department->name ?? "null";
        $project_id = $proj_id;
        $project_name = $proj->project_name;
        $project_type = $proj_type->type;
        $service = $asset->s_name;
        $asset_type = $asset->g_name ?? "null";
        $asset_subtype = $asset->name ?? "null";
        $component = $asset->c_name;

        $filepath = public_path('ISO_SEC_2_2.xlsx');
        $data = Excel::toArray([], $filepath);
        $rows = array_slice($data[0], 1);

        $filteredData = collect($rows)->filter(function ($row) use ($domain, $subdomain) {

            // Condition 1: First column must exactly match the domain
            $firstColumnMatch = strval($row[0]) === $domain;

            // Condition 2: The number before the first space in column 3 must also match the domain
            $thirdColNumber = explode(' ', trim($row[2]))[0] ?? null;
            $thirdColumnMatch = $thirdColNumber === $subdomain;

            return $firstColumnMatch && $thirdColumnMatch;
        })->values();

        $controls = [];

        foreach ($filteredData as $row) {
            $level1 = strval($row[0]);       // e.g., "4"
            $level2 = trim($row[2]);         // e.g., "4.1 ..."
            $level2Key = explode(' ', $level2)[0]; // "4.1"
            $level3Key = trim($row[3]);      // e.g., "4.1-a"
            $description = trim($row[4]);    // control description

            if (!$level1 || !$level2Key || !$level3Key || !$description) continue;

            $controls[$level1][$level2Key][$level3Key] = $description;
        }

        // Build final payload
        $payload = [
            "org" => $org,
            "sub_org" => $sub_org,
            "project_id" => (int)$proj_id,
            "project_name" => $project_name,
            "project_type" => $project_type,
            "asset_id" => (int)$asset_id,
            "service" => $service,
            "asset_type" => $asset_type,
            "asset_subtype" => $asset_subtype,
            "asset_component" => $component,
            "controls" => $controls,
            "attachments" => $attachments,
        ];



        $evidenceLevel = Session::get('evidenceLevel');


        // Call the API
        $response = Http::post('http://103.31.80.138:3000/submit-structure', $payload);

        // dd($response->json());

        $complianceAnalysis = $responseData['message']['compliance_analysis'] ?? [];

        $responseData = $response->json();

        $complianceAnalysis = $responseData['message']['compliance_analysis'] ?? [];

        $responseData = $response->json();

        $complianceAnalysis = $responseData['message']['compliance_analysis'] ?? [];

        $complianceMap = [];

        foreach ($complianceAnalysis as $item) {
            foreach ($item as $controlId => $details) {
                $rawStatus = $details['compliance_status'] ?? '';
                $normalizedStatus = strtolower(trim($details['compliance_status'] ?? ''));

                if ($normalizedStatus === 'not-inplace') {
                    $compStatus = 'no';
                } elseif ($normalizedStatus === 'in-place') {
                    $compStatus = 'yes';
                } else {
                    $compStatus = $normalizedStatus;
                }
                $treatmentDate = null;


                if (!empty($details['date'])) {
                    try {
                        $treatmentDate = Carbon::createFromFormat('d/m/Y', trim($details['date']))->format('Y-m-d');
                    } catch (\Exception $e) {
                        $treatmentDate = null; // fallback if invalid
                    }
                }



                $complianceMap[$controlId] = [
                    'comp_status' => $compStatus,
                    'comments' => $details['compliance_comments'] ?? null,
                    'treatment_action' => $details['action_plan'],
                    'treatment_target_date' => $treatmentDate,
                ];
            }
        }


        // Step 2: Loop through controls and insert data row by row
        if ($evidenceLevel == 'component') {
            foreach ($controls as $level1 => $level2Array) {
                foreach ($level2Array as $level2 => $level3Array) {
                    foreach ($level3Array as $level3 => $description) {

                        $compliance = $complianceMap[$level3] ?? [];

                        $insertData = array_merge($compliance, [
                            'last_edited_by' => $user_id,
                            'last_edited_at' => now(),

                        ]);



                        DB::table('iso_sec_2_2')->updateOrInsert(
                            [
                                'project_id' => $proj_id,
                                'asset_id' => $asset_id,
                                'title_num' => $level1,
                                'subdomain' => $level2,
                                'sub_req' => $level3,
                            ],
                            $insertData
                        );
                    }
                }
            }
        }

        return redirect()->route('iso_sec_2_2_req', [
            'main_req_num' => $subdomain,
            'title' => $domain,
            'proj_id' => $proj_id,
            'user_id' => $user_id,
            'asset_id' => $asset_id
        ])->with('success', "AI input done successfully");
    }
}
