<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class IsoSec2_3_1 extends Controller
{
    public function iso_sec_2_3_1($asset_id,$proj_id,$user_id){
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

                    $group=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)->first();
                    //dd($group->g_name);

                    $name=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$asset_id)
                    ->first();
                    //dd($names);

                    //assume a group willl have unique component names
                    $components=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('name',$name->name)
                    ->pluck('c_name');
                    //dd($components);



                        $filepath=public_path('ISO_SOA_A5.xlsx');
                        $sec2_4_a5_data = Excel::toArray([], $filepath); //with header
                        $sec2_4_a5_rows = array_slice($sec2_4_a5_data[0], 1); //without header(first row)


                    return view('iso_sec_2_3_1.iso_sec_2_3_1_main', [

                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'assets'=>$assets,
                        'group'=>$group->g_name,
                        'name'=>$name->name,
                        'components'=>$components,
                        'asset_id'=>$asset_id,
                        'sec2_4_a5_rows'=>$sec2_4_a5_rows

                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function iso_sec2_3_1_initial_add(Request $req,$proj_id,$user_id){
        $req->validate([
            'asset_value'=>'required',
            'asset'=>'required',
            'applicability' => ['required','array', 'min:1'],

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
        if($asset[0]=="group"){
            $group=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('assessment_id',$req->asset_id)->first();
            $components=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('g_name',$group->g_name)->get();

            foreach($components as $c){
                for ($i = 0; $i < count($yesNoArray); $i++) {

                $exists= Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$c->assessment_id)
                ->where('control_num',$numberArray[$i])->first();
                if(!$exists){
                  DB::table('iso_sec_2_3_1')->insert([
                      'project_id'=>$proj_id,
                      'asset_id'=>$c->assessment_id,
                      'asset_value'=>$req->asset_value,
                      'control_num'=>$numberArray[$i],
                      'applicability'=>$yesNoArray[$i],
                      'last_edited_by'=>$user_id,
                    'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                  ]);
                }
            }
              }
              return redirect()->route('iso_sec_2_3_1',['asset_id'=>$req->asset_id,'proj_id'=>$proj_id,
              'user_id'=>$user_id])->withSuccess('Record Added');

        }

        if($asset[0]=="name"){
            $components_to_add=DB::table('iso_sec_2_1')->where('project_id',$proj_id)->where('name',$asset[1])
            ->get();

            foreach($components_to_add as $c){

                for ($i = 0; $i < count($yesNoArray); $i++) {

              $exists= Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$c->assessment_id)
              ->where('control_num',$numberArray[$i])
              ->first();
              if(!$exists){
                DB::table('iso_sec_2_3_1')->insert([
                    'project_id'=>$proj_id,
                    'asset_id'=>$c->assessment_id,
                    'asset_value'=>$req->asset_value,
                    'control_num'=>$numberArray[$i],
                    'applicability'=>$yesNoArray[$i],
                    'last_edited_by'=>$user_id,
                  'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
                ]);
              }

            }


            }
            return redirect()->route('iso_sec_2_3_1',['asset_id'=>$req->asset_id,'proj_id'=>$proj_id,
            'user_id'=>$user_id])->withSuccess('Record Added');

        }

        if($asset[0]=="component"){

            for ($i = 0; $i < count($yesNoArray); $i++) {

            $exists=Db::table('iso_sec_2_3_1')->where('project_id',$proj_id)->where('asset_id',$req->asset_id)
            ->where('control_num',$numberArray[$i])->first();
            if(!$exists){
            DB::table('iso_sec_2_3_1')->insert([
                'project_id'=>$proj_id,
                'asset_id'=>$req->asset_id,
                'asset_value'=>$req->asset_value,
                'control_num'=>$numberArray[$i],
                'applicability'=>$yesNoArray[$i],
                'last_edited_by'=>$user_id,

               'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
            return redirect()->route('iso_sec_2_3_1',['asset_id'=>$req->asset_id,'proj_id'=>$proj_id,
            'user_id'=>$user_id])->withSuccess('Done!');

        }


    }
}
