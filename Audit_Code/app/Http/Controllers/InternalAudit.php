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


                        $strategy_time_period=DB::table('strategy_time_period')->where('project_id',$proj_id)
                        ->first();
       
                        $time_period_selected = $strategy_time_period ? $strategy_time_period->time_period : null;



                    return view('internal_audit.internal_audit_strategy_main', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'departments' => $departments,
                        'level_num' => $level_num,
                        'existingStrategies' => $existingStrategies,
                        'time_period_selected'=>$time_period_selected

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

                if($req->level_num==2){
               $strategy = DB::table('risk_based_plan_audit')->find($internal_audit_strategy_id);
                }else{
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
                    'level_num'=>$req->level_num
                ]);

                if($req->level_num==2){
                return $pdf->download('RIsk_Based_Audit_Plan_Report_' . $organization->name . '_' . $department->name . '.pdf');
                }else{
                     return $pdf->download('Internal_Audit_Report_' . $organization->name . '_' . $department->name . '.pdf');


                }

               
            }





        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function submit_strategy_time_period($proj_id,$user_id,Request $req){
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

                    DB::table('strategy_time_period')->updateOrInsert([
                        'project_id'=>$proj_id,
                    ],
                    [
                        'time_period'=>$req->time_period,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    return redirect()->route('internal_audit_level_1',[
                        'level_num'=>1,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ])->with('success','Strategic Time period saved successfully');


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
