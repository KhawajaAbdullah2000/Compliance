<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
class PCI_Single_Sheet extends Controller
{
    public function pci_single_sheet_subsections($proj_id,$user_id){
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

                if ($checkpermission->type_id == 1) {
                    $project=Project::join('project_types','projects.project_type','project_types.id')
                    ->where('projects.project_id',$proj_id)->first();

                    return view('pci_single_sheet.sec_2_2_subsections', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project'=>$project
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_section_2_2($title_num, $proj_id, $user_id){
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

                if ($checkpermission->type_id == 1) {
                    $filepath=public_path('PCI_DSS_4_Single_TSP.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)


                   $project=Project::join('project_types','projects.project_type','project_types.id')
                   ->where('projects.project_id',$proj_id)->first();

                   $filteredData = collect($data[0])->filter(function ($row) use ($title_num) {
                    return strval($row[0])=== $title_num;
                })->values()->all();


                    return view('pci_single_sheet.pci_sec_2_2_main', [
                    'project_id' => $checkpermission->project_id,
                   'project_name' => $checkpermission->project_name,
                   'project_permissions'=>$checkpermission->project_permissions,
                   'data'=>$filteredData,
                   'title'=>$title_num,
                   'project'=>$project
                     ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_sec_2_2_req($main_req_num,$title,$proj_id,$user_id){
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

                if ($checkpermission->type_id == 1) {


                    $filepath=public_path('PCI_DSS_4_Single_TSP.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)
                 //  dd($rows);

                 //  dd($data);
                   $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {

                    return strval($row[1])=== $main_req_num;
                })->values()->all();

                dd($filteredData);

                $project=Project::join('project_types','projects.project_type','project_types.id')
                ->where('projects.project_id',$proj_id)->first();

                    return view('iso_sec_2_2.iso_sec_2_2_sub_reqs', [
                    'project_id' => $checkpermission->project_id,
                   'project_name' => $checkpermission->project_name,
                   'project_permissions'=>$checkpermission->project_permissions,
                   'data'=>$filteredData,
                   'main_req_num'=>$main_req_num,
                   'title'=>$title,
                   'project'=>$project
                     ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
}

