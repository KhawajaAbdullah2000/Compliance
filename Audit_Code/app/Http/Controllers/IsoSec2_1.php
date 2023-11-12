<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class IsoSec2_1 extends Controller
{
    public function iso_section2_1($proj_id, $user_id)
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
                    $data = DB::table('iso_sec_2_1')->join(
                        'users',
                        'iso_sec_2_1.last_edited_by',
                        'users.id'
                    )
                        ->where('project_id', $proj_id)->get();
                    return view('iso_sec_2_1.iso_sec_2_1_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function new_iso_sec_2_1(Request $req, $proj_id, $user_id)
    {
        $req->validate(
            [
                'g_name' => 'required|string',
                'name' => 'required|string',
                'c_name' => 'required|string',
                'owner_dept' => 'required|string',
                'physical_loc' => 'required|string',
                'logical_loc' => 'required|string',
                's_name' => 'required|string',
            ],
            [
                '*.required' => 'This field is required'
            ]
        );


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
                    if ($checkpermission->type_id == 4) {
                        Db::table('iso_sec_2_1')->insert([
                            'project_id' => $proj_id,
                            'g_name' => $req->g_name,
                            'name' => $req->name,
                            'c_name' => $req->c_name,
                            'owner_dept' => $req->owner_dept,
                            'physical_loc' => $req->physical_loc,
                            'logical_loc' => $req->logical_loc,
                            's_name' => $req->s_name,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_1_new($proj_id, $user_id)
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
                    if ($checkpermission->type_id == 4) {

                        return view('iso_sec_2_1.iso_sec_2_1_new', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions
                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_1_details($assessment_id, $proj_id, $user_id)
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
                    $data = DB::table('iso_sec_2_1')->join('users', 'iso_sec_2_1.last_edited_by', 'users.id')
                        ->where('assessment_id', $assessment_id)
                        ->where('project_id', $proj_id)->first();

                    if ($data) {
                        return view('iso_sec_2_1.iso_sec_2_1_details', [
                            'data' => $data,
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions
                        ]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_1_edit($assessment_id, $proj_id, $user_id)
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
                    if ($checkpermission->type_id == 4) {
                        $data = Db::table('iso_sec_2_1')->where('assessment_id', $assessment_id)->where('project_id', $proj_id)->first();

                        return view('iso_sec_2_1.iso_sec_2_1_edit', [
                            'data' => $data,
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions
                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_1_submit_edit(Request $req, $assessment_id, $proj_id, $user_id)
    {
        $req->validate(
            [
                'g_name' => 'required|string',
                'name' => 'required|string',
                'c_name' => 'required|string',
                'owner_dept' => 'required|string',
                'physical_loc' => 'required|string',
                'logical_loc' => 'required|string',
                's_name' => 'required|string',
            ],
            [
                '*.required' => 'This field is required'
            ]
        );


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
                    if ($checkpermission->type_id == 4) {
                        Db::table('iso_sec_2_1')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                        ->update([
                            'project_id' => $proj_id,
                            'g_name' => $req->g_name,
                            'name' => $req->name,
                            'c_name' => $req->c_name,
                            'owner_dept' => $req->owner_dept,
                            'physical_loc' => $req->physical_loc,
                            'logical_loc' => $req->logical_loc,
                            's_name' => $req->s_name,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Updated successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_1_delete($assessment_id,$proj_id,$user_id){
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
                    if ($checkpermission->type_id == 4) {
                        Db::table('iso_sec_2_1')->where('assessment_id',$assessment_id)->where('project_id',$proj_id)
                        ->delete();

                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Deleted successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }
}
