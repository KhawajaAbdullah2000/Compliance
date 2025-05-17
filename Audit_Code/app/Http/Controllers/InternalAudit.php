<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use Spatie\LaravelPdf\Facades\Pdf;

use App\Models\Organization;

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
                if ($level_num == 1) {
                    //INTERNAL AUDIT STRATEGY
                    $organization = Organization::with('departments')->findOrFail(auth()->user()->organization->id);
                    $departments = $organization->departments;

                    $existingStrategies = DB::table('internal_audit_strategy')
                    ->where('project_id', $proj_id)
                    ->get()
                    ->keyBy('department_id'); // Key by department_id for easy lookup

              





                    return view('internal_audit.internal_audit_strategy_main', [
                        'project' => $project,
                        'project_permissions' => $checkpermission->project_permissions,
                        'departments' => $departments,
                        'level_num'=>$level_num,
                        'existingStrategies' => $existingStrategies

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
                        'organization_id'=>$req->organization_id,
                        'department_id'=>$req->department_id,
                        'project_id'=>$proj_id
                    ],[
                        'audit_approach'=>$req->audit_approach,
                        'sampling_methodology'=>$req->sampling_methodology,
                        'risk_affecting'=>$req->risk_affecting,
                        'risk_mitigation'=>$req->risk_mitigation,
                        'audit_started'  => $req->audit_started,
                        'audit_ended' => $req->audit_ended,
                        'inclusions_in_scope' => $req->inclusions_in_scope,
                        'exclusions_in_scope' => $req->exclusions_in_scope,
                        'persons_interviewed'=> $req->persons_interviewed,
                        'documents_reviewed'  => $req->documents_reviewed,
                        'processes_observed' => $req->processes_observed,
                        'artefacts_examined'  => $req->artefacts_examined,
        'requirements_status_compliance'   => $req->requirements_status_compliance,
                        'last_edited_by'=>$user_id,
                        'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                      
                    ]);

                    return redirect()->route('internal_audit_level_1',[
                        'level_num'=>$req->level_num,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ])->with('success','Saved Changes Successfully');
                 

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
