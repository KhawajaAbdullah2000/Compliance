<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\Exports\ReportDataExport;
use App\Exports\RiskAssessmentExport;
use App\Exports\RiskTreatmentReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class ProjectController extends Controller
{
    public function assigned_projects($user_id)
    {
        $projects = Project::join('project_details', 'projects.project_id', 'project_details.project_code')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->where('project_details.assigned_enduser', $user_id)->latest('projects.project_creation_date')
            ->get(
                [
                    'project_details.project_code',
                    'projects.project_name',
                    'project_types.type',
                    'project_types.id as type_id',
                    'projects.status',
                    'project_details.project_permissions'

                ]
            );
        return view('assigned_projects.my_projects', ['projects' => $projects]);
    }

    //go to subsections of section 1 for v3_2
    public function v_3_2_section1_subsections($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
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
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 2) {
                    return view(
                        'assigned_projects.v_3_2_section1_subsections',
                        ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name]
                    );
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    //ISO
    public function iso_sections(Request $req, $proj_id, $user_id)
    {

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
            $permissions = json_decode($checkpermission->project_permissions);
            if ($checkpermission->type_id == 4) {

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    'iso.iso_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            }

            //pci single sheet
            elseif ($checkpermission->type_id == 1) {
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    '.pci_single_sheet.main_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            } elseif ($checkpermission->type_id == 2) {
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    '.pci_multi_sheet.main_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            } elseif ($checkpermission->type_id == 3) {
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    '.pci_merchant_sheet.main_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            } elseif ($checkpermission->type_id == 5) {
                //Cybersecurity SAMA
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    '.CY_SAMA.main_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            } elseif ($checkpermission->type_id == 6) {
                //SBP ETGRMF
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    '.SBP_ETGRMF.main_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            } elseif ($checkpermission->type_id == 7) {
                //KSA NCA ECC
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                return view(
                    '.KSA_NCA.main_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name, 'project' => $project]
                );
            }





        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }


    public function dashBoard($proj_id, $user_id)
    {

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $groupsPerService = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->select('s_name', DB::raw('count(distinct g_name) as unique_groups_count'))
            ->groupBy('s_name')
            ->get();


        $componentsPerGroup = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->select('g_name', DB::raw('count(distinct c_name) as unique_components_count'))
            ->groupBy('g_name')
            ->get();

        //    $mandatory_requirements_submitted=DB::table('iso_sec_2_2')->where('project_id',$proj_id)->get()->count();
        //    $mandatory_requirements_left=120-$mandatory_requirements_submitted;


        $mandatory_controls = DB::table('iso_sec_2_2')->where('project_id', $proj_id)
            ->select('comp_status', DB::raw('count(*) as total'))
            ->whereIn('comp_status', ['yes', 'no', 'partial'])
            ->groupBy('comp_status')
            ->get();


        if ($project->project_type == 4) {

            $applicability = DB::table('iso_sec_2_3_1')->where('project_id', $proj_id)
                ->select('applicability', DB::raw('count(*) as total'))
                ->whereIn('applicability', ['yes', 'no'])
                ->groupBy('applicability')
                ->get();






            return view('dashboard.main', [
                'project' => $project,
                'groupsPerService' => $groupsPerService,
                'componentsPerGroup' => $componentsPerGroup,
                'mandatory_controls' => $mandatory_controls,
                'applicability' => $applicability
            ]);
        } else {
            return view('dashboard.main', [
                'project' => $project,
                'groupsPerService' => $groupsPerService,
                'componentsPerGroup' => $componentsPerGroup,
                'mandatory_controls' => $mandatory_controls
            ]);
        }
    }

    public function risk_compliance_heatmap($proj_id,$user_id){

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

        $total=Db::table('iso_sec_2_2')->where('project_id',$proj_id)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();


     $yesCount= DB::table('iso_sec_2_2')->where('project_id',$proj_id)->where('comp_status','yes')->count();
      $noCount= DB::table('iso_sec_2_2')->where('project_id',$proj_id)->where('comp_status','no')->count();
      $partialCount= DB::table('iso_sec_2_2')->where('project_id',$proj_id)->where('comp_status','partial')->count();
      $actionPlanCount= DB::table('iso_sec_2_2')->where('project_id',$proj_id)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();

      $distinctServiceCount = DB::table('iso_sec_2_1')
      ->where('project_id',$proj_id)
    ->distinct()
    ->count('s_name');

    $distinctGroupCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->distinct()
    ->count('g_name');

    $distinctNameCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->distinct()
    ->count('name');

    $distinctComponentCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->distinct()
    ->count('c_name');


    $partialPlanTotal= Db::table('iso_sec_2_2')->where('project_id',$proj_id)
    ->where('comp_status','!=','yes')
    ->where('comp_status','!=','not_applicable')
    ->where('comp_status','!=','not_tested')
    ->count();

    $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

     $serviceOrderRiskConfidentiality = DB::table('iso_sec_2_3_1 as sec_2_3_1')
     ->join('iso_sec_2_1 as sec_2_1', function ($join) {
         $join->on('sec_2_3_1.project_id', '=', 'sec_2_1.project_id')
              ->on('sec_2_3_1.asset_id', '=', 'sec_2_1.assessment_id'); // Adjust column names if necessary
     })
     ->where('sec_2_3_1.project_id', $proj_id) // Filter by specific project
     ->groupBy('sec_2_1.s_name') // Group by service name
     ->select('sec_2_1.s_name', DB::raw('SUM(sec_2_3_1.risk_level) as total_risk_level'))
     ->orderby('total_risk_level','desc')
     ->get();

     $serviceOrderRiskIntegrity = DB::table('iso_sec_2_3_1 as sec_2_3_1')
     ->join('iso_sec_2_1 as sec_2_1', function ($join) {
         $join->on('sec_2_3_1.project_id', '=', 'sec_2_1.project_id')
              ->on('sec_2_3_1.asset_id', '=', 'sec_2_1.assessment_id'); // Adjust column names if necessary
     })
     ->where('sec_2_3_1.project_id', $proj_id) // Filter by specific project
     ->groupBy('sec_2_1.s_name') // Group by service name
     ->select('sec_2_1.s_name', DB::raw('SUM(sec_2_3_1.risk_integrity) as total_risk_level'))
     ->orderby('total_risk_level','desc')
     ->get();

     $serviceOrderRiskAvailability = DB::table('iso_sec_2_3_1 as sec_2_3_1')
     ->join('iso_sec_2_1 as sec_2_1', function ($join) {
         $join->on('sec_2_3_1.project_id', '=', 'sec_2_1.project_id')
              ->on('sec_2_3_1.asset_id', '=', 'sec_2_1.assessment_id'); // Adjust column names if necessary
     })
     ->where('sec_2_3_1.project_id', $proj_id) // Filter by specific project
     ->groupBy('sec_2_1.s_name') // Group by service name
     ->select('sec_2_1.s_name', DB::raw('SUM(sec_2_3_1.risk_availability) as total_risk_level'))
     ->orderby('total_risk_level','desc')
     ->get();



     $yes=$total>0 ? ($yesCount/$total)*100:0;
     $no=$total>0 ? ($noCount/$total)*100:0;
     $partial=$total>0 ? ($partialCount/$total)*100:0;




    return view('risk_compliance_heatmap.heatmap',[
        'yesCount'=>$yes,
        'noCount'=>$no,
        'partialCount'=>$partial,
        'actionPlanCount'=>$action,
        'distinctServiceCount'=>$distinctServiceCount,
        'distinctGroupCount'=>$distinctGroupCount,
        'distinctNameCount'=>$distinctNameCount,
        'distinctComponentCount'=>$distinctComponentCount,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        'serviceOrderRiskConfidentiality'=>$serviceOrderRiskConfidentiality,
        'serviceOrderRiskIntegrity'=>$serviceOrderRiskIntegrity,
        'serviceOrderRiskAvailability'=>$serviceOrderRiskAvailability


    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

      


   
    }

    public function risk_compliance_service_heatmap($proj_id,$s_name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name) ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name) ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name) ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();




    $distinctGroupCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->distinct()
    ->count('g_name');

    $distinctNameCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->distinct()
    ->count('name');

    $distinctComponentCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->distinct()
    ->count('c_name');


 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
     ->where('comp_status','!=','yes')
     ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  







    return view('risk_compliance_heatmap.heatmap_for_service',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'distinctGroupCount'=>$distinctGroupCount,
        'distinctNameCount'=>$distinctNameCount,
        'distinctComponentCount'=>$distinctComponentCount,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
     
        's_name'=>$s_name


    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

      



    }

    public function risk_compliance_heatmap_from_asset_group($proj_id,$s_name,$g_name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('iso_sec_2_1.g_name',$g_name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
      ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name)
      ->where('iso_sec_2_1.g_name',$g_name)
      ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();





    $distinctNameCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('g_name',$g_name)
    ->distinct()
    ->count('name');

    $distinctComponentCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('g_name',$g_name)
    ->distinct()
    ->count('c_name');


 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
 ->where('g_name',$g_name)
     ->where('comp_status','!=','yes')
     ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name)
                ->where('iso1.g_name',$g_name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name)
            ->where('iso1.g_name',$g_name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name)
         ->where('iso1.g_name',$g_name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  



    return view('risk_compliance_heatmap.heatmap_from_asset_group',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'distinctNameCount'=>$distinctNameCount,
        'distinctComponentCount'=>$distinctComponentCount,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        's_name'=>$s_name,
        'g_name'=>$g_name


    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

      
    }

    public function risk_compliance_heatmap_by_asset_from_asset_group($proj_id,$s_name,$g_name,$name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('iso_sec_2_1.g_name',$g_name)
        ->where('iso_sec_2_1.name',$name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('iso_sec_2_1.name',$name)
      ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name)
      ->where('iso_sec_2_1.g_name',$g_name)
      ->where('iso_sec_2_1.name',$name)
      ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('iso_sec_2_1.name',$name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();




    $distinctComponentCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('g_name',$g_name)
    ->where('name',$name)
    ->distinct()
    ->count('c_name');


 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
 ->where('g_name',$g_name)
 ->where('name',$name)
     ->where('comp_status','!=','yes')
     ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name)
                ->where('iso1.g_name',$g_name)
                ->where('iso1.name',$name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name)
            ->where('iso1.g_name',$g_name)
            ->where('iso1.name',$name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name)
         ->where('iso1.g_name',$g_name)
         ->where('iso1.name',$name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  



    return view('risk_compliance_heatmap.heatmap_by_asset_from_asset_group',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'distinctComponentCount'=>$distinctComponentCount,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        's_name'=>$s_name,
        'g_name'=>$g_name,
        'name'=>$name


    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

    }

    public function risk_compliance_heatmap_for_asset_component_by_asset($proj_id,$s_name,$g_name,$name,$c_name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('iso_sec_2_1.g_name',$g_name)
        ->where('iso_sec_2_1.name',$name)
        ->where('iso_sec_2_1.c_name',$c_name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('iso_sec_2_1.c_name',$c_name)
      ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name)
      ->where('iso_sec_2_1.g_name',$g_name)
      ->where('iso_sec_2_1.name',$name)
      ->where('iso_sec_2_1.c_name',$c_name)
      ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('iso_sec_2_1.c_name',$c_name)
     ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.g_name',$g_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('iso_sec_2_1.c_name',$c_name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();




 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
 ->where('g_name',$g_name)
 ->where('name',$name)
 ->where('c_name',$c_name)
 ->where('comp_status','!=','yes')
 ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name)
                ->where('iso1.g_name',$g_name)
                ->where('iso1.name',$name)
                ->where('iso1.c_name',$c_name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name)
            ->where('iso1.g_name',$g_name)
            ->where('iso1.name',$name)
            ->where('iso1.c_name',$c_name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name)
         ->where('iso1.g_name',$g_name)
         ->where('iso1.name',$name)
         ->where('iso1.c_name',$c_name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  



    return view('risk_compliance_heatmap.heatmap_by_asset_component_from_asset',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        's_name'=>$s_name,
        'g_name'=>$g_name,
        'name'=>$name,
        'c_name'=>$c_name


    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

    }

    public function risk_compliance_heatmap_by_service_and_asset($proj_id,$s_name,$name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('iso_sec_2_1.name',$name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.name',$name)
      ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name)
      ->where('iso_sec_2_1.name',$name)
      ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.name',$name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();




 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
 ->where('name',$name)
 ->where('comp_status','!=','yes')
 ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();

    $distinctGroupCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('name',$name)
    ->distinct()
    ->count('g_name');

    $distinctComponentCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('name',$name)
    ->distinct()
    ->count('c_name');


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name)
                ->where('iso1.name',$name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name)
            ->where('iso1.name',$name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name)
         ->where('iso1.name',$name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  



    return view('risk_compliance_heatmap.heatmap_by_service_and_asset',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        's_name'=>$s_name,
        'name'=>$name,
        'distinctComponentCount'=>$distinctComponentCount,
        'distinctGroupCount'=>$distinctGroupCount

    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

    }

    public function risk_compliance_heatmap_by_service_asset_component($proj_id,$s_name,$name,$c_name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('iso_sec_2_1.name',$name)
        ->where('iso_sec_2_1.c_name',$c_name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('iso_sec_2_1.c_name',$c_name)
      ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name)
      ->where('iso_sec_2_1.name',$name)
      ->where('iso_sec_2_1.c_name',$c_name)
      ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('iso_sec_2_1.c_name',$c_name)
     ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.name',$name)
     ->where('iso_sec_2_1.c_name',$c_name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();




 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
 ->where('name',$name)
 ->where('c_name',$c_name)
 ->where('comp_status','!=','yes')
 ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();

    $distinctGroupCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('name',$name)
    ->where('c_name',$c_name)
    ->distinct()
    ->count('g_name');


    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name)
                ->where('iso1.name',$name)
                ->where('iso1.c_name',$c_name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name)
            ->where('iso1.name',$name)
            ->where('iso1.c_name',$c_name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name)
         ->where('iso1.name',$name)
         ->where('iso1.c_name',$c_name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  



    return view('risk_compliance_heatmap.heatmap_by_service_and_asset_and_component',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        's_name'=>$s_name,
        'name'=>$name,
        'c_name'=>$c_name,
        'distinctGroupCount'=>$distinctGroupCount

    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

    }

    public function risk_compliance_heatmap_by_service_and_component($proj_id,$s_name,$c_name,$user_id){
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

        $total=Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
        ->where('iso_sec_2_2.project_id',$proj_id)
        ->where('iso_sec_2_1.s_name',$s_name)
        ->where('iso_sec_2_1.c_name',$c_name)
        ->where('comp_status','!=','not_applicable')
        ->where('comp_status','!=','not_tested')
        ->count();



     $yesCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.c_name',$c_name)
      ->where('comp_status','yes')->count();

     

      $noCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
      ->where('iso_sec_2_2.project_id',$proj_id)
      ->where('iso_sec_2_1.s_name',$s_name)
      ->where('iso_sec_2_1.c_name',$c_name)
      ->where('comp_status','no')->count();

      $partialCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.c_name',$c_name)
     ->where('comp_status','partial')->count();

      $actionPlanCount= DB::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
     ->where('iso_sec_2_2.project_id',$proj_id)
     ->where('iso_sec_2_1.s_name',$s_name)
     ->where('iso_sec_2_1.c_name',$c_name)
      ->whereIn('comp_status', ['no', 'partial'])
      ->whereNotNull('treatment_target_date')
      ->count();




 $partialPlanTotal= Db::table('iso_sec_2_2')->join('iso_sec_2_1','iso_sec_2_1.assessment_id','iso_sec_2_2.asset_id')
 ->where('iso_sec_2_2.project_id',$proj_id)
 ->where('s_name',$s_name)
 ->where('c_name',$c_name)
 ->where('comp_status','!=','yes')
 ->count();

     $action = $partialPlanTotal != 0 ? ($actionPlanCount / $partialPlanTotal) * 100 : 0;


    
    $project=Project::join('project_types','projects.project_type','project_types.id')
    ->where('projects.project_id',$proj_id)->first();

    $distinctGroupCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('c_name',$c_name)
    ->distinct()
    ->count('g_name');

    $distinctAssetCount = DB::table('iso_sec_2_1')
    ->where('project_id',$proj_id)
    ->where('s_name',$s_name)
    ->where('c_name',$c_name)
    ->distinct()
    ->count('name');



    //For heaptmap data confidentiality
    $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id)
                ->where('iso1.s_name',$s_name)
                ->where('iso1.c_name',$c_name);

            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            $query->addSelect( 'iso2.risk_level');

            $iso_risk_results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotDataRiskConfidentiality = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $iso_risk_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //for Data integrity
            $query = DB::table('iso_sec_2_1 as iso1')
            ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
            ->where('iso1.project_id', $proj_id)
            ->where('iso1.s_name',$s_name)
            ->where('iso1.c_name',$c_name);

        $query->select(
            'iso1.s_name',
            'iso1.g_name',
            'iso1.name',
            'iso1.c_name',
            'iso2.control_num',
            'iso2.applicability',
            'iso2.vulnerability',
            'iso2.threat',
            
        );

        $query->addSelect( 'iso2.risk_integrity');

        $iso_risk_integrity_results = $query->orderBy('iso2.control_num', 'asc')
            ->get();
         
          
        $scatterPlotDataRiskIntegrity = [
            // x = Vulnerability, y = Threat, r = Risk Count (point size)
            ['x' => 1, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
            ['x' => 1, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
            ['x' => 1, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

            ['x' => 2, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
            ['x' => 2, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
            ['x' => 2, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

            ['x' => 3, 'y' => 1, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
            ['x' => 3, 'y' => 2, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
            ['x' => 3, 'y' => 3, 'r' => $iso_risk_integrity_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
        ];

         //for Data Availability
         $query = DB::table('iso_sec_2_1 as iso1')
         ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
         ->where('iso1.project_id', $proj_id)
         ->where('iso1.s_name',$s_name)
         ->where('iso1.c_name',$c_name);

     $query->select(
         'iso1.s_name',
         'iso1.g_name',
         'iso1.name',
         'iso1.c_name',
         'iso2.control_num',
         'iso2.applicability',
         'iso2.vulnerability',
         'iso2.threat',
         
     );

     $query->addSelect( 'iso2.risk_availability');

     $iso_risk_availability_results = $query->orderBy('iso2.control_num', 'asc')
         ->get();
      
       
     $scatterPlotDataRiskAvailability = [
         // x = Vulnerability, y = Threat, r = Risk Count (point size)
         ['x' => 1, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
         ['x' => 1, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
         ['x' => 1, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

         ['x' => 2, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
         ['x' => 2, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
         ['x' => 2, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

         ['x' => 3, 'y' => 1, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
         ['x' => 3, 'y' => 2, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
         ['x' => 3, 'y' => 3, 'r' => $iso_risk_availability_results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
     ];

    

  



    return view('risk_compliance_heatmap.heatmap_by_service_and_component',[
        'yesCount'=>(($yesCount)/$total)*100,
        'noCount'=>(($noCount)/$total)*100,
        'partialCount'=>(($partialCount)/$total)*100,
        'actionPlanCount'=>$action,
        'project'=>$project,
        'scatterPlotDataRiskConfidentiality'=>$scatterPlotDataRiskConfidentiality,
        'scatterPlotDataRiskIntegrity'=>$scatterPlotDataRiskIntegrity,
        'scatterPlotDataRiskAvailability'=>$scatterPlotDataRiskAvailability,
        's_name'=>$s_name,
        'c_name'=>$c_name,
        'distinctGroupCount'=>$distinctGroupCount,
        'distinctAssetCount'=>$distinctAssetCount

    ]);


        }

        return redirect()->route('assigned_projects', ['user_id' => $user_id]);

    }


    //Report 
    public function compliance_status($proj_id,$user_id,Request $req){
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

    $selectedServices = $req->input('services', []);

    if($req->input('services')){
 
      $results = DB::table('iso_sec_2_1 AS services')
      ->join('iso_sec_2_2 AS compliance', 'services.assessment_id', '=', 'compliance.asset_id')
      ->select(
          'services.s_name AS service_name',
          'services.c_name AS component_name',
          'compliance.comp_status',
          DB::raw('COUNT(compliance.comp_status) AS status_count')
      )
      ->where('services.project_id',$proj_id)
      ->whereIn('services.s_name', $selectedServices) // Filter by selected services
      ->groupBy('services.s_name', 'services.c_name', 'compliance.comp_status') // Group by service, component, and comp_status
      ->orderBy('services.s_name') // Optional: Order by service name
      ->get();

      $formattedResults = [];
      $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];
      
      foreach ($results as $result) {
          $service = $result->service_name;
          $component = $result->component_name;
          $status = $result->comp_status;
          $count = $result->status_count;
      
          // Initialize service and component in formattedResults
          if (!isset($formattedResults[$service])) {
              $formattedResults[$service] = [];
          }
      
          if (!isset($formattedResults[$service][$component])) {
              $formattedResults[$service][$component] = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0, 'total' => 0];
          }
      
          // Add the count to the respective comp_status
          $formattedResults[$service][$component][$status] += $count;
      
          // Update the total for the component
          $formattedResults[$service][$component]['total'] += $count;
      
          // Update the grand totals for each status
          $totalCounts[$status] += $count;
      }
         // Add the total for all rows
         $totalCounts['total'] = array_sum($totalCounts);
      
   
    return view('reports.compliance_status',[
        'project'=>$project,
        'uniqueServices'=>$uniqueServices,
        'formattedResults'=>$formattedResults,
        'selectedServices'=>$selectedServices
    ]);

}


    return view('reports.compliance_status',[
        'project'=>$project,
        'uniqueServices'=>$uniqueServices,
        'selectedServices'=>$selectedServices
    ]);

        }
    
    }



    public function drill_down_by_service($proj_id,$user_id){
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

$complianceData = [];

foreach ($uniqueServices as $service) {
    $sName = $service->s_name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('s_name', $sName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'service_name' => $sName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_service',[
        'project'=>$project,
        'complianceData'=>$complianceData
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }


    }

    public function drill_down_by_asset_group($proj_id,$s_name,$user_id){
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

    $uniqueGroups = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
    ->where('s_name',$s_name) //for drill down by asset group
    ->select('g_name')
    ->distinct()
    ->get();

$complianceData = [];

foreach ($uniqueGroups as $group) {
    $gName = $group->g_name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('g_name', $gName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'group_name' => $gName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_asset_group',[
        'project'=>$project,
        'complianceData'=>$complianceData,
        'service_name'=>$s_name
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }



    }

    
    public function drill_down_by_asset($proj_id,$s_name,$user_id){
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

    $uniqueNames = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
    ->where('s_name',$s_name) //for drill down by asset from services
    ->select('name')
    ->distinct()
    ->get();

$complianceData = [];

foreach ($uniqueNames as $name) {
    $nName = $name->name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('g_name', $nName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'asset_name' => $nName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_asset',[
        'project'=>$project,
        'complianceData'=>$complianceData,
        'service_name'=>$s_name
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }



    }

    public function drill_down_by_asset_component($proj_id,$s_name,$user_id){
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

    $uniqueComponents = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
    ->where('s_name',$s_name) //for drill down by asset from services
    ->select('c_name')
    ->distinct()
    ->get();

$complianceData = [];

foreach ($uniqueComponents as $cname) {
    $cName = $cname->c_name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('g_name', $cName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'component_name' => $cName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_asset_component',[
        'project'=>$project,
        'complianceData'=>$complianceData,
        'service_name'=>$s_name
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }



    }


    public function drill_down_by_asset_from_asset_group($proj_id,$s_name,$g_name,$user_id){
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

    $uniqueNames = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
    ->where('s_name',$s_name) 
    ->where('g_name',$g_name)//dril down  y asset group from service so need service as well here
    ->select('name')
    ->distinct()
    ->get();

$complianceData = [];

foreach ($uniqueNames as $name) {
    $nName = $name->name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('g_name', $nName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'asset_name' => $nName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_asset_from_asset_group',[
        'project'=>$project,
        'complianceData'=>$complianceData,
        'service_name'=>$s_name,
        'group_name'=>$g_name
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }


    }

    public function drill_down_by_asset_component_from_asset($proj_id,$s_name,$g_name,$name,$user_id){
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

    $uniqueComponents = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
    ->where('s_name',$s_name)
    ->where('g_name',$g_name)
    ->where('name',$name)
    ->select('c_name')
    ->distinct()
    ->get();

$complianceData = [];

foreach ($uniqueComponents as $cname) {
    $cName = $cname->c_name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('g_name', $cName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'component_name' => $cName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_asset_component_from_asset',[
        'project'=>$project,
        'complianceData'=>$complianceData,
        'service_name'=>$s_name,
        'group_name'=>$g_name,
        'name'=>$name
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }


    }

    public function drill_down_by_asset_component_from_service_from_asset($proj_id,$s_name,$name,$user_id){
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

    $uniqueComponents = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
    ->where('s_name',$s_name)
    ->where('name',$name)
    ->select('c_name')
    ->distinct()
    ->get();

$complianceData = [];

foreach ($uniqueComponents as $cname) {
    $cName = $cname->c_name;

    // Get all asset_ids associated with this service (s_name)
    $assetIds =DB::table('iso_sec_2_1')->where('project_id',$proj_id)
    ->where('g_name', $cName)
        ->pluck('assessment_id')
        ->toArray();
 

    // Count compliance controls where comp_status == 'yes'
    $complianceCount = DB::table('iso_sec_2_2')->whereIn('asset_id', $assetIds)
        ->where('comp_status', 'yes')
        ->count();

    
     

    // Total number of records for the service in iso_sec_2_2
    $totalRecords =  DB::table('iso_sec_2_2')->where('project_id', $proj_id)
                         ->whereIn('asset_id', $assetIds)->count();

    // Calculate percentage
    $percentage = $totalRecords > 0 ? ($complianceCount / $totalRecords) * 100 : 0;

    $totalDataConfidentiality = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_level');

    $totalDataIntegrity = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_integrity');

    $totalDataAvailability = DB::table('iso_sec_2_3_1')->whereIn('asset_id', $assetIds)
    ->sum('risk_availability');

    $complianceData[] = [
        'component_name' => $cName,
        'compliance_count' => $complianceCount,
        'total_records' => $totalRecords,
        'percentage' => $percentage,
        'totalDataConfidentiality'=>$totalDataConfidentiality,
        'totalDataIntegrity'=>$totalDataIntegrity,
        'totalDataAvailability'=>$totalDataAvailability
    ];

}

    return view('risk_compliance_heatmap.drill_down_by_asset_component_from_service_from_asset',[
        'project'=>$project,
        'complianceData'=>$complianceData,
        'service_name'=>$s_name,
        'name'=>$name
    ]);




        }else{
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);

        }

    }

    public function my_personal_dashboard($user_id)
    {


        // $project=Project::join('project_types','projects.project_type','project_types.id')
        // ->where('projects.project_id',$proj_id)->first();

        $user = Db::table('users')->where('id', $user_id)->first();

        $projectsCreatedCount = DB::table('projects')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->where('created_by', $user_id)
            ->select('project_types.type', DB::raw('count(*) as total'))
            ->groupBy('project_types.type')
            ->get();

        $permissionsInaProjectCount = DB::table('projects')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->join('project_details', 'projects.project_id', '=', 'project_details.project_code')
            ->where('assigned_enduser', $user_id)
            ->select('project_types.type', DB::raw('count(*) as total'))
            ->groupBy('project_types.type', 'project_details.assigned_enduser')
            ->get();
        // dd($permissionsInaProjectCount);
        // dd($projectsCreatedCount);

        $projectsCreatedByMeByStatus = DB::table('projects')
            ->select('projects.status', DB::raw('count(*) as total'))
            ->where('created_by', $user_id)
            ->groupBy('projects.status')
            ->get();

        $projectsAssignedByStatus = DB::table('projects')
            ->join('project_details', 'projects.project_id', '=', 'project_details.project_code')
            ->where('assigned_enduser', $user_id)
            ->select('projects.status', DB::raw('count(*) as total'))
            ->groupBy('projects.status')
            ->get();

        $projectsAndStatusBarChart = DB::table('projects')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->select('project_types.type', 'projects.status', DB::raw('COUNT(*) as project_count'))
            ->where('projects.org_id', $user->org_id)
            ->groupBy('project_types.type', 'projects.status')
            ->where('project_types.type', '=', 'ISO 27001:2022')
            ->get();

        $projectsAndStatusBarChart2 = DB::table('projects')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->select('project_types.type', 'projects.status', DB::raw('COUNT(*) as project_count'))
            ->where('projects.org_id', $user->org_id)
            ->groupBy('project_types.type', 'projects.status')
            ->where('project_types.type', '=', 'PCI-DSS v4-Single-Tenant Service Provider (stSP)')
            ->get();





        return view('dashboard.my_personal_dashboard', [
            'projectsCreatedCount' => $projectsCreatedCount,
            'permissionsInaProjectCount' => $permissionsInaProjectCount,
            'projectsCreatedByMeByStatus' => $projectsCreatedByMeByStatus,
            'projectsAssignedByStatus' => $projectsAssignedByStatus,
            'projectsAndStatusBarChart' => $projectsAndStatusBarChart,
            'projectsAndStatusBarChart2' => $projectsAndStatusBarChart2
        ]);
    }



    public function ai_wizard($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            if ($project) {

                $user = Db::table('users')->where('id', $user_id)->first();

                $servicesInProject = DB::table('projects')
                    ->where('projects.project_id', $proj_id)
                    ->join('iso_sec_2_1', 'projects.project_id', '=', 'iso_sec_2_1.project_id')
                    ->select('projects.project_name', 'projects.project_id', DB::raw('COUNT(DISTINCT iso_sec_2_1.s_name) as services'))
                    ->groupBy('projects.project_id', 'projects.project_name')
                    ->get();


                $project_date = Db::table('projects')->where('project_id', $proj_id)->first();

                return view('dashboard.ai_wizard', [
                    'project' => $project,
                    'servicesInProjects' => $servicesInProject,
                    'project_date' => $project_date->project_creation_date
                ]);
            } else {
                //Prject not found
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
                // return view('dashboard.ai_wizard',[
                //     'project'=>$project

                // ]);

            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function dashboard_services_and_components($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            if ($project) {
                $results = DB::table('iso_sec_2_1')
                    ->select('project_id', 's_name', DB::raw('COUNT(DISTINCT c_name) as component_count'))
                    ->where('project_id', $proj_id)
                    ->groupBy('s_name', 'project_id')
                    ->get();


                return view('dashboard.components_in_services', [
                    'project_id' => $proj_id,
                    'project' => $project,
                    'results' => $results
                ]);
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        }
    }

    public function services_controls_dashboard($proj_id, $user_id, $s_name)
    {
        if ($user_id == auth()->user()->id) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            if ($project) {
                $resultsConfidentiality = DB::table('iso_sec_2_3_1 as risk_assessment')
                    ->join('iso_sec_2_1 as components', 'risk_assessment.asset_id', '=', 'components.assessment_id')
                    ->select(
                        DB::raw('
                        CASE
                            WHEN risk_assessment.risk_level BETWEEN 0.000 AND 0.99999 THEN "Low"
                            WHEN risk_assessment.risk_level BETWEEN 1.000 AND 7.2000 THEN "Medium"
                            WHEN risk_assessment.risk_level BETWEEN 7.3 AND 10.000 THEN "High"
                            ELSE "Unknown"
                        END as risk_category'),
                        DB::raw('LEFT(risk_assessment.control_num, 1) as control_number_start'),
                        DB::raw('COUNT(*) as total_controls')
                    )
                    ->where('components.project_id', $proj_id)
                    ->where('components.s_name', $s_name)
                    ->groupBy('control_number_start', 'risk_category')
                    ->orderBy('control_number_start')
                    ->get();

                $resultsIntegrity = DB::table('iso_sec_2_3_1 as risk_assessment')
                    ->join('iso_sec_2_1 as components', 'risk_assessment.asset_id', '=', 'components.assessment_id')
                    ->select(
                        DB::raw('
                        CASE
                            WHEN risk_assessment.risk_integrity BETWEEN 0.000 AND 0.99999 THEN "Low"
                            WHEN risk_assessment.risk_integrity BETWEEN 1.000 AND 7.2999 THEN "Medium"
                            WHEN risk_assessment.risk_integrity BETWEEN 7.300 AND 10.000 THEN "High"
                            ELSE "Unknown"
                        END as risk_category'),
                        DB::raw('LEFT(risk_assessment.control_num, 1) as control_number_start'),
                        DB::raw('COUNT(*) as total_controls')
                    )
                    ->where('components.project_id', $proj_id)
                    ->where('components.s_name', $s_name)
                    ->groupBy('control_number_start', 'risk_category')
                    ->orderBy('control_number_start')
                    ->get();

                $resultsAvailability = DB::table('iso_sec_2_3_1 as risk_assessment')
                    ->join('iso_sec_2_1 as components', 'risk_assessment.asset_id', '=', 'components.assessment_id')
                    ->select(
                        DB::raw('
                        CASE
                            WHEN risk_assessment.risk_availability BETWEEN 0.000 AND 0.99999 THEN "Low"
                            WHEN risk_assessment.risk_availability BETWEEN 1.000 AND 7.2999 THEN "Medium"
                            WHEN risk_assessment.risk_availability BETWEEN 7.3000 AND 10.000 THEN "High"
                            ELSE "Unknown"
                        END as risk_category'),
                        DB::raw('LEFT(risk_assessment.control_num, 1) as control_number_start'),
                        DB::raw('COUNT(*) as total_controls')
                    )
                    ->where('components.project_id', $proj_id)
                    ->where('components.s_name', $s_name)
                    ->groupBy('control_number_start', 'risk_category')
                    ->orderBy('control_number_start')
                    ->get();

                $num_of_components = DB::table('iso_sec_2_1')
                    ->select(DB::raw('COUNT(DISTINCT c_name) as component_count'))
                    ->where('project_id', $proj_id)
                    ->where('s_name', $s_name)
                    ->first();



                return view('dashboard.services_controls_dashboard', [
                    'project' => $project,
                    'num_of_components' => $num_of_components,
                    'resultsConfidentiality' => $resultsConfidentiality,
                    'resultsIntegrity' => $resultsIntegrity,
                    'resultsAvailability' => $resultsAvailability,
                    's_name' => $s_name
                ]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    }



    public function components_control_dashboard($proj_id, $user_id, $s_name)
    {
        if ($user_id == auth()->user()->id) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            if ($project) {
                $resultsConfidentiality = DB::table('iso_sec_2_3_1 as risk_assessment')
                    ->join('iso_sec_2_1 as components', 'risk_assessment.asset_id', '=', 'components.assessment_id')
                    ->select(
                        'components.c_name',
                        DB::raw('
                        CASE
                            WHEN risk_assessment.risk_level BETWEEN 0.0000 AND 0.9999 THEN "Low"
                            WHEN risk_assessment.risk_level BETWEEN 1.0000 AND 7.2999 THEN "Medium"
                            WHEN risk_assessment.risk_level BETWEEN 7.3000 AND 10.000 THEN "High"
                            ELSE "Unknown"
                        END as risk_category'),
                        DB::raw('LEFT(risk_assessment.control_num, 1) as control_number_start'),
                        DB::raw('COUNT(*) as total_controls')
                    )
                    ->where('components.project_id', $proj_id)
                    ->where('components.s_name', $s_name)
                    ->groupBy('components.c_name', 'control_number_start', 'risk_category')
                    ->orderBy('components.c_name')
                    ->orderBy('control_number_start')
                    ->get();

                $resultsIntegrity = DB::table('iso_sec_2_3_1 as risk_assessment')
                    ->join('iso_sec_2_1 as components', 'risk_assessment.asset_id', '=', 'components.assessment_id')
                    ->select(
                        'components.c_name',
                        DB::raw('
                        CASE
                            WHEN risk_assessment.risk_integrity BETWEEN 0.0000 AND 0.9999 THEN "Low"
                            WHEN risk_assessment.risk_integrity BETWEEN 1.0000 AND 7.2999 THEN "Medium"
                            WHEN risk_assessment.risk_integrity BETWEEN 7.3000 AND 10.000 THEN "High"
                            ELSE "Unknown"
                        END as risk_category'),
                        DB::raw('LEFT(risk_assessment.control_num, 1) as control_number_start'),
                        DB::raw('COUNT(*) as total_controls')
                    )
                    ->where('components.project_id', $proj_id)
                    ->where('components.s_name', $s_name)
                    ->groupBy('components.c_name', 'control_number_start', 'risk_category')
                    ->orderBy('components.c_name')
                    ->orderBy('control_number_start')
                    ->get();

                $resultsAvailability = DB::table('iso_sec_2_3_1 as risk_assessment')
                    ->join('iso_sec_2_1 as components', 'risk_assessment.asset_id', '=', 'components.assessment_id')
                    ->select(
                        'components.c_name',
                        DB::raw('
                        CASE
                            WHEN risk_assessment.risk_availability BETWEEN 0.0000 AND 0.9999 THEN "Low"
                            WHEN risk_assessment.risk_availability BETWEEN 1.0000 AND 7.2999 THEN "Medium"
                            WHEN risk_assessment.risk_availability BETWEEN 7.3000 AND 10.000 THEN "High"
                            ELSE "Unknown"
                        END as risk_category'),
                        DB::raw('LEFT(risk_assessment.control_num, 1) as control_number_start'),
                        DB::raw('COUNT(*) as total_controls')
                    )
                    ->where('components.project_id', $proj_id)
                    ->where('components.s_name', $s_name)
                    ->groupBy('components.c_name', 'control_number_start', 'risk_category')
                    ->orderBy('components.c_name')
                    ->orderBy('control_number_start')
                    ->get();

                return view('dashboard.components_controls_dashboard', [
                    'project' => $project,
                    'resultsConfidentiality' => $resultsConfidentiality,
                    'resultsIntegrity' => $resultsIntegrity,
                    'resultsAvailability' => $resultsAvailability,
                    's_name' => $s_name
                ]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    }



    public function risk_profile_graphical($proj_id, $user_id)
    {
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

            $data = DB::table('iso_sec_2_1 as sec1')
                ->join('iso_sec_2_3_1 as sec3', 'sec1.assessment_id', '=', 'sec3.asset_id')
                ->select(
                    'sec1.c_name',
                    DB::raw('
            CASE
                WHEN sec3.risk_level BETWEEN 0.00000 AND 0.999999 THEN "Low"
                WHEN sec3.risk_level BETWEEN 1.00000 AND 7.200000 THEN "Medium"
                WHEN sec3.risk_level BETWEEN 7.300000 AND 10.00000 THEN "High"
                ELSE "Unknown"
            END as risk_category'),
                    DB::raw('
            CASE
                WHEN sec3.control_num LIKE "5.%" THEN "Control 5"
                WHEN sec3.control_num LIKE "6.%" THEN "Control 6"
                WHEN sec3.control_num LIKE "7.%" THEN "Control 7"
                WHEN sec3.control_num LIKE "8.%" THEN "Control 8"
                ELSE "Other Controls"
            END as control_group'),
                    DB::raw('COUNT(sec3.risk_level) as total')
                )
                ->where('sec1.project_id', $proj_id)
                ->groupBy('sec1.c_name', 'risk_category', 'control_group')
                ->get();

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            $chartData = $data->groupBy('c_name')->map(function ($componentData) {
                // Group data by control group
                return $componentData->groupBy('control_group')->map(function ($controlData) {
                    // Prepare datasets by risk category (Low, Medium, High)
                    return [
                        'Low' => $controlData->where('risk_category', 'Low')->pluck('total')->toArray(),
                        'Medium' => $controlData->where('risk_category', 'Medium')->pluck('total')->toArray(),
                        'High' => $controlData->where('risk_category', 'High')->pluck('total')->toArray(),
                    ];
                });
            });



            return view('dashboard.risk_profile_graphical', [
                'project' => $project,
                'chartData' => $chartData
            ]);
        }


        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    }


    public function risk_computation($proj_id, $user_id, Request $req)
    {

        if ($user_id == auth()->user()->id) {

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            $servicesInProject = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->select('s_name')
                ->get();

            $groupsInProject = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->select('g_name')
                ->get();

            $namesInProject = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->select('name')
                ->get();

            $componentsInProject = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->select('c_name')
                ->get();





            $query = DB::table('iso_sec_2_1 as iso1')
                ->join('iso_sec_2_3_1 as iso2', 'iso1.assessment_id', '=', 'iso2.asset_id')
                ->where('iso1.project_id', $proj_id);

            // Dynamically select risk columns based on user input for 'risk_type'
            $query->select(
                'iso1.s_name',
                'iso1.g_name',
                'iso1.name',
                'iso1.c_name',
                'iso1.risk_confidentiality as Confidentiality_Risk',
                'iso1.risk_integrity as Integrity_Risk' ,
                'iso1.risk_availability as Availability_Risk',
                'iso2.control_num',
                'iso2.applicability',
                'iso2.vulnerability',
                'iso2.threat',
                
            );

            // Check the value of 'risk_type' and adjust the columns
            $riskType = $req->input('risk_type');

            if ($riskType == 'all' || $riskType == null) {
                $query->addSelect(
                    'iso2.risk_level',

                );
            } else {
                $query->addSelect('iso2.' . $riskType);
            }


            $query->when($req->input('service') && $req->input('service') != 'all', function ($query) use ($req) {
                return $query->where('iso1.s_name', $req->input('service'));
            });

            $query->when($req->input('group') && $req->input('group') != 'all', function ($query) use ($req) {
                return $query->where('iso1.g_name', $req->input('group'));
            });

            $query->when($req->input('name') && $req->input('name') != 'all', function ($query) use ($req) {
                return $query->where('iso1.name', $req->input('name'));
            });

            $query->when($req->input('component') && $req->input('component') != 'all', function ($query) use ($req) {
                return $query->where('iso1.c_name', $req->input('component'));
            });



            // Control group filter (for controls 5, 6, 7, 8, or all)
            $query->when($req->input('control_group') && $req->input('control_group') != 'all', function ($query) use ($req) {
                $controlGroup = $req->input('control_group');


                if ($controlGroup == 5) {
                    return $query->whereBetween('iso2.control_num', [5.1, 5.99]);
                } elseif ($controlGroup == 6) {
                    return $query->whereBetween('iso2.control_num', [6.1, 6.99]);
                } elseif ($controlGroup == 7) {
                    return $query->whereBetween('iso2.control_num', [7.1, 7.99]);
                } elseif ($controlGroup == 8) {
                    return $query->whereBetween('iso2.control_num', [8.1, 8.99]);
                }
            });

            

            $results = $query->orderBy('iso2.control_num', 'asc')
                ->get();
             
              
            $scatterPlotData = [
                // x = Vulnerability, y = Threat, r = Risk Count (point size)
                ['x' => 1, 'y' => 1, 'r' => $results->where('vulnerability', '<=', 20)->where('threat', '<=', 20)->count()],  // Low Vulnerability, Low Threat
                ['x' => 1, 'y' => 2, 'r' => $results->where('vulnerability', '<=', 20)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Low Vulnerability, Medium Threat
                ['x' => 1, 'y' => 3, 'r' => $results->where('vulnerability', '<=', 20)->where('threat', '>', 70)->count()],  // Low Vulnerability, High Threat

                ['x' => 2, 'y' => 1, 'r' => $results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '<=', 20)->count()],  // Medium Vulnerability, Low Threat
                ['x' => 2, 'y' => 2, 'r' => $results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // Medium Vulnerability, Medium Threat
                ['x' => 2, 'y' => 3, 'r' => $results->where('vulnerability', '>', 20)->where('vulnerability', '<=', 70)->where('threat', '>', 70)->count()],  // Medium Vulnerability, High Threat

                ['x' => 3, 'y' => 1, 'r' => $results->where('vulnerability', '>', 70)->where('threat', '<=', 20)->count()],  // High Vulnerability, Low Threat
                ['x' => 3, 'y' => 2, 'r' => $results->where('vulnerability', '>', 70)->where('threat', '>', 20)->where('threat', '<=', 70)->count()],  // High Vulnerability, Medium Threat
                ['x' => 3, 'y' => 3, 'r' => $results->where('vulnerability', '>', 70)->where('threat', '>', 70)->count()]  // High Vulnerability, High Threat
            ];

            //dd( $results ); 


            return view('dashboard.risk_calculation', [
                'project' => $project,
                'servicesInProject' => $servicesInProject,
                'groupsInProject' => $groupsInProject,
                'namesInProject' => $namesInProject,
                'componentsInProject' => $componentsInProject,
                'results' => $results,
                'scatterPlotData' => $scatterPlotData

            ]);
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }

    public function reports($proj_id, $user_id)
    {

        $project = Db::table('projects')->where('project_id', $proj_id)->first();

        return view('assigned_projects.reports_list', ['proj_id' => $proj_id, 'project_name' => $project->project_name]);
    }

    public function assets_in_scope($proj_id, $user_id)
    {
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

            $project = Db::table('projects')->where('project_id', $proj_id)->first('project_name');

            $report_data = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->get([
                's_name',
                'g_name',
                'name',
                'c_name',
                'owner_dept',
                'physical_loc',
                'logical_loc'
            ]);
            if ($report_data->count() > 0) {

                $safeProjectName = Str::slug($project->project_name, '_'); // Example: converting "Project Name!" to "Project_Name"

                // Append the project name to the report filename
                $filename = 'AssetsInScopeReport_' . $safeProjectName . '.xlsx';

                $export = new ReportDataExport($proj_id);
                return Excel::download($export, $filename);
            } else {

                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }


    public function mandatory_and_nonmandatory_controls($proj_id, $user_id)
    {

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


            $project = Db::table('projects')->where('project_id', $proj_id)->first('project_name');

            $report_data = Db::table('iso_sec_2_2')
                ->where('iso_sec_2_2.project_id', $proj_id)->orderBy('title_num', 'asc')->get([
                        'title_num',
                        'sub_req',
                        'comp_status',
                        'comments',
                        'attachment',

                    ]);
            if ($report_data->count() > 0) {

                $safeProjectName = Str::slug($project->project_name, '_');


                $filename = 'RiskAssessmentReport_' . $safeProjectName . '.xlsx';

                $export = new RiskAssessmentExport($proj_id);
                return Excel::download($export, $filename);
            } else {

                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }


    // public function risk_assessment_report($proj_id, $user_id)
    // {
    //     $checkpermission = Db::table('project_details')->select(
    //         'project_types.id as type_id',
    //         'project_details.project_code',
    //         'project_details.project_permissions',
    //         'projects.project_name'
    //     )
    //         ->join('projects', 'project_details.project_code', 'projects.project_id')
    //         ->join('project_types', 'projects.project_type', 'project_types.id')
    //         ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
    //         ->first();


    //     if ($checkpermission) {

    //         $project = Db::table('projects')->where('project_id', $proj_id)->first('project_name');

    //         $report_data = Db::table('iso_sec_2_1')->join('iso_sec_2_3_1', 'iso_sec_2_1.assessment_id', 'iso_sec_2_3_1.asset_id')
    //             ->where('iso_sec_2_1.project_id', $proj_id)->orderBy('control_num', 'asc')->orderBy('asset_id', 'asc')
    //             ->get(
    //                 [
    //                      'title','sub_req','comp_status','comments','attachment'
    //                 ]
    //             );


    //         if ($report_data->count() > 0) {

    //             $safeProjectName = Str::slug($project->project_name, '_'); // Example: converting "Project Name!" to "Project_Name"

    //             //Append the project name to the report filename
    //             $filename = 'RiskAssessmentReport_' . $safeProjectName . '.xlsx';

    //             $export = new RiskAssessmentExport($proj_id);
    //             return Excel::download($export, $filename);
    //         } else {
    //             return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    //         }
    //     } else {
    //         return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    //     }
    // }

    public function risk_treatment($proj_id, $user_id)
    {


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

            $projectName = Db::table('projects')->where('project_id', $proj_id)->first('project_name')->project_name;
            $report_data = Db::table('iso_sec_2_1')->join(
                'iso_risk_treatment',
                'iso_sec_2_1.assessment_id',
                'iso_risk_treatment.asset_id'
            )->where('iso_sec_2_1.project_id', $proj_id)
                ->get();


            if ($report_data->count() > 0) {
                $safeProjectName = Str::slug($projectName, '_'); // Example: converting "Project Name!" to "Project_Name"

                //Append the project name to the report filename
                $filename = 'RiskTreatmentReport_' . $safeProjectName . '.xlsx';

                $export = new RiskTreatmentReport($proj_id);
                return Excel::download($export, $filename);
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }



    public function iso_section2_4_subsections($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
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
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 4) {

                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    return view(
                        'iso.iso_sec2_4_subsections',
                        [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project' => $project
                        ]
                    );
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function delete_my_project($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {

            $check = Db::table('projects')->where('project_id', $proj_id)->where('created_by', $user_id)->first();
            if ($check) {

                Db::table('projects')->where('project_id', $proj_id)->where('created_by', $user_id)->delete();
                return redirect()->route('projects', ['user_id' => $user_id])->with('success', 'Project Deleted');
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }







    public function v3_2_edit_qa($assessment_id, $proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        $qa = Db::table('pci_dss v3_2_1 qa')->where('assessment_id', $assessment_id)->first();
                        return view('assigned_projects.v3_2s1_edit_qa', ['qa' => $qa]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
    public function v3_2_s1_qa_edit_form_submit(Request $req, $assessment_id, $proj_id, $user_id)
    {
        $req->validate([
            'reviewer_name' => 'required|max:100',
            'reviewer_email' => 'required|max:100|email',
            'reviewer_phone' => 'required|numeric'
        ]);

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci_dss v3_2_1 qa')->where('assessment_id', $assessment_id)
                            ->update([
                                'reviewer_name' => $req->reviewer_name,
                                'reviewer_email' => $req->reviewer_email,
                                'reviewer_phone' => $req->reviewer_phone,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'QA edited successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_add_new_qa($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {
                        return view('assigned_projects.add_new_qa', ['project_id' => $checkpermission->project_id]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    }

    //delete QA
    public function v3_2_s1_delete_qa($assessment_id, $proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci_dss v3_2_1 qa')->where('assessment_id', $assessment_id)->delete();

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record deleted');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    //section1.2
    public function v3_2_s1_1_2($proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {

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
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 2) {

                    $timeframe = Db::table('pci-dss v3_2_1 section1_2')->join('users', 'pci-dss v3_2_1 section1_2.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->first();


                    $date_onsite = Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')
                        ->join('users', 'pci-dss v3_2_1 section1_2_dates_spent_onsite.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->get();


                    return view(
                        'assigned_projects.v_3_2_s1_1_2',
                        [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'timeframe' => $timeframe,
                            'date_onsite' => $date_onsite
                        ]
                    );
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_2_date(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'date_of_report' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'time_onsite' => 'required|numeric',
            'time_remote' => 'required|numeric',
            'time_remediation' => 'required|numeric'
        ]);

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_2')->insert([
                            'project_id' => $proj_id,
                            'date_of_report' => $req->date_of_report,
                            'start_date' => $req->start_date,
                            'end_date' => $req->end_date,
                            'time_onsite' => $req->time_onsite,
                            'time_remote' => $req->time_remote,
                            'time_remediation' => $req->time_remediation,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                        return redirect()->route('section1_2', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_2_edit_timeframe($proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        $timeframe = Db::table('pci-dss v3_2_1 section1_2')->where('project_id', $proj_id)->first();
                        if ($timeframe) {
                            return view('assigned_projects.v3_2_s1_1_2_edit_timeframe', ['timeframe' => $timeframe]);
                        }
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_2_edit_timeframe_form(Request $req, $proj_id, $user_id)
    {
        $req->validate(
            [
                'date_of_report' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'time_onsite' => 'required|numeric',
                'time_remote' => 'required|numeric',
                'time_remediation' => 'required|numeric'
            ]
        );


        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_2')->where('project_id', $proj_id)
                            ->update([
                                'date_of_report' => $req->date_of_report,
                                'start_date' => $req->start_date,
                                'end_date' => $req->end_date,
                                'time_onsite' => $req->time_onsite,
                                'time_remote' => $req->time_remote,
                                'time_remediation' => $req->time_remediation,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                            ]);

                        return redirect()->route('section1_2', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Edited successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_2_onsite($proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {
                        return view('assigned_projects.add_new_onsite_date_section1_2', [
                            'project_id' => $checkpermission->project_id
                        ]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_2_onsite_form(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'date_spent_onsite' => 'required'
        ]);

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->insert([
                            'project_id' => $proj_id,
                            'date_spent_onsite' => $req->date_spent_onsite,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                        ]);

                        return redirect()->route('section1_2', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_edit_date_onsite($assessment_id, $proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {
                        $onsite = Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->where('assessment_id', $assessment_id)->first();
                        return view('assigned_projects.v3_2_s1_1_2_edit_onsite', ['onsite' => $onsite]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_edit_submit_1_2_onsite(Request $req, $assessment_id, $proj_id, $user_id)
    {
        $req->validate([
            'date_spent_onsite' => 'required'
        ]);


        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->where('assessment_id', $assessment_id)
                            ->update([
                                'date_spent_onsite' => $req->date_spent_onsite,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                            ]);

                        return redirect()->route('section1_2', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Date Edited successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_2_deleteonsite($assessment_id, $proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_2_dates_spent_onsite')->where('assessment_id', $assessment_id)
                            ->delete();

                        return redirect()->route('section1_2', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Date Deleted successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_4($proj_id, $user_id)
    {

        if ($user_id == auth()->user()->id) {

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

                if ($checkpermission->type_id == 2) {

                    $services = Db::table('pci-dss v3_2_1 section1_4')
                        ->join('users', 'pci-dss v3_2_1 section1_4.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->first();

                    return view(
                        'assigned_projects.v_3_2_s1_1_4',
                        [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'services' => $services,
                        ]
                    );
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_4_services(Request $req, $proj_id, $user_id)
    {
        $req->validate(
            [
                'requirement1' => 'required|max:800',
                'requirement2' => 'required|max:800'
            ],
            [
                'requirement1.required' => 'This field is required',
                'requirement2.required' => 'This field is required',
                'requirement1.max' => 'Max amount you can write is 800 words',
                'requirement2.max' => 'Max amount you can write is 800 words'
            ]
        );

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_4')->insert([
                            'project_id' => $proj_id,
                            'requirement1' => $req->requirement1,
                            'requirement2' => $req->requirement2,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                        ]);


                        return redirect()->route('section1_4', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_4_edit($assessment_id, $proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id',
                'projects.project_name'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        $services = Db::table('pci-dss v3_2_1 section1_4')->where('assessment_id', $assessment_id)
                            ->where('project_id', $proj_id)->first();
                        return view('assigned_projects.v3_2_s1_1_4_edit', [
                            'services' => $services,
                            'project_id' => $checkpermission->project_id,
                            'project_name' => $checkpermission->project_name
                        ]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_4_services_edit_form(Request $req, $assessment_id, $proj_id, $user_id)
    {

        $req->validate(
            [
                'requirement1' => 'required|max:800',
                'requirement2' => 'required|max:800'
            ],
            [
                'requirement1.required' => 'This field is required',
                'requirement2.required' => 'This field is required',
                'requirement1.max' => 'Max amount you can write is 800 words',
                'requirement2.max' => 'Max amount you can write is 800 words'
            ]
        );

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_4')->where('assessment_id', $assessment_id)->where('project_id', $proj_id)
                            ->update([
                                'requirement1' => $req->requirement1,
                                'requirement2' => $req->requirement2,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                            ]);


                        return redirect()->route('section1_4', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Edited successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }



    //section 1.5 summary of findings
    public function v3_2_s1_1_5($proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {

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

                if ($checkpermission->type_id == 2) {

                    $summary = Db::table('pci-dss v3_2_1 section1_5')
                        ->join('users', 'pci-dss v3_2_1 section1_5.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->first();

                    return view(
                        'assigned_projects.v_3_2_s1_1_5',
                        [
                            'project_id' => $proj_id,
                            'project_name' => $checkpermission->project_name,
                            'project_permissions' => $checkpermission->project_permissions,
                            'summary' => $summary
                        ]
                    );
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_5_summary(Request $req, $proj_id, $user_id)
    {

        $req->validate([
            'requirement1' => 'required',
            'requirement2' => 'required',
            'requirement3' => 'required',
            'requirement4' => 'required',
            'requirement5' => 'required',
            'requirement6' => 'required',
            'requirement7' => 'required',
            'requirement8' => 'required',
            'requirement9' => 'required',
            'requirement10' => 'required',
            'requirement11' => 'required',
            'requirement12' => 'required',
            'appendix_A1' => 'required',
            'appendix_A2' => 'required',
            'appendix_A3' => 'required'

        ]);

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_5')->insert([
                            'project_id' => $proj_id,

                            'requirement1' => $req->requirement1,
                            'requirement2' => $req->requirement2,
                            'requirement3' => $req->requirement3,
                            'requirement4' => $req->requirement4,
                            'requirement5' => $req->requirement5,
                            'requirement6' => $req->requirement6,
                            'requirement7' => $req->requirement7,
                            'requirement8' => $req->requirement8,
                            'requirement9' => $req->requirement9,
                            'requirement10' => $req->requirement10,
                            'requirement11' => $req->requirement11,
                            'requirement12' => $req->requirement12,
                            'appendix_A1' => $req->appendix_A1,
                            'appendix_A2' => $req->appendix_A2,
                            'appendix_A3' => $req->appendix_A3,

                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                        ]);



                        return redirect()->route('section1_5', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_5_edit($assessment_id, $proj_id, $user_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id',
                'projects.project_name'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        $summary = Db::table('pci-dss v3_2_1 section1_5')->where('assessment_id', $assessment_id)
                            ->where('project_id', $proj_id)->first();
                        if ($summary) {
                            return view('assigned_projects.v3_2_s1_1_5_edit', [
                                'summary' => $summary,
                                'project_id' => $proj_id,
                                'project_name' => $checkpermission->project_name
                            ]);
                        } else {
                            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                        }
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_1_5_edit_form(Request $req, $assessment_id, $proj_id, $user_id)
    {
        $req->validate([
            'requirement1' => 'required',
            'requirement2' => 'required',
            'requirement3' => 'required',
            'requirement4' => 'required',
            'requirement5' => 'required',
            'requirement6' => 'required',
            'requirement7' => 'required',
            'requirement8' => 'required',
            'requirement9' => 'required',
            'requirement10' => 'required',
            'requirement11' => 'required',
            'requirement12' => 'required',
            'appendix_A1' => 'required',
            'appendix_A2' => 'required',
            'appendix_A3' => 'required'

        ]);

        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();

            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {

                        Db::table('pci-dss v3_2_1 section1_5')->where('assessment_id', $assessment_id)->where('project_id', $proj_id)
                            ->update([

                                'requirement1' => $req->requirement1,
                                'requirement2' => $req->requirement2,
                                'requirement3' => $req->requirement3,
                                'requirement4' => $req->requirement4,
                                'requirement5' => $req->requirement5,
                                'requirement6' => $req->requirement6,
                                'requirement7' => $req->requirement7,
                                'requirement8' => $req->requirement8,
                                'requirement9' => $req->requirement9,
                                'requirement10' => $req->requirement10,
                                'requirement11' => $req->requirement11,
                                'requirement12' => $req->requirement12,
                                'appendix_A1' => $req->appendix_A1,
                                'appendix_A2' => $req->appendix_A2,
                                'appendix_A3' => $req->appendix_A3,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                            ]);



                        return redirect()->route('section1_5', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record Edited successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }
}
