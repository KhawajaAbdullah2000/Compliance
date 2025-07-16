<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;

class KSA_NCA extends Controller
{
    public function ksa_nca_subsections(Request $req, $proj_id, $user_id, $asset_id)
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

                if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19 || $checkpermission->type_id == 4) {
                    //ksa or COSO or iso or

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    if ($req->evidenceLevel != null) {
                        $req->session()->forget('evidenceLevel');
                        $req->session()->put('evidenceLevel', $req->evidenceLevel);
                    }



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


                    $results = DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->get();

                    $finalStatusByTitle = $results->groupBy('title_num')->map(function ($items) {
                    $statuses = $items->pluck('comp_status')->filter()->unique();

                        return $statuses->count() === 1 ? $statuses->first() : 'different';
                    });

                 

                $finalApplicabilityByTitle = $results->groupBy('title_num')->map(function ($items) {
                $statuses = $items->pluck('applicability')->filter()->unique();
            
                        return $statuses->count() === 1 ? $statuses->first() : 'different';
                    });

                

                    return view('KSA_NCA.sec_2_2_subsections', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset,
                        'finalStatusByTitle' => $finalStatusByTitle,
                        'finalApplicabilityByTitle'=>$finalApplicabilityByTitle
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function ksa_nca_section_2_2($title_num, $proj_id, $user_id, $asset_id)
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

                if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19 || $checkpermission->type_id == 4) {

                    if ($checkpermission->type_id == 7) {
                        $filepath = public_path('KSA_NCA_ECC.xlsx');
                    }

                    if ($checkpermission->type_id == 18) {
                        $filepath = public_path('COSO.xlsx');
                    }

                    if ($checkpermission->type_id == 19) {
                        $filepath = public_path('SOC2_Type2.xlsx');
                    }

                    if ($checkpermission->type_id == 4) {
                        $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                    }

                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)



                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();



                    $filteredData = collect($rows)->filter(function ($row) use ($title_num) {
                        return strval($row[0]) === $title_num;
                    })->values()->all();



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


                    $results = DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('title_num', $title_num)
                        ->get();




                    $finalStatusBySubdomain = $results->groupBy('subdomain')->map(function ($items) {
                        $statuses = $items->pluck('comp_status')->filter()->unique();

                        return $statuses->count() === 1 ? $statuses->first() : 'different';
                    });

                    //  dd($finalStatusBySubdomain);




                    return view('KSA_NCA.ksa_nca_2_2_main', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'title' => $title_num,
                        'project' => $project,
                        'asset' => $asset,
                        'finalStatusBySubdomain' => $finalStatusBySubdomain
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function ksa_nca_sec_2_2_req(Request $req, $main_req_num, $title, $proj_id, $user_id, $asset_id)
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

                if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19 || $checkpermission->type_id == 4) {

                    if ($checkpermission->type_id == 7) {
                        $filepath = public_path('KSA_NCA_ECC.xlsx');
                    }

                    if ($checkpermission->type_id == 18) {
                        $filepath = public_path('COSO.xlsx');
                    }

                    if ($checkpermission->type_id == 19) {
                        $filepath = public_path('SOC2_Type2.xlsx');
                    }

                    if ($checkpermission->type_id == 4) {
                        $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                    }

                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {

                        return strval($row[2]) === $main_req_num;
                    })->values()->all();


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


                    $fetchedData = DB::table('iso_Sec_2_2')->where('project_id', $proj_id)
                        ->where('subdomain', $main_req_num)
                        ->get();





                    return view('KSA_NCA.ksa_nca_2_2_sub_reqs', [
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


    public function ksa_nca_sec2_2_sub_req_edit(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id, ?string $main_req = null)
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

                if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19 || $checkpermission->type_id == 4) {
                    $result = Db::table('iso_sec_2_2')->join('users', 'iso_sec_2_2.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->where('sub_req', $sub_req)->where('asset_id', $asset_id)
                        ->first();
                }

                //  dd($result);

                if ($checkpermission->type_id == 7) {
                    $filepath = public_path('KSA_NCA_ECC.xlsx');
                }

                if ($checkpermission->type_id == 18) {
                    $filepath = public_path('COSO.xlsx');
                }

                if ($checkpermission->type_id == 19) {
                    $filepath = public_path('SOC2_Type2.xlsx');
                }

                if ($checkpermission->type_id == 4) {
                    $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                }



                $data = Excel::toArray([], $filepath); //with header
                $rows = array_slice($data[0], 1); //without header(first row)

                if ($main_req == null) {
                    $main_req_num = $req->session()->get('main_req_num');
                } else {
                    $main_req_num = $main_req;
                }


                $filteredData = collect($rows)->filter(function ($row) use ($sub_req, $main_req_num) {
                    return strval($row[2]) === $main_req_num && strval($row[4]) === $sub_req;
                })->values()->all();




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

                $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                //superusers of that organization
                $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                    ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                // dd($superusers_of_that_org);

                //organziatons of those superusers
                $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);



                return view('KSA_NCA.ksa_nca_sec_2_2_sub_reqs_form', [
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
                    'subdomain' => $filteredData[0][2]
                ]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
    public function ksa_nca_sec_2_2_form(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id)
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
                if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19  || $checkpermission->type_id == 4) {

                    $evidenceLevel = $req->session()->get('evidenceLevel');


                    if (in_array('Data Inputter', $permissions)) {

                        $fileName = null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('ksa_nca_sec_2_2'), $fileName);
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

                                if ($checkpermission->type_id == 7) {
                                    $filepath = public_path('KSA_NCA_ECC.xlsx');
                                }

                                if ($checkpermission->type_id == 18) {
                                    $filepath = public_path('COSO.xlsx');
                                }

                                if ($checkpermission->type_id == 19) {
                                    $filepath = public_path('SOC2_Type2.xlsx');
                                }

                                if ($checkpermission->type_id == 4) {
                                    $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                                }

                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                //all controls in this domain
                                $filteredData = collect($rows)->filter(function ($row) use ($req) {
                                    return strval($row[2]) === $req->subdomain;
                                })->values()->all();



                                foreach ($filteredData as $innerArray) {
                                    // Access specific value from the inner array
                                    $fetch_title = $innerArray['0'];
                                    $subdomain = $innerArray['2'];
                                    $fetch_sub_req = $innerArray['4'];

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

                                if ($checkpermission->type_id == 7) {
                                    $filepath = public_path('KSA_NCA_ECC.xlsx');
                                }

                                if ($checkpermission->type_id == 18) {
                                    $filepath = public_path('COSO.xlsx');
                                }


                                if ($checkpermission->type_id == 19) {
                                    $filepath = public_path('SOC2_Type2.xlsx');
                                }

                                if ($checkpermission->type_id == 4) {
                                    $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                                }
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                $filteredData = collect($rows)->filter(function ($row) use ($title) {
                                    return strval($row[0]) === $title;
                                })->values()->all();


                                //all controls in this domain

                                foreach ($filteredData as $innerArray2) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray2['4'];
                                    $fetch_title = $innerArray2['0'];
                                    $subdomain = $innerArray2['2'];

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
                                'ksa_nca_sec_2_2_req',
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
                                if ($checkpermission->type_id == 7) {
                                    $filepath = public_path('KSA_NCA_ECC.xlsx');
                                }

                                if ($checkpermission->type_id == 18) {
                                    $filepath = public_path('COSO.xlsx');
                                }


                                if ($checkpermission->type_id == 19) {
                                    $filepath = public_path('SOC2_Type2.xlsx');
                                }

                                if ($checkpermission->type_id == 4) {
                                    $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                                }
                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                //all controls in this domain
                                $filteredData = collect($rows)->filter(function ($row) use ($req) {
                                    return strval($row[2]) === $req->subdomain;
                                })->values()->all();




                                foreach ($filteredData as $innerArray) {
                                    // Access specific value from the inner array
                                    $fetch_sub_req = $innerArray['4'];
                                    $fetch_title = $innerArray['0'];
                                    $subdomain = $innerArray['2'];


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

                                if ($checkpermission->type_id == 7) {
                                    $filepath = public_path('KSA_NCA_ECC.xlsx');
                                }

                                if ($checkpermission->type_id == 18) {
                                    $filepath = public_path('COSO.xlsx');
                                }


                                if ($checkpermission->type_id == 19) {
                                    $filepath = public_path('SOC2_Type2.xlsx');
                                }

                                if ($checkpermission->type_id == 4) {
                                    $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                                }

                                $data2 = Excel::toArray([], $filepath); //with header
                                $rows = array_slice($data2[0], 1); //without header(first row)

                                $filteredData = collect($rows)->filter(function ($row) use ($title) {
                                    return strval($row[0]) === $title;
                                })->values()->all();


                                foreach ($filteredData as $innerArray) {

                                    // Access specific value from the inner array
                                    $fetch_title = $innerArray['0'];
                                    $fetch_sub_req = $innerArray['4'];
                                    $subdomain = $innerArray['2'];

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
                    'ksa_nca_sec_2_2_req',
                    ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                )
                    ->with('success', 'Record Updated Successfully');
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function approve_sec_2_2(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id)
    {
        // dd($sub_req, $title, $proj_id, $user_id,$asset_id,$req->all());

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




                $evidenceLevel = $req->session()->get('evidenceLevel');


                if (in_array('Data Approver', $permissions)) {

                    if ($req->action == 1 || $req->action == 2 || $req->action == 3) {

                        $data = [
                            'approved' => 1,
                            'approver_comments' => $req->approver_comments,
                            'approved_by' => $user_id,
                            'approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    if ($req->action == 4 || $req->action == 5 || $req->action == 6) {

                        $data = [
                            'approved' => 2,
                            'approver_comments' => $req->approver_comments,
                            'approved_by' => $user_id,
                            'approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    if ($checkpermission->type_id == 7) {
                        //ksa Nca
                        $filepath = public_path('KSA_NCA_ECC_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 1) {
                        $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 2) {
                        $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 4) {
                        $filepath = public_path('ISO27K1_2022_Compliance_Updated.xlsx');
                    }

                    if ($checkpermission->type_id == 3) {
                        $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
                    }


                    if ($evidenceLevel == 'component') {

                        if ($req->action == 2 || $req->action == 5) {
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
                                $subdomain = $innerArray['1'];

                                DB::table('iso_sec_2_2')
                                    ->where('project_id', $proj_id)
                                    ->where('asset_id', $asset_id)
                                    ->where('title_num', $fetch_title)
                                    ->where('sub_req', $fetch_sub_req)
                                    ->where('subdomain', $subdomain)
                                    ->update(
                                        $data
                                    );
                            }
                        }

                        if ($req->action == 3 || $req->action == 6) {

                            $data2 = Excel::toArray([], $filepath); //with header
                            $rows = array_slice($data2[0], 1); //without header(first row)



                            foreach ($rows as $innerArray2) {
                                // Access specific value from the inner array
                                $fetch_sub_req = $innerArray2['3'];
                                $fetch_title = $innerArray2['0'];
                                $subdomain = $innerArray2['1'];

                                DB::table('iso_sec_2_2')
                                    ->where('project_id', $proj_id)
                                    ->where('asset_id', $asset_id)
                                    ->where('title_num', $fetch_title)
                                    ->where('sub_req', $fetch_sub_req)
                                    ->where('subdomain', $subdomain)
                                    ->update(
                                        $data
                                    );
                            }
                        }

                        if ($req->action == 1 || $req->action == 4) {

                            // If evidence level is 'component', just insert or update for the specific asset
                            DB::table('iso_sec_2_2')
                                ->where('project_id', $proj_id)
                                ->where('asset_id', $asset_id)
                                ->where('title_num', $title)
                                ->where('sub_req', $sub_req)
                                ->where('subdomain', $req->subdomain)
                                ->update(
                                    $data
                                );
                        }



                        return redirect()->back()
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
                        if ($req->action == 2 || $req->action == 5) {
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
                                $subdomain = $innerArray['1'];

                                DB::table('iso_sec_2_2')
                                    ->where('project_id', $proj_id)
                                    ->where('asset_id', $ass->assessment_id)
                                    ->where('title_num', $fetch_title)
                                    ->where('sub_req', $fetch_sub_req)
                                    ->where('subdomain', $subdomain)
                                    ->update(
                                        $data
                                    );
                            }
                        }

                        if ($req->action == 3 || $req->action == 6) {

                            $data2 = Excel::toArray([], $filepath); //with header
                            $rows = array_slice($data2[0], 1); //without header(first row)


                            foreach ($rows as $innerArray) {

                                // Access specific value from the inner array
                                $fetch_title = $innerArray['0'];
                                $fetch_sub_req = $innerArray['3'];
                                $subdomain = $innerArray['1'];

                                DB::table('iso_sec_2_2')
                                    ->where('project_id', $proj_id)
                                    ->where('asset_id', $ass->assessment_id)
                                    ->where('title_num', $fetch_title)
                                    ->where('sub_req', $fetch_sub_req)
                                    ->where('subdomain', $subdomain)
                                    ->update(
                                        $data
                                    );
                            }
                        }

                        if ($req->action == 1 || $req->action == 4) {

                            DB::table('iso_sec_2_2')
                                ->where('project_id', $proj_id)
                                ->where('asset_id', $ass->assessment_id)
                                ->where('title_num', $title)
                                ->where('sub_req', $sub_req)
                                ->where('subdomain', $req->subdomain)
                                ->update(
                                    $data
                                );
                        }
                    }
                }




                return redirect()->back()
                    ->with('success', 'Record Updated Successfully');
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function approve_sec_2_3_1(Request $req, $control_num, $proj_id, $user_id, $asset_id)
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
                $permissions = json_decode($checkpermission->project_permissions);

                if (in_array('Data Approver', $permissions)) {

                    if ($req->action == 1 || $req->action == 2 || $req->action == 3) {

                        $data = [
                            'approved' => 1,
                            'approver_comments' => $req->approver_comments,
                            'approved_by' => $user_id,
                            'approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    if ($req->action == 4 || $req->action == 5 || $req->action == 6) {

                        $data = [
                            'approved' => 2,
                            'approver_comments' => $req->approver_comments,
                            'approved_by' => $user_id,
                            'approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    $parts = explode('.', $control_num);
                    $domain = $parts[0];


                    if ($req->action == 1 || $req->action == 4) {
                        DB::table('iso_sec_2_3_1')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)
                            ->update(
                                $data

                            );
                    }

                    if ($req->action == 2 || $req->action == 5) {
                        DB::table('iso_sec_2_3_1')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->where('control_num', 'like', $domain . '%')
                            ->update(
                                $data

                            );
                    }

                    if ($req->action == 3 || $req->action == 6) {
                        DB::table('iso_sec_2_3_1')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->update(
                                $data

                            );
                    }

                    return redirect()->back()
                        ->with('success', 'Record Updated Successfully');
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function approve_risk_treatment(Request $req, $control_num, $proj_id, $user_id, $asset_id)
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
                $permissions = json_decode($checkpermission->project_permissions);

                if (in_array('Data Approver', $permissions)) {

                    if ($req->action == 1 || $req->action == 2 || $req->action == 3) {

                        $data = [
                            'approved' => 1,
                            'approver_comments' => $req->approver_comments,
                            'approved_by' => $user_id,
                            'approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    if ($req->action == 4 || $req->action == 5 || $req->action == 6) {

                        $data = [
                            'approved' => 2,
                            'approver_comments' => $req->approver_comments,
                            'approved_by' => $user_id,
                            'approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    $parts = explode('.', $control_num);
                    $domain = $parts[0];


                    if ($req->action == 1 || $req->action == 4) {
                        DB::table('iso_risk_treatment')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)
                            ->update(
                                $data

                            );
                    }

                    if ($req->action == 2 || $req->action == 5) {
                        DB::table('iso_risk_treatment')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->where('control_num', 'like', $domain . '%')
                            ->update(
                                $data

                            );
                    }

                    if ($req->action == 3 || $req->action == 6) {
                        DB::table('iso_risk_treatment')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->update(
                                $data

                            );
                    }

                    return redirect()->back()
                        ->with('success', 'Record Updated Successfully');
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }




    public function add_mandatory_all_title(Request $req, $proj_id, $user_id, $asset_id)
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
                $permissions = json_decode($checkpermission->project_permissions);


                $evidenceLevel = $req->session()->get('evidenceLevel');
                if (in_array('Data Inputter', $permissions)) {

                    $data = [
                        'comp_status' => $req->comp_status,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ];
                    if ($checkpermission->type_id == 7) {
                        //ksa Nca
                        $filepath = public_path('KSA_NCA_ECC_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 18) {
                        //COSO
                        $filepath = public_path('COSO_Modified.xlsx');
                    }


                    if ($checkpermission->type_id == 19) {
                        $filepath = public_path('SOC2_Type2_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 1) {
                        //PCI SIngle
                        $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 16) {
                        //cobit 2019
                        $filepath = public_path('COBIT_2019.xlsx');
                    }

                    if ($checkpermission->type_id == 2) {
                        //PCI MUlti
                        $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 3) {
                        //PCI Merchant
                        $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
                    }

                    if ($checkpermission->type_id == 5) {
                        //Cy sama
                        $filepath = public_path('CY_SAMA_Modified.xlsx');
                    }

                    //ISA part 3-2
                    if ($checkpermission->type_id == 10) {
                        $filepath = public_path('ISA_62443_Part 3-2_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 12) {
                        $filepath = public_path('ISA 62443 Part 4-2 -Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 13) {
                        $filepath = public_path('ISA 62443 Part 3-3 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 11) {
                        $filepath = public_path('ISA 62443 Part 2-1 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 9) {

                        $filepath = public_path('ISA 62443 Part 4-1 - Modified.xlsx');
                    }

                    //ISO
                    if ($checkpermission->type_id == 4) {
                        $filepath = public_path('ISO27K1_2022_Compliance_Updated_Modified.xlsx');
                    }



                    if ($evidenceLevel == 'component') {


                        $data2 = Excel::toArray([], $filepath); //with header
                        $rows = array_slice($data2[0], 1); //without header(first row)
                        $filteredData = collect($rows)->filter(function ($row) use ($req) {
                            return strval($row[0]) === $req->title;
                        })->values()->all();

                        // dd($filteredData);




                        foreach ($filteredData as $innerArray) {
                            // Access specific value from the inner array
                            $fetch_sub_req = $innerArray['3'];
                            $fetch_title = $innerArray['0'];
                            $subdomain = $innerArray['1'];

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

                        if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19 || $checkpermission->type_id == 4) {
                            return redirect()->route(
                                'ksa_nca_subsections',
                                ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');
                        }

                        if ($checkpermission->type_id == 16) {
                            return redirect()->route(
                                'cobit_subsections',
                                ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');
                        }

                        if ($checkpermission->type_id == 5) {
                            return redirect()->route(
                                'cy_sama_subsections',
                                ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');
                        }

                        if ($checkpermission->type_id == 10 || $checkpermission->type_id == 11 || $checkpermission->type_id == 12 ||  $checkpermission->type_id == 13 ||  $checkpermission->type_id == 9) {
                            return redirect()->route(
                                'isa_subsections',
                                ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');
                        }


                        //PCI
                        if ($checkpermission->type_id == 1 || $checkpermission->type_id == 2 || $checkpermission->type_id == 3) {
                            return redirect()->back()->with('success', 'Record Updated Successfully');
                        }


                        if ($checkpermission->type_id == 4) {

                            return redirect()->back()->with('success', 'Record Updated Successfully');
                        }
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
                        $data2 = Excel::toArray([], $filepath); //with header
                        $rows = array_slice($data2[0], 1); //without header(first row)

                        //all controls in this domain
                        $filteredData = collect($rows)->filter(function ($row) use ($req) {
                            return strval($row[0]) === $req->title;
                        })->values()->all();



                        foreach ($filteredData as $innerArray) {
                            // Access specific value from the inner array
                            $fetch_sub_req = $innerArray['3'];
                            $fetch_title = $innerArray['0'];
                            $subdomain = $innerArray['1'];


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

                    if ($checkpermission->type_id == 7 || $checkpermission->type_id == 18 || $checkpermission->type_id == 19) {
                        return redirect()->route(
                            'ksa_nca_subsections',
                            ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                    }

                    if ($checkpermission->type_id == 5) {
                        return redirect()->route(
                            'cy_sama_subsections',
                            ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                    }

                    if ($checkpermission->type_id == 10 || $checkpermission->type_id == 11 || $checkpermission->type_id == 12 || $checkpermission->type_id == 13 || $checkpermission->type_id == 9) {
                        return redirect()->route(
                            'isa_subsections',
                            ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                    }

                    //PCI
                    if ($checkpermission->type_id == 1 || $checkpermission->type_id == 2 || $checkpermission->type_id == 3) {
                        return redirect()->back()->with('success', 'Record Updated Successfully');
                    }

                    //ISO
                    if ($checkpermission->type_id == 4) {
                        return redirect()->back()->with('success', 'Record Updated Successfully');
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
                }
            }
        }
    }

    // public function add_mandatory_all_title_all_controls(Request $req, $proj_id, $user_id, $asset_id)
    // {
    //     if ($user_id == auth()->user()->id) {
    //         $checkpermission = Db::table('project_details')->select(
    //             'project_types.id as type_id',
    //             'project_details.project_code',
    //             'project_details.project_permissions',
    //             'projects.project_name',
    //             'projects.project_id'
    //         )
    //             ->join('projects', 'project_details.project_code', 'projects.project_id')
    //             ->join('project_types', 'projects.project_type', 'project_types.id')
    //             ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
    //             ->first();
    //         if ($checkpermission) {
    //             $permissions = json_decode($checkpermission->project_permissions);


    //             if (in_array('Data Inputter', $permissions)) {

    //                 $titles = $req->input('titles');
    //                 $statuses = $req->input('comp_statuses');


    //                 $filepath = public_path('ISO27K1_2022_Compliance_Updated_Modified.xlsx');
    //                 $evidenceLevel = $req->session()->get('evidenceLevel');

    //                 $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

    //                 $assets = collect();

    //                 if ($evidenceLevel === 'name') {
    //                     $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get();
    //                 } elseif ($evidenceLevel === 'group') {
    //                     $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get();
    //                 } elseif ($evidenceLevel === 'service') {
    //                     $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get();
    //                 } elseif ($evidenceLevel === 'project') {
    //                     $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->get();
    //                 }

    //                 $data2 = Excel::toArray([], $filepath); // Load once for performance
    //                 $rows = array_slice($data2[0], 1); // Skip header

    //                 foreach ($titles as $index => $title) {

    //                     $compStatus = $statuses[$index];

    //                     $data = [
    //                         'comp_status' => $compStatus,
    //                         'last_edited_by' => $user_id,
    //                         'last_edited_at' => now()->format('Y-m-d H:i:s'),
    //                     ];

    //                     if ($evidenceLevel === 'component') {
    //                         // Handle single asset for 'component' level
    //                         $filteredData = collect($rows)->filter(function ($row) use ($title) {
    //                             return strval($row[0]) === (string)$title;
    //                         })->values();

    //                         foreach ($filteredData as $innerArray) {
    //                             DB::table('iso_sec_2_2')->updateOrInsert(
    //                                 [
    //                                     'project_id' => $proj_id,
    //                                     'asset_id' => $asset_id,
    //                                     'title_num' => $innerArray[0],
    //                                     'sub_req' => $innerArray[3],
    //                                     'subdomain' => $innerArray[1]
    //                                 ],
    //                                 $data
    //                             );
    //                         }
    //                     } else {
    //                         // Handle group, name, service, project levels
    //                         foreach ($assets as $ass) {
    //                             $filteredData = collect($rows)->filter(function ($row) use ($title) {
    //                                 return strval($row[0]) === (string)$title;
    //                             })->values();

    //                             foreach ($filteredData as $innerArray) {
    //                                 DB::table('iso_sec_2_2')->updateOrInsert(
    //                                     [
    //                                         'project_id' => $proj_id,
    //                                         'asset_id' => $ass->assessment_id,
    //                                         'title_num' => $innerArray[0],
    //                                         'sub_req' => $innerArray[3],
    //                                         'subdomain' => $innerArray[1]
    //                                     ],
    //                                     $data
    //                                 );
    //                             }
    //                         }
    //                     }
    //                 }

    //                 return redirect()->back()->with('success', 'All titles updated successfully.');
    //             } else {
    //                 return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    //             }
    //         }
    //     }
    // }

    public function add_mandatory_all_title_all_controls(Request $req, $proj_id, $user_id, $asset_id)
{
    if ($user_id != auth()->user()->id) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    $checkpermission = DB::table('project_details')
        ->join('projects', 'project_details.project_code', 'projects.project_id')
        ->join('project_types', 'projects.project_type', 'project_types.id')
        ->where('project_code', $proj_id)
        ->where('assigned_enduser', $user_id)
        ->first();

    if (!$checkpermission) {
        return redirect()->back()->with('error', 'No project permission found.');
    }

    $permissions = json_decode($checkpermission->project_permissions);

    if (!in_array('Data Inputter', $permissions)) {
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    $titles = $req->input('titles');
    $statuses = $req->input('comp_statuses');
    $applicabilities = $req->input('applicabilities');

    $filepath = public_path('ISO27K1_2022_Compliance_Updated_Modified.xlsx');
    $evidenceLevel = $req->session()->get('evidenceLevel');

    $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

    $assets = collect();

    if ($evidenceLevel === 'name') {
        $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get();
    } elseif ($evidenceLevel === 'group') {
        $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get();
    } elseif ($evidenceLevel === 'service') {
        $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get();
    } elseif ($evidenceLevel === 'project') {
        $assets = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->get();
    }

    $data2 = Excel::toArray([], $filepath);
    $rows = array_slice($data2[0], 1);

    foreach ($titles as $index => $title) {

        $compStatus = $statuses[$index];
        $applicability = $applicabilities[$index];

        $data = [
            'comp_status' => $compStatus,
            'applicability' => $applicability,
            'last_edited_by' => $user_id,
            'last_edited_at' => now()->format('Y-m-d H:i:s'),
        ];

        if ($evidenceLevel === 'component') {
            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) === (string)$title;
            })->values();

            foreach ($filteredData as $innerArray) {
                DB::table('iso_sec_2_2')->updateOrInsert(
                    [
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,
                        'title_num' => $innerArray[0],
                        'sub_req' => $innerArray[3],
                        'subdomain' => $innerArray[1]
                    ],
                    $data
                );
            }
        } else {
            foreach ($assets as $ass) {
                $filteredData = collect($rows)->filter(function ($row) use ($title) {
                    return strval($row[0]) === (string)$title;
                })->values();

                foreach ($filteredData as $innerArray) {
                    DB::table('iso_sec_2_2')->updateOrInsert(
                        [
                            'project_id' => $proj_id,
                            'asset_id' => $ass->assessment_id,
                            'title_num' => $innerArray[0],
                            'sub_req' => $innerArray[3],
                            'subdomain' => $innerArray[1]
                        ],
                        $data
                    );
                }
            }
        }
    }

    return redirect()->back()->with('success', 'All controls updated successfully.');
}


    public function add_mandatory_all_domain(Request $req, $proj_id, $user_id, $asset_id)
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
                $permissions = json_decode($checkpermission->project_permissions);


                $evidenceLevel = $req->session()->get('evidenceLevel');
                if (in_array('Data Inputter', $permissions)) {

                    $data = [
                        'comp_status' => $req->comp_status,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ];
                    if ($checkpermission->type_id == 7) {
                        //ksa Nca
                        $filepath = public_path('KSA_NCA_ECC_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 18) {
                        //COSO
                        $filepath = public_path('COSO_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 19) {
                        $filepath = public_path('SOC2_Type2_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 5) {
                        //Cy sama
                        $filepath = public_path('CY_SAMA_Modified.xlsx');
                    }
                    if ($checkpermission->type_id == 1) {
                        //PCI SIngle
                        $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 16) {
                        //cobit 2019
                        $filepath = public_path('COBIT_2019.xlsx');
                    }

                    if ($checkpermission->type_id == 2) {
                        //PCI MUlti
                        $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 3) {
                        //PCI MUlti
                        $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
                    }

                    //ISA part 3-2
                    if ($checkpermission->type_id == 10) {
                        $filepath = public_path('ISA_62443_Part 3-2_Modified.xlsx');
                    }

                    //ISa part4-2
                    if ($checkpermission->type_id == 12) {

                        $filepath = public_path('ISA 62443 Part 4-2 -Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 13) {
                        $filepath = public_path('ISA 62443 Part 3-3 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 11) {
                        $filepath = public_path('ISA 62443 Part 2-1 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 9) {
                        $filepath = public_path('ISA 62443 Part 4-1 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 4) {
                        $filepath = public_path('ISO27K1_2022_Compliance_Updated_Modified.xlsx');
                    }


                    if ($evidenceLevel == 'component') {


                        $data2 = Excel::toArray([], $filepath); //with header
                        $rows = array_slice($data2[0], 1); //without header(first row)


                        $filteredData = collect($rows)->filter(function ($row) use ($req) {
                            return strval($row[1]) === $req->domain;
                        })->values()->all();



                        foreach ($filteredData as $innerArray) {
                            // Access specific value from the inner array
                            $fetch_sub_req = $innerArray['3'];
                            $fetch_title = $innerArray['0'];
                            $subdomain = $innerArray['1'];

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


                        return redirect()->back()->with('success', 'Record Updated Successfully');


                        // if ($checkpermission->type_id == 10||$checkpermission->type_id == 11 || $checkpermission->type_id == 12 || $checkpermission->type_id==13 ) {
                        //     return redirect()->route(
                        //         'isa_subsections',
                        //         ['proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                        //     )
                        //         ->with('success', 'Record Updated Successfully');

                        // }





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
                        $data2 = Excel::toArray([], $filepath); //with header
                        $rows = array_slice($data2[0], 1); //without header(first row)

                        //all controls in this domain
                        $filteredData = collect($rows)->filter(function ($row) use ($req) {
                            return strval($row[1]) === $req->domain;
                        })->values()->all();



                        foreach ($filteredData as $innerArray) {
                            // Access specific value from the inner array
                            $fetch_sub_req = $innerArray['3'];
                            $fetch_title = $innerArray['0'];
                            $subdomain = $innerArray['1'];


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




                    return redirect()->back()->with('success', 'Record Updated Successfully');
                } else {
                    return redirect()->route(
                        'iso_sections',
                        ['proj_id' => $proj_id, 'user_id' => $user_id]
                    )
                        ->with('error', 'Not Allowed');
                }
            }
        }
    }

    public function add_mandatory_all_domain_all_controls(Request $req, $proj_id, $user_id, $asset_id)
    {
        if ($user_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $checkpermission = DB::table('project_details')
            ->select('project_types.id as type_id', 'project_details.project_code', 'project_details.project_permissions', 'projects.project_name', 'projects.project_id')
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)
            ->where('assigned_enduser', $user_id)
            ->first();

        if (!$checkpermission) {
            return redirect()->back()->with('error', 'No project permission found.');
        }

        $permissions = json_decode($checkpermission->project_permissions);

        if (!in_array('Data Inputter', $permissions)) {
            return redirect()->route('iso_sections', ['proj_id' => $proj_id, 'user_id' => $user_id])
                ->with('error', 'Not Allowed');
        }

        $evidenceLevel = $req->session()->get('evidenceLevel');

        // Determine correct Excel file
        $fileMap = [
            7 => 'KSA_NCA_ECC_Modified.xlsx',
            18 => 'COSO_Modified.xlsx',
            19 => 'SOC2_Type2_Modified.xlsx',
            5 => 'CY_SAMA_Modified.xlsx',
            1 => 'PCI_DSS_4_Single_TSP.xlsx',
            16 => 'COBIT_2019.xlsx',
            2 => 'PCI_DSS_4_Multi_TSP.xlsx',
            3 => 'PCI_DSS_4_Merchant.xlsx',
            10 => 'ISA_62443_Part 3-2_Modified.xlsx',
            12 => 'ISA 62443 Part 4-2 -Modified.xlsx',
            13 => 'ISA 62443 Part 3-3 - Modified.xlsx',
            11 => 'ISA 62443 Part 2-1 - Modified.xlsx',
            9 => 'ISA 62443 Part 4-1 - Modified.xlsx',
            4 => 'ISO27K1_2022_Compliance_Updated_Modified.xlsx',
        ];

        $filepath = public_path($fileMap[$checkpermission->type_id]);

        $data2 = Excel::toArray([], $filepath); // Load Excel once
        $rows = array_slice($data2[0], 1); // Skip header

        $domains = $req->input('domains');
        $statuses = $req->input('comp_statuses');

        if ($evidenceLevel === 'component') {
            foreach ($domains as $index => $domain) {

                $compStatus = $statuses[$index];

                $data = [
                    'comp_status' => $compStatus,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s'),
                ];

                $filteredData = collect($rows)->filter(function ($row) use ($domain) {
                    return strval($row[1]) === strval($domain);
                });

                foreach ($filteredData as $innerArray) {
                    DB::table('iso_sec_2_2')->updateOrInsert(
                        [
                            'project_id' => $proj_id,
                            'asset_id' => $asset_id,
                            'title_num' => $innerArray[0],
                            'sub_req' => $innerArray[3],
                            'subdomain' => $innerArray[1]
                        ],
                        $data
                    );
                }
            }

            return redirect()->back()->with('success', 'Subdomain records updated successfully.');
        }

        // For name, group, service, project levels:
        $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

        $assets = match ($evidenceLevel) {
            'name' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get(),
            'group' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get(),
            'service' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get(),
            'project' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->get(),
            default => collect(),
        };

        foreach ($assets as $ass) {
            foreach ($domains as $index => $domain) {

                $compStatus = $statuses[$index];

                $data = [
                    'comp_status' => $compStatus,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s'),
                ];

                $filteredData = collect($rows)->filter(function ($row) use ($domain) {
                    return strval($row[1]) === strval($domain);
                });

                foreach ($filteredData as $innerArray) {
                    DB::table('iso_sec_2_2')->updateOrInsert(
                        [
                            'project_id' => $proj_id,
                            'asset_id' => $ass->assessment_id,
                            'title_num' => $innerArray[0],
                            'sub_req' => $innerArray[3],
                            'subdomain' => $innerArray[1]
                        ],
                        $data
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'All subdomains updated successfully.');
    }

    public function add_mandatory_all_sub_req(Request $req, $proj_id, $user_id, $asset_id)
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
                $permissions = json_decode($checkpermission->project_permissions);


                $evidenceLevel = $req->session()->get('evidenceLevel');
                if (in_array('Data Inputter', $permissions)) {

                    $data = [
                        'comp_status' => $req->comp_status,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ];

                    if ($checkpermission->type_id == 7) {
                        //ksa Nca
                        $filepath = public_path('KSA_NCA_ECC_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 18) {
                        //COSO
                        $filepath = public_path('COSO_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 19) {
                        $filepath = public_path('SOC2_Type2_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 5) {
                        //Cy sama
                        $filepath = public_path('CY_SAMA_Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 1) {
                        //PCI SIngle
                        $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 16) {
                        //cobit 2019
                        $filepath = public_path('COBIT_2019.xlsx');
                    }

                    if ($checkpermission->type_id == 2) {
                        //PCI Multi
                        $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 3) {
                        //PCI Merchant
                        $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
                    }

                    //ISA part 3-2
                    if ($checkpermission->type_id == 10) {
                        $filepath = public_path('ISA_62443_Part 3-2_Modified.xlsx');
                    }

                    //ISa part4-2
                    if ($checkpermission->type_id == 12) {
                        $filepath = public_path('ISA 62443 Part 4-2 -Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 13) {
                        $filepath = public_path('ISA 62443 Part 3-3 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 11) {
                        $filepath = public_path('ISA 62443 Part 2-1 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 9) {
                        $filepath = public_path('ISA 62443 Part 4-1 - Modified.xlsx');
                    }

                    if ($checkpermission->type_id == 4) {
                        $filepath = public_path('ISO27K1_2022_Compliance_Updated_Modified.xlsx');
                    }

                    if ($evidenceLevel == 'component') {


                        $data2 = Excel::toArray([], $filepath); //with header
                        $rows = array_slice($data2[0], 1); //without header(first row)


                        $filteredData = collect($rows)->filter(function ($row) use ($req) {
                            return strval(trim($row[3])) === $req->sub_req;
                        })->values()->all();






                        foreach ($filteredData as $innerArray) {
                            // Access specific value from the inner array
                            $fetch_sub_req = $innerArray['3'];
                            $fetch_title = $innerArray['0'];
                            $subdomain = $innerArray['1'];

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



                        return redirect()->back()->with('success', 'Record Updated Successfully');
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
                        $data2 = Excel::toArray([], $filepath); //with header
                        $rows = array_slice($data2[0], 1); //without header(first row)

                        //all controls in this domain
                        $filteredData = collect($rows)->filter(function ($row) use ($req) {
                            return strval(trim($row[3])) === $req->sub_req;
                        })->values()->all();



                        foreach ($filteredData as $innerArray) {
                            // Access specific value from the inner array
                            $fetch_sub_req = $innerArray['3'];
                            $fetch_title = $innerArray['0'];
                            $subdomain = $innerArray['1'];


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
                    return redirect()->back()->with('success', 'Record Updated Successfully');
                } else {
                    return redirect()->route(
                        'iso_sections',
                        ['proj_id' => $proj_id, 'user_id' => $user_id]
                    )
                        ->with('error', 'Not Allowed');
                }
            }
        }
    }


    public function add_mandatory_all_sub_req_all_controls(Request $req, $proj_id, $user_id, $asset_id)
    {
        if ($user_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $checkpermission = DB::table('project_details')
            ->select('project_types.id as type_id', 'project_details.project_code', 'project_details.project_permissions', 'projects.project_name', 'projects.project_id')
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)
            ->where('assigned_enduser', $user_id)
            ->first();

        if (!$checkpermission) {
            return redirect()->back()->with('error', 'No project permission found.');
        }

        $permissions = json_decode($checkpermission->project_permissions);

        if (!in_array('Data Inputter', $permissions)) {
            return redirect()->route('iso_sections', ['proj_id' => $proj_id, 'user_id' => $user_id])
                ->with('error', 'Not Allowed');
        }

        $evidenceLevel = $req->session()->get('evidenceLevel');

        // File mapping logic
        $fileMap = [
            7 => 'KSA_NCA_ECC_Modified.xlsx',
            18 => 'COSO_Modified.xlsx',
            19 => 'SOC2_Type2_Modified.xlsx',
            5 => 'CY_SAMA_Modified.xlsx',
            1 => 'PCI_DSS_4_Single_TSP.xlsx',
            16 => 'COBIT_2019.xlsx',
            2 => 'PCI_DSS_4_Multi_TSP.xlsx',
            3 => 'PCI_DSS_4_Merchant.xlsx',
            10 => 'ISA_62443_Part 3-2_Modified.xlsx',
            12 => 'ISA 62443 Part 4-2 -Modified.xlsx',
            13 => 'ISA 62443 Part 3-3 - Modified.xlsx',
            11 => 'ISA 62443 Part 2-1 - Modified.xlsx',
            9 => 'ISA 62443 Part 4-1 - Modified.xlsx',
            4 => 'ISO27K1_2022_Compliance_Updated_Modified.xlsx',
        ];

        $filepath = public_path($fileMap[$checkpermission->type_id]);

        $data2 = Excel::toArray([], $filepath);
        $rows = array_slice($data2[0], 1); // skip header

        $sub_reqs = $req->input('sub_reqs');
        $statuses = $req->input('comp_statuses');

        if ($evidenceLevel === 'component') {
            foreach ($sub_reqs as $index => $sub_req) {
                $compStatus = $statuses[$index];

                $data = [
                    'comp_status' => $compStatus,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s')
                ];

                $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                    return strval(trim($row[3])) === strval(trim($sub_req));
                });

                foreach ($filteredData as $innerArray) {
                    DB::table('iso_sec_2_2')->updateOrInsert(
                        [
                            'project_id' => $proj_id,
                            'asset_id' => $asset_id,
                            'title_num' => $innerArray[0],
                            'sub_req' => $innerArray[3],
                            'subdomain' => $innerArray[1]
                        ],
                        $data
                    );
                }
            }

            return redirect()->back()->with('success', 'Sub-requirements updated successfully.');
        }

        // For name, group, service, project levels
        $assetDetails = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->where('assessment_id', $asset_id)
            ->first();

        $assets = match ($evidenceLevel) {
            'name' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get(),
            'group' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get(),
            'service' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get(),
            'project' => DB::table('iso_sec_2_1')->where('project_id', $proj_id)->get(),
            default => collect(),
        };

        foreach ($assets as $ass) {
            foreach ($sub_reqs as $index => $sub_req) {
                $compStatus = $statuses[$index];

                $data = [
                    'comp_status' => $compStatus,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s')
                ];

                $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                    return strval(trim($row[3])) === strval(trim($sub_req));
                });

                foreach ($filteredData as $innerArray) {
                    DB::table('iso_sec_2_2')->updateOrInsert(
                        [
                            'project_id' => $proj_id,
                            'asset_id' => $ass->assessment_id,
                            'title_num' => $innerArray[0],
                            'sub_req' => $innerArray[3],
                            'subdomain' => $innerArray[1]
                        ],
                        $data
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'All sub-requirements updated successfully.');
    }
}
