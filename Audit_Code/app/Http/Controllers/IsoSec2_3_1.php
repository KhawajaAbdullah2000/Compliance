<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use App\Models\Risk;


class IsoSec2_3_1 extends Controller
{

    public function iso_sec_2_3_1_risk_selection($asset_id,$proj_id,$user_id){
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

                    $asset=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();
                    return view('iso_sec_2_3_1.iso_sec_2_3_1_risk_selection', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project' => $project,
                        'asset'=>$asset
                    ]);

                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function Risk_Selection_form_Submit(Request $req,$asset_id,$proj_id,$user_id){
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

                    $service=  Db::table('iso_sec_2_1')
                    ->where('assessment_id',$asset_id)->first();


                  Db::table('iso_sec_2_1')
                  ->where('s_name',$service->s_name)
                  ->where('project_id',$proj_id)
                  ->update(
                    [
                        'risk_confidentiality'=>$req->risk_confidentiality,
                        'risk_integrity'=>$req->risk_integrity,
                        'risk_availability'=>$req->risk_availability

                    ]
                    );

                    return redirect()->route('iso_sec_2_3_1',[
                        'asset_id'=>$asset_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ]);

                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }


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


        $risk=Risk::where('asset_id',$asset_id)->get();
        $req->validate([

            'applicability' => ['required', 'array', 'min:1'],
            'control_compliance' => ['required', 'array', 'min:1'],
           // 'vulnerability' => ['required', 'array', 'min:1'],
            'threat' => ['required', 'array', 'min:1'],
           // 'risk_level' => ['required', 'array', 'min:1']
        ]);



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



        //  $my_filter = array_filter($req->input('risk_level'), function($value) {
        //     return $value !== null;
        // });
        // $req->merge(['risk_level' => $my_filter]);
        // $risk_level = $req->input('risk_level');
        // $filtered_risk_confidentiality= array_filter($risk_level, function($value) {
        //     return $value !== null;
        // });


        // $my_filter = array_filter($req->input('risk_integrity'), function($value) {
        //     return $value !== null;
        // });
        // $req->merge(['risk_integrity' => $my_filter]);
        // $risk_level = $req->input('risk_integrity');
        // $filtered_risk_integrity= array_filter($risk_level, function($value) {
        //     return $value !== null;
        // });


        // $my_filter = array_filter($req->input('risk_availability'), function($value) {
        //     return $value !== null;
        // });
        // $req->merge(['risk_availability' => $my_filter]);
        // $risk_level = $req->input('risk_availability');
        // $filtered_risk_availability= array_filter($risk_level, function($value) {
        //     return $value !== null;
        // });




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


  


