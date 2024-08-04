<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;

class IsoSec2_3_1 extends Controller
{
    public function iso_sec_2_3_1($asset_id, $proj_id, $user_id)
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

                    $assetData = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                    $filepath = public_path('ISO_SOA_A5.xlsx');
                    $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                    $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)

                    $filepath2 = public_path('ISO_SOA_A6.xlsx');
                    $sec2_4_a6_data = Excel::toArray([], $filepath2); //with header
                    $sec2_4_a6_rows = array_slice($sec2_4_a6_data[0], 1); //without header(first row)

                    $filepath3 = public_path('ISO_SOA_A7.xlsx');
                    $sec2_4_a7_data = Excel::toArray([], $filepath3); //with header
                    $sec2_4_a7_rows = array_slice($sec2_4_a7_data[0], 1); //without header(first row)


                    $filepath4 = public_path('ISO_SOA_A8.xlsx');
                    $sec2_4_a8_data = Excel::toArray([], $filepath4); //with header
                    $sec2_4_a8_rows = array_slice($sec2_4_a8_data[0], 1); //without header(first row)

                    $a5_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '5%')
                        ->get();

                    $a6_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '6%')
                        ->get();

                    $a7_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '7%')
                        ->get();

                    $a8_results = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->where('control_num', 'like', '8%')
                        ->get();

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $global_asset_value = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)->first();


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_main', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'assetData' => $assetData,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows,
                        'sec2_4_a6_rows' => $sec2_4_a6_rows,
                        'sec2_4_a7_rows' => $sec2_4_a7_rows,
                        'sec2_4_a8_rows' => $sec2_4_a8_rows,
                        'a5_results' => $a5_results,
                        'a6_results' => $a6_results,
                        'a7_results' => $a7_results,
                        'a8_results' => $a8_results,
                        'project' => $project,
                        'global_asset_value' => $global_asset_value
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_3_1_initial_add(Request $req, $asset_id, $proj_id, $user_id)
    {


        $req->validate([
            'asset_value' => 'required',
            'applicability' => ['required', 'array', 'min:1'],
            'applicability_all' => ['required', 'array', 'min:1'],
            'control_compliance' => ['required', 'array', 'min:1'],
            'vulnerability' => ['required', 'array', 'min:1'],
            'threat' => ['required', 'array', 'min:1'],
            'risk_level' => ['required', 'array', 'min:1']

        ]);


//same asset component logic is asset value changes
        $global_asset_value = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)->first();
        if ($global_asset_value != null and $global_asset_value->asset_value != $req->asset_value) {
            $old_risk = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)->get();

            foreach ($old_risk as $old) {
                Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                    ->where('control_num', $old->control_num)
                    ->update(
                        [
                            'asset_value' => $req->asset_value,
                            'risk_level' => ($old->vulnerability / 100.0) * ($old->threat / 100.0) * $req->asset_value
                        ]
                    );
            }

            //risk treatment tale also initially contains risk assessment data
            foreach ($old_risk as $old) {
                Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                    ->where('control_num', $old->control_num)
                    ->update(
                        [
                            'asset_value' => $req->asset_value,
                            'risk_level' => ($old->vulnerability / 100.0) * ($old->threat / 100.0) * $req->asset_value
                        ]
                    );
            }
        }

        //same asset component logic is asset value changes finished logic above

        $my_filter = array_filter($req->input('applicability_all'));
        $req->merge(['applicability_all' => $my_filter]);
        $applicability_all = $req->input('applicability_all');
        $filtered_applicability_all = array_filter($applicability_all);
      


        $my_filter = array_filter($req->input('applicability'));
        $req->merge(['applicability' => $my_filter]);
        $applicability = $req->input('applicability');
        $filtered_applicability = array_filter($applicability);



        $my_filter = array_filter($req->input('control_compliance'), function($value) {
            return $value !== null;
        });
        $req->merge(['control_compliance' => $my_filter]);
        $control_compliance = $req->input('control_compliance');
        $filtered_control_compliance = array_filter($control_compliance, function($value) {
            return $value !== null;
        });



        $my_filter = array_filter($req->input('vulnerability'), function($value) {
            return $value !== null;
        });
        $req->merge(['vulnerability' => $my_filter]);
        $vulnerability = $req->input('vulnerability');
        $filtered_vulnerability= array_filter($vulnerability, function($value) {
            return $value !== null;
        });



        $my_filter = array_filter($req->input('threat'), function($value) {
            return $value !== null;
        });
        $req->merge(['threat' => $my_filter]);
        $threat = $req->input('threat');
        $filtered_threat= array_filter($threat, function($value) {
            return $value !== null;
        });



         $my_filter = array_filter($req->input('risk_level'), function($value) {
            return $value !== null;
        });
        $req->merge(['risk_level' => $my_filter]);
        $risk_level = $req->input('risk_level');
        $filtered_risk_level= array_filter($risk_level, function($value) {
            return $value !== null;
        });




        $inputArray = $filtered_applicability;
        $yesNoArray = [];
        $numberArray = [];

        foreach ($inputArray as $key => $value) {
            $parts = explode('+', $value);

            if (count($parts) === 2) {
                $yesNoArray[$key] = $parts[0]; // "yes" or "no" part
                $numberArray[$key] = $parts[1]; // "5.1" or "5.2" part
            }
        }

        $inputArray_all = $filtered_applicability_all;
        $yesNoArray_all = [];
        $numberArray_all = [];

        foreach ($inputArray_all as $key => $value) {
            $parts = explode('+', $value);

            if (count($parts) === 2) {
                $yesNoArray_all[$key] = $parts[0]; // "yes" or "no" part
                $numberArray_all[$key] = $parts[1]; // "5.1" or "5.2" part
            }
        }

        $updates = [];
        $inserts = [];
        $no_updates = [];
        $no_inserts = [];
        
        $batchSize = 10; // Adjust the batch size according to your needs
        
        foreach($yesNoArray_all as $key => $value) {
            if($value == 'no') {
                foreach($yesNoArray as $key2 => $value2) {
                    if($value2 == 'yes') {
                        if (isset($filtered_control_compliance[$key2]) && isset($filtered_vulnerability[$key2])
                            && isset($filtered_threat[$key2]) && isset($filtered_risk_level[$key2])) {
        
                            $data = [
                                'project_id' => $proj_id,
                                'asset_id' => $asset_id,
                                'control_num' => $numberArray[$key2],
                                'asset_value' => $req->asset_value,
                                'applicability' => "yes",
                                'control_compliance' => $filtered_control_compliance[$key2],
                                'vulnerability' => $filtered_vulnerability[$key2],
                                'threat' => $filtered_threat[$key2],
                                'risk_level' => $filtered_risk_level[$key2],
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
        
                            $existing = DB::table('iso_sec_2_3_1')
                                ->where('project_id', $proj_id)
                                ->where('asset_id', $asset_id)
                                ->where('control_num', $numberArray[$key2])
                                ->exists();
        
                            if ($existing) {
                                $updates[] = $data;
                            } else {
                                $inserts[] = $data;
                            }
                        }
                    }
        
                    if ($value2 == "no") {
                        $no_data = [
                            'project_id' => $proj_id,
                            'asset_id' => $asset_id,
                            'control_num' => $numberArray[$key2],
                            'asset_value' => $req->asset_value,
                            'applicability' => "no",
                            'control_compliance' => 0,
                            'vulnerability' => 0,
                            'threat' => 0,
                            'risk_level' => 0,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
        
                        $existing_no = DB::table('iso_sec_2_3_1')
                            ->where('project_id', $proj_id)
                            ->where('asset_id', $asset_id)
                            ->where('control_num', $numberArray[$key2])
                            ->exists();
        
                        if ($existing_no) {
                            $no_updates[] = $no_data;
                        } else {
                            $no_inserts[] = $no_data;
                        }
                    }
                }
            }
            if($value=='yes'){
                $otherAssets=Db::table('iso_sec_2_1')->where('project_id',$proj_id)
                ->Pluck('assessment_id')->toArray();
                foreach ($otherAssets as $index => $assetId) {

                    foreach($yesNoArray as $key3 => $value3) {
                        if($value3 == 'yes') {
                            if (isset($filtered_control_compliance[$key3]) && isset($filtered_vulnerability[$key3])
                                && isset($filtered_threat[$key3]) && isset($filtered_risk_level[$key3])) {
            
                                $data = [
                                    'project_id' => $proj_id,
                                    'asset_id' => $assetId,
                                    'control_num' => $numberArray[$key3],
                                    'asset_value' => $req->asset_value,
                                    'applicability' => "yes",
                                    "applicability_all"=>"yes",
                                    'control_compliance' => $filtered_control_compliance[$key3],
                                    'vulnerability' => $filtered_vulnerability[$key3],
                                    'threat' => $filtered_threat[$key3],
                                    'risk_level' => $filtered_risk_level[$key3],
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ];
            
                                $existing = DB::table('iso_sec_2_3_1')
                                    ->where('project_id', $proj_id)
                                    ->where('asset_id', $assetId)
                                    ->where('control_num', $numberArray[$key3])
                                    ->exists();
            
                                if ($existing) {
                                    $updates[] = $data;
                                } else {
                                    $inserts[] = $data;
                                }
                            }
                        }
            
                        if ($value3 == "no") {
                            $no_data = [
                                'project_id' => $proj_id,
                                'asset_id' => $assetId,
                                'control_num' => $numberArray[$key3],
                                'asset_value' => $req->asset_value,
                                'applicability' => "no",
                                "applicability_all"=>"yes",
                                'control_compliance' => 0,
                                'vulnerability' => 0,
                                'threat' => 0,
                                'risk_level' => 0,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
            
                            $existing_no = DB::table('iso_sec_2_3_1')
                                ->where('project_id', $proj_id)
                                ->where('asset_id', $assetId)
                                ->where('control_num', $numberArray[$key3])
                                ->exists();
            
                            if ($existing_no) {
                                $no_updates[] = $no_data;
                            } else {
                                $no_inserts[] = $no_data;
                            }
                        }
                    }

            
            }
        }
        
        // Function to process updates in batches
        function processBatchUpdates($table, $data, $batchSize) {
            foreach (array_chunk($data, $batchSize) as $batch) {
                foreach ($batch as $update) {
                    DB::table($table)
                        ->where('project_id', $update['project_id'])
                        ->where('asset_id', $update['asset_id'])
                        ->where('control_num', $update['control_num'])
                        ->update($update);
                }
            }
        }
        
        // Function to process inserts in batches
        function processBatchInserts($table, $data, $batchSize) {
            foreach (array_chunk($data, $batchSize) as $batch) {
                foreach ($batch as $insert) {
                    DB::table($table)
                        ->updateOrInsert(
                            [
                                'project_id' => $insert['project_id'],
                                'asset_id' => $insert['asset_id'],
                                'control_num' => $insert['control_num']
                            ],
                            $insert
                        );
                }
            }
        }
        
        // Perform updates in bulk
        processBatchUpdates('iso_sec_2_3_1', $updates, $batchSize);
        processBatchUpdates('iso_risk_treatment', $updates, $batchSize);
        
        processBatchUpdates('iso_sec_2_3_1', $no_updates, $batchSize);
        processBatchUpdates('iso_risk_treatment', $no_updates, $batchSize);
        
        // Perform inserts in bulk
        processBatchInserts('iso_sec_2_3_1', $inserts, $batchSize);
        processBatchInserts('iso_risk_treatment', $inserts, $batchSize);
        
        processBatchInserts('iso_sec_2_3_1', $no_inserts, $batchSize);
        processBatchInserts('iso_risk_treatment', $no_inserts, $batchSize);

        // try {
        // foreach ($yesNoArray as $key => $value) {

        //     if ($value == "yes") {

        //         if (
        //         isset($filtered_control_compliance[$key]) && isset($filtered_vulnerability[$key])
        //             && isset($filtered_threat[$key]) && isset($filtered_risk_level[$key])
        //         ) {


        //             $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
        //             ->where('control_num', $numberArray[$key])->first();

        //             if($check){
        //                 DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
        //                 ->where('control_num', $numberArray[$key])
        //                 ->update([
        //                     'asset_value' => $req->asset_value,
        //                     'applicability' => "yes",
        //                     'control_compliance' => $filtered_control_compliance[$key],
        //                     'vulnerability' => $filtered_vulnerability[$key],
        //                     'threat' => $filtered_threat[$key],
        //                     'risk_level' => $filtered_risk_level[$key],
        //                     'last_edited_by' => $user_id,
        //                     'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //                 ]);

        //                 DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
        //                 ->where('control_num', $numberArray[$key])->update([
        //                     'asset_value' => $req->asset_value,
        //                     'applicability' => "yes",
        //                     'control_compliance' => $filtered_control_compliance[$key],
        //                     'vulnerability' => $filtered_vulnerability[$key],
        //                     'threat' => $filtered_threat[$key],
        //                     'risk_level' => $filtered_risk_level[$key],
        //                     'last_edited_by' => $user_id,
        //                     'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //                 ]);

        //             }else{

        //             DB::table('iso_sec_2_3_1')->insert([
        //                 'project_id' => $proj_id,
        //                 'asset_id' => $asset_id,
        //                 'asset_value' => $req->asset_value,
        //                 'control_num' => $numberArray[$key],
        //                 'applicability' => "yes",
        //                 'control_compliance' => $filtered_control_compliance[$key],
        //                 'vulnerability' => $filtered_vulnerability[$key],
        //                 'threat' => $filtered_threat[$key],
        //                 'risk_level' => $filtered_risk_level[$key],
        //                 'last_edited_by' => $user_id,
        //                 'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //             ]);

        //             DB::table('iso_risk_treatment')->insert([
        //                 'project_id' => $proj_id,
        //                 'asset_id' => $asset_id,
        //                 'asset_value' => $req->asset_value,
        //                 'control_num' => $numberArray[$key],
        //                 'applicability' => "yes",
        //                 'control_compliance' => $filtered_control_compliance[$key],
        //                 'vulnerability' => $filtered_vulnerability[$key],
        //                 'threat' => $filtered_threat[$key],
        //                 'risk_level' => $filtered_risk_level[$key],
        //                 'last_edited_by' => $user_id,
        //                 'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //             ]);

        //         }




        //         }
        //     }
        //     if ($value == "no") {


        //         $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
        //         ->where('control_num', $numberArray[$key])->first();

        //         if($check){

        //             DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
        //             ->where('control_num', $numberArray[$key])->update([
        //                 'asset_value' => $req->asset_value,
        //                 'applicability' => "no",
        //                 'control_compliance' => 0,
        //                 'vulnerability' => 0,
        //                 'threat' => 0,
        //                 'risk_level' => 0,
        //                 'last_edited_by' => $user_id,
        //                 'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //             ]);

        //             DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
        //             ->where('control_num', $numberArray[$key])->update([
        //                 'asset_value' => $req->asset_value,
        //                 'applicability' => "no",
        //                 'control_compliance' => 0,
        //                 'vulnerability' => 0,
        //                 'threat' => 0,
        //                 'risk_level' => 0,
        //                 'last_edited_by' => $user_id,
        //                 'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //             ]);


        //         }else{

        //         DB::table('iso_sec_2_3_1')->insert([
        //             'project_id' => $proj_id,
        //             'asset_id' => $asset_id,
        //             'asset_value' => $req->asset_value,
        //             'control_num' => $numberArray[$key],
        //             'applicability' => "no",
        //             'control_compliance' => 0,
        //             'vulnerability' => 0,
        //             'threat' => 0,
        //             'risk_level' => 0,
        //             'last_edited_by' => $user_id,
        //             'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //         ]);

        //         DB::table('iso_risk_treatment')->insert([
        //             'project_id' => $proj_id,
        //             'asset_id' => $asset_id,
        //             'asset_value' => $req->asset_value,
        //             'control_num' => $numberArray[$key],
        //             'applicability' => "no",
        //             'control_compliance' => 0,
        //             'vulnerability' => 0,
        //             'threat' => 0,
        //             'risk_level' => 0,
        //             'last_edited_by' => $user_id,
        //             'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //         ]);

        //     }
        //     }
        // }


        // } catch (\Throwable $th) {
        //     return redirect()->route('iso_sec_2_3_1',['asset_id'=>$asset_id,'proj_id'=>$proj_id,'user_id'=>$user_id])
        //     ->with('error','Please insert values when selecting yes');

        // }




        return redirect()->route('iso_sec_2_3_1', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])->with('success', 'Record Added');
    }
}



    //editing risk assessment
    public function edit_risk_assessment($proj_id, $user_id, $asset_id, $control_num)
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

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $assetData = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                        ->where('control_num', $control_num)->first();
                    return view('iso_sec_2_3_1.iso_sec_2_3_1_edit', [
                        'project' => $project,
                        'assetData' => $assetData
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function edit_risk_assessment_update(Request $req, $proj_id, $user_id, $asset_id, $control_num)
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


                    $req->validate([
                        'applicability' => 'required',
                        'control_compliance' => 'required_if:applicability,yes',
                        'vulnerability' => 'required_if:applicability,yes',
                        'threat' => 'required_if:applicability,yes',
                        'risk_level' => 'required_if:applicability,yes'
                    ]);

                    if ($req->applicability == "yes") {
                        Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->update(
                                [

                                    'applicability' => $req->applicability,
                                    'control_compliance' => $req->control_compliance,
                                    'vulnerability' => $req->vulnerability,
                                    'threat' => $req->threat,
                                    'risk_level' => $req->risk_level
                                ]
                            );

                        Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->update(
                                [

                                    'applicability' => $req->applicability,
                                    'control_compliance' => $req->control_compliance,
                                    'vulnerability' => $req->vulnerability,
                                    'threat' => $req->threat,
                                    'risk_level' => $req->risk_level
                                ]
                            );
                    }

                    if ($req->applicability == "no") {
                        Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->update(
                                [
                                    'asset_value' => $req->asset_value,
                                    'applicability' => $req->applicability,
                                    'control_compliance' => 0,
                                    'vulnerability' => 0,
                                    'threat' => 0,
                                    'risk_level' => $req->risk_level
                                ]
                            );

                        Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->update(
                                [
                                    'asset_value' => $req->asset_value,
                                    'applicability' => $req->applicability,
                                    'control_compliance' => 0,
                                    'vulnerability' => 0,
                                    'threat' => 0,
                                    'risk_level' => $req->risk_level
                                ]
                            );
                    }

                    return redirect()->route('iso_sec_2_3_1', [
                        'asset_id' => $asset_id,
                        'proj_id' => $proj_id,
                        'user_id' => auth()->user()->id
                    ])->with('success', 'Record Updated');
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function iso_sec_2_3_1_risk($asset_id, $proj_id, $user_id)
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
                    $assets = DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->get();

                    $group = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();
                    //dd($group->g_name);

                    $name = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)
                        ->first();
                    //dd($names);

                    //assume a group willl have unique component names
                    $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $name->name)
                        ->get();
                    //dd($components);



                    $filepath = public_path('ISO_SOA_A5.xlsx');
                    $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                    $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_risk', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'assets' => $assets,
                        'group' => $group->g_name,
                        'name' => $name->name,
                        'components' => $components,
                        'asset_id' => $asset_id,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows

                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function iso_sec2_3_1_risk_treat_controls(Request $req, $asset_id, $proj_id, $user_id)
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

                    $filepath = public_path('ISO_SOA_A5.xlsx');
                    $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                    $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)

                    //dd($sec2_4_a5_rows);

                    $filepath2 = public_path('ISO_SOA_A6.xlsx');
                    $sec2_4_a6_data = Excel::toArray([], $filepath2); //with header
                    $sec2_4_a6_rows = array_slice($sec2_4_a6_data[0], 1); //without header(first row)


                    $filepath3 = public_path('ISO_SOA_A7.xlsx');
                    $sec2_4_a7_data = Excel::toArray([], $filepath3); //with header
                    $sec2_4_a7_rows = array_slice($sec2_4_a7_data[0], 1); //without header(first row)



                    $filepath4 = public_path('ISO_SOA_A8.xlsx');
                    $sec2_4_a8_data = Excel::toArray([], $filepath4); //with header
                    $sec2_4_a8_rows = array_slice($sec2_4_a8_data[0], 1); //without header(first row)


                    $check = DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)->where('applicability', 'yes')
                        ->first();

                       if($check==null){
                        return redirect()->route('risk_treatment',['proj_id'=>$proj_id,'user_id'=>$user_id])->with('error',"No Risk Assessment Done Yet");
                       }

                    //controls wherer applicability is yes
                    $controls = DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                        ->pluck('control_num')->toArray();

                    $asset_value=DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                    ->first()->asset_value;



                    $assetData = Db::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();


                    $assetDataForFive = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                        ->where('asset_id', $asset_id)->get();





                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    return view('iso_sec_2_3_1.risk_treatment', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows,
                        'sec2_4_a6_rows' => $sec2_4_a6_rows,
                        'sec2_4_a7_rows' => $sec2_4_a7_rows,
                        'sec2_4_a8_rows' => $sec2_4_a8_rows,
                        'controls' => $controls,
                        'assetData' => $assetData,
                        'check' => $check,
                        'project' => $project,
                        'assetDataForFive' => $assetDataForFive,
                        'asset_value'=>$asset_value

                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_3_2_risk_treat_form($control_num, $asset_id, $proj_id, $user_id)
    {
        //if component selected

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

                        $asset_risk_assess = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();

                        $after_risk_treatment = Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();

                        // dd($asset_risk_assess);

                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                            ->where('projects.project_id', $proj_id)->first();



                        return view('iso_sec_2_3_1.iso_sec_2_3_2_treatform', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'assetvalue' => $asset_risk_assess->asset_value,
                            'users' => $users,
                            'treatmentData' => $asset_risk_assess,
                            'assetData' => $assetData,
                            'project' => $project,
                            'after_risk_treatment' => $after_risk_treatment


                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_2_treat_form_submit(Request $req, $asset_id, $control_num, $proj_id, $user_id)
    {

        $req->validate([
            'treatment_action' => '',
            'treatment_target_date' => '',
            'treatment_comp_date' => '',
            'responsibility_for_treatment' => '',
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

                        DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->update([
                                'treatment_action' => $req->treatment_action,
                                'treatment_target_date' => $req->treatment_target_date,
                                'treatment_comp_date' => $req->treatment_comp_date,
                                'responsibility_for_treatment' => $req->responsibility_for_treatment,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        return redirect()->route('iso_sec_2_3_2_risk_treat_form', [
                            'control_num' => $control_num, 'asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id
                        ])->with('success', 'Treatment Action Plan Updated');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function iso_sec_2_3_2_treat_form1_submit(Request $req, $asset_id, $control_num, $proj_id, $user_id)
    {


        $req->validate([
            'applicability'=>'required',
            'residual_risk_treatment' => "required|string",
            'control_compliance' => 'required_if:applicability,yes',
            'vulnerability' => 'required_if:applicability,yes',
            'threat' => 'required_if:applicability,yes',
            'risk_level' => 'required_if:applicability,yes'

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


                        if ($req->applicability == "yes") {

                            if($req->residual_risk_treatment=="retain and accept risk"){
                            $risk_assessment=DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->first();

                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->update([
                                'residual_risk_treatment' => $req->residual_risk_treatment,
                                'control_compliance' => $risk_assessment->control_compliance,
                                'vulnerability' => $risk_assessment->vulnerability,
                                'threat' => $risk_assessment->threat,
                                'risk_level' => $risk_assessment->risk_level,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                            ]);




                            }else{


                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                                ->where('asset_id', $asset_id)->update([
                                    'residual_risk_treatment' => $req->residual_risk_treatment,
                                    'control_compliance' => $req->control_compliance,
                                    'vulnerability' => $req->vulnerability,
                                    'threat' => $req->threat,
                                    'risk_level' => $req->risk_level,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                                ]);

                            }
                        }

                        if ($req->applicability == "no") {
                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                                ->where('asset_id', $asset_id)->update([
                                    'residual_risk_treatment' => $req->residual_risk_treatment,
                                    'control_compliance' => 0,
                                    'vulnerability' => 0,
                                    'threat' => 0,
                                    'risk_level' => 0,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                                ]);
                        }


                            return redirect()->route('risk_treatment_edit_action_plan_form', [
                                'asset_id' => $asset_id,  'control_num' => $control_num,
                                 'proj_id' => $proj_id, 'user_id' => $user_id
                            ])->with('success', 'Risk Treatment completed');





                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function iso_sec_2_3_2_justification_form_submit(Request $req, $asset_id, $control_num, $proj_id, $user_id){
        $req->validate([
             'acceptance_justification' => '',
            'acceptance_target_date' => '',
             'acceptance_actual_date' => '',
             'acceptance_proposed_responsibility' => '',
            'accepted_by' => ''
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

                        DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                            ->where('asset_id', $asset_id)->update([
                                'acceptance_justification' => $req->acceptance_justification,
                                'acceptance_target_date' => $req->acceptance_target_date,
                                'acceptance_actual_date' => $req->acceptance_actual_date,
                                'acceptance_proposed_responsibility' => $req->acceptance_proposed_responsibility,
                                'accepted_by'=>$req->accepted_by,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        return redirect()->route('iso_sec_2_3_2_risk_treat_form', [
                            'control_num' => $control_num, 'asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id
                        ])->with('success', 'Justification Updated');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }


    }



    public function risk_treatment_edit_action_plan_form($asset_id, $control_num, $proj_id, $user_id)
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

                $risk_assessment= Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                    ->where('control_num', $control_num)->first();

                 $asset_risk_assess = Db::table('iso_risk_treatment')->where('project_id', $proj_id)
                 ->where('asset_id', $asset_id)
                     ->where('control_num', $control_num)->first();



                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                            ->where('projects.project_id', $proj_id)->first();



                        return view('iso_sec_2_3_1.iso_sec_2_3_2_actionplanform', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'assetvalue' => $asset_risk_assess->asset_value,
                            'users' => $users,
                            'treatmentData' => $asset_risk_assess,
                            'risk_assessment'=>$risk_assessment,
                            'assetData' => $assetData,
                            'project' => $project


                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function risk_treatment_justification($asset_id, $control_num, $proj_id, $user_id){
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

                        $asset_risk_assess = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();



                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                            ->where('projects.project_id', $proj_id)->first();

                     $after_risk_treatment = Db::table('iso_risk_treatment')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();

                        return view('iso_sec_2_3_1.iso_sec_2_3_2_justification', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'assetvalue' => $asset_risk_assess->asset_value,
                            'users' => $users,
                            'treatmentData' => $asset_risk_assess,
                            'assetData' => $assetData,
                            'project' => $project,
                            'after_risk_treatment'=>$after_risk_treatment

                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }
}
