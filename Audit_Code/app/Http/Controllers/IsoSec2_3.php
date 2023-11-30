<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

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


    public function iso_sec_2_3_1($assessment_id,$component_name,$proj_id,$user_id){
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

                     $groups = DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->where('c_name',$component_name)
                         ->distinct()
                        ->pluck('g_name');

                        $components = DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->where('c_name',$component_name)
                        ->distinct()
                        ->pluck('c_name');

                        $names= DB::table('iso_sec_2_1')
                        ->where('project_id', $proj_id)->where('c_name',$component_name)
                        ->distinct()
                        ->pluck('name');


                        $filepath=public_path('ISO_SOA_A5.xlsx');
                        $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                        $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)

                        $results=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->get();

                    return view('iso_sec_2_3.iso_sec_2_3_1_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'groups'=>$groups,
                        'components'=>$components,
                        'names'=>$names,
                        'sec2_4_a5_rows'=>$sec2_4_a5_rows,
                        'assessment_id'=>$assessment_id,
                        'component_name'=>$component_name,
                        'results'=>$results,
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

public function iso_sec2_3_1_new(Request $req,$proj_id,$user_id){

$req->validate([
    'asset'=>'required',
    'applicability' => ['required','array', 'min:1'],
    'asset_value'=>'required'
]);

    $my_filter = array_filter($req->input('applicability'));
    $req->merge(['applicability' => $my_filter]);

    $applicability = $req->input('applicability');

    $filtered_applicability=array_filter($applicability);

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



$asset=explode('+',$req->asset);



$grpcheck=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('name',$asset[1])->where('c_name',$req->component_name)
->first();



if($asset[0]=='name'){

    for ($i = 0; $i < count($yesNoArray); $i++) {
        Db::table('iso_sec_2_3_1')->insert([
            'project_id'=>$proj_id,
            'control_num'=>$numberArray[$i],
            'applicability'=>$yesNoArray[$i],
            'asset_type'=>$asset[0],
            'group_name'=>$grpcheck->g_name,
            'name'=>$asset[1],
            'component_name'=>$req->component_name,
            'asset_value'=>$req->asset_value,
            'last_edited_by'=>$user_id,
            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);

    }

//if name was selected, so all components in that name must be also same values
$check=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('name',$asset[1])
    ->where('g_name',$grpcheck->g_name)->where('c_name','!=',$req->component_name)
    ->pluck('c_name')->toArray();


for ($j= 0; $j < count($check); $j++) {

        for ($i = 0; $i < count($yesNoArray); $i++) {
            Db::table('iso_sec_2_3_1')->insert([
                'project_id'=>$proj_id,
                'control_num'=>$numberArray[$i],
                'applicability'=>$yesNoArray[$i],
                'asset_type'=>$asset[0],
                'group_name'=>$grpcheck->g_name,
                'name'=>$asset[1],
                'component_name'=>$check[$j],
                'asset_value'=>$req->asset_value,
                'last_edited_by'=>$user_id,
                'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
            ]);

            }



}

} //if name was selected as asset


if($asset[0]=='component'){
    //assuming for each project compnnet name is unique

    $grp=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('c_name',$req->component_name)->first();


    for ($i = 0; $i < count($yesNoArray); $i++) {
        Db::table('iso_sec_2_3_1')->insert([
            'project_id'=>$proj_id,
            'control_num'=>$numberArray[$i],
            'applicability'=>$yesNoArray[$i],
            'asset_type'=>$asset[0],
            'group_name'=>$grp->g_name,
            'name'=>$grp->name,
            'component_name'=>$req->component_name,
            'asset_value'=>$req->asset_value,
            'last_edited_by'=>$user_id,
            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);


    }


}//if component was selected


if($asset[0]=='group'){
    //assuming for each project compnnet name is unique

    $components=Db::table('iso_sec_2_1')->where('project_id',$proj_id)->where('g_name',$asset[1])->get(['c_name','name']);

    for($j=0; $j<count($components);$j++){

     for ($i = 0; $i < count($yesNoArray); $i++) {
        Db::table('iso_sec_2_3_1')->insert([
            'project_id'=>$proj_id,
            'control_num'=>$numberArray[$i],
            'applicability'=>$yesNoArray[$i],
            'asset_type'=>$asset[0],
            'group_name'=>$asset[1],
            'name'=>$components[$j]->name,
            'component_name'=>$components[$j]->c_name,
            'asset_value'=>$req->asset_value,
            'last_edited_by'=>$user_id,
            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);


    }


    }



}//if component was selected


return redirect()->route('iso_sec_2_3_1',['assessment_id'=>$req->assessment_id,'component_name'=>$req->component_name,
'proj_id'=>$proj_id,'user_id'=>$user_id])
->with('success','Record Added successfully');



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

    public function iso_sec_2_3_edit_asset_value(Request $req,$asset_id,$proj_id,$user_id){
       $req->validate([
        'edit_asset_value'=>'required'
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
                    Db::table('iso_sec_2_3')->where('asset_id',$asset_id)->where('project_id',$proj_id)
                    ->update([
                        'asset_value' => $req->edit_asset_value,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    return redirect()->route('iso_sec_2_3_edit', ['assessment_id' => $asset_id, 'proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('success', 'Asset value updated successfully.But now Edit the threat values for risk assessment with updated asset value');
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