        // try {
        foreach ($yesNoArray as $key => $value) {

    

                 //only to this asset component
                 $risk_level=((100-$filtered_control_compliance[$key]) / 100.0) * ($filtered_threat[$key] / 100.0) * $req->risk_confidentiality_value;
                 $risk_integrity=((100-$filtered_control_compliance[$key]) / 100.0) * ($filtered_threat[$key] / 100.0) * $req->risk_integrity_value;
 
                 $risk_availability=((100-$filtered_control_compliance[$key]) / 100.0) * ($filtered_threat[$key] / 100.0) * $req->risk_availability_value;

            if(in_array($numberArray[$key],array(8.6,8.13,8.14))){
                       $risk_level=0;  

            }

            if(in_array($numberArray[$key],array(8.6,8.13,8.14,6.6,8.11,8,12))){
                $risk_integrity=0;  

     }

     if(in_array($numberArray[$key],array(6.6,8.11,8,12))){
        $risk_availability=0;  

}



           

                if ($value == "yes") {

                if (isset($filtered_control_compliance[$key]) && isset($filtered_threat[$key]))
                 {
                    
                  


                    $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->first();


                    if($check){ //if record already exists



                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])
                        ->update([

                            'applicability' => "yes",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])->update([

                            'applicability' => "yes",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }else{
                        //record inserting first time

                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,

                            'applicability' => "yes",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,

                       'control_num'=>$numberArray[$key],
                            'applicability' => "yes",
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }




                }
            }
            if ($value == "no") {
                //not to this asset component


                $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                ->where('control_num', $numberArray[$key])->first();

                if($check){

                    DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->update([

                        'applicability' => "no",
                        'control_num'=>$numberArray[$key],
                        'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                        'risk_level' => 0,
                        'risk_integrity'=>0,
                        'risk_availability'=>0,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->update([

                        'applicability' => "no",
                        'control_num'=>$numberArray[$key],
                   'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' => 0,
                        'risk_integrity'=>0,
                        'risk_availability'=>0,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);


                }else{
                    //new record

                DB::table('iso_sec_2_3_1')->insert([
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,

                    'control_num' => $numberArray[$key],
                    'applicability' => "no",
                   'control_compliance' => $filtered_control_compliance[$key],
                     'vulnerability' => 100-$filtered_control_compliance[$key],
                      'threat' => $filtered_threat[$key],
                      'risk_level' => 0,
                      'risk_integrity'=>0,
                      'risk_availability'=>0,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                DB::table('iso_risk_treatment')->insert([
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,

                    'control_num' => $numberArray[$key],
                    'applicability' => "no",
                    'control_compliance' => $filtered_control_compliance[$key],
                    'vulnerability' => 100-$filtered_control_compliance[$key],
                    'threat' => $filtered_threat[$key],
                    'risk_level' => 0,
                    'risk_integrity'=>0,
                    'risk_availability'=>0,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

            }
            }
            if($value=='yes_to_all'){
                if (isset($filtered_control_compliance[$key]) && isset($filtered_threat[$key])){
                    $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                    ->where('control_num', $numberArray[$key])->first();

                    if($check){ //if record already exists
                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])
                        ->update([

                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num', $numberArray[$key])->update([

                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }else{
                        //record inserting first time

                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,
                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,             
                           'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset_id,
                       'control_num'=>$numberArray[$key],
                            'applicability' => "yes_to_all",
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                         'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }

                $service=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();


                //other assets in this service
            $otherAssets= Db::table('iso_sec_2_1')->where('project_id',$proj_id)
            ->where('s_name',$service->s_name)
            ->where('assessment_id','!=',$asset_id)
            ->get();

            if($otherAssets->count()>0){
                foreach($otherAssets as $other){
                    $check=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                    ->where('asset_id',$other->assessment_id)->where('control_num', $numberArray[$key])->first();
                    if($check){ //if record already exists
                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$other->assessment_id)
                        ->where('control_num', $numberArray[$key])
                        ->update([
                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                             'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        DB::table('iso_risk_treatment')->where('project_id',$proj_id)->where('asset_id',$other->assessment_id)
                        ->where('control_num', $numberArray[$key])->update([
                            'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    }else{

                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $other->assessment_id,
                         'applicability' => "yes_to_all",
                            'control_num'=>$numberArray[$key],
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                           'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    DB::table('iso_risk_treatment')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $other->assessment_id,
                       'control_num'=>$numberArray[$key],
                            'applicability' => "yes",
                            'control_compliance' => $filtered_control_compliance[$key],
                            'vulnerability' => 100-$filtered_control_compliance[$key],
                            'threat' => $filtered_threat[$key],
                            'risk_level' =>$risk_level,
                            'risk_integrity' =>$risk_integrity,
                            'risk_availability' =>$risk_availability,
                             'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                }




                }
            }






                }
            }
        }


        // } catch (\Throwable $th) {
        //     return redirect()->route('iso_sec_2_3_1',['asset_id'=>$asset_id,'proj_id'=>$proj_id,'user_id'=>$user_id])
        //     ->with('error','Please insert values when selecting yes');

        // }




        return redirect()->route('iso_sec_2_3_1', ['asset_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])->with('success', 'Record Added');
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

                        $riskData=Db::table('iso_sec_2_1')->where('project_id',$proj_id)
                        ->where('assessment_id',$asset_id)->first();

                    return view('iso_sec_2_3_1.iso_sec_2_3_1_edit', [
                        'project' => $project,
                        'assetData' => $assetData,
                        'riskData'=>$riskData
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

                        'desc_vulnerability' => 'required',

                         'desc_threat' => 'required', // Ensure the radio button is selected

                       'desc_risk' => 'required|array|min:1',

                    ]);

                     $desc_risk = $req->desc_risk;
                    $desc_risk_json = json_encode($desc_risk);


                     Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->update(
                                [
                                    'desc_vulnerability'=>$req->desc_vulnerability,
                                    'desc_vulnerability_other'=>$req->desc_vulnerability_other,
                                    'desc_threat'=>$req->desc_threat,
                                    'desc_threat_other'=>$req->desc_threat_other,
                                    'desc_risk' => $desc_risk_json, // Save as JSON
                                    'desc_risk_other' => $req->desc_risk_other,

                                ]
                            );



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


    public function iso_sec2_3_1_risk_treat_controls($asset_id, $proj_id, $user_id)
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


                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_3_2_risk_treat_form($control_num, $asset_id, $proj_id, $user_id)
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
            'acceptance_actual_date'
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
                                'acceptance_actual_date'=>$req->acceptance_actual_date,
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
            'control_compliance' => 'required',
            'vulnerability' => 'required',
            'threat' => 'required',
            'risk_level' => 'required',
            'risk_integrity'=>'required',
            'risk_availability'=>'required'

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


                        if ($req->applicability != "no") {

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
                                'risk_integrity' => $risk_assessment->risk_integrity,
                                'risk_availability' => $risk_assessment->risk_availability,
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
                                    'risk_integrity' => $req->risk_integrity,
                                    'risk_availability' => $req->risk_availability,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                                ]);

                            }
                        }

                        if ($req->applicability == "no") {
                            DB::table('iso_risk_treatment')->where('project_id', $proj_id)->where('control_num', $control_num)
                                ->where('asset_id', $asset_id)->update([
                                    'residual_risk_treatment' => $req->residual_risk_treatment,
                                    'control_compliance' => $req->control_compliance,
                                    'vulnerability' => $req->vulnerability,
                                    'threat' => $req->threat,
                                    'risk_level' => $req->risk_level,
                                    'risk_integrity' => $req->risk_integrity,
                                    'risk_availability' => $req->risk_availability,
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
