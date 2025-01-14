<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplianceStatusExport;

class ComplianceMap extends Controller
{
    public function compliance_map_all_services($proj_id,$user_id){
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
            $project=Project::join('project_types','projects.project_type','project_types.id')
            ->where('projects.project_id',$proj_id)->first();
        
            $uniqueServices = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();

           if($project->project_type==7){
            //KSA NCA
            $results = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->select(
                'compliance.title_num AS Domain',
                'compliance.comp_status',
                DB::raw('COUNT(compliance.comp_status) AS status_count')
            )
            ->where('assets.project_id',$proj_id)
            ->groupBy('compliance.title_num','compliance.comp_status') // Group by service, component, and comp_status
            ->orderBy('compliance.title_num') // Optional: Order by service name
            ->get();

            $formattedResults = [];
            $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];
            
            foreach ($results as $result) {
                $domain = $result->Domain;
                $status = $result->comp_status;
                $count = $result->status_count;
            
                // Initialize domain
                if (!isset($formattedResults[$domain])) {
                    $formattedResults[$domain] = [];
                }

                if (!isset($formattedResults[$domain][$status])) {
                    $formattedResults[$domain][$status] =0;
                }
          
                // Add the count to the respective comp_status
                $formattedResults[$domain][$status] += $count;
            
                // Update the grand totals for each status
                $totalCounts[$status] += $count;
            }
               // Add the total for all rows
               $totalCounts['total'] = array_sum($totalCounts);
         

               return view('compliance_map.ksa_nca_all_services_all_controls',[
                'project'=>$project,
                'uniqueServices'=>$uniqueServices,
                'formattedResults'=>$formattedResults,
            ]);

           
           }

        }

    }

    public function download_excel_compliance_map($proj_id,$user_id){

         $results = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->select(
                'compliance.title_num AS Domain',
                'compliance.comp_status',
                DB::raw('COUNT(compliance.comp_status) AS status_count')
            )
            ->where('assets.project_id',$proj_id)
            ->groupBy('compliance.title_num','compliance.comp_status') // Group by service, component, and comp_status
            ->orderBy('compliance.title_num') // Optional: Order by service name
            ->get();

      $formattedResults = [];
      $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];
      
      foreach ($results as $result) {
        $domain = $result->Domain;
        $status = $result->comp_status;
        $count = $result->status_count;
    
        // Initialize domain
        if (!isset($formattedResults[$domain])) {
            $formattedResults[$domain] = [];
        }

        if (!isset($formattedResults[$domain][$status])) {
            $formattedResults[$domain][$status] =0;
        }
  
        // Add the count to the respective comp_status
        $formattedResults[$domain][$status] += $count;
    
        // Update the grand totals for each status
        $totalCounts[$status] += $count;
    }
       // Add the total for all rows
       $totalCounts['total'] = array_sum($totalCounts);

       $project=Project::join('project_types','projects.project_type','project_types.id')
       ->where('projects.project_id',$proj_id)->first();
   
      if($project->project_type==7){
        $domainNames = [
            1 => 'Cybersecurity Governance',
            2 => 'Cybersecurity Defense',
            3 => 'Cybersecurity Resilience',
            4 => 'Third-Party and Cloud Computing Cybersecurity',
            5 => 'Industrial Control Systems Cybersecurity',
        ];
      }
      else{
        $domainNames=[];
      }

       
$projectName=$project->project_name;
   
         return Excel::download(
            new ComplianceStatusExport($formattedResults, $totalCounts,$domainNames),
            $projectName.'_compliance_map.xlsx'
        );
    }
}
