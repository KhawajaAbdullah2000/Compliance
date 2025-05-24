<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Session;
use App\Exports\RiskRegister;

class RiskHeatmap extends Controller
{


    public function heatmap_all_services_all_risks($proj_id, $user_id)
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
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

            $results_data_confidentiality = DB::table('iso_sec_2_3_1')
                ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
                ->where('iso_sec_2_3_1.project_id', $proj_id)
                ->selectRaw("
        iso_sec_2_1.risk_confidentiality,
        CASE 
            WHEN iso_sec_2_3_1.risk_level >= 0.0 AND iso_sec_2_3_1.risk_level < 0.9999 THEN 'low'
            WHEN iso_sec_2_3_1.risk_level >= 0.999 AND iso_sec_2_3_1.risk_level < 7.2 THEN 'medium'
            WHEN iso_sec_2_3_1.risk_level >= 7.2 AND iso_sec_2_3_1.risk_level <= 10.0 THEN 'high'
        END AS risk_category,
        COUNT(*) as count,
        MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
        MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    ")
                ->groupBy('iso_sec_2_1.risk_confidentiality', 'risk_category')
                ->get();


            $impactLevels = [
                10 => 'High',
                5 => 'Medium',
                1 => 'Low',
            ];

            $data_confidentiality = $results_data_confidentiality->groupBy('risk_confidentiality')->mapWithKeys(function ($items, $confidentiality) use ($impactLevels) {
                $mappedImpact = $impactLevels[$confidentiality] ?? $confidentiality; // Default to original value if not mapped
                $row = [
                    'low' => ['count' => 0, 'range' => ''],
                    'medium' => ['count' => 0, 'range' => ''],
                    'high' => ['count' => 0, 'range' => ''],
                ];
                foreach ($items as $item) {
                    $row[$item->risk_category] = [
                        'count' => $item->count,
                        'range' => $item->min_risk_score . ' - ' . $item->max_risk_score,
                    ];
                }
                return [$mappedImpact => $row];
            });

            $overallConfidentialityRanges = $results_data_confidentiality->groupBy('risk_category')->mapWithKeys(function ($items, $riskCategory) {
                return [
                    $riskCategory => [
                        'min' => $items->min('min_risk_score'),
                        'max' => $items->max('max_risk_score'),
                    ],
                ];
            });

            // Ensure all categories are present (low, medium, high) even if some are missing
            $defaultCategories = ['low', 'medium', 'high'];

            foreach ($defaultCategories as $category) {
                if (!isset($overallConfidentialityRanges[$category])) {
                    $overallConfidentialityRanges[$category] = ['min' => '-', 'max' => '-']; // Set default values
                }
            }


            $totalConfidentialityCount = $results_data_confidentiality->sum('count');



            $results_data_integrity = DB::table('iso_sec_2_3_1')
                ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
                ->where('iso_sec_2_3_1.project_id', $proj_id)
                ->selectRaw("
        iso_sec_2_1.risk_integrity,
        CASE 
            WHEN iso_sec_2_3_1.risk_integrity >= 0.0 AND iso_sec_2_3_1.risk_integrity < 0.9999 THEN 'low'
            WHEN iso_sec_2_3_1.risk_integrity >= 0.999 AND iso_sec_2_3_1.risk_integrity < 7.2 THEN 'medium'
            WHEN iso_sec_2_3_1.risk_integrity >= 7.2 AND iso_sec_2_3_1.risk_integrity <= 10.0 THEN 'high'
        END AS risk_category,
        COUNT(*) as count,
        MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
        MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    ")
                ->groupBy('iso_sec_2_1.risk_integrity', 'risk_category')
                ->get();

            //dd($results_data_integrity);




            $data_integrity = $results_data_integrity->groupBy('risk_integrity')->mapWithKeys(function ($items, $integrity) use ($impactLevels) {
                $mappedImpact = $impactLevels[$integrity] ?? $integrity; // Default to original value if not mapped
                $row = [
                    'low' => ['count' => 0, 'range' => ''],
                    'medium' => ['count' => 0, 'range' => ''],
                    'high' => ['count' => 0, 'range' => ''],
                ];
                foreach ($items as $item) {
                    $row[$item->risk_category] = [
                        'count' => $item->count,
                        'range' => $item->min_risk_score . ' - ' . $item->max_risk_score,
                    ];
                }
                return [$mappedImpact => $row];
            });

            $overallIntegrityRanges = $results_data_integrity->groupBy('risk_category')->mapWithKeys(function ($items, $riskCategory) {
                return [
                    $riskCategory => [
                        'min' => $items->min('min_risk_score'),
                        'max' => $items->max('max_risk_score'),
                    ],
                ];
            });

            // Ensure all categories are present (low, medium, high) even if some are missing
            $defaultCategories = ['low', 'medium', 'high'];

            foreach ($defaultCategories as $category) {
                if (!isset($overallIntegrityRanges[$category])) {
                    $overallIntegrityRanges[$category] = ['min' => '-', 'max' => '-']; // Set default values
                }
            }



            $totalIntegrityCount = $results_data_integrity->sum('count');




            $results_data_availability = DB::table('iso_sec_2_3_1')
                ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
                ->where('iso_sec_2_3_1.project_id', $proj_id)
                ->selectRaw("
        iso_sec_2_1.risk_availability,
        CASE 
            WHEN iso_sec_2_3_1.risk_availability >= 0.0 AND iso_sec_2_3_1.risk_availability < 0.9999 THEN 'low'
            WHEN iso_sec_2_3_1.risk_availability >= 0.999 AND iso_sec_2_3_1.risk_availability < 7.2 THEN 'medium'
            WHEN iso_sec_2_3_1.risk_availability >= 7.2 AND iso_sec_2_3_1.risk_availability <= 10.0 THEN 'high'
        END AS risk_category,
        COUNT(*) as count,
        MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
        MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    ")
                ->groupBy('iso_sec_2_1.risk_availability', 'risk_category')
                ->get();

            $data_availability = $results_data_availability->groupBy('risk_availability')->mapWithKeys(function ($items, $availability) use ($impactLevels) {
                $mappedImpact = $impactLevels[$availability] ?? $availability; // Default to original value if not mapped
                $row = [
                    'low' => ['count' => 0, 'range' => ''],
                    'medium' => ['count' => 0, 'range' => ''],
                    'high' => ['count' => 0, 'range' => ''],
                ];
                foreach ($items as $item) {
                    $row[$item->risk_category] = [
                        'count' => $item->count,
                        'range' => $item->min_risk_score . ' - ' . $item->max_risk_score,
                    ];
                }
                return [$mappedImpact => $row];
            });

            $overallAvailabilityRanges = $results_data_availability->groupBy('risk_category')->mapWithKeys(function ($items, $riskCategory) {
                return [
                    $riskCategory => [
                        'min' => $items->min('min_risk_score'),
                        'max' => $items->max('max_risk_score'),
                    ],
                ];
            });

            // Ensure all categories are present (low, medium, high) even if some are missing
            $defaultCategories = ['low', 'medium', 'high'];

            foreach ($defaultCategories as $category) {
                if (!isset($overallAvailabilityRanges[$category])) {
                    $overallAvailabilityRanges[$category] = ['min' => '-', 'max' => '-']; // Set default values
                }
            }





            $totalAvailabilityCount = $results_data_availability->sum('count');


            $uniqueServicesCount = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->count('s_name');

            $uniqueGroupsCount = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->count('g_name');

            $uniqueSubGroupsCount = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->count('name');

            $uniqueComponentsCount = DB::table('iso_sec_2_1')
                ->where('project_id', $proj_id)
                ->distinct()
                ->count('c_name');

            return view('heatmap.all_services_all_controls', [
                'project' => $project,
                'uniqueServicesCount' => $uniqueServicesCount,
                'uniqueGroupsCount' => $uniqueGroupsCount,
                'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
                'uniqueComponentsCount' => $uniqueComponentsCount,
                'data_confidentiality' => $data_confidentiality,
                'totalConfidentialityCount' => $totalConfidentialityCount,
                'overallConfidentialityRanges' => $overallConfidentialityRanges,
                'data_integrity' => $data_integrity,
                'totalIntegrityCount' => $totalIntegrityCount,
                'overallIntegrityRanges' => $overallIntegrityRanges,
                'data_availability' => $data_availability,
                'totalAvailabilityCount' => $totalAvailabilityCount,
                'overallAvailabilityRanges' => $overallAvailabilityRanges

            ]);


        }
    }

    public function heatmap_select_services_and_risks($proj_id,$user_id){
        $uniqueServices = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->select('s_name') // Select only the column you want to be distinct
        ->distinct()
        ->get();
    
        
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();
        $uniqueServicesCount = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->distinct()
        ->count('s_name');

    $uniqueGroupsCount = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->distinct()
        ->count('g_name');

    $uniqueSubGroupsCount = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->distinct()
        ->count('name');

    $uniqueComponentsCount = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->distinct()
        ->count('c_name');

        return view('heatmap.select_service_and_risk_type',[
            'uniqueServices'=>$uniqueServices,
            'project'=>$project,
            'uniqueServicesCount' => $uniqueServicesCount,
            'uniqueGroupsCount' => $uniqueGroupsCount,
            'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
            'uniqueComponentsCount' => $uniqueComponentsCount
        ]);

 
    }

    // public function heatmap_single_risk($proj_id, Request $req)
    // {
      
    //     //$group = $req->query('group');
    //     //$subgroup = $req->query('subgroup');
    //     $risk_type = $req->selected_risk;
    //     $service=$req->selected_service;

       
    //     $assetIds = DB::table('iso_sec_2_1')
    //         ->where('project_id', $proj_id)
    //         ->when($service != '_all', function ($query) use ($service) {
    //             return $query->where('s_name', $service);
    //         })
    //         // ->when($group, function ($query, $group) {
    //         //     return $query->when($group != '_all', function ($query) use ($group) {
    //         //         return $query->where('g_name', $group);
    //         //     });
    //         // })
    //         // ->when($subgroup, function ($query, $subgroup) {
    //         //     return $query->when($subgroup != '_all', function ($query) use ($subgroup) {
    //         //         return $query->where('name', $subgroup);
    //         //     });
    //         // })
    //         // ->when($component != '_all', function ($query) use ($component) {
    //         //     return $query->where('c_name', $component);
    //         // })
    //         ->pluck('assessment_id')->toArray();

         

    //         $risk_adverse_value=$req->selected_risk;
        
    //         if($risk_type=='risk_level'){
    //             $risk_adverse_value='risk_confidentiality';
    //         }

    //         $results = DB::table('iso_sec_2_3_1')
    //         ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
    //         ->where('iso_sec_2_3_1.project_id', $proj_id)
    //         ->whereIn('iso_sec_2_3_1.asset_id', $assetIds)
    //         ->selectRaw("
    //             iso_sec_2_1.{$risk_adverse_value} AS risk_value,
    //             CASE 
    //                 WHEN iso_sec_2_3_1.{$risk_type} >= 0.0 AND iso_sec_2_3_1.{$risk_type} < 0.9999 THEN 'low'
    //                 WHEN iso_sec_2_3_1.{$risk_type} >= 0.999 AND iso_sec_2_3_1.{$risk_type} < 7.2 THEN 'medium'
    //                 WHEN iso_sec_2_3_1.{$risk_type} >= 7.2 AND iso_sec_2_3_1.{$risk_type} <= 10.0 THEN 'high'
    //             END AS risk_category,
    //             COUNT(*) as count,
    //             MIN(iso_sec_2_3_1.risk_score) as min_risk_score,
    //             MAX(iso_sec_2_3_1.risk_score) as max_risk_score
    //         ")
    //         ->groupBy("iso_sec_2_1.{$risk_adverse_value}", 'risk_category')
    //         ->get();

    //         dd($results);

    //         $impactLevels = [
    //             10 => 'High',
    //             5 => 'Medium',
    //             1 => 'Low',
    //         ];


    //         $data = $results->groupBy('risk_value')->mapWithKeys(function ($items, $value) use ($impactLevels) {
    //             $mappedImpact = $impactLevels[$value] ?? $value; // Default to original value if not mapped
    //             $row = [
    //                 'low' => ['count' => 0, 'range' => ''],
    //                 'medium' => ['count' => 0, 'range' => ''],
    //                 'high' => ['count' => 0, 'range' => ''],
    //             ];
    //             foreach ($items as $item) {
    //                 $row[$item->risk_category] = [
    //                     'count' => $item->count,
    //                     'range' => $item->min_risk_score . ' - ' . $item->max_risk_score,
    //                 ];
    //             }
    //             return [$mappedImpact => $row];
    //         });


    //         $overallRanges = $results->groupBy('risk_category')->mapWithKeys(function ($items, $riskCategory) use ($impactLevels) {
    //             $mappedCategory = $impactLevels[$riskCategory] ?? $riskCategory; // Map numerical values to labels
    //             return [
    //                 $mappedCategory => [
    //                     'min' => $items->min('min_risk_score'),
    //                     'max' => $items->max('max_risk_score'),
    //                 ],
    //             ];
    //         });
            
    //         // Ensure all categories are present (Low, Medium, High) even if some are missing
    //         $defaultCategories = ['low', 'medium', 'high'];
            
    //         foreach ($defaultCategories as $category) {
    //             if (!isset($overallRanges[$category])) {
    //                 $overallRanges[$category] = ['min' => '-', 'max' => '-']; // Set default values
    //             }
    //         }
            
         
          
    //         $totalCount = $results->sum('count');

    //         $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
    //         ->where('projects.project_id', $proj_id)->first();

    //         $uniqueServicesCount = DB::table('iso_sec_2_1')
    //         ->where('project_id', $proj_id)
    //         ->distinct()
    //         ->count('s_name');

    //     $uniqueGroupsCount = DB::table('iso_sec_2_1')
    //         ->where('project_id', $proj_id)
    //         ->distinct()
    //         ->count('g_name');

    //     $uniqueSubGroupsCount = DB::table('iso_sec_2_1')
    //         ->where('project_id', $proj_id)
    //         ->distinct()
    //         ->count('name');

    //     $uniqueComponentsCount = DB::table('iso_sec_2_1')
    //         ->where('project_id', $proj_id)
    //         ->distinct()
    //         ->count('c_name');
           
           
     
    //         return view('heatmap.heatmap_single_type',
    //         [
    //             'project'=>$project,
    //             'data'=>$data,
    //             'totalCount'=>$totalCount,
    //             'overallRanges'=>$overallRanges,
    //             'risk_type'=>$risk_type,
    //             'uniqueServicesCount' => $uniqueServicesCount,
    //             'uniqueGroupsCount' => $uniqueGroupsCount,
    //             'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //             'uniqueComponentsCount' => $uniqueComponentsCount,
    //             'service'=>$service,
    //             'group'=>$group,
    //             'subgroup'=>$subgroup,
    //             'component'=>$component,

    //         ]);



    // }

    public function heatmap_single_risk($proj_id, Request $req)
    {
      
        $risk_type = $req->selected_risk;
        $service=$req->selected_service;

       
        $assetIds = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->pluck('assessment_id')->toArray();

        
        

            $results = DB::table('iso_sec_2_3_1')
            ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
            ->where('iso_sec_2_3_1.project_id', $proj_id)
            ->whereIn('iso_sec_2_3_1.asset_id', $assetIds)
            ->selectRaw("FLOOR(control_num) as category, MAX(iso_sec_2_3_1.$risk_type) as max_risk, 
                         MIN(iso_sec_2_3_1.$risk_type) as min_risk, AVG(iso_sec_2_3_1.$risk_type) as mean_risk")
            ->groupBy('category')
            ->orderBy('category')
            ->get();
         

            $likelihood_of_exploit = DB::table('iso_sec_2_3_1')
            ->join('iso_sec_2_1', 'iso_sec_2_3_1.asset_id', '=', 'iso_sec_2_1.assessment_id')
            ->where('iso_sec_2_3_1.project_id', $proj_id)
            ->whereIn('iso_sec_2_3_1.asset_id', $assetIds)
            ->selectRaw("
                FLOOR(control_num) as category, 
               MAX((vulnerability * threat) /10000) as max_likelihood, 
                MIN((vulnerability * threat) / 10000) as min_likelihood, 
                AVG((vulnerability * threat) / 100000) as mean_likelihood
            ")
            ->groupBy('category')
            ->orderBy('category')
            ->get();




            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

            $uniqueServicesCount = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->distinct()
            ->count('s_name');

        $uniqueGroupsCount = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->distinct()
            ->count('g_name');

        $uniqueSubGroupsCount = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->distinct()
            ->count('name');

        $uniqueComponentsCount = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->distinct()
            ->count('c_name');
        
            $serviceDetails=DB::table('iso_sec_2_1')->where('project_id',$proj_id)
            ->where('s_name',$service)->first();
            
           
        
            return view('heatmap.heatmap_single_type',
            [
                'project'=>$project,
                'risk_type'=>$risk_type,
                'uniqueServicesCount' => $uniqueServicesCount,
                'uniqueGroupsCount' => $uniqueGroupsCount,
                'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
                'uniqueComponentsCount' => $uniqueComponentsCount,
                'service'=>$service,
                'serviceDetails'=>$serviceDetails,
                'results'=>$results,
                'likelihood_of_exploit'=>$likelihood_of_exploit
        
        

            ]);
        
        }


    public function select_assets($proj_id, Request $req)
    {

        $risk_type = $req->query('risk_type');
        session(['risk_type' => $risk_type]);
        $value = Session('risk_type');


        $services = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->select('s_name')
            ->distinct()
            ->get();

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        return view('heatmap.services', [
            'services' => $services,
            'project' => $project,
            'risk_type' => $value
        ]);
    }

    public function getGroups($service, $proj_id)
    {
        $value = Session('risk_type');
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $groups = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->whereNotNull('g_name')
            ->select('g_name')
            ->distinct()
            ->get();

        if ($groups->count() == 0) {
            return redirect()->route(
                'heatmap_no_groups_for_compliance_map',
                [
                    'proj_id' => $project->project_id,
                    'service' => $service,
                    'risk_type' => $value

                ]
            );

        }


        return view('heatmap.groups', [
            'project' => $project,
            'service' => $service,
            'groups' => $groups,
            'risk_type' => $value
        ]);

    }

    public function no_groups_for_compliance_map($proj_id, $service)
    {
        $value = Session('risk_type');
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $subgroups = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->whereNotNull('name')
            ->select('name')
            ->distinct()
            ->get();

        if ($subgroups->count() == 0) {
            $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->when($service != '_all', function ($query) use ($service) {
                    return $query->where('s_name', $service);
                })
                ->whereNotNull('c_name')
                ->select('c_name')
                ->distinct()
                ->get();

            return view('heatmap.components', [
                'project' => $project,
                'service' => $service,
                'group' => null,
                'subgroup' => null,
                'components' => $components,
                'risk_type' => $value

            ]);
        }

        return view('heatmap.from_service_to_subgroup', [
            'project' => $project,
            'service' => $service,
            'subgroups' => $subgroups,
            'risk_type' => $value

        ]);
    }


    public function getSubgroups($service, $group, $proj_id)
    {

        $value = Session('risk_type');
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $subgroups = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->when($group != '_all', function ($query) use ($group) {
                return $query->where('g_name', $group);
            })
            ->whereNotNull('name')
            ->select('name')
            ->distinct()
            ->get();

        if ($subgroups->count() == 0) {

            $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->when($service != '_all', function ($query) use ($service) {
                    return $query->where('s_name', $service);
                })
                ->when($group != '_all', function ($query) use ($group) {
                    return $query->where('g_name', $group);
                })
                ->whereNotNull('c_name')
                ->select('c_name')
                ->distinct()
                ->get();

            return view('heatmap.components', [
                'project' => $project,
                'service' => $service,
                'group' => $group,
                'subgroup' => null,
                'components' => $components,
                'risk_type' => $value

            ]);
        }


        return view('heatmap.subgroups', [
            'project' => $project,
            'group' => $group,
            'service' => $service,
            'subgroups' => $subgroups,
            'risk_type' => $value

        ]);
    }

    public function service_subgroups_to_components($service, $subgroup, $proj_id)
    {
        $value = Session('risk_type');
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->when($subgroup != '_all', function ($query) use ($subgroup) {
                return $query->where('name', $subgroup);
            })
            ->whereNotNull('c_name')
            ->select('c_name')
            ->distinct()
            ->get();


        return view('heatmap.components', [
            'project' => $project,
            'service' => $service,
            'group' => null,
            'subgroup' => $subgroup,
            'components' => $components
        ]);


    }

    public function getComponents($service, $group, $subgroup, $proj_id)
    {
        $value = Session('risk_type');

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->when($group != '_all', function ($query) use ($group) {
                return $query->where('g_name', $group);
            })
            ->when($subgroup != '_all', function ($query) use ($subgroup) {
                return $query->where('name', $subgroup);
            })
            ->whereNotNull('c_name')
            ->select('c_name')
            ->distinct()
            ->get();



        return view('heatmap.components', [
            'project' => $project,
            'group' => $group,
            'service' => $service,
            'subgroup' => $subgroup,
            'components' => $components,
            'risk_type' => $value

        ]);
    }
    public function risk_register_single_type($service, $component, $proj_id, Request $req){
        $group = $req->query('group');
        $subgroup = $req->query('subgroup');
        $risk_type = Session('risk_type');

        $assetIds = DB::table('iso_sec_2_1')
            ->where('project_id', $proj_id)
            ->when($service != '_all', function ($query) use ($service) {
                return $query->where('s_name', $service);
            })
            ->when($group, function ($query, $group) {
                return $query->when($group != '_all', function ($query) use ($group) {
                    return $query->where('g_name', $group);
                });
            })
            ->when($subgroup, function ($query, $subgroup) {
                return $query->when($subgroup != '_all', function ($query) use ($subgroup) {
                    return $query->where('name', $subgroup);
                });
            })
            ->when($component != '_all', function ($query) use ($component) {
                return $query->where('c_name', $component);
            })
            ->pluck('assessment_id')->toArray();

            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

            $results=DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)
            ->where('iso_sec_2_3_1.project_id', $proj_id)
            ->whereIn('iso_sec_2_3_1.asset_id', $assetIds)
            ->get();

            $files = [
                public_path('ISO_SOA_A5.xlsx'),
                public_path('ISO_SOA_A6.xlsx'),
                public_path('ISO_SOA_A7.xlsx'),
                public_path('ISO_SOA_A8.xlsx'),
            ];
            
            $all_data = [];
            
            foreach ($files as $file) {
                $data = Excel::toArray([], $file); // Get data with header
                $rows = array_slice($data[0], 1); // Remove header row
                $all_data = array_merge($all_data, $rows);
            }

   
            return view('heatmap.risk_register_single_type',[
                'project'=>$project,
                'results'=>$results,
                'risk_type'=>$risk_type,
                'all_data'=>$all_data,
                'service'=>$service,
                'group'=>$group,
                'subgroup'=>$subgroup,
                'component'=>$component
            ]);
    }

    public function download_excel_risk_register_single_type($service,$component,$proj_id,Request $req){
        $group = $req->query('group');
        $subgroup = $req->query('subgroup');
        $risk_type = Session('risk_type');

        $RiskToData=null;
        if($risk_type=='risk_level'){
            $RiskToData='Data Confidentiality';
        }

        if($risk_type=='risk_integrity'){
            $RiskToData='Data Integrity';
        }

        if($risk_type=='risk_availability'){
            $RiskToData='Data Availability';
        }

     

        $assetIds = DB::table('iso_sec_2_1')
        ->where('project_id', $proj_id)
        ->when($service != '_all', function ($query) use ($service) {
            return $query->where('s_name', $service);
        })
        ->when($group, function ($query, $group) {
            return $query->when($group != '_all', function ($query) use ($group) {
                return $query->where('g_name', $group);
            });
        })
        ->when($subgroup, function ($query, $subgroup) {
            return $query->when($subgroup != '_all', function ($query) use ($subgroup) {
                return $query->where('name', $subgroup);
            });
        })
        ->when($component != '_all', function ($query) use ($component) {
            return $query->where('c_name', $component);
        })
        ->pluck('assessment_id')->toArray();

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();

        $results=DB::table('iso_sec_2_3_1')->where('project_id',$proj_id)
        ->where('iso_sec_2_3_1.project_id', $proj_id)
        ->whereIn('iso_sec_2_3_1.asset_id', $assetIds)
        ->get()->toArray();

    

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)->first();
    
        $projectName = $project->project_name;



            return Excel::download(
                new RiskRegister($results,$risk_type,$RiskToData),
                $projectName . 'RiskRegister.xlsx'
            );
        

    
    }
}
