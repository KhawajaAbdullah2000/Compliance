<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;



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

                    $data = DB::table('iso_sec_2_1')->join(
                        'users',
                        'iso_sec_2_1.last_edited_by',
                        'users.id'
                    )
                        ->where('project_id', $proj_id)->get();

                 $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();




                    $org_projects=Db::table('projects')->where('org_id',auth()->user()->org_id)
                    ->where('project_id','!=',$proj_id)->get();

                    $distinctServices= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.s_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.s_name')
                     // Ensures distinct s_name values
                    ->get();

                    $distinctGroups= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.g_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.g_name')
                    ->get();

                    $distinctAssets= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.name')
                    ->get();


                    $distinctComponents= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.c_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.c_name')
                    ->get();





                    return view('iso_sec_2_1.iso_sec_2_1_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project,
                        'org_projects'=>$org_projects,
                        'distinctServices'=>$distinctServices,
                        'distinctGroups'=>$distinctGroups,
                        'distinctAssets'=>$distinctAssets,
                        'distinctComponents'=>$distinctComponents
                    ]);

            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_section2_3($proj_id, $user_id)
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


                 $org_projects=Db::table('projects')->where('org_id',auth()->user()->org_id)
                 ->where('project_id','!=',$proj_id)->get();

                 $distinctServices= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.s_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.s_name')
                     // Ensures distinct s_name values
                    ->get();

                    $distinctGroups= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.g_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.g_name')
                    ->get();

                    $distinctAssets= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.name')
                    ->get();


                    $distinctComponents= DB::table('iso_sec_2_1')
                    ->join('users', 'iso_sec_2_1.last_edited_by', '=', 'users.id')
                    ->select('iso_sec_2_1.c_name')
                    ->where('iso_sec_2_1.project_id',$proj_id)
                    ->distinct('iso_sec_2_1.c_name')
                    ->get();


                    return view('iso_sec_2_1.iso_sec_2_3_main', [
                        'data' => $data,
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'project'=>$project,
                        'org_projects'=>$org_projects,
                        'distinctServices'=>$distinctServices,
                        'distinctGroups'=>$distinctGroups,
                        'distinctAssets'=>$distinctAssets,
                        'distinctComponents'=>$distinctComponents
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function risk_treatment($proj_id, $user_id)
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

                    return view('risk_treatment.serviceslist', [
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

    public function new_iso_sec_2_1(Request $req, $proj_id, $user_id)
    {
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

        $req->validate(
            [
               'g_name' => 'required',
                'name' => 'required',
               'c_name' => 'required',
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

                        try {
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




                        } catch (\Exception $e) {
                            $error=$e->getMessage();
                            if($e->getCode()==23000){
                 $error="Service,AssetGroup,Asset and COmponent name must be unique in a project";
                            }
                            return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('error', $error);

                        }


                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');

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

                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();


                        return view('iso_sec_2_1.iso_sec_2_1_new', [
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'project'=>$project
                        ]);

                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
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

                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();

                        return view('iso_sec_2_1.iso_sec_2_1_edit', [
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
    }

    public function iso_sec_2_1_submit_edit(Request $req, $assessment_id, $proj_id, $user_id)
    {

        $req->validate(
            [
               'g_name' => 'required',
                'name' => 'required',
               'c_name' => 'required',
                'owner_dept' => 'required|string',
                'physical_loc' => 'required|string',
                'logical_loc' => 'required|string',
                's_name' => 'required|string',
            ],
            [
                '*.required' => 'This field is required',

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


    public function download_asset_template(){
        $path=public_path("assets_template.xlsx");
        return response()->download($path);

    }

    public function upload_assets(Request $req,$proj_id,$user_id)  {
        $req->validate([
            'file' => 'required|mimes:xlsx,xls',
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

                        $file = $req->file('file');
                        $data = Excel::toArray([], $file);
                        $rows = array_slice($data[0], 1);

                        $g_name=[];
                        $name=[];
                        $c_name=[];
                        $owner_dept=[];
                        $physical_loc=[];
                        $logical_loc=[];
                        $s_name=[];
                        $error=null;



                        foreach($rows as $row){

                            if($row[0]!=null){
                                $s_name[]=$row[0];
                            }else{
                                $error="Service Name of an asset Missing";
                                break;
                            }

                            if($row[1]!=null){
                                $g_name[]=$row[1];
                            }else{
                                $error="Asset Group Name of an asset Missing";
                                break;
                            }

                            if($row[2]!=null){
                                $name[]=$row[2];
                            }else{
                                $error="Asset Name of an asset Missing";
                                break;
                            }


                            if($row[3]!=null){
                                $c_name[]=$row[3];
                            }else{
                                $error="Asset component name of an asset Missing";
                                break;
                            }

                            if($row[4]!=null){
                                $owner_dept[]=$row[4];
                            }else{
                                $error="Owner dept of an asset Missing";
                                break;
                            }

                            if($row[5]!=null){
                                $physical_loc[]=$row[5];
                            }else{
                                $error="Physical Location of an asset Missing";
                                break;
                            }

                            if($row[6]!=null){
                                $logical_loc[]=$row[6];
                            }else{
                                $error="Logical location of an asset Missing";
                                break;
                            }


                        }


                        if($error!=null){
                            return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('error', $error);
                        }

                        try {
                            for($i=0;$i<count($rows);$i++){
                                DB::table('iso_sec_2_1')->insert([
                                    'project_id'=>$proj_id,
                                    'g_name'=>$g_name[$i],
                                    'name'=>$name[$i],
                                    'c_name'=>$c_name[$i],
                                    'owner_dept'=>$owner_dept[$i],
                                    'physical_loc'=>$physical_loc[$i],
                                    'logical_loc'=>$logical_loc[$i],
                                    's_name'=>$s_name[$i],
                                    'last_edited_by'=>$user_id,
                                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                                ]);
                            }

                        } catch (\Exception $e) {

                            if($e->getCode()==23000){
                                $error="Each row must contain a unique combination of Asset Group Name,Name, and Component Name.All 3 cannot be same for multiple rows";
                            }else{
                                $error=$e->getCode();
                            }


                            return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('error', $error);
                        }


                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('success', 'Assets Uploaded Successfully');






                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }


    public function ShowServices(Request $req,$proj_id,$user_id){


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


                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();

                        $services = DB::table('iso_sec_2_1')
              ->where('project_id', $req->query('project_to_copy'))
              ->select('s_name')
              ->groupBy('s_name')
              ->get();

                        $project_to_copy=Project::where('project_id',$req->query('project_to_copy'))->first();


                        return view('iso_sec_2_1.services_to_copy',[
                            'services'=>$services,
                            'project'=>$project,
                            'project_to_copy'=>$project_to_copy

                        ]);



                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function ShowGroups($proj_id,$user_id,$proj_to_copy,$servicename){
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


                        $project=Project::join('project_types','projects.project_type','project_types.id')
                        ->where('projects.project_id',$proj_id)->first();

                        // $groups=Db::table('iso_sec_2_1')->where('project_id',$proj_to_copy)
                        // ->where('s_name',$servicename)
                        // ->distinct('g_name')->get();




                       $groups = DB::table('iso_sec_2_1')
           ->where('project_id', $proj_to_copy)->where('s_name',$servicename)
            ->select('g_name')
             ->groupBy('g_name')
              ->get();

                        $project_to_copy=Project::where('project_id',$proj_to_copy)->first();



                        return view('iso_sec_2_1.groups_to_copy',[
                            'groups'=>$groups,
                            'project'=>$project,
                            'project_to_copy'=>$project_to_copy,
                            'servicename'=>$servicename

                        ]);



                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function CopyGroups(Request $req,$proj_id,$user_id,$proj_to_copy,$servicename){
        $req->validate([
            'group_to_copy'=>'required'
        ],[
            'required'=>"Please select atleast one group"
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


                    $assets=Db::table('iso_sec_2_1')->where('project_id',$proj_to_copy)->where('s_name',$servicename)
                    ->whereIn('g_name',$req->group_to_copy)->get();

                    try {
                        foreach($assets as $ass){


                        Db::table('iso_sec_2_1')->insert([
                            'project_id' => $proj_id,
                            'g_name' => $ass->g_name,
                            'name' => $ass->name,
                            'c_name' => $ass->c_name,
                            'owner_dept' => $ass->owner_dept,
                            'physical_loc' => $ass->physical_loc,
                            'logical_loc' => $ass->logical_loc,
                            's_name' => $ass->s_name,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        }

                    } catch (\Exception $e) {
                        if($e->getCode()==23000){
                            $error="Each row must contain a unique combination of Service Name,Asset Group Name,Name, and Component Name.All 4 cannot be same in a project";
                        }else{
                            $error=$e->getCode();
                        }

                        return redirect()->route('iso_section2_1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                    ->with('error', $error);
                    }

                    return redirect()->route('iso_section2_1',[
                        'proj_id'=>$proj_id,
                        'user_id'=>$user_id
                    ])->with('success','Record Added successfully');




                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }



}
