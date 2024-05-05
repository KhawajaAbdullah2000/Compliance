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
}
