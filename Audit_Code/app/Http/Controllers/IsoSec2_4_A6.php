<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use App\Models\Project;
class IsoSec2_4_A6 extends Controller
{
    public function iso_sec2_4_a6_assets($proj_id, $user_id)
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
                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();
                    return view('iso.iso_sec_2_5_assets_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_4_a6($asset_id, $proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
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
                if ($checkpermission->type_id == 4) {
                    //reading excel file
                    $filepath = public_path('ISO_SOA_A6.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)


                    $results = DB::table('iso_sec_2_3_1')->join('users', 'iso_sec_2_3_1.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->get();

                    $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                    //    $results=Db::table('iso_sec2_4_a5')->join('users','iso_sec2_4_a5.last_edited_by','users.id')
                    //    ->where('project_id',$proj_id)->get();


                 $project=Project::join('project_types','projects.project_type','project_types.id')
                 ->where('projects.project_id',$proj_id)->first();
                    return view(
                        'iso.iso_sec2_4_a6',
                        [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'results' => $results,
                            'data' => $rows,
                            'results' => $results,
                            'assetData' => $assetData,
                            'project'=>$project
                        ]
                    );
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }



    public function iso_sec2_4_a6_edit($control_num, $asset_id, $proj_id, $user_id)
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
                        $filepath = public_path('ISO_SOA_A6.xlsx');
                        $data = Excel::toArray([], $filepath); //with header
                        // $rows = array_slice($data[0], 1); //without header(first row)
                        //    dd(gettype($rows[0][0]));
                        $filteredData = collect($data[0])->filter(function ($row) use ($control_num) {
                            // Assuming the column with the specific value is the second column (index 1).
                            // Adjust the column index and the value as per your Excel file structure.
                            return strval($row[0]) === $control_num;
                        })->values()->all();

                        $result = Db::table('iso_sec_2_3_1')->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->where('project_id', $proj_id)->first();

                        $control_data = Db::table('iso_sec2_4_a6')->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->where('project_id', $proj_id)->first();


                            $project=Project::join('project_types','projects.project_type','project_types.id')
                            ->where('projects.project_id',$proj_id)->first();

                    $assetData=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();


                        return view('iso.edit_sec2_4_a6', [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'data' => $filteredData,
                            'result' => $result,
                            'asset_id' => $asset_id,
                            'assetData'=>$assetData,
                            'control_data' => $control_data,
                            'project'=>$project
                        ]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }



    public function submit_edit_sec2_4_a6(Request $req, $control_num, $asset_id, $proj_id, $user_id)
    {

        $check = Db::table('iso_sec_2_3_1')->where('control_num', $control_num)->where('project_id', $proj_id)
            ->where('asset_id', $asset_id)->first();

        if ($check->applicability == "no") {
            $req->validate([
                'justification' => 'required',

            ]);
        }
        if ($check->applicability == "yes") {
            $req->validate([
                'ref_of_risk' => 'required'
            ]);
        }

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

                        $exists = DB::table('iso_sec2_4_a6')->where('control_num', $control_num)->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)->first();
                        if ($exists) {

                            if ($check->applicability == "yes") {

                                Db::table('iso_sec2_4_a6')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                                    ->where('control_num', $control_num)
                                    ->update([
                                        'ref_of_risk' => $req->ref_of_risk,
                                        'justification' => null,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                    ]);
                                return redirect()->route('iso_sec2_4_a6', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                                    ->with('success', 'Record Updated successfully');
                            }

                            if ($check->applicability == "no") {

                                Db::table('iso_sec2_4_a6')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                                    ->where('control_num', $control_num)
                                    ->update([
                                        'ref_of_risk' => $req->ref_of_risk,
                                        'justification' => $req->justification,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                    ]);

                                return redirect()->route('iso_sec2_4_a6', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                                    ->with('success', 'Record Updated successfully');
                            }
                        } else {


                            if ($check->applicability == "yes") {

                                Db::table('iso_sec2_4_a6')
                                    ->insert([
                                        'project_id' => $proj_id,
                                        'control_num' => $control_num,
                                        'asset_id' => $asset_id,
                                        'ref_of_risk' => $req->ref_of_risk,
                                        'justification' => null,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                    ]);
                                return redirect()->route('iso_sec2_4_a6', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                                    ->with('success', 'Record Updated successfully');
                            }


                            if ($check->applicability == "no") {


                                Db::table('iso_sec2_4_a6')
                                    ->insert([
                                        'project_id' => $proj_id,
                                        'control_num' => $control_num,
                                        'asset_id' => $asset_id,
                                        'ref_of_risk' => $req->ref_of_risk,
                                        'justification' => $req->justification,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                    ]);

                                return redirect()->route('iso_sec2_4_a6', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                                    ->with('success', 'Record Updated successfully');
                            }
                        }
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
}
