<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class IsoSec2_4_A7 extends Controller
{

    public function iso_sec2_4_a7($proj_id, $user_id)
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
                    $filepath = public_path('ISO_SOA_A7.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    //dd($rows);

                    $results = Db::table('iso_sec2_4_a7')->join('users', 'iso_sec2_4_a7.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->get();
                    return view(
                        'iso.iso_sec2_4_a7',
                        [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'results' => $results,
                            'data' => $rows
                        ]
                    );
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_4_a7_new(Request $req, $proj_id, $user_id)
    {
        $my_filter = array_filter($req->input('applicability'));

        $req->merge(['applicability' => $my_filter]);
        $req->validate(
            [
                'applicability' => ['required', 'array', 'min:1'],

            ],
            [
                'applicability.required' => 'Please choose atleast one value'
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
                        $applicability = $req->input('applicability');

                        $filtered_applicability = array_filter($applicability);


                        $inputArray = $filtered_applicability;
                        $yesNoArray = [];
                        $numberArray = [];

                        foreach ($inputArray as $value) {
                            $parts = explode('+', $value);

                            if (count($parts) === 2) {
                                $yesNoArray[] = $parts[0]; // "yes" or "no" part
                                $numberArray[] = $parts[1]; // "5.1" or "5.2" part
                            }
                        }


                        for ($i = 0; $i < count($yesNoArray); $i++) {
                            Db::table('iso_sec2_4_a7')->insert([
                                'project_id' => $proj_id,
                                'control_num' => $numberArray[$i],
                                'applicability' => $yesNoArray[$i],
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        }

                        return redirect()->route('iso_sec2_4_a7', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_4_a7_edit($control_num, $proj_id, $user_id)
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
                        $filepath = public_path('ISO_SOA_A7.xlsx');
                        $data = Excel::toArray([], $filepath); //with header
                        $filteredData = collect($data[0])->filter(function ($row) use ($control_num) {
                            // Assuming the column with the specific value is the second column (index 1).
                            // Adjust the column index and the value as per your Excel file structure.
                            return strval($row[0]) === $control_num;
                        })->values()->all();

                        $result = Db::table('iso_sec2_4_a7')->where('control_num', $control_num)->where('project_id', $proj_id)->first();


                        return view('iso.edit_sec2_4_a7', [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'data' => $filteredData,
                            'result' => $result
                        ]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function submit_edit_sec2_4_a7(Request $req, $control_num, $proj_id, $user_id)
    {
        $check = Db::table('iso_sec2_4_a7')->where('control_num', $control_num)->where('project_id', $proj_id)->first();

        if ($check->applicability == "no") {
            $req->validate([
                'justification' => 'required',
                'ref_of_risk' => 'required'
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

                        if ($check->applicability == "yes") {

                            Db::table('iso_sec2_4_a7')->where('control_num', $control_num)->where('project_id', $proj_id)
                                ->update([
                                    'ref_of_risk' => $req->ref_of_risk,
                                    'justification' => null,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]);
                            return redirect()->route('iso_sec2_4_a7', ['proj_id' => $proj_id, 'user_id' => $user_id])
                                ->with('success', 'Record Updated successfully');
                        }


                        if ($check->applicability == "no") {

                            Db::table('iso_sec2_4_a7')->where('control_num', $control_num)->where('project_id', $proj_id)
                                ->update([
                                    'ref_of_risk' => $req->ref_of_risk,
                                    'justification' => $req->justification,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]);

                            return redirect()->route('iso_sec2_4_a7', ['proj_id' => $proj_id, 'user_id' => $user_id])
                                ->with('success', 'Record Updated successfully');
                        }
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function edit_app_iso_sec2_4_a7($control_num, $proj_id, $user_id)
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

                        $filepath = public_path('ISO_SOA_A7.xlsx');
                        $data = Excel::toArray([], $filepath); //with header

                        $filteredData = collect($data[0])->filter(function ($row) use ($control_num) {
                            // Assuming the column with the specific value is the second column (index 1).
                            // Adjust the column index and the value as per your Excel file structure.
                            return strval($row[0]) === $control_num;
                        })->values()->all();


                        $results = Db::table('iso_sec2_4_a7')->where('control_num', $control_num)->where('project_id', $proj_id)
                            ->first();
                        return view('iso.sec2_4_a7_edit_applicability', [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'result' => $results,
                            'data' => $filteredData
                        ]);
                    }
                }
            }
        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function submit_edit_app_sec2_4_a7(Request $req, $control_num, $proj_id, $user_id)
    {
        $req->validate([
            'applicability' => 'required'
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

                        Db::table('iso_sec2_4_a7')->where('control_num', $control_num)->where('project_id', $proj_id)
                            ->update([
                                'applicability' => $req->applicability,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        return redirect()->route('iso_sec2_4_a7', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');
                    }
                }
            }
        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
}
