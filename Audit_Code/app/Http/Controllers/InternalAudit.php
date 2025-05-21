<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Organization;
use App\Models\Department;
use App\Models\User;


class InternalAudit extends Controller
{
    public function internal_audit_level_1($level_num, $proj_id, $user_id)
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

                $organization = Organization::with('departments')->findOrFail(auth()->user()->organization->id);
                $departments = $organization->departments;
                if ($level_num == 1) {
                    //INTERNAL AUDIT STRATEGY
                    $existingStrategies = DB::table('internal_audit_strategy')
                        ->where('project_id', $proj_id)
                        ->get()
                        ->keyBy('department_id'); // Key by department_id for easy lookup


                    $strategy_time_period = DB::table('strategy_time_period')->where('project_id', $proj_id)
                        ->first();

                    $time_period_selected = $strategy_time_period ? $strategy_time_period->time_period : null;



                    return view('internal_audit.internal_audit_strategy_main', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'departments' => $departments,
                        'level_num' => $level_num,
                        'existingStrategies' => $existingStrategies,
                        'time_period_selected' => $time_period_selected

                    ]);
                }

                if ($level_num == 2) {
                    //RIsk Based Audit Plan

                    $existingStrategies = DB::table('risk_based_plan_audit')
                        ->where('project_id', $proj_id)
                        ->get()
                        ->keyBy('department_id'); // Key by department_id for easy lookup


                    return view('internal_audit.risk_based_audit_main', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'departments' => $departments,
                        'level_num' => $level_num,
                        'existingStrategies' => $existingStrategies,

                    ]);
                }



            }

        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function audit_strategy_department($proj_id, $user_id, Request $req)
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


                if (in_array('Data Inputter', $permissions)) {

                    //   dd($req->all());

                    DB::table('internal_audit_strategy')->updateOrInsert([
                        'organization_id' => $req->organization_id,
                        'department_id' => $req->department_id,
                        'project_id' => $proj_id
                    ], [
                        'audit_approach' => $req->audit_approach,
                        'sampling_methodology' => $req->sampling_methodology,
                        'risk_affecting' => $req->risk_affecting,
                        'risk_mitigation' => $req->risk_mitigation,
                        'audit_started' => $req->audit_started,
                        'audit_ended' => $req->audit_ended,
                        'inclusions_in_scope' => $req->inclusions_in_scope,
                        'exclusions_in_scope' => $req->exclusions_in_scope,
                        'persons_interviewed' => $req->persons_interviewed,
                        'documents_reviewed' => $req->documents_reviewed,
                        'processes_observed' => $req->processes_observed,
                        'artefacts_examined' => $req->artefacts_examined,
                        'requirements_status_compliance' => $req->requirements_status_compliance,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                    ]);

                    return redirect()->route('internal_audit_level_1', [
                        'level_num' => $req->level_num,
                        'proj_id' => $proj_id,
                        'user_id' => $user_id
                    ])->with('success', 'Saved Changes Successfully');


                }




            }

        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function select_internal_audit_fields_for_report($internal_audit_strategy_id, $proj_id, $user_id)
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
                $strategy = DB::table('internal_audit_strategy')->find($internal_audit_strategy_id);

                if (!$strategy) {
                    return redirect()->back()->with('error', 'Strategy not found.');
                } else {

                    $organization = DB::table('organizations')->find($strategy->organization_id);
                    $department = DB::table('departments')->find($strategy->department_id);


                    return view('internal_audit.select_fields_internal_audit', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'organization' => $organization,
                        'department' => $department,
                        'strategy' => $strategy


                    ]);
                }





            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }

    public function select_risk_based_plan_audit_for_report($role_based_plan_id, $proj_id, $user_id)
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
                $strategy = DB::table('risk_based_plan_audit')->find($role_based_plan_id);

                if (!$strategy) {
                    return redirect()->back()->with('error', 'Strategy not found.');
                } else {

                    $organization = DB::table('organizations')->find($strategy->organization_id);
                    $department = DB::table('departments')->find($strategy->department_id);


                    return view('internal_audit.select_fields_risk_based_plan_audit', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'organization' => $organization,
                        'department' => $department,
                        'strategy' => $strategy


                    ]);
                }





            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }


    public function select_fields_generate_report($internal_audit_strategy_id, $proj_id, $user_id, Request $req)
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

                $selectedFields = $req->fields ?? [];
                if (empty($selectedFields)) {
                    return back()->with('error', 'Please select at least one field.');
                }

                if ($req->level_num == 2) {
                    $strategy = DB::table('risk_based_plan_audit')->find($internal_audit_strategy_id);
                } else {
                    $strategy = DB::table('internal_audit_strategy')->find($internal_audit_strategy_id);
                }


                $organization = Organization::find($strategy->organization_id);
                $department = Department::find($strategy->department_id);

                $reportData = [];
                foreach ($selectedFields as $field) {
                    $reportData[] = [
                        'label' => ucwords(str_replace('_', ' ', $field)),
                        'value' => $strategy->$field ?? 'N/A'
                    ];
                }


                $pdf = Pdf::view('internal_audit.report_pdf', [
                    'organization' => $organization,
                    'department' => $department,
                    'project' => $checkpermission,
                    'reportData' => $reportData,
                    'level_num' => $req->level_num
                ]);

                if ($req->level_num == 2) {
                    return $pdf->download('RIsk_Based_Audit_Plan_Report_' . $organization->name . '_' . $department->name . '.pdf');
                } else {
                    return $pdf->download('Internal_Audit_Report_' . $organization->name . '_' . $department->name . '.pdf');


                }


            }





        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function submit_strategy_time_period($proj_id, $user_id, Request $req)
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


                if (in_array('Data Inputter', $permissions)) {

                    DB::table('strategy_time_period')->updateOrInsert(
                        [
                            'project_id' => $proj_id,
                        ],
                        [
                            'time_period' => $req->time_period,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]
                    );

                    return redirect()->route('internal_audit_level_1', [
                        'level_num' => 1,
                        'proj_id' => $proj_id,
                        'user_id' => $user_id
                    ])->with('success', 'Strategic Time period saved successfully');


                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }



    public function submit_risk_based_plan_audit($proj_id, $user_id, Request $req)
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


                if (in_array('Data Inputter', $permissions)) {

                    DB::table('risk_based_plan_audit')->updateOrInsert([
                        'organization_id' => $req->organization_id,
                        'department_id' => $req->department_id,
                        'project_id' => $proj_id
                    ], [
                        'audit_approach' => $req->audit_approach,
                        'sampling_methodology' => $req->sampling_methodology,
                        'risk_affecting' => $req->risk_affecting,
                        'risk_mitigation' => $req->risk_mitigation,
                        'audit_started' => $req->audit_started,
                        'audit_ended' => $req->audit_ended,
                        'inclusions_in_scope' => $req->inclusions_in_scope,
                        'exclusions_in_scope' => $req->exclusions_in_scope,
                        'persons_interviewed' => $req->persons_interviewed,
                        'documents_reviewed' => $req->documents_reviewed,
                        'processes_observed' => $req->processes_observed,
                        'artefacts_examined' => $req->artefacts_examined,
                        'requirements_status_compliance' => $req->requirements_status_compliance,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                    ]);

                    return redirect()->route('internal_audit_level_1', [
                        'level_num' => $req->level_num, //2
                        'proj_id' => $proj_id,
                        'user_id' => $user_id
                    ])->with('success', 'Saved Changes Successfully');


                }




            }

        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function audit_universe($risk_based_plan_id, $proj_id, $user_id)
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


                $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($risk_based_plan_id);


                $organization = DB::table('organizations')->find($risk_based_plan_details->organization_id);
                $department = DB::table('departments')->find($risk_based_plan_details->department_id);

                $auditUniverseList = DB::table('audit_universe')
                    ->leftJoin('users as auditors', 'audit_universe.auditor', '=', 'auditors.id')
                    ->leftJoin('users as approvers', 'audit_universe.approver', '=', 'approvers.id')
                    ->select(
                        'audit_universe.*',
                        DB::raw("CONCAT(auditors.first_name, ' ', auditors.last_name) as auditor_name"),
                        DB::raw("CONCAT(approvers.first_name, ' ', approvers.last_name) as approver_name")
                    )
                    ->where('project_id', $proj_id)
                    ->where('dept_id',$risk_based_plan_details->department_id)
                    ->get();


                return view('internal_audit.audit_universe_main', [
                    'project' => $project,
                    'project_permissions' => $checkpermission->project_permissions,
                    'organization' => $organization,
                    'department' => $department,
                    'risk_based_plan_details' => $risk_based_plan_details,
                    'auditUniverseList' => $auditUniverseList


                ]);


            }





        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function add_new_audit_universe_form($risk_based_plan_id, $proj_id, $user_id)
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

                if (in_array('Data Inputter', $permissions)) {

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();


                    $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($risk_based_plan_id);


                    $organization = DB::table('organizations')->find($risk_based_plan_details->organization_id);
                    $department = DB::table('departments')->find($risk_based_plan_details->department_id);

                    $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();


                    $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                        ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();

                    $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                    $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);


                    return view('internal_audit.audit_universe_form', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'organization' => $organization,
                        'department' => $department,
                        'risk_based_plan_details' => $risk_based_plan_details,
                        'users' => $users

                    ]);

                }


            }





        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function save_audit_universe($risk_based_plan_id, $proj_id, $user_id, Request $request)
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

                if (in_array('Data Inputter', $permissions)) {
                    DB::table('audit_universe')->insert([
                        'risk_based_plan_audit_id' => $risk_based_plan_id,
                        'project_id' => $proj_id,
                        'dept_id'=>$request->dept_id,
                        'name' => $request->name,
                        'planned_start' => $request->planned_start,
                        'planned_end' => $request->planned_end,
                        'actual_start' => $request->actual_start,
                        'actual_end' => $request->actual_end,
                        'auditor' => $request->auditor,
                        'approver' => $request->approver,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                    return redirect()->route('audit_universe', [
                        'risk_based_plan_id' => $risk_based_plan_id,
                        'proj_id' => $proj_id,
                        'user_id' => $user_id
                    ])->with('success', 'Auditable unit Added successfully');
                }




            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function edit_audit_universe($unit_id, $proj_id, $user_id, Request $request)
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

                if (in_array('Data Inputter', $permissions)) {

                    $unit = DB::table('audit_universe')->where('id', $unit_id)->first();

                    $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($unit->risk_based_plan_audit_id);
                    $department = DB::table('departments')->find($risk_based_plan_details->department_id);

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();


                    $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();


                    $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                        ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();

                    $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                    $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);


                    return view('internal_audit.edit_audit_universe_form', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'department' => $department,
                        'risk_based_plan_details' => $risk_based_plan_details,
                        'users' => $users,
                        'unit' => $unit

                    ]);


                }




            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function submit_audit_universe_edit($unit_id, $proj_id, $user_id, Request $request)
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

                if (in_array('Data Inputter', $permissions)) {

                    DB::table('audit_universe')->where('id', $unit_id)->update([
                        'name' => $request->name,
                        'planned_start' => $request->planned_start,
                        'planned_end' => $request->planned_end,
                        'actual_start' => $request->actual_start,
                        'actual_end' => $request->actual_end,
                        'auditor' => $request->auditor,
                        'approver' => $request->approver,
                        'last_edited_by' => auth()->user()->id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }

                return redirect()->route('audit_universe', [
                    'risk_based_plan_id' => $request->risk_based_plan_audit_id,
                    'proj_id' => $proj_id,
                    'user_id' => $user_id
                ])->with('success', 'Auditable Unit Edited Successfully');




            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }


    public function delete_audit_universe($unit_id,$proj_id,$user_id){
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

                 if (in_array('Data Inputter', $permissions)) {

                
                    $unitDetails=DB::table('audit_universe')->find($unit_id);
                 
                    Db::table('audit_universe')->where('id',$unit_id)->delete();

                  

                return redirect()->route('audit_universe',[
                    'risk_based_plan_id'=>$unitDetails->risk_based_plan_audit_id,
                    'proj_id'=>$proj_id,
                    'user_id'=>$user_id
                ])->with('success','Auditable Unit Deleted Successfully');
        
                
        

                }

            }

               
            }

        
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);



        }


    public function data_records($unit_id, $proj_id, $user_id, Request $request)
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

                    $unit = DB::table('audit_universe')->where('id', $unit_id)->first();

                    $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($unit->risk_based_plan_audit_id);
                    $department = DB::table('departments')->find($risk_based_plan_details->department_id);


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();
                   
                    $data_records=DB::table('data_record_audit_universe')->where('audit_universe_id',$unit_id)->get();
            

                    return view('internal_audit.data_records_main', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'department' => $department,
                        'risk_based_plan_details' => $risk_based_plan_details,
                        'unit' => $unit,
                        'data_records'=>$data_records

                    ]);



            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function add_new_data_record_form($unit_id,$proj_id,$user_id){
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

                    if(in_array('Data Inputter',$permissions)){
                        $unit = DB::table('audit_universe')->where('id', $unit_id)->first();

                    $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($unit->risk_based_plan_audit_id);
                    $department = DB::table('departments')->find($risk_based_plan_details->department_id);


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();
                   

                    return view('internal_audit.add_data_record_form', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'department' => $department,
                        'risk_based_plan_details' => $risk_based_plan_details,
                        'unit' => $unit

                    ]);



                    }

                    

            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

        public function save_data_record($unit_id,$proj_id,$user_id,Request $req){
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

                    if(in_array('Data Inputter',$permissions)){
              
              DB::table('data_record_audit_universe')->insert([
                'data_record_name'=>$req->data_record_name,
                'data_record_approach'=>$req->data_record_approach,
                'data_record_sampling'=>$req->data_record_sampling,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'audit_universe_id'=>$unit_id
              ]);

              return redirect()->route('data_records',[
                'unit_id'=>$unit_id,
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
              ])->with('success','Data Record Saved Successfully');

                    



                    }

                    

            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }



    public function edit_data_record($data_record_id,$proj_id,$user_id){
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

                    if(in_array('Data Inputter',$permissions)){
                       
                     $data_record=DB::table('data_record_audit_universe')->find($data_record_id);
            
                        
                    $unit = DB::table('audit_universe')->where('id', $data_record->audit_universe_id)->first();

                    $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($unit->risk_based_plan_audit_id);
                    $department = DB::table('departments')->find($risk_based_plan_details->department_id);


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();
                   

                    return view('internal_audit.edit_data_record_form', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'department' => $department,
                        'risk_based_plan_details' => $risk_based_plan_details,
                        'unit' => $unit,
                        'data_record'=>$data_record

                    ]);



                    }

                    

            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

     public function update_data_record($data_record_id,$unit_id,$proj_id,$user_id,Request $req){
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

                    if(in_array('Data Inputter',$permissions)){
                       
                     Db::table('data_record_audit_universe')->where('id',$data_record_id)->update([
                            'data_record_name'=>$req->data_record_name,
                            'data_record_approach'=>$req->data_record_approach,
                            'data_record_sampling'=>$req->data_record_sampling,
                            'last_edited_by'=>$user_id,
                            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                            
                     ]);

            

              return redirect()->route('data_records',[
                'unit_id'=>$unit_id,
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
              ])->with('success','Data Record Edited Successfully');



                    }

                    

            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

     public function delete_data_record($data_record_id,$unit_id,$proj_id,$user_id){
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

                    if(in_array('Data Inputter',$permissions)){
                     
                        Db::table('data_record_audit_universe')->where('id',$data_record_id)->delete();


                        return redirect()->route('data_records',[
                'unit_id'=>$unit_id,
                'proj_id'=>$proj_id,
                'user_id'=>$user_id,
              ])->with('success','Record Deleted Successfully');


                    }

                    

            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }


     public function attachments_data_record($data_record_id,$unit_id,$proj_id,$user_id){
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

                $data_record=DB::table('data_record_audit_universe')->find($data_record_id);
                

                 $unit = DB::table('audit_universe')->where('id', $unit_id)->first();

                

                    $risk_based_plan_details = DB::table('risk_based_plan_audit')->find($unit->risk_based_plan_audit_id);
                    $department = DB::table('departments')->find($risk_based_plan_details->department_id);


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();
                   
                        $attachments = DB::table('data_record_attachments')
                    ->where('data_record_id', $data_record_id)
                    ->orderByDesc('last_edited_at')
                    ->get();

                    return view('internal_audit.attachments_data_record', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'department' => $department,
                        'risk_based_plan_details' => $risk_based_plan_details,
                        'unit' => $unit,
                        'data_record'=>$data_record,
                        'attachments'=>$attachments

                    ]);



                    

                    

            }


        }


        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);


    }

    public function upload_data_record_attachments($data_record_id,$proj_id,$user_id,Request $req){
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

                    if(in_array('Data Inputter',$permissions)){
                     $req->validate([
                        'attachment' => 'required|file|max:10240' // Max 10MB
                    ]);

                     $data_record=DB::table('data_record_audit_universe')->find($data_record_id);
                
                    // Store file
                $filename = time() . '_' . $req->file('attachment')->getClientOriginalName();
                $req->file('attachment')->move(public_path('data_record_attachments'), $filename);
                $filePath = 'data_record_attachments/' . $filename;
                    // Insert into DB
                    DB::table('data_record_attachments')->insert([
                        'data_record_id' => $data_record_id,
                        'attachment' => $filePath,
                        'last_edited_by' => auth()->user()->id,
                        'last_edited_at' => Carbon::now()
                    ]);

                   
                    return redirect()->route('attachments_data_record',[
                        'data_record_id'=>$data_record_id,
                        'unit_id'=>$data_record->audit_universe_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ])->with('success','Attachment added successfully');

                    }

                    return redirect()->back()->with('error','Not Allowed');

            }

        }
          return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function delete_record_attachment($file_id){
        $attachment = DB::table('data_record_attachments')->where('id', $file_id)->first();

    if ($attachment) {
        $filePath = public_path($attachment->attachment);

        // Delete file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from DB
        DB::table('data_record_attachments')->where('id', $file_id)->delete();

        return back()->with('success', 'Attachment deleted successfully.');
    }
}



    public function internal_audit_level_2($level1_num, $level2_num, $proj_id, $user_id)
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


                $filepath = public_path('internal_audit_sheet.xlsx');
                $rows = Excel::toArray([], $filepath); //with header
                $data = array_slice($rows[0], 1); //without header(first row)

                $filteredData = collect($data)->filter(function ($row) use ($level1_num, $level2_num) {
                    return (isset($row[0]) && strval($row[0]) == $level1_num) && (isset($row[2]) && strval($row[02]) == $level2_num);
                })->values()->all();



                return view('internal_audit.form', [
                    'project' => $project,
                    'project_permissions' => $checkpermission->project_permissions,
                    'data' => $filteredData
                ]);


            }

        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function generate_pdf()
    {
        $data = [
            'invoiceNumber' => 'INV-2025-001',
            'customerName' => 'John Doe',
            'amount' => '299.99',
        ];

        $pdf = Pdf::view('internal_audit.invoice', $data)
            ->format('a4')
            ->margins(10, 10, 10, 10);

        return $pdf->download('invoice.pdf');
    }
}
