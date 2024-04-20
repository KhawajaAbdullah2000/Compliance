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

                    $assetData=Db::table('iso_sec_2_1')->where('assessment_id',$asset_id)->first();


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

                    $a5_results=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                    ->where('asset_id',$asset_id)->where('control_num','like','5%')
                    ->get();

                    $a6_results=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                    ->where('asset_id',$asset_id)->where('control_num','like','6%')
                    ->get();

                    $a7_results=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                    ->where('asset_id',$asset_id)->where('control_num','like','7%')
                    ->get();

                    $a8_results=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                    ->where('asset_id',$asset_id)->where('control_num','like','8%')
                    ->get();

                    $project=Project::join('project_types','projects.project_type','project_types.id')
                    ->where('projects.project_id',$proj_id)->first();


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_main', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                         'assetData'=>$assetData,
                        'sec2_4_a5_rows' => $sec2_4_a5_rows,
                        'sec2_4_a6_rows'=>$sec2_4_a6_rows,
                        'sec2_4_a7_rows'=>$sec2_4_a7_rows,
                        'sec2_4_a8_rows'=>$sec2_4_a8_rows,
                        'a5_results'=>$a5_results,
                        'a6_results'=>$a6_results,
                        'a7_results'=>$a7_results,
                        'a8_results'=>$a8_results,
                        'project'=>$project

                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_3_1_initial_add(Request $req,$asset_id,$proj_id,$user_id)
    {

        $req->validate([
             'asset_value' => 'required',
             'applicability' => ['required', 'array', 'min:1'],
            'control_compliance'=>['required','array','min:1'],
             'vulnerability'=>['required','array','min:1'],
             'threat'=>['required','array','min:1'],
             'risk_level'=>['required','array','min:1']

         ]);



        $my_filter = array_filter($req->input('applicability'));
        $req->merge(['applicability' => $my_filter]);
        $applicability = $req->input('applicability');
        $filtered_applicability = array_filter($applicability);



        $control_compliance_filter = array_filter($req->input('control_compliance'));


        $req->merge(['control_compliance' => $control_compliance_filter]);
        $control_compliance = $req->input('control_compliance');
        $filtered_control_compliance = array_filter($control_compliance);





        $vulnerability_filter = array_filter($req->input('vulnerability'));
        $req->merge(['vulnerability' => $vulnerability_filter]);
        $vulnerability = $req->input('vulnerability');
        $filtered_vulnerability = array_filter($vulnerability);

       // dd($filtered_vulnerability);

        $threat_filter = array_filter($req->input('threat'));
        $req->merge(['threat' => $threat_filter]);
        $threat = $req->input('threat');
        $filtered_threat = array_filter($threat);



        $risk_level_filter = array_filter($req->input('threat'));
        $req->merge(['threat' => $risk_level_filter]);
        $risk_level = $req->input('risk_level');
       $filtered_risk_level = array_filter($risk_level);


        $inputArray = $filtered_applicability;
        $yesNoArray = [];
        $numberArray = [];

        foreach ($inputArray as $key=>$value) {
            $parts = explode('+', $value);

            if (count($parts) === 2) {
                $yesNoArray[$key] = $parts[0]; // "yes" or "no" part
                $numberArray[$key] = $parts[1]; // "5.1" or "5.2" part
            }
        }


       //dd($filtered_control_compliance,$filtered_vulnerability,$filtered_threat,$filtered_risk_level,$yesNoArray,$numberArray);


        $inputControlCompliance=$filtered_control_compliance;
        foreach($inputControlCompliance as $icc){
            $final_control_compliance[]=$icc;
        }


        $inputVulnerability=$filtered_vulnerability;
        foreach($inputVulnerability as $iv){
            $final_vulnerability[]=$iv;
        }


        $inputThreat=$filtered_threat;
        foreach($inputThreat as $it){
            $final_threat[]=$it;
        }

        $inputRiskLevel=$filtered_risk_level;
        foreach($inputRiskLevel as $irl){
            $final_risk_level[]=$irl;
        }



        foreach($yesNoArray as $key=>$value){

            if($value=="yes"){
                DB::table('iso_sec_2_3_1')->insert([
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,
                    'asset_value' => $req->asset_value,
                    'control_num' => $numberArray[$key],
                    'applicability' => "yes",
                    'control_compliance'=>$filtered_control_compliance[$key],
                    'vulnerability'=>$filtered_vulnerability[$key],
                    'threat'=>$filtered_threat[$key],
                    'risk_level'=>$filtered_risk_level[$key],
                    'last_edited_by' => $user_id,
                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
            if($value=="no"){
                DB::table('iso_sec_2_3_1')->insert([
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,
                    'asset_value' => $req->asset_value,
                    'control_num' => $numberArray[$key],
                    'applicability' => "no",
                    'control_compliance'=>0,
                    'vulnerability'=>0,
                    'threat'=>0,
                    'risk_level'=>0,
                    'last_edited_by' => $user_id,
                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }

        }




        // for ($i = 0; $i < count($yesNoArray); $i++) {

        //         if ($yesNoArray[$i]=='yes'){
        //             DB::table('iso_sec_2_3_1')->insert([
        //                 'project_id' => $proj_id,
        //                 'asset_id' => $asset_id,
        //                 'asset_value' => $req->asset_value,
        //                 'control_num' => $numberArray[$i],
        //                 'applicability' => $yesNoArray[$i],
        //                 'control_compliance'=>$filtered_control_compliance[$i],
        //                 'vulnerability'=>$filtered_vulnerability[$i],
        //                 'threat'=>$filtered_threat[$i],
        //                 'risk_level'=>$filtered_risk_level[$i],
        //                 'last_edited_by' => $user_id,
        //                 'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //             ]);
        //         }

        //         if ($yesNoArray[$i]=='no'){
        //             DB::table('iso_sec_2_3_1')->insert([
        //                 'project_id' => $proj_id,
        //                 'asset_id' => $asset_id,
        //                 'asset_value' => $req->asset_value,
        //                 'control_num' => $numberArray[$i],
        //                 'applicability' => $yesNoArray[$i],
        //                 'control_compliance'=>0,
        //                 'vulnerability'=>0,
        //                 'threat'=>0,
        //                 'risk_level'=>0,
        //                 'last_edited_by' => $user_id,
        //                 'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
        //             ]);
        //         }



        // }

        return redirect()->route('iso_sec_2_3_1',['asset_id'=>$asset_id,'proj_id'=>$proj_id,'user_id'=>$user_id])->with('success','Record Added');


    }


    //editing risk assessment
    public function edit_risk_assessment($proj_id,$user_id,$asset_id,$control_num){
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

                 $project=Project::join('project_types','projects.project_type','project_types.id')
                 ->where('projects.project_id',$proj_id)->first();

                 $assetData=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                 ->where('control_num',$control_num)->first();
                 return view('iso_sec_2_3_1.iso_sec_2_3_1_edit',[
                    'project'=>$project,
                    'assetData'=>$assetData
                 ]);

                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }


    public function edit_risk_assessment_update(Request $req,$proj_id,$user_id,$asset_id,$control_num){
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
                        'asset_value' => 'required',
                        'applicability' => 'required',
                        'control_compliance' => 'required_if:applicability,yes',
                        'vulnerability' => 'required_if:applicability,yes',
                        'threat' => 'required_if:applicability,yes',
                        'risk_level' => 'required_if:applicability,yes'
                    ]);

                    if($req->applicability=="yes"){
                        Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num',$control_num)->update(
                           [
                            'asset_value'=>$req->asset_value,
                            'applicability'=>$req->applicability,
                            'control_compliance'=>$req->control_compliance,
                            'vulnerability'=>$req->vulnerability,
                            'threat'=>$req->threat,
                            'risk_level'=>$req->risk_level
                            ]
                           );
                    }

                    if($req->applicability=="no"){
                        Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                        ->where('control_num',$control_num)->update(
                           [
                            'asset_value'=>$req->asset_value,
                            'applicability'=>$req->applicability,
                            'control_compliance'=>0,
                            'vulnerability'=>0,
                            'threat'=>0,
                            'risk_level'=>$req->risk_level
                            ]
                           );
                    }

                    return redirect()->route('iso_sec_2_3_1',[
                        'asset_id'=>$asset_id,
                        'proj_id'=>$proj_id,
                        'user_id'=>auth()->user()->id
                    ]);

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


    public function iso_sec2_3_1_risk_treat_controls(Request $req,$asset_id, $proj_id, $user_id)
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


                   $check=DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)->where('applicability','yes')
                   ->first();

                            //controls wherer applicability is yes
                         $controls=DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$asset_id)
                                    ->pluck('control_num')->toArray();


                        $assetData=Db::table('iso_sec_2_1')
                        ->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();


                        $assetDataForFive=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)
                        ->where('asset_id',$asset_id)->get();







                          $project=Project::join('project_types','projects.project_type','project_types.id')
                          ->where('projects.project_id',$proj_id)->first();

                            return view('iso_sec_2_3_1.risk_treatment', [
                                'project_id' => $checkpermission->project_id,
                                'project_name' => $checkpermission->project_name,
                                'project_permissions' => $checkpermission->project_permissions,
                                'sec2_4_a5_rows' => $sec2_4_a5_rows,
                                'sec2_4_a6_rows'=>$sec2_4_a6_rows,
                                'sec2_4_a7_rows'=>$sec2_4_a7_rows,
                                'sec2_4_a8_rows'=>$sec2_4_a8_rows,
                                'controls'=>$controls,
                                'assetData'=>$assetData,
                                'check'=>$check,
                                'project'=>$project,
                                'assetDataForFive'=>$assetDataForFive

                            ]);




                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_3_2_risk_treat_form($control_num, $asset_id,$proj_id, $user_id)
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

                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);

                        $assetData=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();


                        return view('iso_sec_2_3_1.iso_sec_2_3_2_treatform', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'assetvalue' => $asset_risk_assess->asset_value,
                            'users' => $users,
                            'treatmentData'=>$asset_risk_assess,
                            'assetData'=>$assetData


                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_2_treat_form_submit(Request $req,$asset_id,$control_num,$proj_id,$user_id){
        //is user selected component
        $req->validate([
            'residual_risk_treatment' => 'required',
            'treatment_action' => 'required',
            'treatment_target_date' => 'required',
            'treatment_comp_date' => 'required',
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

                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('control_num',$control_num)
                        ->where('asset_id',$asset_id)->update([
                            'residual_risk_treatment'=>$req->residual_risk_treatment,
                            'treatment_action'=>$req->treatment_action,
                            'treatment_target_date'=>$req->treatment_target_date,
                            'treatment_comp_date'=>$req->treatment_comp_date,
                            'responsibility_for_treatment'=>$req->responsibility_for_treatment,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('iso_sec2_3_1_risk_treat_controls',[
                            'asset_id'=>$asset_id,'proj_id'=>$proj_id,'user_id'=>$user_id
                        ])->with('success','Risk Treatment completed');

                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }
}
