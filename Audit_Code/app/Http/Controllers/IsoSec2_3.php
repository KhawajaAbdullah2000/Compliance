<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class IsoSec2_3 extends Controller
{
    public function iso_sec_2_3($proj_id, $user_id)
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
                    $data = DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->get();
                    return view('iso_sec_2_3.iso_sec_2_3_main', [
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

    public function iso_sec_2_3_edit($assessment_id, $proj_id, $user_id)
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

                        $iso_sec_2_4_a5 = Db::table('iso_sec2_4_a5')->where('project_id', $proj_id)
                            ->where('applicability', 'yes')->get();

                        $iso_sec_2_4_a6 = Db::table('iso_sec2_4_a6')->where('project_id', $proj_id)
                            ->where('applicability', 'yes')->get();
                        $iso_sec_2_4_a7 = Db::table('iso_sec2_4_a7')->where('project_id', $proj_id)
                            ->where('applicability', 'yes')->get();

                            $iso_sec_2_4_a8 = Db::table('iso_sec2_4_a8')->where('project_id', $proj_id)
                            ->where('applicability', 'yes')->get();


        $assetData = Db::table('iso_sec_2_1')->where('assessment_id', $assessment_id)->where('project_id', $proj_id)->first();
        $assetvalue = Db::table('iso_sec_2_3')->where('asset_id', $assessment_id)->where('project_id', $proj_id)->first();

        $tableData=Db::table('iso_sec_2_3_table')->join('users','iso_sec_2_3_table.responsibility_for_treatment','users.id')
        ->where('project_id',$proj_id)->where('asset_id',$assessment_id)->get();

                        if ($assetData && !$assetvalue) {
                            return view('iso_sec_2_3.iso_sec_2_3_edit', [
                                'tableData'=>null,
                                'iso_sec_2_4_a5' => null,
                                'iso_sec_2_4_a6' => null,
                                'iso_sec_2_4_a7' => null,
                                'iso_sec_2_4_a8' => null,
                                'assetData' => $assetData,
                                'assetvalue' => null,
                                'project_id' => $checkpermission->project_id,
                                'project_name' => $checkpermission->project_name,
                                'project_permissions' => $checkpermission->project_permissions
                            ]);
                        }

                        if ($assetData && $assetvalue) {
                            return view('iso_sec_2_3.iso_sec_2_3_edit', [
                                'tableData'=>$tableData,
                                'iso_sec_2_4_a5' => $iso_sec_2_4_a5,
                                'iso_sec_2_4_a6' => $iso_sec_2_4_a6,
                                'iso_sec_2_4_a7' => $iso_sec_2_4_a7,
                                'iso_sec_2_4_a8' => $iso_sec_2_4_a8,
                                'assetvalue' => $assetvalue->asset_value,
                                'assetData' => $assetData,
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
    }

    public function iso_sec_2_3_new_asset_value(Request $req, $asset_id, $proj_id, $user_id)
    {
        $req->validate([
            'asset_value' => 'required'
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
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 4) {
                        Db::table('iso_sec_2_3')->insert([
                            'asset_id' => $asset_id,
                            'project_id' => $proj_id,
                            'asset_value' => $req->asset_value,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('iso_sec_2_3_edit', ['assessment_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Asset value updated successfully');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_table_insert($asset_id, $control_num, $proj_id, $user_id)
    {
        //  dd($asset_id,$control_num,$proj_id,$user_id);
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
                        $assetvalue = Db::table('iso_sec_2_3')->where('asset_id', $asset_id)->where('project_id', $proj_id)->first();

                        //find superusers
                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);


                        return view('iso_sec_2_3.iso_sec_2_3_table_insert', [
                            'asset_id' => $asset_id,
                            'assetvalue' => $assetvalue->asset_value,
                            'control_num' => $control_num,
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'users' => $users
                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_table_submit(Request $req, $proj_id, $user_id)
    {
       // dd($req->all());
        $req->validate([
            'control_compliance' => 'required|numeric|min:1|max:100',
            'threat' => 'required|numeric|min:1|max:100',
            'residual_risk_treatment' => 'required',
            'treatment_action' => 'required',
            'treatment_target_date' => 'required',
            'responsibility_for_treatment' => 'required',
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
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 4) {
                       Db::table('iso_sec_2_3_table')->insert([
                        'asset_id'=>$req->asset_id,
                        'control_num'=>$req->control_num,
                        'project_id'=>$proj_id,
                        'control_compliance'=>$req->control_compliance,
                        'vulnerability'=>$req->vulnerability,
                        'threat'=>$req->threat,
                        'risk_level'=>$req->risk_level,
                        'residual_risk_treatment'=>$req->residual_risk_treatment,
                        'treatment_action'=>$req->treatment_action,
                        'treatment_target_date'=>$req->treatment_target_date,
                        'responsibility_for_treatment'=>$req->responsibility_for_treatment,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);
         return redirect()->route('iso_sec_2_3_edit', ['assessment_id' => $req->asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                       ->with('success', 'Asset value updated successfully');

                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function iso_sec_2_3_edit_table($asset_id,$control_num,$proj_id,$user_id){

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
                        $assetvalue = Db::table('iso_sec_2_3')->where('asset_id', $asset_id)->where('project_id', $proj_id)->first();

                        //find superusers
                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $data=Db::table('iso_sec_2_3_table')->where('asset_id',$asset_id)->where('project_id',$proj_id)
                        ->where('control_num',$control_num)->first();
                        //dd($data);
                        if($data){
                            return view('iso_sec_2_3.iso_sec_2_3_edit_table', [
                                'asset_id' => $asset_id,
                                'assetvalue' => $assetvalue->asset_value,
                                'control_num' => $control_num,
                                'project_id' => $checkpermission->project_id,
                                'project_name' => $checkpermission->project_name,
                                'project_permissions' => $checkpermission->project_permissions,
                                'users' => $users,
                                'data'=>$data
                            ]);
                        }


                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_edit_table_submit(Request $req,$proj_id,$user_id){
        $req->validate([
            'control_compliance' => 'required|numeric|min:1|max:100',
            'threat' => 'required|numeric|min:1|max:100',
            'residual_risk_treatment' => 'required',
            'treatment_action' => 'required',
            'treatment_target_date' => 'required',
            'responsibility_for_treatment' => 'required',
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
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 4) {
                       Db::table('iso_sec_2_3_table')->where('asset_id',$req->asset_id)->where('project_id',$proj_id)
                       ->where('control_num',$req->control_num)
                       ->update([
                        'control_compliance'=>$req->control_compliance,
                        'vulnerability'=>$req->vulnerability,
                        'threat'=>$req->threat,
                        'risk_level'=>$req->risk_level,
                        'residual_risk_treatment'=>$req->residual_risk_treatment,
                        'treatment_action'=>$req->treatment_action,
                        'treatment_target_date'=>$req->treatment_target_date,
                        'responsibility_for_treatment'=>$req->responsibility_for_treatment,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);
         return redirect()->route('iso_sec_2_3_edit', ['assessment_id' => $req->asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                       ->with('success', 'Asset value updated successfully');

                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }
}
