<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;
use APP\Models\DocumentRepository;
use App\Models\IsoSec22;

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


                //  dd($finalApplicabilityByTitle);




                return view('KSA_NCA.sec_2_2_subsections', [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project' => $project,
                    'asset' => $asset,
                    'finalStatusByTitle' => $finalStatusByTitle,
                    'finalApplicabilityByTitle' => $finalApplicabilityByTitle
                ]);
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
                    $filepath = public_path('KM_ISO27K1_2022_Compliance_18Jul25.xlsx');
                }

                if ($checkpermission->type_id == 23) {
                    $filepath = public_path('NIST_CSF.xlsx');
                }

                if ($checkpermission->type_id == 24) {
                    $filepath = public_path('ISO27701_2019v2.xlsx');
                }

                if ($checkpermission->type_id == 1) {
                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                }

                if ($checkpermission->type_id == 2) {
                    $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                }

                if ($checkpermission->type_id == 3) {
                    $filepath = public_path('PCI_DSS_4_Merchant_TSP.xlsx');
                }

                if ($checkpermission->type_id == 16) {
                    $filepath = public_path('COBIT_2019.xlsx');
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


                // $results = DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                //     ->where('asset_id', $asset_id)->where('title_num', $title_num)
                //     ->get();

                $results = DB::table('iso_sec_2_2')
                    ->where('project_id', $proj_id)
                    ->where('asset_id', $asset_id)
                    ->where('title_num', $title_num)
                    ->get()
                    ->map(function ($item) {
                        $item->subdomain = (string) $item->subdomain;
                        $item->comp_status = (string) $item->comp_status;
                        return $item;
                    });




                $finalStatusBySubdomain = $results->groupBy('subdomain')->map(function ($items) {
                    $statuses = $items->pluck('comp_status')->filter()->unique();

                    return $statuses->count() === 1 ? $statuses->first() : 'different';
                });

                //  dd($finalStatusBySubdomain);


                $finalApplicabilityByTitle = $results->groupBy('subdomain')->map(function ($items) {
                    $statuses = $items->pluck('applicability')->filter()->unique();

                    return $statuses->count() === 1 ? $statuses->first() : 'different';
                });


                // dd($finalStatusBySubdomain,$finalApplicabilityByTitle);

                return view('KSA_NCA.ksa_nca_2_2_main', [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'data' => $filteredData,
                    'title' => $title_num,
                    'project' => $project,
                    'asset' => $asset,
                    'finalStatusBySubdomain' => $finalStatusBySubdomain,
                    'finalApplicabilityByTitle' => $finalApplicabilityByTitle
                ]);
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


                if ($checkpermission->type_id == 7) {
                    $filepath = public_path('KSA_NCA_ECC.xlsx');
                }

                if ($checkpermission->type_id == 18) {
                    $filepath = public_path('COSO.xlsx');
                }

                if ($checkpermission->type_id == 19) {
                    $filepath = public_path('SOC2_Type2.xlsx');
                }

                if ($checkpermission->type_id == 23) {
                    $filepath = public_path('NIST_CSF.xlsx');
                }

                if ($checkpermission->type_id == 4) {
                    $filepath = public_path('KM_ISO27K1_2022_Compliance_18Jul25.xlsx');
                }

                if ($checkpermission->type_id == 24) {
                    $filepath = public_path('ISO27701_2019v2.xlsx');
                }

                if ($checkpermission->type_id == 1) {
                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                }

                if ($checkpermission->type_id == 2) {
                    $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                }

                if ($checkpermission->type_id == 3) {
                    $filepath = public_path('PCI_DSS_4_Merchant_TSP.xlsx');
                }

                if ($checkpermission->type_id == 16) {
                    $filepath = public_path('COBIT_2019.xlsx');
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
                    ->where('title_num', $title)
                    ->where('subdomain', $main_req_num)
                    ->where('asset_id', $asset_id)
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
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function ksa_nca_sec2_2_sub_req_edit(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id, ?string $main_req = null)
    {
        //

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


                $attachedIds = [];
                $record = null;

                $result = Db::table('iso_sec_2_2')->join('users', 'iso_sec_2_2.last_edited_by', 'users.id')
                    ->where('project_id', $proj_id)->where('sub_req', $sub_req)->where('asset_id', $asset_id)
                    ->first();
                if ($result != null) {
                    $record = IsoSec22::find($result->assessment_id);
                    if ($record != null) {
                        $attachedIds = $record->documents()->pluck('document_repository.id')->toArray();
                        //dd($attachedIds);
                    }
                }





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
                    $filepath = public_path('KM_ISO27K1_2022_Compliance_18Jul25.xlsx');
                }

                if ($checkpermission->type_id == 23) {
                    $filepath = public_path('NIST_CSF.xlsx');
                }

                if ($checkpermission->type_id == 24) {
                    $filepath = public_path('ISO27701_2019v2.xlsx');
                }

                if ($checkpermission->type_id == 1) {
                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                }

                if ($checkpermission->type_id == 2) {
                    $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                }

                if ($checkpermission->type_id == 3) {
                    $filepath = public_path('PCI_DSS_4_Merchant_TSP.xlsx');
                }

                if ($checkpermission->type_id == 16) {
                    $filepath = public_path('COBIT_2019.xlsx');
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



                $org_documents = DB::table('document_repository')->where('organization_id', auth()->user()->organization->id)
                    ->orderByDesc('created_at')
                    ->get();


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
                    'subdomain' => $filteredData[0][2],
                    'org_documents' => $org_documents,
                    'attachedIds' => $attachedIds,
                    'record' => $record
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
                        $filepath = public_path('KM_ISO27K1_2022_Compliance_18Jul25.xlsx');
                    }

                    if ($checkpermission->type_id == 23) {
                        $filepath = public_path('NIST_CSF.xlsx');
                    }

                    if ($checkpermission->type_id == 24) {
                        $filepath = public_path('ISO27701_2019v2.xlsx');
                    }

                    if ($checkpermission->type_id == 1) {
                        $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 2) {
                        $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 3) {
                        $filepath = public_path('PCI_DSS_4_Merchant_TSP.xlsx');
                    }

                    if ($checkpermission->type_id == 16) {
                        $filepath = public_path('COBIT_2019.xlsx');
                    }

                    $docIds = collect($req->input('document_ids', []))
                        ->filter(fn($v) => $v !== null && $v !== '' && $v !== '0')
                        ->map(fn($v) => (int) $v)
                        ->filter(fn($v) => $v > 0)
                        ->all();

                    // (Optional) verify IDs exist
                    $validDocIds = DB::table('document_repository')
                        ->whereIn('id', $docIds)
                        ->pluck('id')
                        ->all();



                    // 2) Build the target rows to upsert (you already do this; shown compactly)
                    if ($evidenceLevel == 'component') {

                        $targets = [];

                        if ((int) $req->action === 1) {
                            $targets[] = [
                                'project_id' => $proj_id,
                                'asset_id'   => $asset_id,
                                'title_num'  => $title,
                                'sub_req'    => $sub_req,
                                'subdomain'  => $req->subdomain,
                            ];
                        }

                        if ((int) $req->action === 2) {
                            // all controls in this subdomain
                            $data2 = \Maatwebsite\Excel\Facades\Excel::toArray([], $filepath);
                            $rows  = array_slice($data2[0], 1); // drop header
                            foreach ($rows as $r) {
                                if ((string) $r[2] === (string) $req->subdomain) {
                                    $targets[] = [
                                        'project_id' => $proj_id,
                                        'asset_id'   => $asset_id,
                                        'title_num'  => $r[0],
                                        'sub_req'    => $r[4],
                                        'subdomain'  => $r[2],
                                    ];
                                }
                            }
                        }

                        if ((int) $req->action === 3) {
                            // all controls in this title
                            $data2 = \Maatwebsite\Excel\Facades\Excel::toArray([], $filepath);
                            $rows  = array_slice($data2[0], 1); // drop header
                            foreach ($rows as $r) {
                                if ((string) $r[0] === (string) $title) {
                                    $targets[] = [
                                        'project_id' => $proj_id,
                                        'asset_id'   => $asset_id,
                                        'title_num'  => $r[0],
                                        'sub_req'    => $r[4],
                                        'subdomain'  => $r[2],
                                    ];
                                }
                            }
                        }


                        // (optional) de-duplicate targets
                        if (!empty($targets)) {
                            $targets = array_values(array_unique(array_map('json_encode', $targets)));
                            $targets = array_map('json_decode', $targets, array_fill(0, count($targets), true));
                        }



                        $affectedIds = [];

                        foreach ($targets as $attrs) {
                            $existing = DB::table('iso_sec_2_2')->where($attrs)->first();

                            if ($existing) {
                                DB::table('iso_sec_2_2')
                                    ->where('assessment_id', $existing->assessment_id)
                                    ->update($data);
                                $affectedIds[] = (int) $existing->assessment_id;
                            } else {
                                $newId = (int) DB::table('iso_sec_2_2')->insertGetId(array_merge($attrs, $data));
                                $affectedIds[] = $newId;
                            }
                        }

                        $affectedIds = array_values(array_unique($affectedIds));

                        // 4) Only touch attachments if the field was present in the request
                        //    (so you can distinguish "no changes" vs "clear all")
                        if ($req->has('document_ids')) {

                            // Clear ALL previous links for all affected rows
                            if (!empty($affectedIds)) {
                                DB::table('iso_sec_2_2_attachments')
                                    ->whereIn('iso_sec_2_2_id', $affectedIds)
                                    ->delete();
                            }



                            // Insert new links (skip if none selected)
                            if (!empty($validDocIds) && !empty($affectedIds)) {
                                $now = \Carbon\Carbon::now();
                                $rows = [];

                                foreach ($affectedIds as $id) {
                                    foreach ($validDocIds as $docId) {
                                        $rows[] = [
                                            'iso_sec_2_2_id' => $id,
                                            'document_id'    => $docId,
                                            'last_edited_by' => $user_id,
                                            'last_edited_at' => $now,
                                            // if your pivot has created_at/updated_at, add them:
                                            // 'created_at' => $now,
                                            // 'updated_at' => $now,
                                        ];
                                    }
                                }



                                DB::table('iso_sec_2_2_attachments')->insert($rows);
                            }
                        }


                        $mysessionreq = $req->session()->get('main_req_num');
                        return redirect()->route(
                            'ksa_nca_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                    }





                    // if ($evidenceLevel == 'component') {

                    //     if ($req->action == 2) {

                    //         $data2 = Excel::toArray([], $filepath); //with header
                    //         $rows = array_slice($data2[0], 1); //without header(first row)

                    //         //all controls in this domain
                    //         $filteredData = collect($rows)->filter(function ($row) use ($req) {
                    //             return strval($row[2]) === $req->subdomain;
                    //         })->values()->all();


                    //         foreach ($filteredData as $innerArray) {
                    //             // Access specific value from the inner array
                    //             $fetch_title = $innerArray['0'];
                    //             $subdomain = $innerArray['2'];
                    //             $fetch_sub_req = $innerArray['4'];

                    //             DB::table('iso_sec_2_2')->updateOrInsert(
                    //                 [
                    //                     'project_id' => $proj_id,
                    //                     'asset_id' => $asset_id,
                    //                     'title_num' => $fetch_title,
                    //                     'sub_req' => $fetch_sub_req,
                    //                     'subdomain' => $subdomain
                    //                 ],
                    //                 $data
                    //             );
                    //         }
                    //     }

                    //     if ($req->action == 3) {


                    //         $data2 = Excel::toArray([], $filepath); //with header
                    //         $rows = array_slice($data2[0], 1); //without header(first row)

                    //         $filteredData = collect($rows)->filter(function ($row) use ($title) {
                    //             return strval($row[0]) === $title;
                    //         })->values()->all();


                    //         //all controls in this domain

                    //         foreach ($filteredData as $innerArray2) {
                    //             // Access specific value from the inner array
                    //             $fetch_sub_req = $innerArray2['4'];
                    //             $fetch_title = $innerArray2['0'];
                    //             $subdomain = $innerArray2['2'];

                    //             DB::table('iso_sec_2_2')->updateOrInsert(
                    //                 [
                    //                     'project_id' => $proj_id,
                    //                     'asset_id' => $asset_id,
                    //                     'title_num' => $fetch_title,
                    //                     'sub_req' => $fetch_sub_req,
                    //                     'subdomain' => $subdomain
                    //                 ],
                    //                 $data
                    //             );
                    //         }
                    //     }

                    //     if ($req->action == 1) {

                    //         DB::table('iso_sec_2_2')->updateOrInsert(
                    //             [
                    //                 'project_id' => $proj_id,
                    //                 'asset_id' => $asset_id,
                    //                 'title_num' => $title,
                    //                 'sub_req' => $sub_req,
                    //                 'subdomain' => $req->subdomain
                    //             ],
                    //             $data
                    //         );
                    //     }



                    //     // Redirect after updating the specific asset
                    //     $mysessionreq = $req->session()->get('main_req_num');
                    //     return redirect()->route(
                    //         'ksa_nca_sec_2_2_req',
                    //         ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                    //     )
                    //         ->with('success', 'Record Updated Successfully');
                    // }




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



                    // foreach ($assets as $ass) {
                    //     if ($req->action == 2) {

                    //         $data2 = Excel::toArray([], $filepath); //with header
                    //         $rows = array_slice($data2[0], 1); //without header(first row)

                    //         //all controls in this domain
                    //         $filteredData = collect($rows)->filter(function ($row) use ($req) {
                    //             return strval($row[2]) === $req->subdomain;
                    //         })->values()->all();


                    //         foreach ($filteredData as $innerArray) {
                    //             // Access specific value from the inner array
                    //             $fetch_sub_req = $innerArray['4'];
                    //             $fetch_title = $innerArray['0'];
                    //             $subdomain = $innerArray['2'];


                    //             DB::table('iso_sec_2_2')->updateOrInsert(
                    //                 [
                    //                     'project_id' => $proj_id,
                    //                     'asset_id' => $ass->assessment_id,
                    //                     'title_num' => $fetch_title,
                    //                     'sub_req' => $fetch_sub_req,
                    //                     'subdomain' => $subdomain
                    //                 ],
                    //                 $data
                    //             );
                    //         }
                    //     }

                    //     if ($req->action == 3) {
                    //         //all controls in all  domains

                    //         $data2 = Excel::toArray([], $filepath); //with header
                    //         $rows = array_slice($data2[0], 1); //without header(first row)

                    //         $filteredData = collect($rows)->filter(function ($row) use ($title) {
                    //             return strval($row[0]) === $title;
                    //         })->values()->all();


                    //         foreach ($filteredData as $innerArray) {

                    //             // Access specific value from the inner array
                    //             $fetch_title = $innerArray['0'];
                    //             $fetch_sub_req = $innerArray['4'];
                    //             $subdomain = $innerArray['2'];

                    //             DB::table('iso_sec_2_2')->updateOrInsert(
                    //                 [
                    //                     'project_id' => $proj_id,
                    //                     'asset_id' => $ass->assessment_id,
                    //                     'sub_req' => $fetch_sub_req,
                    //                     'title_num' => $fetch_title,
                    //                     'subdomain' => $subdomain

                    //                 ],
                    //                 $data
                    //             );
                    //         }
                    //     }

                    //     if ($req->action == 1) {

                    //         DB::table('iso_sec_2_2')->updateOrInsert(
                    //             [
                    //                 'project_id' => $proj_id,
                    //                 'asset_id' => $ass->assessment_id,
                    //                 'title_num' => $title,
                    //                 'sub_req' => $sub_req,
                    //                 'subdomain' => $req->subdomain

                    //             ],
                    //             $data
                    //         );
                    //     }
                    // }

                    $excel = \Maatwebsite\Excel\Facades\Excel::toArray([], $filepath);
                    $rows  = array_slice($excel[0], 1); // drop header

                    // ----- Build all targets across all selected assets -----
                    $targets = [];

                    if ((int) $req->action === 1) {
                        // one control per asset
                        foreach ($assets as $ass) {
                            $targets[] = [
                                'project_id' => $proj_id,
                                'asset_id'   => $ass->assessment_id,
                                'title_num'  => $title,
                                'sub_req'    => $sub_req,
                                'subdomain'  => $req->subdomain,
                            ];
                        }
                    }

                    if ((int) $req->action === 2) {
                        // all controls in this subdomain, for every asset
                        $filtered = array_values(array_filter($rows, fn($r) => (string) $r[2] === (string) $req->subdomain));
                        foreach ($assets as $ass) {
                            foreach ($filtered as $r) {
                                $targets[] = [
                                    'project_id' => $proj_id,
                                    'asset_id'   => $ass->assessment_id,
                                    'title_num'  => $r[0],
                                    'sub_req'    => $r[4],
                                    'subdomain'  => $r[2],
                                ];
                            }
                        }
                    }

                    if ((int) $req->action === 3) {
                        // all controls in this title, for every asset
                        $filtered = array_values(array_filter($rows, fn($r) => (string) $r[0] === (string) $title));
                        foreach ($assets as $ass) {
                            foreach ($filtered as $r) {
                                $targets[] = [
                                    'project_id' => $proj_id,
                                    'asset_id'   => $ass->assessment_id,
                                    'title_num'  => $r[0],
                                    'sub_req'    => $r[4],
                                    'subdomain'  => $r[2],
                                ];
                            }
                        }
                    }

                    // ----- De-duplicate targets (avoid double upserts) -----
                    if (!empty($targets)) {
                        $targets = array_values(array_unique(array_map('json_encode', $targets)));
                        $targets = array_map('json_decode', $targets, array_fill(0, count($targets), true));
                    }

                    // ----- Upsert all targets, collect ALL assessment_ids -----
                    $affectedIds = [];

                    foreach ($targets as $attrs) {
                        $existing = DB::table('iso_sec_2_2')->where($attrs)->first();

                        if ($existing) {
                            DB::table('iso_sec_2_2')
                                ->where('assessment_id', $existing->assessment_id)
                                ->update($data);

                            $affectedIds[] = (int) $existing->assessment_id;
                        } else {
                            $newId = (int) DB::table('iso_sec_2_2')->insertGetId(array_merge($attrs, $data));
                            $affectedIds[] = $newId;
                        }
                    }

                    $affectedIds = array_values(array_unique($affectedIds));

                    // ----- Sync attachments for ALL affected rows (only if field present) -----
                    if ($req->has('document_ids')) {
                        if (!empty($affectedIds)) {
                            DB::table('iso_sec_2_2_attachments')
                                ->whereIn('iso_sec_2_2_id', $affectedIds)
                                ->delete();
                        }

                        if (!empty($validDocIds) && !empty($affectedIds)) {
                            $now  = \Carbon\Carbon::now();
                            $rows = [];

                            foreach ($affectedIds as $id) {
                                foreach ($validDocIds as $docId) {
                                    $rows[] = [
                                        'iso_sec_2_2_id' => $id,
                                        'document_id'    => $docId,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => $now,
                                        // add these if your pivot has timestamps:
                                        // 'created_at' => $now,
                                        // 'updated_at' => $now,
                                    ];
                                }
                            }

                            DB::table('iso_sec_2_2_attachments')->insert($rows);
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
        $justifications = $req->input('justifications');

        $filepath = "";
        if ($checkpermission->id == 4) {
            $filepath = public_path('KM_ISO27K1_2022_Compliance_18Jul25_updated.xlsx');
        }

        if ($checkpermission->id == 23) {
            $filepath = public_path('NIST_CSF_Modified.xlsx');
        }

        if ($checkpermission->id == 24) {
            $filepath = public_path('ISO27701_2019v2_Modified.xlsx');
        }

        if ($checkpermission->id == 1) {
            $filepath = public_path('PCI_DSS_4_Single_TSP_Modified.xlsx');
        }

        if ($checkpermission->id == 2) {
            $filepath = public_path('PCI_DSS_4_Multi_TSP_Modified.xlsx');
        }

        if ($checkpermission->id == 3) {
            $filepath = public_path('PCI_DSS_4_Merchant_TSP_Modified.xlsx');
        }

        if ($checkpermission->id == 19) {
            $filepath = public_path('SOC2_Type2_Modified.xlsx');
        }

        if ($checkpermission->id == 16) {
            $filepath = public_path('COBIT_2019_Modified.xlsx');
        }



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
            $justification = $justifications[$index];

            // Skip if all fields are null/empty
            if (is_null($compStatus) && is_null($applicability) && empty($justification)) {
                continue;
            }

            $data = [
                'last_edited_by' => $user_id,
                'last_edited_at' => now()->format('Y-m-d H:i:s'),
            ];

            if (!is_null($compStatus)) {
                $data['comp_status'] = $compStatus;
            }

            if (!is_null($applicability)) {
                $data['applicability'] = $applicability;
            }

            if (!empty($justification)) {
                $data['justification'] = $justification;
            }

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) === (string)$title;
            })->values();

            if ($evidenceLevel === 'component') {
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




    public function add_mandatory_all_domain_all_controls(Request $req, $proj_id, $user_id, $asset_id)
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
            return redirect()->route('iso_sections', ['proj_id' => $proj_id, 'user_id' => $user_id])
                ->with('error', 'Not Allowed');
        }

        $evidenceLevel = $req->session()->get('evidenceLevel');

        $fileMap = [
            7 => 'KSA_NCA_ECC_Modified.xlsx',
            18 => 'COSO_Modified.xlsx',
            19 => 'SOC2_Type2_Modified.xlsx',
            5 => 'CY_SAMA_Modified.xlsx',
            1 => 'PCI_DSS_4_Single_TSP_Modified.xlsx',
            2 => 'PCI_DSS_4_Multi_TSP_Modified.xlsx',
            3 => 'PCI_DSS_4_Merchant_TSP_Modified.xlsx',
            16 => 'COBIT_2019_Modified.xlsx',
            10 => 'ISA_62443_Part 3-2_Modified.xlsx',
            12 => 'ISA 62443 Part 4-2 -Modified.xlsx',
            13 => 'ISA 62443 Part 3-3 - Modified.xlsx',
            11 => 'ISA 62443 Part 2-1 - Modified.xlsx',
            9 => 'ISA 62443 Part 4-1 - Modified.xlsx',
            4 => 'KM_ISO27K1_2022_Compliance_18Jul25_updated.xlsx',
            23 => 'NIST_CSF_Modified.xlsx',
            24 => 'ISO27701_2019v2_Modified.xlsx'
        ];


        $filepath = public_path($fileMap[$checkpermission->project_type]);

        $data2 = Excel::toArray([], $filepath);
        $rows = array_slice($data2[0], 1);

        $domains = $req->input('domains');
        $statuses = $req->input('comp_statuses');
        $applicabilities = $req->input('applicabilities');
        $justifications = $req->input('justifications');

        if ($evidenceLevel === 'component') {
            foreach ($domains as $index => $domain) {

                $compStatus = $statuses[$index];
                $applicability = $applicabilities[$index];
                $justification = $justifications[$index];

                // Skip if no update needed
                if (is_null($compStatus) && is_null($applicability) && empty($justification)) {
                    continue;
                }

                $data = [
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s'),
                ];

                if (!is_null($compStatus)) {
                    $data['comp_status'] = $compStatus;
                }

                if (!is_null($applicability)) {
                    $data['applicability'] = $applicability;
                }

                if (!empty($justification)) {
                    $data['justification'] = $justification;
                }

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

        // For other levels (name, group, service, project)
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
                $applicability = $applicabilities[$index];
                $justification = $justifications[$index];

                if (is_null($compStatus) && is_null($applicability) && empty($justification)) {
                    continue;
                }

                $data = [
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s'),
                ];

                if (!is_null($compStatus)) {
                    $data['comp_status'] = $compStatus;
                }

                if (!is_null($applicability)) {
                    $data['applicability'] = $applicability;
                }

                if (!empty($justification)) {
                    $data['justification'] = $justification;
                }

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

        $fileMap = [
            7 => 'KSA_NCA_ECC_Modified.xlsx',
            18 => 'COSO_Modified.xlsx',
            19 => 'SOC2_Type2_Modified.xlsx',
            5 => 'CY_SAMA_Modified.xlsx',
            1 => 'PCI_DSS_4_Single_TSP_Modified.xlsx',
            16 => 'COBIT_2019_Modified.xlsx',
            2 => 'PCI_DSS_4_Multi_TSP_Modified.xlsx',
            3 => 'PCI_DSS_4_Merchant_TSP_Modified.xlsx',
            10 => 'ISA_62443_Part 3-2_Modified.xlsx',
            12 => 'ISA 62443 Part 4-2 -Modified.xlsx',
            13 => 'ISA 62443 Part 3-3 - Modified.xlsx',
            11 => 'ISA 62443 Part 2-1 - Modified.xlsx',
            9 => 'ISA 62443 Part 4-1 - Modified.xlsx',
            4 => 'KM_ISO27K1_2022_Compliance_18Jul25_updated.xlsx',
            23 => 'NIST_CSF_Modified.xlsx',
            24 => 'ISO27701_2019v2_Modified.xlsx'
        ];

        $filepath = public_path($fileMap[$checkpermission->type_id]);

        $data2 = Excel::toArray([], $filepath);
        $rows = array_slice($data2[0], 1); // Skip header

        $sub_reqs = $req->input('sub_reqs');
        $statuses = $req->input('comp_statuses');
        $applicabilities = $req->input('applicabilities');
        $justifications = $req->input('justifications');

        if ($evidenceLevel === 'component') {
            foreach ($sub_reqs as $index => $sub_req) {

                $compStatus = $statuses[$index];
                $applicability = $applicabilities[$index];
                $justification = $justifications[$index];

                // Skip if all fields are empty
                if (is_null($compStatus) && is_null($applicability) && empty($justification)) {
                    continue;
                }

                $data = [
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s')
                ];

                if (!is_null($compStatus)) {
                    $data['comp_status'] = $compStatus;
                }

                if (!is_null($applicability)) {
                    $data['applicability'] = $applicability;
                }

                if (!empty($justification)) {
                    $data['justification'] = $justification;
                }

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
                $applicability = $applicabilities[$index];
                $justification = $justifications[$index];

                // Skip if all fields are empty
                if (is_null($compStatus) && is_null($applicability) && empty($justification)) {
                    continue;
                }

                $data = [
                    'last_edited_by' => $user_id,
                    'last_edited_at' => now()->format('Y-m-d H:i:s')
                ];

                if (!is_null($compStatus)) {
                    $data['comp_status'] = $compStatus;
                }

                if (!is_null($applicability)) {
                    $data['applicability'] = $applicability;
                }

                if (!empty($justification)) {
                    $data['justification'] = $justification;
                }

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

    public function view_soa_project($proj_id, $user_id)
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


           $fileMap = [
            7 => 'KSA_NCA_ECC.xlsx',
            18 => 'COSO.xlsx',
            19 => 'SOC2_Type2.xlsx',
            5 => 'CY_SAMA.xlsx',
            1 => 'PCI_DSS_4_Single_TSP.xlsx',
            16 => 'COBIT_2019.xlsx',
            2 => 'PCI_DSS_4_Multi_TSP.xlsx',
            3 => 'PCI_DSS_4_Merchant_TSP.xlsx',
            10 => 'ISA_62443_Part 3-2.xlsx',
            12 => 'ISA 62443 Part 4-2.xlsx',
            13 => 'ISA 62443 Part 3-3.xlsx',
            11 => 'ISA 62443 Part 2-1.xlsx',
            9 => 'ISA 62443 Part 4-1.xlsx',
            4 => 'KM_ISO27K1_2022_Compliance_18Jul25.xlsx',
            23 => 'NIST_CSF.xlsx',
            24 => 'ISO27701_2019v2.xlsx'
        ];

        $filepath = public_path($fileMap[$checkpermission->type_id]);

        $data2 = Excel::toArray([], $filepath);
        $rows = array_slice($data2[0], 1); // Skip header

        $titles = collect($rows)->mapWithKeys(function ($row) {
            return [$row[0] => $row[1]];
        })->unique();


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $assets = DB::table('iso_sec_2_1')
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
            ->where('iso_sec_2_1.project_id', $proj_id)
            ->get();


        return view('SOA.choose_controls', [
            'titles' => $titles,
            'proj_id' => $proj_id,
            'user_id' => $user_id,
            'project' => $project,
            'assets' => $assets

        ]);









        return redirect()->back()->with('success', 'All sub-requirements updated successfully.');
    }

    public function show_soa($proj_id, $user_id, Request $req)
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


      
           $fileMap = [
            7 => 'KSA_NCA_ECC.xlsx',
            18 => 'COSO.xlsx',
            19 => 'SOC2_Type2.xlsx',
            5 => 'CY_SAMA.xlsx',
            1 => 'PCI_DSS_4_Single_TSP.xlsx',
            16 => 'COBIT_2019.xlsx',
            2 => 'PCI_DSS_4_Multi_TSP.xlsx',
            3 => 'PCI_DSS_4_Merchant_TSP.xlsx',
            10 => 'ISA_62443_Part 3-2.xlsx',
            12 => 'ISA 62443 Part 4-2.xlsx',
            13 => 'ISA 62443 Part 3-3.xlsx',
            11 => 'ISA 62443 Part 2-1.xlsx',
            9 => 'ISA 62443 Part 4-1.xlsx',
            4 => 'KM_ISO27K1_2022_Compliance_18Jul25.xlsx',
            23 => 'NIST_CSF.xlsx',
            24 => 'ISO27701_2019v2.xlsx'
        ];


        $filepath = public_path($fileMap[$checkpermission->type_id]);

        $data2 = Excel::toArray([], $filepath);
        $rows = array_slice($data2[0], 1); // Skip header

        $data = Db::table('iso_sec_2_2')->whereIn('title_num', $req->selected_titles)
            ->where('asset_id', $req->selected_asset)
            ->orderBy('title_num', 'asc')
            ->get();

        $finalData = [];

        foreach ($data as $record) {
            $matchingRow = collect($rows)->first(function ($row) use ($record) {
                return strval($row[0]) === $record->title_num && // Title number
                    strval($row[2]) === $record->subdomain && // Subdomain number
                    strval($row[4]) === $record->sub_req;     // Sub req number
            });

            $finalData[] = [
                'title_num' => $record->title_num,
                'title' => $matchingRow[1] ?? 'N/A',
                'subdomain' => $record->subdomain,
                'subdomain_heading' => $matchingRow['3'],
                'sub_req' => $record->sub_req,
                'requirement' => $matchingRow[5] ?? 'N/A',
                'comp_status' => $record->comp_status,
                'applicability' => $record->applicability,
                'justification' => $record->justification ?? '-'
            ];
        }


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        return view('SOA.show_soa', [

            'proj_id' => $proj_id,
            'user_id' => $user_id,
            'project' => $project,
            'finalData' => $finalData

        ]);
    }
}
