<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

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
                'totalConfidentialityCount'=>$totalConfidentialityCount,
                'overallConfidentialityRanges'=>$overallConfidentialityRanges,
                'data_integrity' => $data_integrity,
                'totalIntegrityCount'=>$totalIntegrityCount,
                'overallIntegrityRanges'=>$overallIntegrityRanges,
                'data_availability' => $data_availability,
                'totalAvailabilityCount'=>$totalAvailabilityCount,
                'overallAvailabilityRanges'=>$overallAvailabilityRanges

            ]);


        }
    }
}
