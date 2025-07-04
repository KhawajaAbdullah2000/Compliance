<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;
use APP\Models\Organization;
use APP\Models\Department;
use App\Models\SubEntity;

class OneLinkEndUserController extends Controller
{
    public function create_one_link_erm_project($user_id, $org_id)
    {
        $project_types = DB::table('project_types')->where('id', 22)->get();
        return view('project.create_project', ['types' => $project_types]);
    }

    public function one_link_inherent_risk_main($proj_id, $user_id)
    {

        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
        )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
            ->first();



        if ($checkpermission) {
            $permissions = json_decode($checkpermission->project_permissions);

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();


            $riskRecords = DB::table('one_link_risk_record as r')
                ->leftJoin('departments as d', 'r.department_id', '=', 'd.id')
                ->leftJoin('units as u', 'r.unit_id', '=', 'u.id')
                ->leftJoin('one_link_sub_entities as p', 'r.product_id', '=', 'p.id')
                ->leftJoin('one_link_sub_entities as c', 'r.cycle_id', '=', 'c.id')
                ->leftJoin('one_link_sub_entities as sp', 'r.sub_process_id', '=', 'sp.id')
                ->leftJoin('users as usr', 'r.created_by', '=', 'usr.id')
                ->select(
                    'r.*',
                    'r.id as risk_id',
                    'd.name as department_name',
                    'u.name as unit_name',
                    'p.name as product_name',
                    'c.name as cycle_name',
                    'sp.name as sub_process_name',
                    DB::raw("CONCAT(usr.first_name, ' ', usr.last_name) as created_by_name")
                )
                ->where('r.org_id', auth()->user()->organization->id)
                ->where('r.project_id', $project->project_id)
                ->orderBy('r.created_at', 'desc')
                ->get();


            return view('one_link_inherent_risk.risk_records', [
                'project' => $project,
                'project_permissions' => $checkpermission->project_permissions,
                'riskRecords' => $riskRecords
            ]);
        }
    }

    public function edit_risk_record_initial($risk_id, $proj_id, $user_id)
    {
        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
        )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
            ->first();



        if ($checkpermission) {
            $permissions = json_decode($checkpermission->project_permissions);

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            $departments = Db::Table('departments')->where('org_id', auth()->user()->organization->id)->get();

            $products = SubEntity::where('org_id', $project->org_id)
                ->where('sub_entity_type', 'products')
                ->get();

            $cycles = SubEntity::where('org_id', $project->org_id)
                ->where('sub_entity_type', 'cycles')
                ->get();

            $sub_processes = SubEntity::where('org_id', $project->org_id)
                ->where('sub_entity_type', 'sub_processes')
                ->get();

            $riskRecords = DB::table('one_link_risk_record as r')
                ->leftJoin('departments as d', 'r.department_id', '=', 'd.id')
                ->leftJoin('units as u', 'r.unit_id', '=', 'u.id')
                ->leftJoin('one_link_sub_entities as p', 'r.product_id', '=', 'p.id')
                ->leftJoin('one_link_sub_entities as c', 'r.cycle_id', '=', 'c.id')
                ->leftJoin('one_link_sub_entities as sp', 'r.sub_process_id', '=', 'sp.id')
                ->leftJoin('users as usr', 'r.created_by', '=', 'usr.id')
                ->select(
                    'r.*',
                    'r.id as risk_id',
                    'd.name as department_name',
                    'u.name as unit_name',
                    'p.name as product_name',
                    'c.name as cycle_name',
                    'sp.name as sub_process_name',
                    DB::raw("CONCAT(usr.first_name, ' ', usr.last_name) as created_by_name")
                )
                ->where('r.org_id', auth()->user()->organization->id)
                ->where('r.project_id', $project->project_id)
                ->where('r.id', $risk_id)
                ->orderBy('r.created_at', 'desc')
                ->first();

            $units = DB::table('units')
                ->where('department_id', $riskRecords->department_id ?? 0)
                ->get();

            return view('one_link_inherent_risk.edit_risk_record_initial', [
                'project' => $project,
                'project_permissions' => $checkpermission->project_permissions,
                'record' => $riskRecords,
                'departments' => $departments,
                'products' => $products,
                'cycles' => $cycles,
                'sub_processes' => $sub_processes,
                'units' => $units
            ]);
        }
    }

    public function edit_initial_risk_record($proj_id,$org_id,$user_id,Request $request){
        $request->validate([
        'id' => 'required|exists:one_link_risk_record,id',
        'risk_identification_date' => 'nullable|date',
        'risk_reassessment_date' => 'nullable|date',
        'department_id' => 'nullable|exists:departments,id',
        'unit_id' => 'nullable|exists:units,id',
        'product_id' => 'nullable|exists:one_link_sub_entities,id',
        'cycle_id' => 'nullable|exists:one_link_sub_entities,id',
        'sub_process_id' => 'nullable|exists:one_link_sub_entities,id',
    ]);

     $risk = DB::table('one_link_risk_record')->where('id', $request->id)->first();

    if (!$risk) {
        return redirect()->back()->withErrors(['Record not found']);
    }

      DB::table('one_link_risk_record')
        ->where('id', $request->id)
        ->update([
            'risk_identification_date' => $request->risk_identification_date,
            'risk_reassessment_date' => $request->risk_reassessment_date,
            'department_id' => $request->department_id,
            'unit_id' => $request->unit_id,
            'product_id' => $request->product_id,
            'cycle_id' => $request->cycle_id,
            'sub_process_id' => $request->sub_process_id,
            'updated_at' => now(),
        ]);

            return redirect()->route('one_link_inherent_risk_main',[
                'proj_id'=>$proj_id,
                'user_id'=>$user_id
            ])->with('success', 'Risk record updated successfully.');


    }

    public function add_new_risk_record($proj_id, $user_id)
    {
        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
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

                $departments = Db::Table('departments')->where('org_id', auth()->user()->organization->id)->get();


                $products = SubEntity::where('org_id', $project->org_id)
                    ->where('sub_entity_type', 'products')
                    ->get();

                $cycles = SubEntity::where('org_id', $project->org_id)
                    ->where('sub_entity_type', 'cycles')
                    ->get();

                $sub_processes = SubEntity::where('org_id', $project->org_id)
                    ->where('sub_entity_type', 'sub_processes')
                    ->get();


                return view('one_link_inherent_risk.add_new_risk_record', [
                    'project' => $project,
                    'project_permissions' => $checkpermission->project_permissions,
                    'products' => $products,
                    'cycles' => $cycles,
                    'sub_processes' => $sub_processes,
                    'departments' => $departments
                ]);
            }
        }

        return redirect()->route('assigned_projects', [
            'user_id' => $user_id
        ])->with('error', 'donot have permission');
    }

    public function save_initial_risk_record($proj_id, $org_id, $user_id, Request $request)
    {
        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
        )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
            ->first();

        if ($checkpermission) {
            $permissions = json_decode($checkpermission->project_permissions);

            if (in_array('Data Inputter', $permissions)) {
                $request->validate([
                    'department_id' => 'required|exists:departments,id',
                    'unit_id'       => 'required|exists:units,id',
                    'product_id'    => 'required|exists:one_link_sub_entities,id',
                    'cycle_id'      => 'required|exists:one_link_sub_entities,id',
                    'sub_process_id' => 'required|exists:one_link_sub_entities,id',
                    'risk_identification_date' => 'required',
                    'risk_identification_date' => 'required'

                ]);

                DB::table('one_link_risk_record')->insert([
                    'org_id'         => $org_id,
                    'department_id'  => $request->department_id,
                    'project_id' => $proj_id,
                    'risk_identification_date' => $request->risk_identification_date,
                    'risk_reassessment_date' => $request->risk_reassessment_date,
                    'unit_id'        => $request->unit_id,
                    'product_id'     => $request->product_id,
                    'cycle_id'       => $request->cycle_id,
                    'sub_process_id' => $request->sub_process_id,
                    'created_by'     => $user_id,
                    'created_at'     => now(),
                    'updated_at'     => now(),

                ]);

                return redirect()->route("one_link_inherent_risk_main", [
                    'proj_id' => $proj_id,
                    'user_id' => $user_id
                ])->with('success', 'Risk record submitted successfully.');
            }
        }

        return redirect()->route('assigned_projects', [
            'user_id' => $user_id
        ])->with('error', 'donot have permission');
    }


    public function edit_risk_record_attributes($record_id, $proj_id, $user_id)
    {
        $checkpermission = Db::table('project_details')->select(
            'project_types.id as type_id',
            'project_details.project_code',
            'project_details.project_permissions',
            'projects.project_name'
        )
            ->join('projects', 'project_details.project_code', 'projects.project_id')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
            ->first();

        if ($checkpermission) {
            $permissions = json_decode($checkpermission->project_permissions);

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();


            $riskRecord = DB::table('one_link_risk_record as r')
                ->leftJoin('departments as d', 'r.department_id', '=', 'd.id')
                ->leftJoin('units as u', 'r.unit_id', '=', 'u.id')
                ->leftJoin('one_link_sub_entities as p', 'r.product_id', '=', 'p.id')
                ->leftJoin('one_link_sub_entities as c', 'r.cycle_id', '=', 'c.id')
                ->leftJoin('one_link_sub_entities as sp', 'r.sub_process_id', '=', 'sp.id')
                ->leftJoin('users as usr', 'r.created_by', '=', 'usr.id')
                ->select(
                    'r.*',
                    'r.id as risk_id',
                    'd.name as department_name',
                    'u.name as unit_name',
                    'p.name as product_name',
                    'c.name as cycle_name',
                    'sp.name as sub_process_name',
                    DB::raw("CONCAT(usr.first_name, ' ', usr.last_name) as created_by_name")
                )
                ->where('r.org_id', auth()->user()->organization->id)
                ->where('r.project_id', $proj_id)
                ->where('r.id', $record_id)
                ->orderBy('r.created_at', 'desc')
                ->first();

            $catalogs = DB::table('risk_description_catalog')->orderBy('description')->get();



            return view('one_link_inherent_risk.edit_risk_attributes', [
                'record' => $riskRecord,
                'project' => $project,
                'project_permissions' => $checkpermission->project_permissions,
                'catalogs' => $catalogs
            ]);
        }

        return redirect()->route('assigned_projects', [
            'user_id' => $user_id
        ])->with('error', 'donot have permission');
    }



    public function update_risk_record($proj_id, $org_id, $user_id, Request $request)
    {
        $request->validate([
            'risk_id' => 'required|exists:one_link_risk_record,id',
            'risk_description' => 'required|string|max:5000',
            'erm_risk_classification' => 'required',
            'op_loss_event_type_one' => 'required',
            'op_loss_event_type_two' => 'required'
        ]);

        $description = trim($request->risk_description);

        // Save the risk record
        DB::table('one_link_risk_record')
            ->where('id', $request->risk_id)
            ->where('project_id', $proj_id)
            ->update([
                'risk_description' => $description,
                'erm_risk_classification' => $request->erm_risk_classification,
                'op_loss_event_type_one' => $request->op_loss_event_type_one,
                'op_loss_event_type_two' => $request->op_loss_event_type_two,
                'updated_at' => now(),
            ]);

        // Check and insert into catalog if not exists
        $alreadyExists = DB::table('risk_description_catalog')
            ->whereRaw('LOWER(TRIM(description)) = ?', [strtolower($description)])
            ->exists();

        if (!$alreadyExists) {
            DB::table('risk_description_catalog')->insert([
                'description' => $description,
                'created_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Risk description updated and catalog updated (if needed).');
    }
}
