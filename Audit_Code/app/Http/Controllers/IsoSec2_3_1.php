<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


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


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_main', [

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

    public function iso_sec2_3_1_initial_add(Request $req, $proj_id, $user_id)
    {
        $req->validate([
             'asset_value' => 'required',
        'asset' => 'required',
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



        $vulnerability_filter = array_filter($req->input('vulnerability'));
        $req->merge(['vulnerability' => $vulnerability_filter]);

        $vulnerability = $req->input('control_compliance');
        //dd($vulnerability);

        $threat_filter = array_filter($req->input('threat'));
        $req->merge(['threat' => $threat_filter]);

        $threat = $req->input('threat');

        $risk_level_filter = array_filter($req->input('threat'));
        $req->merge(['threat' => $risk_level_filter]);
        $risk_level = $req->input('risk_level');




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






        $asset = explode('+', $req->asset);
        if ($asset[0] == "group") {
            $group = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $req->asset_id)->first();
            $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $group->g_name)->get();

            foreach ($components as $c) {
                for ($i = 0; $i < count($yesNoArray); $i++) {

                    $exists = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $c->assessment_id)
                        ->where('control_num', $numberArray[$i])->first();
                    if (!$exists) {
                        DB::table('iso_sec_2_3_1')->insert([
                            'project_id' => $proj_id,
                            'asset_id' => $c->assessment_id,
                            'asset_value' => $req->asset_value,
                            'control_num' => $numberArray[$i],
                            'applicability' => $yesNoArray[$i],
                            'control_compliance'=>$control_compliance[$i],
                            'vulnerability'=>$vulnerability[$i],
                            'threat'=>$threat[$i],
                            'risk_level'=>$risk_level[$i],
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            return redirect()->route('iso_sec_2_3_1', [
                'asset_id' => $req->asset_id, 'proj_id' => $proj_id,
                'user_id' => $user_id
            ])->withSuccess('Record Added');
        }

        if ($asset[0] == "name") {
            $components_to_add = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $asset[1])
                ->get();

            foreach ($components_to_add as $c) {

                for ($i = 0; $i < count($yesNoArray); $i++) {

                    $exists = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $c->assessment_id)
                        ->where('control_num', $numberArray[$i])
                        ->first();
                    if (!$exists) {
                        DB::table('iso_sec_2_3_1')->insert([
                            'project_id' => $proj_id,
                            'asset_id' => $c->assessment_id,
                            'asset_value' => $req->asset_value,
                            'control_num' => $numberArray[$i],
                            'applicability' => $yesNoArray[$i],
                            'control_compliance'=>$control_compliance[$i],
                            'vulnerability'=>$vulnerability[$i],
                            'threat'=>$threat[$i],
                            'risk_level'=>$risk_level[$i],
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            return redirect()->route('iso_sec_2_3_1', [
                'asset_id' => $req->asset_id, 'proj_id' => $proj_id,
                'user_id' => $user_id
            ])->withSuccess('Record Added');
        }

        if ($asset[0] == "component") {

            for ($i = 0; $i < count($yesNoArray); $i++) {

                $exists = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset[1])
                    ->where('control_num', $numberArray[$i])->first();
                if (!$exists) {
                    DB::table('iso_sec_2_3_1')->insert([
                        'project_id' => $proj_id,
                        'asset_id' => $asset[1],
                        'asset_value' => $req->asset_value,
                        'control_num' => $numberArray[$i],
                        'applicability' => $yesNoArray[$i],
                        'control_compliance'=>$control_compliance[$i],
                        'vulnerability'=>$vulnerability[$i],
                        'threat'=>$threat[$i],
                        'risk_level'=>$risk_level[$i],
                        'last_edited_by' => $user_id,

                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
            }
            return redirect()->route('iso_sec_2_3_1', [
                'asset_id' => $req->asset_id, 'proj_id' => $proj_id,
                'user_id' => $user_id
            ])->withSuccess('Done!');
        }
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


    public function iso_sec2_3_1_find_asset_value(Request $req, $proj_id, $user_id)
    {

      //  dd($req->query('asset'));



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


                    $asset = explode(' ', $req->query('asset'),2);

                    if ($asset[0] == "group") {
                    }

                    if ($asset[0] == "name") {
                    }

                    if ($asset[0] == "component") {

                        $componentDetails = Db::table('iso_sec_2_1')->where('assessment_id', $asset[1])->first();

                        $component = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset[1])
                            ->where('applicability', 'yes')->get();


                        if ($component) {
                            return view('iso_sec_2_3_1.risk_treatment', [
                                'project_id' => $checkpermission->project_id,
                                'project_name' => $checkpermission->project_name,
                                'project_permissions' => $checkpermission->project_permissions,
                                'component' => $component,
                                'componentDetails' => $componentDetails,
                                'sec2_4_a5_rows' => $sec2_4_a5_rows,
                                'asset'=>$req->query('asset'),
                                'asset_id'=>$req->query('asset_id')
                            ]);
                        }
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec_2_3_2_risk_treat_form($control_num, $asset_id, $asset,$proj_id, $user_id)
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

                        $asset_value = Db::table('iso_sec_2_3_1')->where('project_id', $proj_id)->where('asset_id', $asset_id)
                            ->where('control_num', $control_num)->first();

                        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

                        //superusers of that organization
                        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
                            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
                        // dd($superusers_of_that_org);

                        //organziatons of those superusers
                        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

                        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);


                        return view('iso_sec_2_3_1.iso_sec_2_3_2_treatform', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'asset_id' => $asset_id,
                            'control_num' => $control_num,
                            'assetvalue' => $asset_value->asset_value,
                            'users' => $users,
                            'treatmentData'=>$asset_value,
                            'asset'=>$asset

                        ]);
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function iso_sec_2_3_2_treat_form_submit(Request $req,$asset_id,$control_num,$asset,$proj_id,$user_id){
        //is user selected component
        $req->validate([
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

                        DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('control_num',$control_num)
                        ->where('asset_id',$asset_id)->update([
                            'residual_risk_treatment'=>$req->residual_risk_treatment,
                            'treatment_action'=>$req->treatment_action,
                            'treatment_target_date'=>$req->treatment_target_date,
                            'responsibility_for_treatment'=>$req->responsibility_for_treatment,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect("/iso_sec2_3_1_find_asset_value/{$proj_id}/{$user_id}?asset={$asset}&asset_id={$asset_id}");




                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }
}
