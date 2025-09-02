<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RiskRegisterController extends Controller
{
    public function risk_register_dashboard($proj_id, $user_id)
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
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                $assets = DB::table('iso_sec_2_1')
                    ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                    ->join('proj_asset_likelihood_value', 'iso_sec_2_1.assessment_id', 'proj_asset_likelihood_value.asset_id')
                    ->join('proj_asset_likelihood_timeframe', 'iso_sec_2_1.assessment_id', 'proj_asset_likelihood_timeframe.asset_id')
                    ->join('proj_asset_selected_level_of_threat', 'iso_sec_2_1.assessment_id', 'proj_asset_selected_level_of_threat.asset_id')
                    ->join('global_level_of_threats', 'proj_asset_selected_level_of_threat.threat_selected', 'global_level_of_threats.global_level_of_threats_id')
                    ->join('proj_asset_selected_level_of_vulnerability', 'iso_sec_2_1.assessment_id', 'proj_asset_selected_level_of_vulnerability.asset_id')
                    ->join('global_level_of_vulnerability', 'proj_asset_selected_level_of_vulnerability.vulnerability_selected', 'global_level_of_vulnerability.global_level_of_vulnerability_id')

                    ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                    ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                    ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                    ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                    ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                    ->select(
                        'iso_sec_2_1.*',
                        'proj_asset_likelihood_value.*',
                        'proj_asset_likelihood_timeframe.*',
                        'proj_asset_selected_level_of_threat.*',
                        'global_level_of_threats.*',
                        'proj_asset_selected_level_of_vulnerability.*',
                        'global_level_of_vulnerability.*',
                        DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                        DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                        DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                        DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                        DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                        DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                    )
                    ->where('iso_sec_2_1.project_id', $proj_id)
                    ->get();


                //dd($assets);

                $frameworkDetails = $this->getProjectFrameworkDetails($project);
                //dd($frameworkDetails);

                return view('risk_register.risk_register_dashboard', [

                    'project' => $project,
                    'assets' => $assets,
                    'project_permissions' => $checkpermission->project_permissions,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach']

                ]);
            }
        }

        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function view_risk_register_from_home($org_id)
    {
        return view('risk_register.view_risk_register_from_home');
    }


    public function index(string $dimension, int $orgId)
    {
        // Map each dimension to the columns we want to show (order matters)
        $columnSets = [
            'project' => [
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
            ],
            'services' => [
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
            ],
            'asset_types' => [
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
            ],
            'asset_sub_types' => [
                ['key' => 'name',          'label' => 'Asset Sub Type'],
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
            ],
            'components' => [
                ['key' => 'c_name',        'label' => 'Component'],
                ['key' => 'name',          'label' => 'Asset Sub Type'],
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                ['key' => 'type',        'label' => 'Project Type'],
                ['key' => 'data_confidentiality',        'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',        'label' => 'Data Integrity'],
                 ['key' => 'data_availability',        'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'qualitative_likelihood_risk_confidentiality_selected'],
                 ['key' => 'qualitative_likelihood_risk_integrity_selected', 'label' => 'qualitative_likelihood_risk_integrity_selected'],
                  ['key' => 'qualitative_likelihood_risk_availability_selected', 'label' => 'qualitative_likelihood_risk_availability_selected'],

                ['key' => 'framework_selected', 'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types', 'label' => "Framework Approach Type"],
                //qual_asset
                [
                    'key' => 'qual_asset_risk_confidentiality_calculated_matrix',
                    'label' => 'Data Confidentiality Risk',
                ],

                  [
                    'key' => 'qual_asset_risk_integrity_calculated_matrix',
                    'label' => 'Data Integrity Risk',
                ],

                  [
                    'key' => 'qual_asset_risk_availability_calculated_matrix',
                    'label' => 'Data Availability Risk',
                ],
                 
            ],
        ];

        abort_unless(isset($columnSets[$dimension]), 404);


        $q = DB::table('iso_sec_2_1 as i')
            ->join('projects as p', 'p.project_id', '=', 'i.project_id')
            ->join('project_types', 'p.project_type', 'project_types.id')
            ->join('org_projects_framework_selected', 'org_projects_framework_selected.project_type_id', 'project_types.id')
            ->join('org_risk_assessment_approach', 'org_risk_assessment_approach.project_type_id', 'project_types.id')
            ->join('org_framework_approach_selected', 'org_framework_approach_selected.project_type_id', 'project_types.id')
            ->leftjoin('proj_asset_likelihood_value', 'proj_asset_likelihood_value.project_id', 'p.project_id')
            ->where('p.org_id', $orgId);


        switch ($dimension) {
            case 'services':
                $q->whereNotNull('i.s_name');
                break;
            case 'asset_types':
                $q->whereNotNull('i.g_name');
                break;
            case 'asset_sub_types':
                $q->whereNotNull('i.name');
                break;
            case 'components':
                $q->whereNotNull('i.c_name'); // component required
                break;
            case 'project':
            default:
                // no extra filters
                break;
        }


        $selects = collect($columnSets[$dimension])->pluck('key')->map(function ($k) {
            if (in_array($k, ['project_name', 'status'])) {
                return "p.$k as $k";
            }
            if ($k === 'type') {
                return "project_types.type as type";
            }

    
            if ($k == 'framework_selected') {
                return "org_projects_framework_selected.framework_selected as framework_selected";
            }

            if ($k == 'assessment_approach_selected') {
                return "org_risk_assessment_approach.assessment_approach_selected";
            }

            if ($k == "framework_approach_types") {
                return "org_framework_approach_selected.framework_approach_types";
            }

               if ($k === 'data_confidentiality') {
                return "i.risk_confidentiality as data_confidentiality";
            }

            if ($k == 'qualitative_likelihood_risk_confidentiality_selected') {
                return "proj_asset_likelihood_value.qualitative_likelihood_risk_confidentiality_selected";
            }

               if ($k == 'qual_asset_risk_confidentiality_calculated_matrix') {
                  return DB::raw("'N/A' as qual_asset_risk_confidentiality_calculated_matrix");
            }

               if ($k === 'data_integrity') {
                return "i.risk_integrity as data_integrity";
            }

            if ($k == 'qualitative_likelihood_risk_integrity_selected') {
                return "proj_asset_likelihood_value.qualitative_likelihood_risk_integrity_selected";
            }

            if($k=='qual_asset_risk_integrity_calculated_matrix'){
                 return DB::raw("'N/A' as qual_asset_risk_integrity_calculated_matrix");
            }


            if ($k === 'data_availability') {
                return "i.risk_availability as data_availability";
            }

            if ($k == 'qualitative_likelihood_risk_availability_selected') {
                return "proj_asset_likelihood_value.qualitative_likelihood_risk_availability_selected";
            }

            if($k=='qual_asset_risk_availability_calculated_matrix'){
                 return DB::raw("'N/A' as qual_asset_risk_availability_calculated_matrix");
            }
            // Default → iso_sec_2_1 columns
            return "i.$k as $k";
        })->all();

        $rows = $q->select($selects)
            ->distinct()
            ->orderBy('p.project_name')
            ->get();

        $matrix = $this->qualitativeRiskMatrix();

        $rows->transform(function ($row) use ($matrix) {
            if (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 2 &&
                $row->framework_approach_types == 1
            ) {
                //qual-asset based
                $impact_data_confidentiality = $row->data_confidentiality; 
                $impact_data_integrity = $row->data_integrity; 
                 $impact_data_availability = $row->data_availability; 
               
                $likelihood_confidentiality = $row->qualitative_likelihood_risk_confidentiality_selected; 
                $likelihood_integrity = $row->qualitative_likelihood_risk_integrity_selected; 
                 $likelihood_availability = $row->qualitative_likelihood_risk_availability_selected; 

            

                if (isset($matrix[$impact_data_confidentiality][$likelihood_confidentiality])) {
                    $row->qual_asset_risk_confidentiality_calculated_matrix = $matrix[$impact_data_confidentiality][$likelihood_confidentiality];
                } else {
                    $row->qual_asset_risk_confidentiality_calculated_matrix = 'N/A';
                }

                 if (isset($matrix[$impact_data_integrity][$likelihood_integrity])) {
                    $row->qual_asset_risk_integrity_calculated_matrix = $matrix[$impact_data_integrity][$likelihood_integrity];
                } else {
                    $row->qual_asset_risk_integrity_calculated_matrix = 'N/A';
                }

                 if (isset($matrix[$impact_data_availability][$likelihood_availability])) {
                    $row->qual_asset_risk_availability_calculated_matrix = $matrix[$impact_data_availability][$likelihood_availability];
                } else {
                    $row->qual_asset_risk_availability_calculated_matrix = 'N/A';
                }
            } else {
                $row->qual_asset_risk_confidentiality_calculated_matrix = null; // not applicable
                $row->qual_asset_risk_integrity_calculated_matrix=null;
                $row->qual_asset_risk_availability_calculated_matrix=null;
            }

            return $row;
        });

       //dd($dimension, $columnSets[$dimension], $rows);

        return view('risk_register.index', [
            'dimension' => $dimension,
            'columns'   => $columnSets[$dimension],
            'rows'      => $rows,
            'orgId'     => $orgId,
        ]);
    }


    private function qualitativeRiskMatrix()
    {
        return [
            5 => [ // Catastrophic
                5 => 'Very high', // Almost certain
                4 => 'Very high', // Very likely
                3 => 'High',      // Likely
                2 => 'Medium',    // Rather unlikely
                1 => 'Low',       // Unlikely
            ],
            4 => [ // Critical
                5 => 'Very high',
                4 => 'High',
                3 => 'High',
                2 => 'Medium',
                1 => 'Low',
            ],
            3 => [ // Serious
                5 => 'High',
                4 => 'High',
                3 => 'Medium',
                2 => 'Low',
                1 => 'Low',
            ],
            2 => [ // Significant
                5 => 'High',
                4 => 'Medium',
                3 => 'Low',
                2 => 'Low',
                1 => 'Very low',
            ],
            1 => [ // Minor
                5 => 'Medium',
                4 => 'Low',
                3 => 'Low',
                2 => 'Very low',
                1 => 'Very low',
            ],
        ];
    }

    function getProjectFrameworkDetails($project)
    {
        $orgId = auth()->user()->organization->id;

        $complianceFramework = DB::table('org_projects_framework_selected')
            ->join('risk_management_framework', 'org_projects_framework_selected.framework_selected', '=', 'risk_management_framework.framework_id')
            ->where('org_id', $orgId)
            ->where('project_type_id', $project->project_type)
            ->first();

        $risk_assessment_approach = DB::table('org_risk_assessment_approach')
            ->join('global_risk_assessment_approach', 'org_risk_assessment_approach.assessment_approach_selected', '=', 'global_risk_assessment_approach.global_risk_assessment_approach_id')
            ->where('org_risk_assessment_approach.org_id', $orgId)
            ->where('project_type_id', $project->project_type)
            ->first();

        $framework_approach = DB::table('org_framework_approach_selected')
            ->join('framework_approach_types', 'org_framework_approach_selected.framework_approach_types', '=', 'framework_approach_types.framework_approach_types_id')
            ->where('org_framework_approach_selected.org_id', $orgId)
            ->where('project_type_id', $project->project_type)
            ->first();

        return compact('complianceFramework', 'risk_assessment_approach', 'framework_approach');
    }
}
