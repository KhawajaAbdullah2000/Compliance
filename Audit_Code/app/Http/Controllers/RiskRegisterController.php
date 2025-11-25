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
                ['key' => 'contains_assets', 'label' => 'Contains Asset Components'],

                ['key' => 'project_id', 'label' => "Project ID"],

            ],
            'services' => [
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

            ],
            'asset_types' => [
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

            ],
            'asset_sub_types' => [
                ['key' => 'name',          'label' => 'Asset Sub Type'],
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

            ],
            'components' => [
                ['key' => 'c_name',        'label' => 'Component'],
                ['key' => 'name',          'label' => 'Asset Sub Type'],
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                ['key' => 'risk_assessment', 'label' => "Risk Assessment Methodology"],


                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],
                ['key' => 'project_id', 'label' => "Project ID"],
                ['key' => 'assessment_id', 'label' => "Asset ID"],

            ],
        ];

        abort_unless(isset($columnSets[$dimension]), 404);

        $q = DB::table('projects as p')
            ->join('project_types', 'p.project_type', '=', 'project_types.id')
            ->join('org_projects_framework_selected', 'org_projects_framework_selected.project_type_id', '=', 'project_types.id')
            ->join('org_risk_assessment_approach', 'org_risk_assessment_approach.project_type_id', '=', 'project_types.id')
            ->join('org_framework_approach_selected', 'org_framework_approach_selected.project_type_id', '=', 'project_types.id')
            ->leftJoin('iso_sec_2_1 as i', 'i.project_id', '=', 'p.project_id') // 👈 flipped to LEFT JOIN
            ->leftJoin('proj_asset_likelihood_value', 'proj_asset_likelihood_value.project_id', '=', 'p.project_id')
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
                $q->whereNotNull('i.c_name');
                break;
            case 'project':
                $q->groupBy(
                    'p.project_id',
                    'p.project_name',
                    'p.status',
                    'org_projects_framework_selected.framework_selected',
                    'org_risk_assessment_approach.assessment_approach_selected',
                    'org_framework_approach_selected.framework_approach_types'
                );
                break;
            default:
                break;
        }

        if ($dimension === 'project') {
            $selects = [
                'p.project_id',
                'p.project_name',
                'p.status',
                DB::raw("CASE WHEN i.project_id IS NOT NULL THEN 'Yes' ELSE 'No' END as contains_assets"),
                'org_projects_framework_selected.framework_selected',
                'org_risk_assessment_approach.assessment_approach_selected',
                'org_framework_approach_selected.framework_approach_types',
            ];
        } else {
          
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

                // Map risk_* → data_*
                if ($k === 'data_confidentiality') {
                    return "i.risk_confidentiality as data_confidentiality";
                }
                if ($k === 'data_integrity') {
                    return "i.risk_integrity as data_integrity";
                }
                if ($k === 'data_availability') {
                    return "i.risk_availability as data_availability";
                }

                // Placeholders for calculated risks
                if ($k === 'data_confidentiality_risk') {
                    return DB::raw("NULL as data_confidentiality_risk");
                }
                if ($k === 'data_integrity_risk') {
                    return DB::raw("NULL as data_integrity_risk");
                }
                if ($k === 'data_availability_risk') {
                    return DB::raw("NULL as data_availability_risk");
                }

                // Likelihoods
                if ($k == 'qualitative_likelihood_risk_confidentiality_selected') {
                    return "proj_asset_likelihood_value.qualitative_likelihood_risk_confidentiality_selected";
                }
                if ($k == 'quantitative_likelihood_risk_confidentiality_selected') {
                    return "proj_asset_likelihood_value.quantitative_likelihood_risk_confidentiality_selected";
                }
                if ($k == 'qualitative_likelihood_risk_integrity_selected') {
                    return "proj_asset_likelihood_value.qualitative_likelihood_risk_integrity_selected";
                }
                if ($k == 'quantitative_likelihood_risk_integrity_selected') {
                    return "proj_asset_likelihood_value.quantitative_likelihood_risk_integrity_selected";
                }
                if ($k == 'qualitative_likelihood_risk_availability_selected') {
                    return "proj_asset_likelihood_value.qualitative_likelihood_risk_availability_selected";
                }
                if ($k == 'quantitative_likelihood_risk_availability_selected') {
                    return "proj_asset_likelihood_value.quantitative_likelihood_risk_availability_selected";
                }

                if ($k === 'contains_assets') {
                    return DB::raw("CASE WHEN i.project_id IS NOT NULL THEN 'Yes' ELSE 'No' END as contains_assets");
                }

                if ($k == 'risk_assessment') {
                    return DB::raw("NULL as risk_assessment");
                }

                // if($k=='project_id'){
                //     return 'p.project_id';
                // }

                // Defaults → iso_sec_2_1
                return "i.$k as $k";
            })->all();
        }



        // Ensure quantitative likelihood columns are always present (alias them explicitly)
        if ($dimension !== 'project') {
            $forceQuantitative = [
                "proj_asset_likelihood_value.quantitative_likelihood_risk_confidentiality_selected as quantitative_likelihood_risk_confidentiality_selected",
                "proj_asset_likelihood_value.quantitative_likelihood_risk_integrity_selected as quantitative_likelihood_risk_integrity_selected",
                "proj_asset_likelihood_value.quantitative_likelihood_risk_availability_selected as quantitative_likelihood_risk_availability_selected",
            ];

            foreach ($forceQuantitative as $fq) {
                if (! in_array($fq, $selects, true)) {
                    $selects[] = $fq;
                }
            }
        }

        $rows = $q->select($selects)
            ->distinct()
            ->orderBy('p.project_name')
            ->get();

        $rows->transform(function ($row) use ($dimension) {
            $row->data_confidentiality_risk = null;
            $row->data_integrity_risk = null;
            $row->data_availability_risk = null;

            if ($dimension === 'project') {
                return $row;
            }

            $hasQualInputs =
        !is_null($row->data_confidentiality) &&
        !is_null($row->data_integrity) &&
        !is_null($row->data_availability) &&
        !is_null($row->qualitative_likelihood_risk_confidentiality_selected) &&
        !is_null($row->qualitative_likelihood_risk_integrity_selected) &&
        !is_null($row->qualitative_likelihood_risk_availability_selected);

    $hasQuantInputs =
        !is_null($row->data_confidentiality) &&
        !is_null($row->data_integrity) &&
        !is_null($row->data_availability) &&
        !is_null($row->quantitative_likelihood_risk_confidentiality_selected) &&
        !is_null($row->quantitative_likelihood_risk_integrity_selected) &&
        !is_null($row->quantitative_likelihood_risk_availability_selected);




            if (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 2 &&
                $row->framework_approach_types == 1  && $hasQualInputs
            ) {

                $row->risk_assessment = 'Qualitative Asset Based';


                // Qualitative Asset
                $matrix = $this->qualitativeRiskMatrix();

                $row->data_confidentiality_risk = $matrix[$row->data_confidentiality][$row->qualitative_likelihood_risk_confidentiality_selected] ?? 'N/A';
                $row->data_integrity_risk       = $matrix[$row->data_integrity][$row->qualitative_likelihood_risk_integrity_selected] ?? 'N/A';
                $row->data_availability_risk    = $matrix[$row->data_availability][$row->qualitative_likelihood_risk_availability_selected] ?? 'N/A';
            } elseif (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 2 &&
                $row->framework_approach_types == 2
            ) {
                // Quantitative Asset

                $row->risk_assessment = 'Quantitative Asset Based';

                $matrix = $this->quantitativeRiskMatrix();
                $severityLabels   = $this->severityLabels();
                $likelihoodLabels = $this->likelihoodLabels();


                $row->data_confidentiality_risk = isset($severityLabels[$row->data_confidentiality], $likelihoodLabels[$row->quantitative_likelihood_risk_confidentiality_selected])
                    ? $severityLabels[$row->data_confidentiality] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_confidentiality_selected]
                    : 'N/A';

                $row->data_integrity_risk = isset($severityLabels[$row->data_integrity], $likelihoodLabels[$row->quantitative_likelihood_risk_integrity_selected])
                    ? $severityLabels[$row->data_integrity] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_integrity_selected]
                    : 'N/A';

                $row->data_availability_risk = isset($severityLabels[$row->data_availability], $likelihoodLabels[$row->quantitative_likelihood_risk_availability_selected])
                    ? $severityLabels[$row->data_availability] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_availability_selected]
                    : 'N/A';
            } elseif (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 1 &&
                $row->framework_approach_types == 1
            ) {

                $row->risk_assessment = 'Qualitative Event Based';
            } else {
                $row->risk_assessment = 'Default';
            }

            return $row;
        });


      // dd($rows);

       

        return view('risk_register.index', [
            'dimension' => $dimension,
            'columns'   => $columnSets[$dimension],
            'rows'      => $rows,
            'orgId'     => $orgId,
        ]);
    }


    public function index_project(string $dimension, int $orgId, int $proj_id)
    {
        // Map each dimension to the columns we want to show (order matters)
        $columnSets = [
            'project' => [
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                ['key' => 'contains_assets', 'label' => 'Contains Asset Components'],

                ['key' => 'project_id', 'label' => "Project ID"],

            ],
            'services' => [
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

            ],
            'asset_types' => [
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

            ],
            'asset_sub_types' => [
                ['key' => 'name',          'label' => 'Asset Sub Type'],
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

            ],
            'components' => [
                ['key' => 'c_name',        'label' => 'Component'],
                ['key' => 'name',          'label' => 'Asset Sub Type'],
                ['key' => 'g_name',        'label' => 'Asset Type'],
                ['key' => 's_name',        'label' => 'Service'],
                ['key' => 'project_name',  'label' => 'Project'],
                ['key' => 'status',        'label' => 'Status'],
                ['key' => 'risk_assessment', 'label' => "Risk Assessment Methodology"],


                // These three must map to risk_* in iso_sec_2_1
                ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
                ['key' => 'data_integrity',       'label' => 'Data Integrity'],
                ['key' => 'data_availability',    'label' => 'Data Availability'],

                ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
                ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
                ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

                ['key' => 'framework_selected',          'label' => 'Framework Selected'],
                ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
                ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

                ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
                ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
                ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],
                ['key' => 'project_id', 'label' => "Project ID"],
                ['key' => 'assessment_id', 'label' => "Asset ID"],

            ],
        ];

        abort_unless(isset($columnSets[$dimension]), 404);

        $q = DB::table('projects as p')
            ->join('project_types', 'p.project_type', '=', 'project_types.id')
            ->join('org_projects_framework_selected', 'org_projects_framework_selected.project_type_id', '=', 'project_types.id')
            ->join('org_risk_assessment_approach', 'org_risk_assessment_approach.project_type_id', '=', 'project_types.id')
            ->join('org_framework_approach_selected', 'org_framework_approach_selected.project_type_id', '=', 'project_types.id')
            ->leftJoin('iso_sec_2_1 as i', 'i.project_id', '=', 'p.project_id') // 👈 flipped to LEFT JOIN
            ->leftJoin('proj_asset_likelihood_value', 'proj_asset_likelihood_value.project_id', '=', 'p.project_id')
            ->where('p.org_id', $orgId)
            ->where('p.project_id', $proj_id);



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
                $q->whereNotNull('i.c_name');
                break;
            case 'project':
                $q->groupBy(
                    'p.project_id',
                    'p.project_name',
                    'p.status',
                    'org_projects_framework_selected.framework_selected',
                    'org_risk_assessment_approach.assessment_approach_selected',
                    'org_framework_approach_selected.framework_approach_types'
                );
                break;
            default:
                break;
        }

        if ($dimension === 'project') {
            $selects = [
                'p.project_id',
                'p.project_name',
                'p.status',
                DB::raw("CASE WHEN i.project_id IS NOT NULL THEN 'Yes' ELSE 'No' END as contains_assets"),
                'org_projects_framework_selected.framework_selected',
                'org_risk_assessment_approach.assessment_approach_selected',
                'org_framework_approach_selected.framework_approach_types',
            ];
        } else {
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

                // Map risk_* → data_*
                if ($k === 'data_confidentiality') {
                    return "i.risk_confidentiality as data_confidentiality";
                }
                if ($k === 'data_integrity') {
                    return "i.risk_integrity as data_integrity";
                }
                if ($k === 'data_availability') {
                    return "i.risk_availability as data_availability";
                }

                // Placeholders for calculated risks
                if ($k === 'data_confidentiality_risk') {
                    return DB::raw("NULL as data_confidentiality_risk");
                }
                if ($k === 'data_integrity_risk') {
                    return DB::raw("NULL as data_integrity_risk");
                }
                if ($k === 'data_availability_risk') {
                    return DB::raw("NULL as data_availability_risk");
                }

                // Likelihoods
                if ($k == 'qualitative_likelihood_risk_confidentiality_selected') {
                    return "proj_asset_likelihood_value.qualitative_likelihood_risk_confidentiality_selected";
                }
                if ($k == 'quantitative_likelihood_risk_confidentiality_selected') {
                    return "proj_asset_likelihood_value.quantitative_likelihood_risk_confidentiality_selected";
                }
                if ($k == 'qualitative_likelihood_risk_integrity_selected') {
                    return "proj_asset_likelihood_value.qualitative_likelihood_risk_integrity_selected";
                }
                if ($k == 'quantitative_likelihood_risk_integrity_selected') {
                    return "proj_asset_likelihood_value.quantitative_likelihood_risk_integrity_selected";
                }
                if ($k == 'qualitative_likelihood_risk_availability_selected') {
                    return "proj_asset_likelihood_value.qualitative_likelihood_risk_availability_selected";
                }
                if ($k == 'quantitative_likelihood_risk_availability_selected') {
                    return "proj_asset_likelihood_value.quantitative_likelihood_risk_availability_selected";
                }

                if ($k === 'contains_assets') {
                    return DB::raw("CASE WHEN i.project_id IS NOT NULL THEN 'Yes' ELSE 'No' END as contains_assets");
                }

                if ($k == 'risk_assessment') {
                    return DB::raw("NULL as risk_assessment");
                }

                // if($k=='project_id'){
                //     return 'p.project_id';
                // }

                // Defaults → iso_sec_2_1
                return "i.$k as $k";
            })->all();
        }


        // Ensure quantitative likelihood columns are always present (alias them explicitly)
        if ($dimension !== 'project') {
            $forceQuantitative = [
                "proj_asset_likelihood_value.quantitative_likelihood_risk_confidentiality_selected as quantitative_likelihood_risk_confidentiality_selected",
                "proj_asset_likelihood_value.quantitative_likelihood_risk_integrity_selected as quantitative_likelihood_risk_integrity_selected",
                "proj_asset_likelihood_value.quantitative_likelihood_risk_availability_selected as quantitative_likelihood_risk_availability_selected",
            ];

            foreach ($forceQuantitative as $fq) {
                if (! in_array($fq, $selects, true)) {
                    $selects[] = $fq;
                }
            }
        }

        $rows = $q->select($selects)
            ->distinct()
            ->orderBy('p.project_name')
            ->get();

        $rows->transform(function ($row) use ($dimension) {
            $row->data_confidentiality_risk = null;
            $row->data_integrity_risk = null;
            $row->data_availability_risk = null;

            if ($dimension === 'project') {
                return $row;
            }


            if (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 2 &&
                $row->framework_approach_types == 1
            ) {

                $row->risk_assessment = 'Qualitative Asset Based';


                // Qualitative Asset
                $matrix = $this->qualitativeRiskMatrix();

                $row->data_confidentiality_risk = $matrix[$row->data_confidentiality][$row->qualitative_likelihood_risk_confidentiality_selected] ?? 'N/A';
                $row->data_integrity_risk       = $matrix[$row->data_integrity][$row->qualitative_likelihood_risk_integrity_selected] ?? 'N/A';
                $row->data_availability_risk    = $matrix[$row->data_availability][$row->qualitative_likelihood_risk_availability_selected] ?? 'N/A';
            } elseif (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 2 &&
                $row->framework_approach_types == 2
            ) {
                // Quantitative Asset

                $row->risk_assessment = 'Quantitative Asset Based';

                $matrix = $this->quantitativeRiskMatrix();
                $severityLabels   = $this->severityLabels();
                $likelihoodLabels = $this->likelihoodLabels();


                $row->data_confidentiality_risk = isset($severityLabels[$row->data_confidentiality], $likelihoodLabels[$row->quantitative_likelihood_risk_confidentiality_selected])
                    ? $severityLabels[$row->data_confidentiality] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_confidentiality_selected]
                    : 'N/A';

                $row->data_integrity_risk = isset($severityLabels[$row->data_integrity], $likelihoodLabels[$row->quantitative_likelihood_risk_integrity_selected])
                    ? $severityLabels[$row->data_integrity] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_integrity_selected]
                    : 'N/A';

                $row->data_availability_risk = isset($severityLabels[$row->data_availability], $likelihoodLabels[$row->quantitative_likelihood_risk_availability_selected])
                    ? $severityLabels[$row->data_availability] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_availability_selected]
                    : 'N/A';
            } elseif (
                $row->framework_selected == 2 &&
                $row->assessment_approach_selected == 1 &&
                $row->framework_approach_types == 1
            ) {

                $row->risk_assessment = 'Qualitative Event Based';
            } else {
                $row->risk_assessment = 'Default';
            }

            return $row;
        });

        //  dd($rows);
        // dd($dimension);

        return view('risk_register.index_project', [
            'dimension' => $dimension,
            'columns'   => $columnSets[$dimension],
            'rows'      => $rows,
            'orgId'     => $orgId,
        ]);
    }



    // public function index_project(string $dimension, int $orgId, int $proj_id)
    // {
    //     // Map each dimension to the columns we want to show (order matters)
    //     $columnSets = [
    //         'project' => [
    //             ['key' => 'project_name',  'label' => 'Project'],
    //             ['key' => 'status',        'label' => 'Status'],
    //             ['key' => 'contains_assets', 'label' => 'Contains Asset Components'],

    //             ['key' => 'project_id', 'label' => "Project ID"],

    //         ],
    //         'services' => [
    //             ['key' => 's_name',        'label' => 'Service'],
    //             ['key' => 'project_name',  'label' => 'Project'],
    //             ['key' => 'status',        'label' => 'Status'],
    //             // These three must map to risk_* in iso_sec_2_1
    //             ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
    //             ['key' => 'data_integrity',       'label' => 'Data Integrity'],
    //             ['key' => 'data_availability',    'label' => 'Data Availability'],

    //             ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
    //             ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
    //             ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

    //             ['key' => 'framework_selected',          'label' => 'Framework Selected'],
    //             ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
    //             ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

    //             ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
    //             ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
    //             ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

    //         ],
    //         'asset_types' => [
    //             ['key' => 'g_name',        'label' => 'Asset Type'],
    //             ['key' => 's_name',        'label' => 'Service'],
    //             ['key' => 'project_name',  'label' => 'Project'],
    //             ['key' => 'status',        'label' => 'Status'],
    //             // These three must map to risk_* in iso_sec_2_1
    //             ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
    //             ['key' => 'data_integrity',       'label' => 'Data Integrity'],
    //             ['key' => 'data_availability',    'label' => 'Data Availability'],

    //             ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
    //             ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
    //             ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

    //             ['key' => 'framework_selected',          'label' => 'Framework Selected'],
    //             ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
    //             ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

    //             ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
    //             ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
    //             ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

    //         ],
    //         'asset_sub_types' => [
    //             ['key' => 'name',          'label' => 'Asset Sub Type'],
    //             ['key' => 'g_name',        'label' => 'Asset Type'],
    //             ['key' => 's_name',        'label' => 'Service'],
    //             ['key' => 'project_name',  'label' => 'Project'],
    //             ['key' => 'status',        'label' => 'Status'],
    //             // These three must map to risk_* in iso_sec_2_1
    //             ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
    //             ['key' => 'data_integrity',       'label' => 'Data Integrity'],
    //             ['key' => 'data_availability',    'label' => 'Data Availability'],

    //             ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
    //             ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
    //             ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

    //             ['key' => 'framework_selected',          'label' => 'Framework Selected'],
    //             ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
    //             ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

    //             ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
    //             ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
    //             ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],

    //         ],
    //         'components' => [
    //             ['key' => 'c_name',        'label' => 'Component'],
    //             ['key' => 'name',          'label' => 'Asset Sub Type'],
    //             ['key' => 'g_name',        'label' => 'Asset Type'],
    //             ['key' => 's_name',        'label' => 'Service'],
    //             ['key' => 'project_name',  'label' => 'Project'],
    //             ['key' => 'status',        'label' => 'Status'],


    //             // These three must map to risk_* in iso_sec_2_1
    //             ['key' => 'data_confidentiality', 'label' => 'Data Confidentiality'],
    //             ['key' => 'data_integrity',       'label' => 'Data Integrity'],
    //             ['key' => 'data_availability',    'label' => 'Data Availability'],

    //             ['key' => 'qualitative_likelihood_risk_confidentiality_selected', 'label' => 'Qual Likelihood Confidentiality'],
    //             ['key' => 'qualitative_likelihood_risk_integrity_selected',       'label' => 'Qual Likelihood Integrity'],
    //             ['key' => 'qualitative_likelihood_risk_availability_selected',    'label' => 'Qual Likelihood Availability'],

    //             ['key' => 'framework_selected',          'label' => 'Framework Selected'],
    //             ['key' => "assessment_approach_selected", 'label' => "Assessment Approach Selected"],
    //             ['key' => 'framework_approach_types',    'label' => "Framework Approach Type"],

    //             ['key' => 'data_confidentiality_risk',   'label' => 'Data Confidentiality Risk'],
    //             ['key' => 'data_integrity_risk',         'label' => 'Data Integrity Risk'],
    //             ['key' => 'data_availability_risk',      'label' => 'Data Availability Risk'],
    //             ['key' => 'project_id', 'label' => "Project ID"],
    //             ['key' => 'assessment_id', 'label' => "Asset ID"]
    //         ],
    //     ];

    //     abort_unless(isset($columnSets[$dimension]), 404);

    //     $q = DB::table('projects as p')
    //         ->join('project_types', 'p.project_type', '=', 'project_types.id')
    //         ->join('org_projects_framework_selected', 'org_projects_framework_selected.project_type_id', '=', 'project_types.id')
    //         ->join('org_risk_assessment_approach', 'org_risk_assessment_approach.project_type_id', '=', 'project_types.id')
    //         ->join('org_framework_approach_selected', 'org_framework_approach_selected.project_type_id', '=', 'project_types.id')
    //         ->leftJoin('iso_sec_2_1 as i', 'i.project_id', '=', 'p.project_id') // 👈 flipped to LEFT JOIN
    //         ->leftJoin('proj_asset_likelihood_value', 'proj_asset_likelihood_value.project_id', '=', 'p.project_id')
    //         ->where('p.org_id', $orgId)
    //         ->where('p.project_id', $proj_id);



    //     switch ($dimension) {
    //         case 'services':
    //             $q->whereNotNull('i.s_name');
    //             break;
    //         case 'asset_types':
    //             $q->whereNotNull('i.g_name');
    //             break;
    //         case 'asset_sub_types':
    //             $q->whereNotNull('i.name');
    //             break;
    //         case 'components':
    //             $q->whereNotNull('i.c_name');
    //             break;
    //         case 'project':
    //             $q->groupBy(
    //                 'p.project_id',
    //                 'p.project_name',
    //                 'p.status',
    //                 'org_projects_framework_selected.framework_selected',
    //                 'org_risk_assessment_approach.assessment_approach_selected',
    //                 'org_framework_approach_selected.framework_approach_types'
    //             );
    //             break;
    //         default:
    //             break;
    //     }

    //     if ($dimension === 'project') {
    //         $selects = [
    //             'p.project_id',
    //             'p.project_name',
    //             'p.status',
    //             DB::raw("CASE WHEN i.project_id IS NOT NULL THEN 'Yes' ELSE 'No' END as contains_assets"),
    //             'org_projects_framework_selected.framework_selected',
    //             'org_risk_assessment_approach.assessment_approach_selected',
    //             'org_framework_approach_selected.framework_approach_types',
    //         ];
    //     } else {
    //         $selects = collect($columnSets[$dimension])->pluck('key')->map(function ($k) {
    //             if (in_array($k, ['project_name', 'status'])) {
    //                 return "p.$k as $k";
    //             }
    //             if ($k === 'type') {
    //                 return "project_types.type as type";
    //             }
    //             if ($k == 'framework_selected') {
    //                 return "org_projects_framework_selected.framework_selected as framework_selected";
    //             }
    //             if ($k == 'assessment_approach_selected') {
    //                 return "org_risk_assessment_approach.assessment_approach_selected";
    //             }
    //             if ($k == "framework_approach_types") {
    //                 return "org_framework_approach_selected.framework_approach_types";
    //             }

    //             // Map risk_* → data_*
    //             if ($k === 'data_confidentiality') {
    //                 return "i.risk_confidentiality as data_confidentiality";
    //             }
    //             if ($k === 'data_integrity') {
    //                 return "i.risk_integrity as data_integrity";
    //             }
    //             if ($k === 'data_availability') {
    //                 return "i.risk_availability as data_availability";
    //             }

    //             // Placeholders for calculated risks
    //             if ($k === 'data_confidentiality_risk') {
    //                 return DB::raw("NULL as data_confidentiality_risk");
    //             }
    //             if ($k === 'data_integrity_risk') {
    //                 return DB::raw("NULL as data_integrity_risk");
    //             }
    //             if ($k === 'data_availability_risk') {
    //                 return DB::raw("NULL as data_availability_risk");
    //             }

    //             // Likelihoods
    //             if ($k == 'qualitative_likelihood_risk_confidentiality_selected') {
    //                 return "proj_asset_likelihood_value.qualitative_likelihood_risk_confidentiality_selected";
    //             }
    //             if ($k == 'quantitative_likelihood_risk_confidentiality_selected') {
    //                 return "proj_asset_likelihood_value.quantitative_likelihood_risk_confidentiality_selected";
    //             }
    //             if ($k == 'qualitative_likelihood_risk_integrity_selected') {
    //                 return "proj_asset_likelihood_value.qualitative_likelihood_risk_integrity_selected";
    //             }
    //             if ($k == 'quantitative_likelihood_risk_integrity_selected') {
    //                 return "proj_asset_likelihood_value.quantitative_likelihood_risk_integrity_selected";
    //             }
    //             if ($k == 'qualitative_likelihood_risk_availability_selected') {
    //                 return "proj_asset_likelihood_value.qualitative_likelihood_risk_availability_selected";
    //             }
    //             if ($k == 'quantitative_likelihood_risk_availability_selected') {
    //                 return "proj_asset_likelihood_value.quantitative_likelihood_risk_availability_selected";
    //             }

    //             if ($k === 'contains_assets') {
    //                 return DB::raw("CASE WHEN i.project_id IS NOT NULL THEN 'Yes' ELSE 'No' END as contains_assets");
    //             }

    //             // if($k=='project_id'){
    //             //     return 'p.project_id';
    //             // }

    //             // Defaults → iso_sec_2_1
    //             return "i.$k as $k";
    //         })->all();
    //     }


    //     // Ensure quantitative likelihood columns are always present (alias them explicitly)
    //     if ($dimension !== 'project') {
    //         $forceQuantitative = [
    //             "proj_asset_likelihood_value.quantitative_likelihood_risk_confidentiality_selected as quantitative_likelihood_risk_confidentiality_selected",
    //             "proj_asset_likelihood_value.quantitative_likelihood_risk_integrity_selected as quantitative_likelihood_risk_integrity_selected",
    //             "proj_asset_likelihood_value.quantitative_likelihood_risk_availability_selected as quantitative_likelihood_risk_availability_selected",
    //         ];

    //         foreach ($forceQuantitative as $fq) {
    //             if (! in_array($fq, $selects, true)) {
    //                 $selects[] = $fq;
    //             }
    //         }
    //     }

    //     $rows = $q->select($selects)
    //         ->distinct()
    //         ->orderBy('p.project_name')
    //         ->get();

    //     $rows->transform(function ($row) use ($dimension) {
    //         $row->data_confidentiality_risk = null;
    //         $row->data_integrity_risk = null;
    //         $row->data_availability_risk = null;

    //         if ($dimension === 'project') {
    //             return $row;
    //         }

    //         if (
    //             $row->framework_selected == 2 &&
    //             $row->assessment_approach_selected == 2 &&
    //             $row->framework_approach_types == 1
    //         ) {
    //             // Qualitative
    //             $matrix = $this->qualitativeRiskMatrix();

    //             $row->data_confidentiality_risk = $matrix[$row->data_confidentiality][$row->qualitative_likelihood_risk_confidentiality_selected] ?? 'N/A';
    //             $row->data_integrity_risk       = $matrix[$row->data_integrity][$row->qualitative_likelihood_risk_integrity_selected] ?? 'N/A';
    //             $row->data_availability_risk    = $matrix[$row->data_availability][$row->qualitative_likelihood_risk_availability_selected] ?? 'N/A';
    //         } elseif (
    //             $row->framework_selected == 2 &&
    //             $row->assessment_approach_selected == 2 &&
    //             $row->framework_approach_types == 2
    //         ) {
    //             // Quantitative
    //             $matrix = $this->quantitativeRiskMatrix();
    //             $severityLabels   = $this->severityLabels();
    //             $likelihoodLabels = $this->likelihoodLabels();


    //             $row->data_confidentiality_risk = isset($severityLabels[$row->data_confidentiality], $likelihoodLabels[$row->quantitative_likelihood_risk_confidentiality_selected])
    //                 ? $severityLabels[$row->data_confidentiality] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_confidentiality_selected]
    //                 : 'N/A';

    //             $row->data_integrity_risk = isset($severityLabels[$row->data_integrity], $likelihoodLabels[$row->quantitative_likelihood_risk_integrity_selected])
    //                 ? $severityLabels[$row->data_integrity] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_integrity_selected]
    //                 : 'N/A';

    //             $row->data_availability_risk = isset($severityLabels[$row->data_availability], $likelihoodLabels[$row->quantitative_likelihood_risk_availability_selected])
    //                 ? $severityLabels[$row->data_availability] . ' - ' . $likelihoodLabels[$row->quantitative_likelihood_risk_availability_selected]
    //                 : 'N/A';
    //         }

    //         return $row;
    //     });

    //  //  dd($rows);
    //     // dd($dimension);

    //     return view('risk_register.index_project', [
    //         'dimension' => $dimension,
    //         'columns'   => $columnSets[$dimension],
    //         'rows'      => $rows,
    //         'orgId'     => $orgId,

    //     ]);
    // }



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

    private function quantitativeRiskMatrix()
    {
        return [
            5 => [ // Catastrophic
                6 => 30, //every hour 
                5 => 25, //every 8 hour
                4 => 20, //twice a week 
                3 => 15, //once a month
                2 => 10, //once a year
                1 => 5 //once a decade
            ],
            4 => [ // Critical
                6 => 24,
                5 => 20,
                4 => 16,
                3 => 12,
                2 => 8,
                1 => 4
            ],
            3 => [ // Serious
                6 => 18,
                5 => 15,
                4 => 12,
                3 => 9,
                2 => 6,
                1 => 3
            ],
            2 => [ // Significant
                6 => 12,
                5 => 10,
                4 => 8,
                3 => 6,
                2 => 4,
                1 => 2
            ],
            1 => [ // Minor
                6 => 6,
                5 => 5,
                4 => 4,
                3 => 3,
                2 => 2,
                1 => 1
            ],
        ];
    }

    private function severityLabels()
    {
        return [
            5 => 'Catastrophic',
            4 => 'Critical',
            3 => 'Serious',
            2 => 'Significant',
            1 => 'Minor',
        ];
    }

    private function likelihoodLabels()
    {
        return [
            6 => 'Every Hour',
            5 => 'Every 8 Hours',
            4 => 'Twice a Week',
            3 => 'Once a Month',
            2 => 'Once a Year',
            1 => 'Once a Decade',
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
