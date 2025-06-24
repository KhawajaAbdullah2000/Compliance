<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplianceStatusExport;
use App\Exports\ComplianceStatusSubDomainExport;

class ComplianceMap extends Controller
{

    public function compliance_map_dashboard_all_services($proj_id, $user_id)
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


            //KSA NCA
            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.title_num AS Domain',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->groupBy('compliance.title_num', 'compliance.comp_status') // Group by service, component, and comp_status
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
                    $formattedResults[$domain][$status] = 0;
                }

                // Add the count to the respective comp_status
                $formattedResults[$domain][$status] += $count;

                // Update the grand totals for each status
                $totalCounts[$status] += $count;
            }
            // Add the total for all rows
            $totalCounts['total'] = array_sum($totalCounts);

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

            if (session('comp_status')) {
                session()->forget('comp_status');
            }

            return view('compliance_map.dashboard', [
                'project' => $project,
                'uniqueServicesCount' => $uniqueServicesCount,
                'uniqueGroupsCount' => $uniqueGroupsCount,
                'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
                'uniqueComponentsCount' => $uniqueComponentsCount,
                'formattedResults' => $formattedResults,
            ]);
        }
    }




    public function compliances_all_projects_in_org($org_id)
    {
        $projects = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.org_id', $org_id)->get();

        $allProjectsResults = [];

        foreach ($projects as $project) {
            $proj_id = $project->project_id;

            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.title_num AS Domain',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->groupBy('compliance.title_num', 'compliance.comp_status') // Group by service, component, and comp_status
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
                    $formattedResults[$domain][$status] = 0;
                }

                // Add the count to the respective comp_status
                $formattedResults[$domain][$status] += $count;

                // Update the grand totals for each status
                $totalCounts[$status] += $count;
            }
            // Add the total for all rows
            $totalCounts['total'] = array_sum($totalCounts);


            $allProjectsResults[$proj_id] = [
                'project_name' => $project->project_name, // Assuming the project has a 'name' field
                'compliance_results' => $formattedResults,
                'total_counts' => $totalCounts,
            ];
        }


        return view('compliance_map.projects_in_org_dashboard', [
            'project' => $project,
            'formattedResults' => $allProjectsResults,
        ]);
    }

    public function compliance_map_all_services(int $proj_id, int $user_id)
    {
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();



        $domainNames = config('domain-names')[$project->project_type] ?? [];

        $results = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->select(
                'compliance.title_num AS Domain',
                'compliance.comp_status',
                DB::raw('COUNT(compliance.comp_status) AS status_count')
            )
            ->where('assets.project_id', $proj_id)
            ->groupBy('compliance.title_num', 'compliance.comp_status') // Group by service, component, and comp_status
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
                $formattedResults[$domain][$status] = 0;
            }

            // Add the count to the respective comp_status
            $formattedResults[$domain][$status] += $count;

            // Update the grand totals for each status
            $totalCounts[$status] += $count;
        }
        // Add the total for all rows
        $totalCounts['total'] = array_sum($totalCounts);

        $uniqueServices = DB::table('iso_sec_2_1')
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

        // 4)  One single view
        return view('compliance_map.all_services_all_controls', [
            'project'               => $project,
            'domainNames'           => $domainNames,
            'formattedResults'      => $formattedResults,
            'uniqueServicesCount'   => $uniqueServices,
            'uniqueGroupsCount'     => $uniqueGroupsCount,
            'uniqueSubGroupsCount'  => $uniqueSubGroupsCount,
            'uniqueComponentsCount' => $uniqueComponentsCount,
        ]);
    }




    // public function compliance_map_all_services($proj_id, $user_id)
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
    //         $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
    //             ->where('projects.project_id', $proj_id)->first();

    //         //KSA NCA
    //         $results = DB::table('iso_sec_2_1 AS assets')
    //             ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
    //             ->select(
    //                 'compliance.title_num AS Domain',
    //                 'compliance.comp_status',
    //                 DB::raw('COUNT(compliance.comp_status) AS status_count')
    //             )
    //             ->where('assets.project_id', $proj_id)
    //             ->groupBy('compliance.title_num', 'compliance.comp_status') // Group by service, component, and comp_status
    //             ->orderBy('compliance.title_num') // Optional: Order by service name
    //             ->get();

    //         $formattedResults = [];
    //         $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];

    //         foreach ($results as $result) {
    //             $domain = $result->Domain;
    //             $status = $result->comp_status;
    //             $count = $result->status_count;

    //             // Initialize domain
    //             if (!isset($formattedResults[$domain])) {
    //                 $formattedResults[$domain] = [];
    //             }

    //             if (!isset($formattedResults[$domain][$status])) {
    //                 $formattedResults[$domain][$status] = 0;
    //             }

    //             // Add the count to the respective comp_status
    //             $formattedResults[$domain][$status] += $count;

    //             // Update the grand totals for each status
    //             $totalCounts[$status] += $count;
    //         }
    //         // Add the total for all rows
    //         $totalCounts['total'] = array_sum($totalCounts);

    //         $uniqueServicesCount = DB::table('iso_sec_2_1')
    //             ->where('project_id', $proj_id)
    //             ->distinct()
    //             ->count('s_name');

    //         $uniqueGroupsCount = DB::table('iso_sec_2_1')
    //             ->where('project_id', $proj_id)
    //             ->distinct()
    //             ->count('g_name');

    //         $uniqueSubGroupsCount = DB::table('iso_sec_2_1')
    //             ->where('project_id', $proj_id)
    //             ->distinct()
    //             ->count('name');

    //         $uniqueComponentsCount = DB::table('iso_sec_2_1')
    //             ->where('project_id', $proj_id)
    //             ->distinct()
    //             ->count('c_name');

    //         //KSA
    //         if ($project->project_type == 7) {
    //             return view('compliance_map.ksa_nca_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         if ($project->project_type == 18) {
    //             //coso
    //             return view('compliance_map.coso_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         if ($project->project_type == 19) {
    //             //coso
    //             return view('compliance_map.soc2_type2_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }




    //         //PCI SIngle
    //         if ($project->project_type == 1) {

    //             return view('compliance_map.pci_single_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //PCI Multi
    //         if ($project->project_type == 2) {

    //             return view('compliance_map.pci_multi_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //PCI Merchant
    //         if ($project->project_type == 3) {

    //             return view('compliance_map.pci_merchant_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //CY SAMA
    //         if ($project->project_type == 5) {

    //             return view('compliance_map.cy_sama_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //SBP ETGRMF
    //         if ($project->project_type == 6) {

    //             return view('compliance_map.sbp_etgrmf_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //UAE IA
    //         if ($project->project_type == 8) {
    //             return view('compliance_map.uae_ia_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //ISO
    //         if ($project->project_type == 4) {
    //             return view('compliance_map.iso_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //IS part 3-2
    //         if ($project->project_type == 10) {
    //             return view('compliance_map.isa_3_2_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //IS part 4-2
    //         if ($project->project_type == 12) {
    //             return view('compliance_map.isa_4_2_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //ISA part 3-3
    //         if ($project->project_type == 13) {
    //             return view('compliance_map.isa_3_3_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }
    //         //ISA part 2-1
    //         if ($project->project_type == 11) {
    //             return view('compliance_map.isa_2_1_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }

    //         //ISA part 4-1
    //         if ($project->project_type == 9) {

    //             return view('compliance_map.isa_4_1_all_services_all_controls', [
    //                 'project' => $project,
    //                 'uniqueServicesCount' => $uniqueServicesCount,
    //                 'uniqueGroupsCount' => $uniqueGroupsCount,
    //                 'uniqueSubGroupsCount' => $uniqueSubGroupsCount,
    //                 'uniqueComponentsCount' => $uniqueComponentsCount,
    //                 'formattedResults' => $formattedResults,
    //             ]);
    //         }
    //     } else {
    //         return redirect()->back()->with('error', "You are not assigned as an end user on this project");
    //     }
    // }

    public function compliance_map_all_services_comp_type($proj_id, $user_id, $comp_status)
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

            $domainNames = config('domain-names')[$project->project_type] ?? [];

            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.title_num AS Domain',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->where('compliance.comp_status', $comp_status)
                ->groupBy('compliance.title_num', 'compliance.comp_status')
                ->orderBy('compliance.title_num')
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
                    $formattedResults[$domain][$status] = 0;
                }

                // Add the count to the respective comp_status
                $formattedResults[$domain][$status] += $count;

                // Update the grand totals for each status
                $totalCounts[$status] += $count;
            }
            // Add the total for all rows
            $totalCounts['total'] = array_sum($totalCounts);

            $uniqueServices = DB::table('iso_sec_2_1')
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

            return view('compliance_map.all_services_all_controls', [
                'project'               => $project,
                'domainNames'           => $domainNames,
                'formattedResults'      => $formattedResults,
                'uniqueServicesCount'   => $uniqueServices,
                'uniqueGroupsCount'     => $uniqueGroupsCount,
                'uniqueSubGroupsCount'  => $uniqueSubGroupsCount,
                'uniqueComponentsCount' => $uniqueComponentsCount,
                'comp_status_count' => 1,
                'comp_status' => $comp_status
            ]);
        }
    }


    public function download_excel_compliance_map($proj_id, $user_id)
    {

        $results = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->select(
                'compliance.title_num AS Domain',
                'compliance.comp_status',
                DB::raw('COUNT(compliance.comp_status) AS status_count')
            )
            ->where('assets.project_id', $proj_id)
            ->groupBy('compliance.title_num', 'compliance.comp_status') // Group by service, component, and comp_status
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
                $formattedResults[$domain][$status] = 0;
            }

            // Add the count to the respective comp_status
            $formattedResults[$domain][$status] += $count;

            // Update the grand totals for each status
            $totalCounts[$status] += $count;
        }
        // Add the total for all rows
        $totalCounts['total'] = array_sum($totalCounts);

        // Calculate the total for each domain
        foreach ($formattedResults as $domain => $statuses) {
            $formattedResults[$domain]['rowTotal'] = array_sum($statuses);
        }


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        if ($project->project_type == 7) {
            $domainNames = [
                1 => 'Cybersecurity Governance',
                2 => 'Cybersecurity Defense',
                3 => 'Cybersecurity Resilience',
                4 => 'Third-Party and Cloud Computing Cybersecurity',
                5 => 'Industrial Control Systems Cybersecurity',
            ];
        }

        if ($project->project_type == 1) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 2) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 3) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }


        if ($project->project_type == 5) {
            $domainNames = [
                '3.1' => 'Cybersecurity Leadership and Governance',
                '3.2' => 'Cybersecurity Risk Management and Compliance',
                '3.3' => 'Cybersecurity Operations and Technology',
                '3.4' => 'Third-Party Cybersecurity',

            ];
        }

        if ($project->project_type == 6) {
            $domainNames = [
                1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                2 => 'INFORMATION SECURITY',
                3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                6 => 'IT AUDIT'
            ];
        }

        if ($project->project_type == 8) {
            $domainNames = [
                'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                'M1.2' => 'INFORMATION SECURITY POLICY',
                'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                'M1.4' => 'SUPPORT',
                'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                'M3.1' => 'AWARENESS AND TRAINING POLICY',
                'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                'M3.3' => 'SECURITY TRAINING',
                'M3.4' => 'SECURITY AWARENESS',
                'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                'M4.2' => 'PRIOR TO EMPLOYMENT',
                'M4.3' => 'DURING EMPLOYMENT',
                'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                'M5.1' => 'COMPLIANCE POLICY',
                'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                'M6.2' => 'PERFORMANCE EVALUATION',
                'M6.3' => 'IMPROVEMENT',
                'T1.1' => 'ASSET MANAGEMENT POLICY',
                'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                'T1.3' => 'INFORMATION CLASSIFICATION',
                'T1.4' => 'MEDIA HANDLING',
                'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                'T2.2' => 'SECURE AREAS',
                'T2.3' => 'EQUIPMENT SECURITY',
                'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                'T3.4' => 'PROTECTION FROM MALWARE',
                'T3.5' => 'BACKUP',
                'T3.6' => 'MONITORING',
                'T4.1' => 'COMMUNICATIONS POLICY',
                'T4.2' => 'INFORMATION TRANSFER',
                'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                'T4.4' => 'INFORMATION SHARING PROTECTION',
                'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                'T5.1' => 'ACCESS CONTROL POLICY',
                'T5.2' => 'USER ACCESS MANAGEMENT',
                'T5.3' => 'USER RESPONSIBILITIES',
                'T5.4' => 'NETWORK ACCESS CONTROL',
                'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                'T6.3' => 'CLOUD COMPUTING',
                'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                'T7.5' => 'SECURITY OF SYSTEM FILES',
                'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
            ];
        }

        if ($project->project_type == 4) {
            $domainNames = [
                4 => 'Context of the Organization',
                5 => 'Leadership',
                6 => 'Planning',
                7 => 'Support',
                8 => 'Operation',
                9 => 'Performance Evaluation',
                10 => 'Improvement'
            ];
        }

        if ($project->project_type == 10) {
            $domainNames = [
                '4.2' => 'ZCR 1: Identify the SUC',
                '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                '4.5' => 'ZCR 4: Risk Comparison',
                '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                '4.8' => 'ZCR 7: Asset Owner Approval',

            ];
        }

        if ($project->project_type == 12) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',
                '12' => 'Software application requirements',
                '13' => 'Embedded device requirements',
                '14' => 'Host device requirements',
                '15' => 'Network device requirements',

            ];
        }

        if ($project->project_type == 13) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',

            ];
        }

        if ($project->project_type == 11) {
            $domainNames = [
                '4.2.2' => 'Business Rationale',
                '4.2.3' => 'Risk Identification, Classification, and Assessment',
                '4.3.2' => 'Security Policy, Organization, and Awareness',
                '4.3.3' => 'Selected Security Countermeasures',
                '4.3.4' => 'Implementation',
                '4.4.2' => 'Conformance',
                '4.4.3' => 'Review, Improve, and Maintain the CSMS',

            ];
        }


        if ($project->project_type == 9) {
            $domainNames = [
                '5.2' => 'SM-1: Development process',
                '5.3' => 'SM-2: Identification of responsibilities',
                '5.4' => 'SM-3: Identification of applicability',
                '5.5' => 'SM-4: Security expertise',
                '5.6' => 'SM-5: Process scoping',
                '5.7' => 'SM-6: File integrity',
                '5.8' => 'SM-7: Development environment security',
                '5.9' => 'SM-8: Controls for private keys',
                '5.10' => 'SM-9: Security requirements for externally provided components',
                '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                '5.12' => 'SM-11: Assessing and addressing security-related issues',
                '5.13' => 'SM-12: Process verification',
                '5.14' => 'SM-13: Continuous improvement',
                '6.2' => 'SR-1: Product security context',
                '6.3' => 'SR-2: Threat model',
                '6.4' => 'SR-3: Product security requirements',
                '6.5' => 'SR-4: Product security requirements content',
                '6.6' => 'SR-5: Security requirements review',
                '7.2' => 'SD-1: Secure design principles',
                '7.3' => 'SD-2: Defense in depth design',
                '7.4' => 'SD-3: Security design review',
                '7.5' => 'SD-4: Secure design best practices',
                '8.3' => 'SI-1: Security implementation review',
                '8.4' => 'SI-2: Secure coding standards',
                '9.2' => 'SVV-1: Security requirements testing',
                '9.3' => 'SVV-2: Threat mitigation testing',
                '9.4' => 'SVV-3: Vulnerability testing',
                '9.5' => 'SVV-4: Penetration testing',
                '9.6' => 'SVV-5: Independence of testers',
                '10.2' => 'DM-1: Receiving notifications of security-related issues',
                '10.3' => 'DM-2: Reviewing security-related issues',
                '10.4' => 'DM-3: Assessing security-related issues',
                '10.5' => 'DM-4: Addressing security-related issues',
                '10.6' => 'DM-5: Disclosing security-related issues',
                '10.7' => 'DM-6: Periodic review of security defect management practice',
                '11.2' => 'SUM-1: Security update qualification',
                '11.3' => 'SUM-2: Security update documentation',
                '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                '11.5' => 'SUM-4: Security update delivery',
                '11.6' => 'SUM-5: Timely delivery of security patches',
                '12.2' => 'SG-1: Product defense in depth',
                '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                '12.4' => 'SG-3: Security hardening guidelines',
                '12.5' => 'SG-4: Secure disposal guidelines',
                '12.6' => 'SG-5: Secure operation guidelines',
                '12.7' => 'SG-6: Account management guidelines',
                '12.8' => 'SG-7: Documentation review',
            ];
        }

        if ($project->project_type == 18) {
            $domainNames = [
                1 => 'Control Environment',
                2 => 'Risk Assessment',
                3 => 'Control Activities',
                4 => 'Information and Communication',
                5 => 'Monitoring'
            ];
        }

        if ($project->project_type == 19) {
            $domainNames = [
                1 => 'Asset Management',
                2 => 'Availability',
                3 => 'Change Management',
                4 => 'Communications',
                5 => 'Confidentiality',
                6 => 'Data Classification',
                7 => 'Fraud Management',
                8 => 'Human Resource aspects of Trust Services',
                9 => 'Information Assets Security Management Policy',
                10 => 'Information Security Events Monitoring',
                11 => 'Information Security Incident Management',
                12 => 'Information Security Monitoring',
                13 => 'IT Operational Anomalies Reporting',
                14 => 'Logical and Physical Access Controls',
                15 => 'Monitoring of Controls',
                16 => 'Organization & Management',
                17 => 'Risk Management',
                18 => 'Vendor and Business Partner Risk Management',
                19 => 'Vulnerability Management'
            ];
        }





        $projectName = $project->project_name;

        return Excel::download(
            new ComplianceStatusExport($formattedResults, $totalCounts, $domainNames),
            $projectName . '_compliance_map.xlsx'
        );
    }

    public function select_assets_for_subdomain_map($domain, $proj_id, $user_id)
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


            $services = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->select('s_name')
                ->distinct()
                ->get();

            //KSA
            if ($project->project_type == 7) {
                $domainNames = [
                    1 => 'Cybersecurity Governance',
                    2 => 'Cybersecurity Defense',
                    3 => 'Cybersecurity Resilience',
                    4 => 'Third-Party and Cloud Computing Cybersecurity',
                    5 => 'Industrial Control Systems Cybersecurity',
                ];
            }

            //PCI SIngle

            if ($project->project_type == 1) {
                $domainNames = [
                    1 => 'Install and Maintain Network Security Controls',
                    2 => 'Apply Secure Configurations to All System Components',
                    3 => 'Protect Stored Account Data',
                    4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5 => 'Protect All Systems and Networks from Malicious Software',
                    6 => 'Develop and Maintain Secure Systems and Software',
                    7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8 => 'Identify Users and Authenticate Access to System Components',
                    9 => 'Restrict Physical Access to Cardholder Data',
                    10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                    11 => 'Test Security of Systems and Networks Regularly',
                    12 => 'Support Information Security with Organizational Policies and Programs',
                    'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if ($project->project_type == 2) {
                $domainNames = [
                    1 => 'Install and Maintain Network Security Controls',
                    2 => 'Apply Secure Configurations to All System Components',
                    3 => 'Protect Stored Account Data',
                    4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5 => 'Protect All Systems and Networks from Malicious Software',
                    6 => 'Develop and Maintain Secure Systems and Software',
                    7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8 => 'Identify Users and Authenticate Access to System Components',
                    9 => 'Restrict Physical Access to Cardholder Data',
                    10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                    11 => 'Test Security of Systems and Networks Regularly',
                    12 => 'Support Information Security with Organizational Policies and Programs',
                    'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                    'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if ($project->project_type == 3) {
                $domainNames = [
                    1 => 'Install and Maintain Network Security Controls',
                    2 => 'Apply Secure Configurations to All System Components',
                    3 => 'Protect Stored Account Data',
                    4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5 => 'Protect All Systems and Networks from Malicious Software',
                    6 => 'Develop and Maintain Secure Systems and Software',
                    7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8 => 'Identify Users and Authenticate Access to System Components',
                    9 => 'Restrict Physical Access to Cardholder Data',
                    10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                    11 => 'Test Security of Systems and Networks Regularly',
                    12 => 'Support Information Security with Organizational Policies and Programs',
                    'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if ($project->project_type == 5) {
                $domainNames = [
                    '3.1' => 'Cybersecurity Leadership and Governance',
                    '3.2' => 'Cybersecurity Risk Management and Compliance',
                    '3.3' => 'Cybersecurity Operations and Technology',
                    '3.4' => 'Third-Party Cybersecurity',

                ];
            }

            if ($project->project_type == 6) {
                $domainNames = [
                    1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                    2 => 'INFORMATION SECURITY',
                    3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                    4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                    5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                    6 => 'IT AUDIT'
                ];
            }

            if ($project->project_type == 8) {
                $domainNames = [
                    'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                    'M1.2' => 'INFORMATION SECURITY POLICY',
                    'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                    'M1.4' => 'SUPPORT',
                    'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                    'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                    'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                    'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                    'M3.1' => 'AWARENESS AND TRAINING POLICY',
                    'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                    'M3.3' => 'SECURITY TRAINING',
                    'M3.4' => 'SECURITY AWARENESS',
                    'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                    'M4.2' => 'PRIOR TO EMPLOYMENT',
                    'M4.3' => 'DURING EMPLOYMENT',
                    'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                    'M5.1' => 'COMPLIANCE POLICY',
                    'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                    'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                    'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                    'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                    'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                    'M6.2' => 'PERFORMANCE EVALUATION',
                    'M6.3' => 'IMPROVEMENT',
                    'T1.1' => 'ASSET MANAGEMENT POLICY',
                    'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                    'T1.3' => 'INFORMATION CLASSIFICATION',
                    'T1.4' => 'MEDIA HANDLING',
                    'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                    'T2.2' => 'SECURE AREAS',
                    'T2.3' => 'EQUIPMENT SECURITY',
                    'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                    'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                    'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                    'T3.4' => 'PROTECTION FROM MALWARE',
                    'T3.5' => 'BACKUP',
                    'T3.6' => 'MONITORING',
                    'T4.1' => 'COMMUNICATIONS POLICY',
                    'T4.2' => 'INFORMATION TRANSFER',
                    'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                    'T4.4' => 'INFORMATION SHARING PROTECTION',
                    'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                    'T5.1' => 'ACCESS CONTROL POLICY',
                    'T5.2' => 'USER ACCESS MANAGEMENT',
                    'T5.3' => 'USER RESPONSIBILITIES',
                    'T5.4' => 'NETWORK ACCESS CONTROL',
                    'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                    'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                    'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                    'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                    'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                    'T6.3' => 'CLOUD COMPUTING',
                    'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                    'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                    'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                    'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                    'T7.5' => 'SECURITY OF SYSTEM FILES',
                    'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                    'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                    'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                    'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                    'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                    'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                    'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                    'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                    'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
                ];
            }


            if ($project->project_type == 4) {
                $domainNames = [
                    4 => 'Context of the Organization',
                    5 => 'Leadership',
                    6 => 'Planning',
                    7 => 'Support',
                    8 => 'Operation',
                    9 => 'Performance Evaluation',
                    10 => 'Improvement'
                ];
            }

            if ($project->project_type == 10) {
                $domainNames = [
                    '4.2' => 'ZCR 1: Identify the SUC',
                    '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                    '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                    '4.5' => 'ZCR 4: Risk Comparison',
                    '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                    '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                    '4.8' => 'ZCR 7: Asset Owner Approval',

                ];
            }

            if ($project->project_type == 19) {
                $domainNames = [
                    1 => 'Asset Management',
                    2 => 'Availability',
                    3 => 'Change Management',
                    4 => 'Communications',
                    5 => 'Confidentiality',
                    6 => 'Data Classification',
                    7 => 'Fraud Management',
                    8 => 'Human Resource aspects of Trust Services',
                    9 => 'Information Assets Security Management Policy',
                    10 => 'Information Security Events Monitoring',
                    11 => 'Information Security Incident Management',
                    12 => 'Information Security Monitoring',
                    13 => 'IT Operational Anomalies Reporting',
                    14 => 'Logical and Physical Access Controls',
                    15 => 'Monitoring of Controls',
                    16 => 'Organization & Management',
                    17 => 'Risk Management',
                    18 => 'Vendor and Business Partner Risk Management',
                    19 => 'Vulnerability Management'
                ];
            }


            if ($project->project_type == 12) {
                $domainNames = [
                    '5' => 'FR 1 – Identification and authentication control',
                    '6' => 'FR 2 – Use control',
                    '7' => 'FR 3 – System integrity',
                    '8' => 'FR 4 – Data confidentiality',
                    '9' => 'FR 5 – Restricted data flow',
                    '10' => 'FR 6 – Timely response to events',
                    '11' => 'FR 7 – Resource availability',
                    '12' => 'Software application requirements',
                    '13' => 'Embedded device requirements',
                    '14' => 'Host device requirements',
                    '15' => 'Network device requirements',

                ];
            }

            if ($project->project_type == 13) {
                $domainNames = [
                    '5' => 'FR 1 – Identification and authentication control',
                    '6' => 'FR 2 – Use control',
                    '7' => 'FR 3 – System integrity',
                    '8' => 'FR 4 – Data confidentiality',
                    '9' => 'FR 5 – Restricted data flow',
                    '10' => 'FR 6 – Timely response to events',
                    '11' => 'FR 7 – Resource availability',

                ];
            }


            if ($project->project_type == 11) {
                $domainNames = [
                    '4.2.2' => 'Business Rationale',
                    '4.2.3' => 'Risk Identification, Classification, and Assessment',
                    '4.3.2' => 'Security Policy, Organization, and Awareness',
                    '4.3.3' => 'Selected Security Countermeasures',
                    '4.3.4' => 'Implementation',
                    '4.4.2' => 'Conformance',
                    '4.4.3' => 'Review, Improve, and Maintain the CSMS',
                ];
            }

            if ($project->project_type == 9) {
                $domainNames = [
                    '5.2' => 'SM-1: Development process',
                    '5.3' => 'SM-2: Identification of responsibilities',
                    '5.4' => 'SM-3: Identification of applicability',
                    '5.5' => 'SM-4: Security expertise',
                    '5.6' => 'SM-5: Process scoping',
                    '5.7' => 'SM-6: File integrity',
                    '5.8' => 'SM-7: Development environment security',
                    '5.9' => 'SM-8: Controls for private keys',
                    '5.10' => 'SM-9: Security requirements for externally provided components',
                    '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                    '5.12' => 'SM-11: Assessing and addressing security-related issues',
                    '5.13' => 'SM-12: Process verification',
                    '5.14' => 'SM-13: Continuous improvement',
                    '6.2' => 'SR-1: Product security context',
                    '6.3' => 'SR-2: Threat model',
                    '6.4' => 'SR-3: Product security requirements',
                    '6.5' => 'SR-4: Product security requirements content',
                    '6.6' => 'SR-5: Security requirements review',
                    '7.2' => 'SD-1: Secure design principles',
                    '7.3' => 'SD-2: Defense in depth design',
                    '7.4' => 'SD-3: Security design review',
                    '7.5' => 'SD-4: Secure design best practices',
                    '8.3' => 'SI-1: Security implementation review',
                    '8.4' => 'SI-2: Secure coding standards',
                    '9.2' => 'SVV-1: Security requirements testing',
                    '9.3' => 'SVV-2: Threat mitigation testing',
                    '9.4' => 'SVV-3: Vulnerability testing',
                    '9.5' => 'SVV-4: Penetration testing',
                    '9.6' => 'SVV-5: Independence of testers',
                    '10.2' => 'DM-1: Receiving notifications of security-related issues',
                    '10.3' => 'DM-2: Reviewing security-related issues',
                    '10.4' => 'DM-3: Assessing security-related issues',
                    '10.5' => 'DM-4: Addressing security-related issues',
                    '10.6' => 'DM-5: Disclosing security-related issues',
                    '10.7' => 'DM-6: Periodic review of security defect management practice',
                    '11.2' => 'SUM-1: Security update qualification',
                    '11.3' => 'SUM-2: Security update documentation',
                    '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                    '11.5' => 'SUM-4: Security update delivery',
                    '11.6' => 'SUM-5: Timely delivery of security patches',
                    '12.2' => 'SG-1: Product defense in depth',
                    '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                    '12.4' => 'SG-3: Security hardening guidelines',
                    '12.5' => 'SG-4: Secure disposal guidelines',
                    '12.6' => 'SG-5: Secure operation guidelines',
                    '12.7' => 'SG-6: Account management guidelines',
                    '12.8' => 'SG-7: Documentation review',
                ];
            }

            if ($project->project_type == 18) {
                $domainNames = [
                    1 => 'Control Environment',
                    2 => 'Risk Assessment',
                    3 => 'Control Activities',
                    4 => 'Information and Communication',
                    5 => 'Monitoring'
                ];
            }




            return view('compliance_map.services', [
                'project' => $project,
                'services' => $services,
                'domain' => $domain,
                'domainName' => $domainNames[$domain]
            ]);
        }
    }

    public function select_assets_for_subdomain_map_comp_status($domain, $comp_status, $proj_id, $user_id)
    {

        session(['comp_status' => $comp_status]);

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


            $services = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->select('s_name')
                ->distinct()
                ->get();

            //KSA
            if ($project->project_type == 7) {
                $domainNames = [
                    1 => 'Cybersecurity Governance',
                    2 => 'Cybersecurity Defense',
                    3 => 'Cybersecurity Resilience',
                    4 => 'Third-Party and Cloud Computing Cybersecurity',
                    5 => 'Industrial Control Systems Cybersecurity',
                ];
            }

            //PCI SIngle

            if ($project->project_type == 1) {
                $domainNames = [
                    1 => 'Install and Maintain Network Security Controls',
                    2 => 'Apply Secure Configurations to All System Components',
                    3 => 'Protect Stored Account Data',
                    4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5 => 'Protect All Systems and Networks from Malicious Software',
                    6 => 'Develop and Maintain Secure Systems and Software',
                    7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8 => 'Identify Users and Authenticate Access to System Components',
                    9 => 'Restrict Physical Access to Cardholder Data',
                    10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                    11 => 'Test Security of Systems and Networks Regularly',
                    12 => 'Support Information Security with Organizational Policies and Programs',
                    'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if ($project->project_type == 2) {
                $domainNames = [
                    1 => 'Install and Maintain Network Security Controls',
                    2 => 'Apply Secure Configurations to All System Components',
                    3 => 'Protect Stored Account Data',
                    4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5 => 'Protect All Systems and Networks from Malicious Software',
                    6 => 'Develop and Maintain Secure Systems and Software',
                    7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8 => 'Identify Users and Authenticate Access to System Components',
                    9 => 'Restrict Physical Access to Cardholder Data',
                    10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                    11 => 'Test Security of Systems and Networks Regularly',
                    12 => 'Support Information Security with Organizational Policies and Programs',
                    'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                    'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if ($project->project_type == 3) {
                $domainNames = [
                    1 => 'Install and Maintain Network Security Controls',
                    2 => 'Apply Secure Configurations to All System Components',
                    3 => 'Protect Stored Account Data',
                    4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5 => 'Protect All Systems and Networks from Malicious Software',
                    6 => 'Develop and Maintain Secure Systems and Software',
                    7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8 => 'Identify Users and Authenticate Access to System Components',
                    9 => 'Restrict Physical Access to Cardholder Data',
                    10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                    11 => 'Test Security of Systems and Networks Regularly',
                    12 => 'Support Information Security with Organizational Policies and Programs',
                    'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if ($project->project_type == 5) {
                $domainNames = [
                    '3.1' => 'Cybersecurity Leadership and Governance',
                    '3.2' => 'Cybersecurity Risk Management and Compliance',
                    '3.3' => 'Cybersecurity Operations and Technology',
                    '3.4' => 'Third-Party Cybersecurity',

                ];
            }

            if ($project->project_type == 6) {
                $domainNames = [
                    1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                    2 => 'INFORMATION SECURITY',
                    3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                    4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                    5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                    6 => 'IT AUDIT'
                ];
            }

            if ($project->project_type == 8) {
                $domainNames = [
                    'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                    'M1.2' => 'INFORMATION SECURITY POLICY',
                    'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                    'M1.4' => 'SUPPORT',
                    'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                    'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                    'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                    'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                    'M3.1' => 'AWARENESS AND TRAINING POLICY',
                    'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                    'M3.3' => 'SECURITY TRAINING',
                    'M3.4' => 'SECURITY AWARENESS',
                    'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                    'M4.2' => 'PRIOR TO EMPLOYMENT',
                    'M4.3' => 'DURING EMPLOYMENT',
                    'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                    'M5.1' => 'COMPLIANCE POLICY',
                    'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                    'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                    'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                    'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                    'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                    'M6.2' => 'PERFORMANCE EVALUATION',
                    'M6.3' => 'IMPROVEMENT',
                    'T1.1' => 'ASSET MANAGEMENT POLICY',
                    'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                    'T1.3' => 'INFORMATION CLASSIFICATION',
                    'T1.4' => 'MEDIA HANDLING',
                    'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                    'T2.2' => 'SECURE AREAS',
                    'T2.3' => 'EQUIPMENT SECURITY',
                    'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                    'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                    'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                    'T3.4' => 'PROTECTION FROM MALWARE',
                    'T3.5' => 'BACKUP',
                    'T3.6' => 'MONITORING',
                    'T4.1' => 'COMMUNICATIONS POLICY',
                    'T4.2' => 'INFORMATION TRANSFER',
                    'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                    'T4.4' => 'INFORMATION SHARING PROTECTION',
                    'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                    'T5.1' => 'ACCESS CONTROL POLICY',
                    'T5.2' => 'USER ACCESS MANAGEMENT',
                    'T5.3' => 'USER RESPONSIBILITIES',
                    'T5.4' => 'NETWORK ACCESS CONTROL',
                    'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                    'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                    'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                    'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                    'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                    'T6.3' => 'CLOUD COMPUTING',
                    'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                    'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                    'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                    'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                    'T7.5' => 'SECURITY OF SYSTEM FILES',
                    'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                    'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                    'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                    'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                    'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                    'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                    'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                    'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                    'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
                ];
            }


            if ($project->project_type == 4) {
                $domainNames = [
                    4 => 'Context of the Organization',
                    5 => 'Leadership',
                    6 => 'Planning',
                    7 => 'Support',
                    8 => 'Operation',
                    9 => 'Performance Evaluation',
                    10 => 'Improvement'
                ];
            }

            if ($project->project_type == 10) {
                $domainNames = [
                    '4.2' => 'ZCR 1: Identify the SUC',
                    '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                    '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                    '4.5' => 'ZCR 4: Risk Comparison',
                    '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                    '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                    '4.8' => 'ZCR 7: Asset Owner Approval',

                ];
            }

            if ($project->project_type == 19) {
                $domainNames = [
                    1 => 'Asset Management',
                    2 => 'Availability',
                    3 => 'Change Management',
                    4 => 'Communications',
                    5 => 'Confidentiality',
                    6 => 'Data Classification',
                    7 => 'Fraud Management',
                    8 => 'Human Resource aspects of Trust Services',
                    9 => 'Information Assets Security Management Policy',
                    10 => 'Information Security Events Monitoring',
                    11 => 'Information Security Incident Management',
                    12 => 'Information Security Monitoring',
                    13 => 'IT Operational Anomalies Reporting',
                    14 => 'Logical and Physical Access Controls',
                    15 => 'Monitoring of Controls',
                    16 => 'Organization & Management',
                    17 => 'Risk Management',
                    18 => 'Vendor and Business Partner Risk Management',
                    19 => 'Vulnerability Management'
                ];
            }


            if ($project->project_type == 12) {
                $domainNames = [
                    '5' => 'FR 1 – Identification and authentication control',
                    '6' => 'FR 2 – Use control',
                    '7' => 'FR 3 – System integrity',
                    '8' => 'FR 4 – Data confidentiality',
                    '9' => 'FR 5 – Restricted data flow',
                    '10' => 'FR 6 – Timely response to events',
                    '11' => 'FR 7 – Resource availability',
                    '12' => 'Software application requirements',
                    '13' => 'Embedded device requirements',
                    '14' => 'Host device requirements',
                    '15' => 'Network device requirements',

                ];
            }

            if ($project->project_type == 13) {
                $domainNames = [
                    '5' => 'FR 1 – Identification and authentication control',
                    '6' => 'FR 2 – Use control',
                    '7' => 'FR 3 – System integrity',
                    '8' => 'FR 4 – Data confidentiality',
                    '9' => 'FR 5 – Restricted data flow',
                    '10' => 'FR 6 – Timely response to events',
                    '11' => 'FR 7 – Resource availability',

                ];
            }


            if ($project->project_type == 11) {
                $domainNames = [
                    '4.2.2' => 'Business Rationale',
                    '4.2.3' => 'Risk Identification, Classification, and Assessment',
                    '4.3.2' => 'Security Policy, Organization, and Awareness',
                    '4.3.3' => 'Selected Security Countermeasures',
                    '4.3.4' => 'Implementation',
                    '4.4.2' => 'Conformance',
                    '4.4.3' => 'Review, Improve, and Maintain the CSMS',
                ];
            }

            if ($project->project_type == 9) {
                $domainNames = [
                    '5.2' => 'SM-1: Development process',
                    '5.3' => 'SM-2: Identification of responsibilities',
                    '5.4' => 'SM-3: Identification of applicability',
                    '5.5' => 'SM-4: Security expertise',
                    '5.6' => 'SM-5: Process scoping',
                    '5.7' => 'SM-6: File integrity',
                    '5.8' => 'SM-7: Development environment security',
                    '5.9' => 'SM-8: Controls for private keys',
                    '5.10' => 'SM-9: Security requirements for externally provided components',
                    '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                    '5.12' => 'SM-11: Assessing and addressing security-related issues',
                    '5.13' => 'SM-12: Process verification',
                    '5.14' => 'SM-13: Continuous improvement',
                    '6.2' => 'SR-1: Product security context',
                    '6.3' => 'SR-2: Threat model',
                    '6.4' => 'SR-3: Product security requirements',
                    '6.5' => 'SR-4: Product security requirements content',
                    '6.6' => 'SR-5: Security requirements review',
                    '7.2' => 'SD-1: Secure design principles',
                    '7.3' => 'SD-2: Defense in depth design',
                    '7.4' => 'SD-3: Security design review',
                    '7.5' => 'SD-4: Secure design best practices',
                    '8.3' => 'SI-1: Security implementation review',
                    '8.4' => 'SI-2: Secure coding standards',
                    '9.2' => 'SVV-1: Security requirements testing',
                    '9.3' => 'SVV-2: Threat mitigation testing',
                    '9.4' => 'SVV-3: Vulnerability testing',
                    '9.5' => 'SVV-4: Penetration testing',
                    '9.6' => 'SVV-5: Independence of testers',
                    '10.2' => 'DM-1: Receiving notifications of security-related issues',
                    '10.3' => 'DM-2: Reviewing security-related issues',
                    '10.4' => 'DM-3: Assessing security-related issues',
                    '10.5' => 'DM-4: Addressing security-related issues',
                    '10.6' => 'DM-5: Disclosing security-related issues',
                    '10.7' => 'DM-6: Periodic review of security defect management practice',
                    '11.2' => 'SUM-1: Security update qualification',
                    '11.3' => 'SUM-2: Security update documentation',
                    '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                    '11.5' => 'SUM-4: Security update delivery',
                    '11.6' => 'SUM-5: Timely delivery of security patches',
                    '12.2' => 'SG-1: Product defense in depth',
                    '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                    '12.4' => 'SG-3: Security hardening guidelines',
                    '12.5' => 'SG-4: Secure disposal guidelines',
                    '12.6' => 'SG-5: Secure operation guidelines',
                    '12.7' => 'SG-6: Account management guidelines',
                    '12.8' => 'SG-7: Documentation review',
                ];
            }

            if ($project->project_type == 18) {
                $domainNames = [
                    1 => 'Control Environment',
                    2 => 'Risk Assessment',
                    3 => 'Control Activities',
                    4 => 'Information and Communication',
                    5 => 'Monitoring'
                ];
            }




            return view('compliance_map.services', [
                'project' => $project,
                'services' => $services,
                'domain' => $domain,
                'domainName' => $domainNames[$domain]
            ]);
        }
    }

    public function getGroups($domain, $service, $proj_id)
    {

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


        if ($project->project_type == 8) {
            $domainNames = [
                'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                'M1.2' => 'INFORMATION SECURITY POLICY',
                'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                'M1.4' => 'SUPPORT',
                'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                'M3.1' => 'AWARENESS AND TRAINING POLICY',
                'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                'M3.3' => 'SECURITY TRAINING',
                'M3.4' => 'SECURITY AWARENESS',
                'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                'M4.2' => 'PRIOR TO EMPLOYMENT',
                'M4.3' => 'DURING EMPLOYMENT',
                'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                'M5.1' => 'COMPLIANCE POLICY',
                'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                'M6.2' => 'PERFORMANCE EVALUATION',
                'M6.3' => 'IMPROVEMENT',
                'T1.1' => 'ASSET MANAGEMENT POLICY',
                'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                'T1.3' => 'INFORMATION CLASSIFICATION',
                'T1.4' => 'MEDIA HANDLING',
                'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                'T2.2' => 'SECURE AREAS',
                'T2.3' => 'EQUIPMENT SECURITY',
                'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                'T3.4' => 'PROTECTION FROM MALWARE',
                'T3.5' => 'BACKUP',
                'T3.6' => 'MONITORING',
                'T4.1' => 'COMMUNICATIONS POLICY',
                'T4.2' => 'INFORMATION TRANSFER',
                'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                'T4.4' => 'INFORMATION SHARING PROTECTION',
                'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                'T5.1' => 'ACCESS CONTROL POLICY',
                'T5.2' => 'USER ACCESS MANAGEMENT',
                'T5.3' => 'USER RESPONSIBILITIES',
                'T5.4' => 'NETWORK ACCESS CONTROL',
                'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                'T6.3' => 'CLOUD COMPUTING',
                'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                'T7.5' => 'SECURITY OF SYSTEM FILES',
                'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
            ];
        }



        if ($project->project_type == 7) {
            $domainNames = [
                1 => 'Cybersecurity Governance',
                2 => 'Cybersecurity Defense',
                3 => 'Cybersecurity Resilience',
                4 => 'Third-Party and Cloud Computing Cybersecurity',
                5 => 'Industrial Control Systems Cybersecurity',
            ];
        }

        if ($project->project_type == 1) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 2) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 3) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 5) {
            $domainNames = [
                '3.1' => 'Cybersecurity Leadership and Governance',
                '3.2' => 'Cybersecurity Risk Management and Compliance',
                '3.3' => 'Cybersecurity Operations and Technology',
                '3.4' => 'Third-Party Cybersecurity',

            ];
        }

        if ($project->project_type == 6) {
            $domainNames = [
                1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                2 => 'INFORMATION SECURITY',
                3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                6 => 'IT AUDIT'
            ];
        }


        if ($project->project_type == 4) {
            $domainNames = [
                4 => 'Context of the Organization',
                5 => 'Leadership',
                6 => 'Planning',
                7 => 'Support',
                8 => 'Operation',
                9 => 'Performance Evaluation',
                10 => 'Improvement'
            ];
        }

        if ($project->project_type == 10) {
            $domainNames = [
                '4.2' => 'ZCR 1: Identify the SUC',
                '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                '4.5' => 'ZCR 4: Risk Comparison',
                '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                '4.8' => 'ZCR 7: Asset Owner Approval',

            ];
        }

        if ($project->project_type == 12) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',
                '12' => 'Software application requirements',
                '13' => 'Embedded device requirements',
                '14' => 'Host device requirements',
                '15' => 'Network device requirements',

            ];
        }

        if ($project->project_type == 13) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',

            ];
        }

        if ($project->project_type == 11) {
            $domainNames = [
                '4.2.2' => 'Business Rationale',
                '4.2.3' => 'Risk Identification, Classification, and Assessment',
                '4.3.2' => 'Security Policy, Organization, and Awareness',
                '4.3.3' => 'Selected Security Countermeasures',
                '4.3.4' => 'Implementation',
                '4.4.2' => 'Conformance',
                '4.4.3' => 'Review, Improve, and Maintain the CSMS',
            ];
        }

        if ($project->project_type == 9) {
            $domainNames = [
                '5.2' => 'SM-1: Development process',
                '5.3' => 'SM-2: Identification of responsibilities',
                '5.4' => 'SM-3: Identification of applicability',
                '5.5' => 'SM-4: Security expertise',
                '5.6' => 'SM-5: Process scoping',
                '5.7' => 'SM-6: File integrity',
                '5.8' => 'SM-7: Development environment security',
                '5.9' => 'SM-8: Controls for private keys',
                '5.10' => 'SM-9: Security requirements for externally provided components',
                '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                '5.12' => 'SM-11: Assessing and addressing security-related issues',
                '5.13' => 'SM-12: Process verification',
                '5.14' => 'SM-13: Continuous improvement',
                '6.2' => 'SR-1: Product security context',
                '6.3' => 'SR-2: Threat model',
                '6.4' => 'SR-3: Product security requirements',
                '6.5' => 'SR-4: Product security requirements content',
                '6.6' => 'SR-5: Security requirements review',
                '7.2' => 'SD-1: Secure design principles',
                '7.3' => 'SD-2: Defense in depth design',
                '7.4' => 'SD-3: Security design review',
                '7.5' => 'SD-4: Secure design best practices',
                '8.3' => 'SI-1: Security implementation review',
                '8.4' => 'SI-2: Secure coding standards',
                '9.2' => 'SVV-1: Security requirements testing',
                '9.3' => 'SVV-2: Threat mitigation testing',
                '9.4' => 'SVV-3: Vulnerability testing',
                '9.5' => 'SVV-4: Penetration testing',
                '9.6' => 'SVV-5: Independence of testers',
                '10.2' => 'DM-1: Receiving notifications of security-related issues',
                '10.3' => 'DM-2: Reviewing security-related issues',
                '10.4' => 'DM-3: Assessing security-related issues',
                '10.5' => 'DM-4: Addressing security-related issues',
                '10.6' => 'DM-5: Disclosing security-related issues',
                '10.7' => 'DM-6: Periodic review of security defect management practice',
                '11.2' => 'SUM-1: Security update qualification',
                '11.3' => 'SUM-2: Security update documentation',
                '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                '11.5' => 'SUM-4: Security update delivery',
                '11.6' => 'SUM-5: Timely delivery of security patches',
                '12.2' => 'SG-1: Product defense in depth',
                '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                '12.4' => 'SG-3: Security hardening guidelines',
                '12.5' => 'SG-4: Secure disposal guidelines',
                '12.6' => 'SG-5: Secure operation guidelines',
                '12.7' => 'SG-6: Account management guidelines',
                '12.8' => 'SG-7: Documentation review',
            ];
        }

        if ($project->project_type == 18) {
            $domainNames = [
                1 => 'Control Environment',
                2 => 'Risk Assessment',
                3 => 'Control Activities',
                4 => 'Information and Communication',
                5 => 'Monitoring'
            ];
        }

        if ($project->project_type == 19) {
            $domainNames = [
                1 => 'Asset Management',
                2 => 'Availability',
                3 => 'Change Management',
                4 => 'Communications',
                5 => 'Confidentiality',
                6 => 'Data Classification',
                7 => 'Fraud Management',
                8 => 'Human Resource aspects of Trust Services',
                9 => 'Information Assets Security Management Policy',
                10 => 'Information Security Events Monitoring',
                11 => 'Information Security Incident Management',
                12 => 'Information Security Monitoring',
                13 => 'IT Operational Anomalies Reporting',
                14 => 'Logical and Physical Access Controls',
                15 => 'Monitoring of Controls',
                16 => 'Organization & Management',
                17 => 'Risk Management',
                18 => 'Vendor and Business Partner Risk Management',
                19 => 'Vulnerability Management'
            ];
        }


        if ($groups->count() == 0) {
            return redirect()->route(
                'no_groups_for_compliance_map',
                [
                    'proj_id' => $project->project_id,
                    'service' => $service,
                    'domainName' => $domainNames[$domain],
                    'domain' => $domain
                ]
            );
        }


        return view('compliance_map.groups', [
            'project' => $project,
            'groups' => $groups,
            'service' => $service,
            'domainName' => $domainNames[$domain],
            'domain' => $domain
        ]);
    }

    public function getSubgroups($domain, $service, $group, $proj_id)
    {

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

        if ($project->project_type == 7) {
            $domainNames = [
                1 => 'Cybersecurity Governance',
                2 => 'Cybersecurity Defense',
                3 => 'Cybersecurity Resilience',
                4 => 'Third-Party and Cloud Computing Cybersecurity',
                5 => 'Industrial Control Systems Cybersecurity',
            ];
        }

        if ($project->project_type == 18) {
            $domainNames = [
                1 => 'Control Environment',
                2 => 'Risk Assessment',
                3 => 'Control Activities',
                4 => 'Information and Communication',
                5 => 'Monitoring'
            ];
        }

        if ($project->project_type == 1) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 2) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 5) {
            $domainNames = [
                '3.1' => 'Cybersecurity Leadership and Governance',
                '3.2' => 'Cybersecurity Risk Management and Compliance',
                '3.3' => 'Cybersecurity Operations and Technology',
                '3.4' => 'Third-Party Cybersecurity',

            ];
        }


        if ($project->project_type == 8) {
            $domainNames = [
                'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                'M1.2' => 'INFORMATION SECURITY POLICY',
                'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                'M1.4' => 'SUPPORT',
                'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                'M3.1' => 'AWARENESS AND TRAINING POLICY',
                'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                'M3.3' => 'SECURITY TRAINING',
                'M3.4' => 'SECURITY AWARENESS',
                'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                'M4.2' => 'PRIOR TO EMPLOYMENT',
                'M4.3' => 'DURING EMPLOYMENT',
                'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                'M5.1' => 'COMPLIANCE POLICY',
                'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                'M6.2' => 'PERFORMANCE EVALUATION',
                'M6.3' => 'IMPROVEMENT',
                'T1.1' => 'ASSET MANAGEMENT POLICY',
                'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                'T1.3' => 'INFORMATION CLASSIFICATION',
                'T1.4' => 'MEDIA HANDLING',
                'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                'T2.2' => 'SECURE AREAS',
                'T2.3' => 'EQUIPMENT SECURITY',
                'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                'T3.4' => 'PROTECTION FROM MALWARE',
                'T3.5' => 'BACKUP',
                'T3.6' => 'MONITORING',
                'T4.1' => 'COMMUNICATIONS POLICY',
                'T4.2' => 'INFORMATION TRANSFER',
                'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                'T4.4' => 'INFORMATION SHARING PROTECTION',
                'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                'T5.1' => 'ACCESS CONTROL POLICY',
                'T5.2' => 'USER ACCESS MANAGEMENT',
                'T5.3' => 'USER RESPONSIBILITIES',
                'T5.4' => 'NETWORK ACCESS CONTROL',
                'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                'T6.3' => 'CLOUD COMPUTING',
                'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                'T7.5' => 'SECURITY OF SYSTEM FILES',
                'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
            ];
        }

        if ($project->project_type == 3) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 6) {
            $domainNames = [
                1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                2 => 'INFORMATION SECURITY',
                3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                6 => 'IT AUDIT'
            ];
        }


        if ($project->project_type == 4) {
            $domainNames = [
                4 => 'Context of the Organization',
                5 => 'Leadership',
                6 => 'Planning',
                7 => 'Support',
                8 => 'Operation',
                9 => 'Performance Evaluation',
                10 => 'Improvement'
            ];
        }

        if ($project->project_type == 10) {
            $domainNames = [
                '4.2' => 'ZCR 1: Identify the SUC',
                '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                '4.5' => 'ZCR 4: Risk Comparison',
                '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                '4.8' => 'ZCR 7: Asset Owner Approval',

            ];
        }

        if ($project->project_type == 12) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',
                '12' => 'Software application requirements',
                '13' => 'Embedded device requirements',
                '14' => 'Host device requirements',
                '15' => 'Network device requirements',

            ];
        }

        if ($project->project_type == 11) {
            $domainNames = [
                '4.2.2' => 'Business Rationale',
                '4.2.3' => 'Risk Identification, Classification, and Assessment',
                '4.3.2' => 'Security Policy, Organization, and Awareness',
                '4.3.3' => 'Selected Security Countermeasures',
                '4.3.4' => 'Implementation',
                '4.4.2' => 'Conformance',
                '4.4.3' => 'Review, Improve, and Maintain the CSMS',
            ];
        }

        if ($project->project_type == 13) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',

            ];
        }

        if ($project->project_type == 9) {
            $domainNames = [
                '5.2' => 'SM-1: Development process',
                '5.3' => 'SM-2: Identification of responsibilities',
                '5.4' => 'SM-3: Identification of applicability',
                '5.5' => 'SM-4: Security expertise',
                '5.6' => 'SM-5: Process scoping',
                '5.7' => 'SM-6: File integrity',
                '5.8' => 'SM-7: Development environment security',
                '5.9' => 'SM-8: Controls for private keys',
                '5.10' => 'SM-9: Security requirements for externally provided components',
                '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                '5.12' => 'SM-11: Assessing and addressing security-related issues',
                '5.13' => 'SM-12: Process verification',
                '5.14' => 'SM-13: Continuous improvement',
                '6.2' => 'SR-1: Product security context',
                '6.3' => 'SR-2: Threat model',
                '6.4' => 'SR-3: Product security requirements',
                '6.5' => 'SR-4: Product security requirements content',
                '6.6' => 'SR-5: Security requirements review',
                '7.2' => 'SD-1: Secure design principles',
                '7.3' => 'SD-2: Defense in depth design',
                '7.4' => 'SD-3: Security design review',
                '7.5' => 'SD-4: Secure design best practices',
                '8.3' => 'SI-1: Security implementation review',
                '8.4' => 'SI-2: Secure coding standards',
                '9.2' => 'SVV-1: Security requirements testing',
                '9.3' => 'SVV-2: Threat mitigation testing',
                '9.4' => 'SVV-3: Vulnerability testing',
                '9.5' => 'SVV-4: Penetration testing',
                '9.6' => 'SVV-5: Independence of testers',
                '10.2' => 'DM-1: Receiving notifications of security-related issues',
                '10.3' => 'DM-2: Reviewing security-related issues',
                '10.4' => 'DM-3: Assessing security-related issues',
                '10.5' => 'DM-4: Addressing security-related issues',
                '10.6' => 'DM-5: Disclosing security-related issues',
                '10.7' => 'DM-6: Periodic review of security defect management practice',
                '11.2' => 'SUM-1: Security update qualification',
                '11.3' => 'SUM-2: Security update documentation',
                '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                '11.5' => 'SUM-4: Security update delivery',
                '11.6' => 'SUM-5: Timely delivery of security patches',
                '12.2' => 'SG-1: Product defense in depth',
                '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                '12.4' => 'SG-3: Security hardening guidelines',
                '12.5' => 'SG-4: Secure disposal guidelines',
                '12.6' => 'SG-5: Secure operation guidelines',
                '12.7' => 'SG-6: Account management guidelines',
                '12.8' => 'SG-7: Documentation review',
            ];
        }

        if ($project->project_type == 19) {
            $domainNames = [
                1 => 'Asset Management',
                2 => 'Availability',
                3 => 'Change Management',
                4 => 'Communications',
                5 => 'Confidentiality',
                6 => 'Data Classification',
                7 => 'Fraud Management',
                8 => 'Human Resource aspects of Trust Services',
                9 => 'Information Assets Security Management Policy',
                10 => 'Information Security Events Monitoring',
                11 => 'Information Security Incident Management',
                12 => 'Information Security Monitoring',
                13 => 'IT Operational Anomalies Reporting',
                14 => 'Logical and Physical Access Controls',
                15 => 'Monitoring of Controls',
                16 => 'Organization & Management',
                17 => 'Risk Management',
                18 => 'Vendor and Business Partner Risk Management',
                19 => 'Vulnerability Management'
            ];
        }


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

            return view('compliance_map.components', [
                'project' => $project,
                'service' => $service,
                'group' => $group,
                'subgroup' => null,
                'components' => $components,
                'domainName' => $domainNames[$domain],
                'domain' => $domain
            ]);
        }


        return view('compliance_map.subgroups', [
            'project' => $project,
            'group' => $group,
            'service' => $service,
            'subgroups' => $subgroups,
            'domainName' => $domainNames[$domain],
            'domain' => $domain
        ]);
    }

    public function getComponents($domain, $service, $group, $subgroup, $proj_id)
    {

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


        if ($project->project_type == 8) {
            $domainNames = [
                'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                'M1.2' => 'INFORMATION SECURITY POLICY',
                'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                'M1.4' => 'SUPPORT',
                'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                'M3.1' => 'AWARENESS AND TRAINING POLICY',
                'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                'M3.3' => 'SECURITY TRAINING',
                'M3.4' => 'SECURITY AWARENESS',
                'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                'M4.2' => 'PRIOR TO EMPLOYMENT',
                'M4.3' => 'DURING EMPLOYMENT',
                'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                'M5.1' => 'COMPLIANCE POLICY',
                'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                'M6.2' => 'PERFORMANCE EVALUATION',
                'M6.3' => 'IMPROVEMENT',
                'T1.1' => 'ASSET MANAGEMENT POLICY',
                'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                'T1.3' => 'INFORMATION CLASSIFICATION',
                'T1.4' => 'MEDIA HANDLING',
                'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                'T2.2' => 'SECURE AREAS',
                'T2.3' => 'EQUIPMENT SECURITY',
                'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                'T3.4' => 'PROTECTION FROM MALWARE',
                'T3.5' => 'BACKUP',
                'T3.6' => 'MONITORING',
                'T4.1' => 'COMMUNICATIONS POLICY',
                'T4.2' => 'INFORMATION TRANSFER',
                'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                'T4.4' => 'INFORMATION SHARING PROTECTION',
                'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                'T5.1' => 'ACCESS CONTROL POLICY',
                'T5.2' => 'USER ACCESS MANAGEMENT',
                'T5.3' => 'USER RESPONSIBILITIES',
                'T5.4' => 'NETWORK ACCESS CONTROL',
                'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                'T6.3' => 'CLOUD COMPUTING',
                'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                'T7.5' => 'SECURITY OF SYSTEM FILES',
                'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
            ];
        }

        if ($project->project_type == 7) {
            $domainNames = [
                1 => 'Cybersecurity Governance',
                2 => 'Cybersecurity Defense',
                3 => 'Cybersecurity Resilience',
                4 => 'Third-Party and Cloud Computing Cybersecurity',
                5 => 'Industrial Control Systems Cybersecurity',
            ];
        }
        if ($project->project_type == 1) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 2) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 3) {
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 5) {
            $domainNames = [
                '3.1' => 'Cybersecurity Leadership and Governance',
                '3.2' => 'Cybersecurity Risk Management and Compliance',
                '3.3' => 'Cybersecurity Operations and Technology',
                '3.4' => 'Third-Party Cybersecurity',

            ];
        }

        if ($project->project_type == 18) {
            $domainNames = [
                1 => 'Control Environment',
                2 => 'Risk Assessment',
                3 => 'Control Activities',
                4 => 'Information and Communication',
                5 => 'Monitoring'
            ];
        }

        if ($project->project_type == 6) {
            $domainNames = [
                1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                2 => 'INFORMATION SECURITY',
                3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                6 => 'IT AUDIT'
            ];
        }

        if ($project->project_type == 10) {
            $domainNames = [
                '4.2' => 'ZCR 1: Identify the SUC',
                '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                '4.5' => 'ZCR 4: Risk Comparison',
                '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                '4.8' => 'ZCR 7: Asset Owner Approval',

            ];
        }

        if ($project->project_type == 12) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',
                '12' => 'Software application requirements',
                '13' => 'Embedded device requirements',
                '14' => 'Host device requirements',
                '15' => 'Network device requirements',

            ];
        }

        if ($project->project_type == 11) {
            $domainNames = [
                '4.2.2' => 'Business Rationale',
                '4.2.3' => 'Risk Identification, Classification, and Assessment',
                '4.3.2' => 'Security Policy, Organization, and Awareness',
                '4.3.3' => 'Selected Security Countermeasures',
                '4.3.4' => 'Implementation',
                '4.4.2' => 'Conformance',
                '4.4.3' => 'Review, Improve, and Maintain the CSMS',
            ];
        }

        if ($project->project_type == 9) {
            $domainNames = [
                '5.2' => 'SM-1: Development process',
                '5.3' => 'SM-2: Identification of responsibilities',
                '5.4' => 'SM-3: Identification of applicability',
                '5.5' => 'SM-4: Security expertise',
                '5.6' => 'SM-5: Process scoping',
                '5.7' => 'SM-6: File integrity',
                '5.8' => 'SM-7: Development environment security',
                '5.9' => 'SM-8: Controls for private keys',
                '5.10' => 'SM-9: Security requirements for externally provided components',
                '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                '5.12' => 'SM-11: Assessing and addressing security-related issues',
                '5.13' => 'SM-12: Process verification',
                '5.14' => 'SM-13: Continuous improvement',
                '6.2' => 'SR-1: Product security context',
                '6.3' => 'SR-2: Threat model',
                '6.4' => 'SR-3: Product security requirements',
                '6.5' => 'SR-4: Product security requirements content',
                '6.6' => 'SR-5: Security requirements review',
                '7.2' => 'SD-1: Secure design principles',
                '7.3' => 'SD-2: Defense in depth design',
                '7.4' => 'SD-3: Security design review',
                '7.5' => 'SD-4: Secure design best practices',
                '8.3' => 'SI-1: Security implementation review',
                '8.4' => 'SI-2: Secure coding standards',
                '9.2' => 'SVV-1: Security requirements testing',
                '9.3' => 'SVV-2: Threat mitigation testing',
                '9.4' => 'SVV-3: Vulnerability testing',
                '9.5' => 'SVV-4: Penetration testing',
                '9.6' => 'SVV-5: Independence of testers',
                '10.2' => 'DM-1: Receiving notifications of security-related issues',
                '10.3' => 'DM-2: Reviewing security-related issues',
                '10.4' => 'DM-3: Assessing security-related issues',
                '10.5' => 'DM-4: Addressing security-related issues',
                '10.6' => 'DM-5: Disclosing security-related issues',
                '10.7' => 'DM-6: Periodic review of security defect management practice',
                '11.2' => 'SUM-1: Security update qualification',
                '11.3' => 'SUM-2: Security update documentation',
                '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                '11.5' => 'SUM-4: Security update delivery',
                '11.6' => 'SUM-5: Timely delivery of security patches',
                '12.2' => 'SG-1: Product defense in depth',
                '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                '12.4' => 'SG-3: Security hardening guidelines',
                '12.5' => 'SG-4: Secure disposal guidelines',
                '12.6' => 'SG-5: Secure operation guidelines',
                '12.7' => 'SG-6: Account management guidelines',
                '12.8' => 'SG-7: Documentation review',
            ];
        }

        if ($project->project_type == 13) {
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',

            ];
        }

        if ($project->project_type == 19) {
            $domainNames = [
                1 => 'Asset Management',
                2 => 'Availability',
                3 => 'Change Management',
                4 => 'Communications',
                5 => 'Confidentiality',
                6 => 'Data Classification',
                7 => 'Fraud Management',
                8 => 'Human Resource aspects of Trust Services',
                9 => 'Information Assets Security Management Policy',
                10 => 'Information Security Events Monitoring',
                11 => 'Information Security Incident Management',
                12 => 'Information Security Monitoring',
                13 => 'IT Operational Anomalies Reporting',
                14 => 'Logical and Physical Access Controls',
                15 => 'Monitoring of Controls',
                16 => 'Organization & Management',
                17 => 'Risk Management',
                18 => 'Vendor and Business Partner Risk Management',
                19 => 'Vulnerability Management'
            ];
        }


        if ($project->project_type == 4) {
            $domainNames = [
                4 => 'Context of the Organization',
                5 => 'Leadership',
                6 => 'Planning',
                7 => 'Support',
                8 => 'Operation',
                9 => 'Performance Evaluation',
                10 => 'Improvement'
            ];
        }



        return view('compliance_map.components', [
            'project' => $project,
            'group' => $group,
            'service' => $service,
            'subgroup' => $subgroup,
            'components' => $components,
            'domainName' => $domainNames[$domain],
            'domain' => $domain
        ]);
    }

    public function no_groups_for_compliance_map($proj_id, $service, $domainName, $domain)
    {
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

            return view('compliance_map.components', [
                'project' => $project,
                'service' => $service,
                'group' => null,
                'subgroup' => null,
                'components' => $components,
                'domainName' => $domainName,
                'domain' => $domain
            ]);
        }

        return view('compliance_map.from_service_to_subgroup', [
            'project' => $project,
            'service' => $service,
            'subgroups' => $subgroups,
            'domainName' => $domainName,
            'domain' => $domain
        ]);
    }

    public function service_subgroups_to_components($domain, $domainName, $service, $subgroup, $proj_id)
    {
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


        return view('compliance_map.components', [
            'project' => $project,
            'service' => $service,
            'group' => null,
            'subgroup' => $subgroup,
            'components' => $components,
            'domainName' => $domainName,
            'domain' => $domain
        ]);
    }

    public function compliance_map_subdomain($domain, $service, $component, $proj_id, Request $req)
    {



        $title = $domain;
        $group = $req->query('group');
        $subgroup = $req->query('subgroup');


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

        if (session()->has('comp_status')) {
            $comp_status = session('comp_status');
            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.subdomain AS SubDomain',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->whereIn('compliance.asset_id', $assetIds)
                ->where('compliance.title_num', $domain)
                ->groupBy('compliance.subdomain', 'compliance.comp_status') // Group by service, component, and comp_status
                ->orderByRaw("CAST(SUBSTRING_INDEX(compliance.subdomain, '-', 1) AS UNSIGNED), CAST(SUBSTRING_INDEX(compliance.subdomain, '-', -1) AS UNSIGNED)")
                ->get();
            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.comp_status',
                    'compliance.subdomain AS SubDomain',
                    DB::raw('COUNT(*) AS status_count')   // count after filtering
                )
                ->where('assets.project_id', $proj_id)
                ->whereIn('compliance.asset_id', $assetIds)
                ->where('compliance.title_num', $domain)
                ->where('compliance.comp_status', $comp_status)   // 🔑 keep only this status
                ->groupBy('compliance.subdomain', 'compliance.comp_status')                 // no need to group by comp_status now
                ->orderByRaw("
        CAST(SUBSTRING_INDEX(compliance.subdomain, '-', 1) AS UNSIGNED),
        CAST(SUBSTRING_INDEX(compliance.subdomain, '-', -1) AS UNSIGNED)
    ")->get();
        } else {
            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.subdomain AS SubDomain',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->whereIn('compliance.asset_id', $assetIds)
                ->where('compliance.title_num', $domain)
                ->groupBy('compliance.subdomain', 'compliance.comp_status') // Group by service, component, and comp_status
                ->orderByRaw("CAST(SUBSTRING_INDEX(compliance.subdomain, '-', 1) AS UNSIGNED), CAST(SUBSTRING_INDEX(compliance.subdomain, '-', -1) AS UNSIGNED)")
                ->get();
        }




        $formattedResults = [];
        $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];

        foreach ($results as $result) {
            $domain = $result->SubDomain;
            $status = $result->comp_status;
            $count = $result->status_count;

            // Initialize domain
            if (!isset($formattedResults[$domain])) {
                $formattedResults[$domain] = [];
            }

            if (!isset($formattedResults[$domain][$status])) {
                $formattedResults[$domain][$status] = 0;
            }

            // Add the count to the respective comp_status
            $formattedResults[$domain][$status] += $count;

            // Update the grand totals for each status
            $totalCounts[$status] += $count;
        }
        // Add the total for all rows
        $totalCounts['total'] = array_sum($totalCounts);


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        if ($project->project_type == 7) {

            $filepath = public_path('KSA_NCA_ECC_Modified.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();


            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[1] => $row[4]]; // Map 1st index (key) to 4th index (value)
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array



            $domainNames = [
                1 => 'Cybersecurity Governance',
                2 => 'Cybersecurity Defense',
                3 => 'Cybersecurity Resilience',
                4 => 'Third-Party and Cloud Computing Cybersecurity',
                5 => 'Industrial Control Systems Cybersecurity',
            ];
        }

        if ($project->project_type == 18) {

            $filepath = public_path('COSO_Modified.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();



            $UniqueSubDomains = collect($filteredData)
                ->unique(fn($row) => $row[1]) // Keep only first per control ID
                ->mapWithKeys(function ($row) {
                    return [(string) $row[1] => $row[4]]; // force key to string
                })
                ->toArray();


            $domainNames = [
                1 => 'Control Environment',
                2 => 'Risk Assessment',
                3 => 'Control Activities',
                4 => 'Information and Communication',
                5 => 'Monitoring'
            ];
        }

        if ($project->project_type == 19) {

            $filepath = public_path('Soc2_Type2_Modified.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();



            $UniqueSubDomains = collect($filteredData)
                ->unique(fn($row) => $row[1]) // Keep only first per control ID
                ->mapWithKeys(function ($row) {
                    return [(string) $row[1] => $row[4]]; // force key to string
                })
                ->toArray();

            $domainNames = [
                1 => 'Asset Management',
                2 => 'Availability',
                3 => 'Change Management',
                4 => 'Communications',
                5 => 'Confidentiality',
                6 => 'Data Classification',
                7 => 'Fraud Management',
                8 => 'Human Resource aspects of Trust Services',
                9 => 'Information Assets Security Management Policy',
                10 => 'Information Security Events Monitoring',
                11 => 'Information Security Incident Management',
                12 => 'Information Security Monitoring',
                13 => 'IT Operational Anomalies Reporting',
                14 => 'Logical and Physical Access Controls',
                15 => 'Monitoring of Controls',
                16 => 'Organization & Management',
                17 => 'Risk Management',
                18 => 'Vendor and Business Partner Risk Management',
                19 => 'Vulnerability Management'
            ];
        }



        if ($project->project_type == 1) {

            $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();



            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[1] => (string)($row[2])];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 2) {

            $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();



            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[1] => (string)($row[2])];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }


        if ($project->project_type == 3) {

            $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();



            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[1] => (string)($row[2])];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if ($project->project_type == 5) {
            $filepath = public_path('CY_SAMA.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();


            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[2] => $row[3]]; // Map 1st index (key) to 4th index (value)
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array



            $domainNames = [
                '3.1' => 'Cybersecurity Leadership and Governance',
                '3.2' => 'Cybersecurity Risk Management and Compliance',
                '3.3' => 'Cybersecurity Operations and Technology',
                '3.4' => 'Third-Party Cybersecurity',

            ];
        }
        if ($project->project_type == 6) {
            $filepath = public_path('SBP_ETGRMF.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();


            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


            $domainNames = [
                1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                2 => 'INFORMATION SECURITY',
                3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                6 => 'IT AUDIT'
            ];
        }


        if ($project->project_type == 8) {

            $filepath = public_path('UAE_IA.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique()
                ->toArray();


            $domainNames = [
                'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
                'M1.2' => 'INFORMATION SECURITY POLICY',
                'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
                'M1.4' => 'SUPPORT',
                'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
                'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
                'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
                'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',
                'M3.1' => 'AWARENESS AND TRAINING POLICY',
                'M3.2' => 'AWARENESS AND TRAINING PLANNING',
                'M3.3' => 'SECURITY TRAINING',
                'M3.4' => 'SECURITY AWARENESS',
                'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
                'M4.2' => 'PRIOR TO EMPLOYMENT',
                'M4.3' => 'DURING EMPLOYMENT',
                'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',
                'M5.1' => 'COMPLIANCE POLICY',
                'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
                'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
                'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
                'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',
                'M6.1' => 'PERFORMANCE EVALUATION POLICY',
                'M6.2' => 'PERFORMANCE EVALUATION',
                'M6.3' => 'IMPROVEMENT',
                'T1.1' => 'ASSET MANAGEMENT POLICY',
                'T1.2' => 'RESPONSIBILITY FOR ASSETS',
                'T1.3' => 'INFORMATION CLASSIFICATION',
                'T1.4' => 'MEDIA HANDLING',
                'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
                'T2.2' => 'SECURE AREAS',
                'T2.3' => 'EQUIPMENT SECURITY',
                'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
                'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
                'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
                'T3.4' => 'PROTECTION FROM MALWARE',
                'T3.5' => 'BACKUP',
                'T3.6' => 'MONITORING',
                'T4.1' => 'COMMUNICATIONS POLICY',
                'T4.2' => 'INFORMATION TRANSFER',
                'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
                'T4.4' => 'INFORMATION SHARING PROTECTION',
                'T4.5' => 'NETWORK SECURITY MANAGEMENT',
                'T5.1' => 'ACCESS CONTROL POLICY',
                'T5.2' => 'USER ACCESS MANAGEMENT',
                'T5.3' => 'USER RESPONSIBILITIES',
                'T5.4' => 'NETWORK ACCESS CONTROL',
                'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
                'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
                'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',
                'T6.1' => 'THIRD-PARTY SECURITY POLICY',
                'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
                'T6.3' => 'CLOUD COMPUTING',
                'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
                'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
                'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
                'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
                'T7.5' => 'SECURITY OF SYSTEM FILES',
                'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
                'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
                'T7.8' => 'SUPPLY CHAIN MANAGEMENT',
                'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
                'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
                'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',
                'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
                'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
                'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS'
            ];
        }

        //ISA part3-2
        if ($project->project_type == 10) {

            $filepath = public_path('ISA 62443 Part 3-2.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique()
                ->toArray();

            $domainNames = [
                '4.2' => 'ZCR 1: Identify the SUC',
                '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
                '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
                '4.5' => 'ZCR 4: Risk Comparison',
                '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
                '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
                '4.8' => 'ZCR 7: Asset Owner Approval',
            ];
        }

        if ($project->project_type == 12) {
            $filepath = public_path('ISA 62443 Part 4-2.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique()
                ->toArray();
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',
                '12' => 'Software application requirements',
                '13' => 'Embedded device requirements',
                '14' => 'Host device requirements',
                '15' => 'Network device requirements',

            ];
        }

        if ($project->project_type == 13) {
            $filepath = public_path('ISA 62443 Part 3-3.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique()
                ->toArray();
            $domainNames = [
                '5' => 'FR 1 – Identification and authentication control',
                '6' => 'FR 2 – Use control',
                '7' => 'FR 3 – System integrity',
                '8' => 'FR 4 – Data confidentiality',
                '9' => 'FR 5 – Restricted data flow',
                '10' => 'FR 6 – Timely response to events',
                '11' => 'FR 7 – Resource availability',

            ];
        }

        if ($project->project_type == 11) {
            $filepath = public_path('ISA 62443 Part 2-1.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique()
                ->toArray();

            $domainNames = [
                '4.2.2' => 'Business Rationale',
                '4.2.3' => 'Risk Identification, Classification, and Assessment',
                '4.3.2' => 'Security Policy, Organization, and Awareness',
                '4.3.3' => 'Selected Security Countermeasures',
                '4.3.4' => 'Implementation',
                '4.4.2' => 'Conformance',
                '4.4.3' => 'Review, Improve, and Maintain the CSMS',
            ];
        }

        if ($project->project_type == 9) {
            $filepath = public_path('ISA 62443 Part 4-1.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[2] => (string)$row[3]];
                })
                ->unique()
                ->toArray();
            $domainNames = [
                '5.2' => 'SM-1: Development process',
                '5.3' => 'SM-2: Identification of responsibilities',
                '5.4' => 'SM-3: Identification of applicability',
                '5.5' => 'SM-4: Security expertise',
                '5.6' => 'SM-5: Process scoping',
                '5.7' => 'SM-6: File integrity',
                '5.8' => 'SM-7: Development environment security',
                '5.9' => 'SM-8: Controls for private keys',
                '5.10' => 'SM-9: Security requirements for externally provided components',
                '5.11' => 'SM-10: Custom developed components from third-party suppliers',
                '5.12' => 'SM-11: Assessing and addressing security-related issues',
                '5.13' => 'SM-12: Process verification',
                '5.14' => 'SM-13: Continuous improvement',
                '6.2' => 'SR-1: Product security context',
                '6.3' => 'SR-2: Threat model',
                '6.4' => 'SR-3: Product security requirements',
                '6.5' => 'SR-4: Product security requirements content',
                '6.6' => 'SR-5: Security requirements review',
                '7.2' => 'SD-1: Secure design principles',
                '7.3' => 'SD-2: Defense in depth design',
                '7.4' => 'SD-3: Security design review',
                '7.5' => 'SD-4: Secure design best practices',
                '8.3' => 'SI-1: Security implementation review',
                '8.4' => 'SI-2: Secure coding standards',
                '9.2' => 'SVV-1: Security requirements testing',
                '9.3' => 'SVV-2: Threat mitigation testing',
                '9.4' => 'SVV-3: Vulnerability testing',
                '9.5' => 'SVV-4: Penetration testing',
                '9.6' => 'SVV-5: Independence of testers',
                '10.2' => 'DM-1: Receiving notifications of security-related issues',
                '10.3' => 'DM-2: Reviewing security-related issues',
                '10.4' => 'DM-3: Assessing security-related issues',
                '10.5' => 'DM-4: Addressing security-related issues',
                '10.6' => 'DM-5: Disclosing security-related issues',
                '10.7' => 'DM-6: Periodic review of security defect management practice',
                '11.2' => 'SUM-1: Security update qualification',
                '11.3' => 'SUM-2: Security update documentation',
                '11.4' => 'SUM-3: Dependent component or operating system security update documentation',
                '11.5' => 'SUM-4: Security update delivery',
                '11.6' => 'SUM-5: Timely delivery of security patches',
                '12.2' => 'SG-1: Product defense in depth',
                '12.3' => 'SG-2: Defense in depth measures expected in the environment',
                '12.4' => 'SG-3: Security hardening guidelines',
                '12.5' => 'SG-4: Secure disposal guidelines',
                '12.6' => 'SG-5: Secure operation guidelines',
                '12.7' => 'SG-6: Account management guidelines',
                '12.8' => 'SG-7: Documentation review',
            ];
        }


        if ($project->project_type == 4) {

            $filepath = public_path('ISO_SEC_2_2.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($title) {
                return strval($row[0]) == $title;
            })->values()->all();



            // $UniqueSubDomains = collect($filteredData)
            // ->pluck(2) // Pluck the 2nd index from each sub-array
            // ->unique() // Get unique values
            // ->values() // Reindex the collection
            // ->all(); // Convert to an array if needed
            // dd($UniqueSubDomains);

            $UniqueSubDomains = collect($filteredData)
                ->mapWithKeys(function ($item) {
                    $words = explode(" ", $item[2]);
                    $subdomain = array_shift($words); // Get the first word
                    $value = implode(" ", $words); // Join the remaining words
                    return [$subdomain => $value];
                })
                ->unique(function ($value, $key) {
                    // Ensure uniqueness based on the key
                    return $key;
                })
                ->all(); // Convert to array


            $domainNames = [
                4 => 'Context of the Organization',
                5 => 'Leadership',
                6 => 'Planning',
                7 => 'Support',
                8 => 'Operation',
                9 => 'Performance Evaluation',
                10 => 'Improvement'
            ];
        }




        return view('compliance_map.subdomains_map', [
            'project' => $project,
            'formattedResults' => $formattedResults,
            'results' => $results,
            'UniqueSubDomains' => $UniqueSubDomains,
            'domain' => $title,
            'domainName' => $domainNames[$title],
            'service' => $service,
            'component' => $component,
            'group' => $group,
            'subgroup' => $subgroup
        ]);
    }

    public function download_excel_compliance_map_subdomain($proj_id, $user_id, Request $req)
    {
        $results = json_decode($req->query('formattedResult'), true);

        $formattedResults = [];
        $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];

        foreach ($results as $result) {

            $domain = $result['SubDomain'];
            $status = $result['comp_status'];
            $count = $result['status_count'];

            // Initialize domain
            if (!isset($formattedResults[$domain])) {
                $formattedResults[$domain] = [];
            }

            if (!isset($formattedResults[$domain][$status])) {
                $formattedResults[$domain][$status] = 0;
            }

            // Add the count to the respective comp_status
            $formattedResults[$domain][$status] += $count;

            // Update the grand totals for each status
            $totalCounts[$status] += $count;
        }

        // Calculate the total for each domain
        foreach ($formattedResults as $domain => $statuses) {
            $formattedResults[$domain]['rowTotal'] = array_sum($statuses);
        }
        // Add the total for all rows
        $totalCounts['total'] = array_sum($totalCounts);


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();



        $projectName = $project->project_name;


        return Excel::download(
            new ComplianceStatusSubDomainExport($formattedResults, $totalCounts),
            $projectName . '_compliance_map_subdomains.xlsx'
        );
    }

    public function compliance_map_sub_req($subdomain, $service, $component, $proj_id, Request $req)
    {
        $group = $req->query('group');
        $subgroup = $req->query('subgroup');

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


        if (session('comp_status')) {
            $comp_status = session('comp_status'); // get from session, or pass as parameter

            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.sub_req AS SubReq',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->whereIn('compliance.asset_id', $assetIds)
                ->where('compliance.subdomain', $subdomain)
                ->where('compliance.comp_status', $comp_status)
                ->groupBy('compliance.sub_req', 'compliance.comp_status')
                ->orderBy('compliance.sub_req')
                ->get();
        } else {
            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.sub_req AS SubReq',
                    'compliance.comp_status',
                    DB::raw('COUNT(compliance.comp_status) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->whereIn('compliance.asset_id', $assetIds)
                ->where('compliance.subdomain', $subdomain)
                ->groupBy('compliance.sub_req', 'compliance.comp_status') // Group by service, component, and comp_status
                ->orderby('compliance.sub_req')
                ->get();
        }





        $formattedResults = [];
        $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];

        foreach ($results as $result) {
            $domain = $result->SubReq;
            $status = $result->comp_status;
            $count = $result->status_count;

            // Initialize domain
            if (!isset($formattedResults[$domain])) {
                $formattedResults[$domain] = [];
            }

            if (!isset($formattedResults[$domain][$status])) {
                $formattedResults[$domain][$status] = 0;
            }

            // Add the count to the respective comp_status
            $formattedResults[$domain][$status] += $count;

            // Update the grand totals for each status
            $totalCounts[$status] += $count;
        }
        // Add the total for all rows
        $totalCounts['total'] = array_sum($totalCounts);



        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        if ($project->project_type == 7) {

            $filepath = public_path('KSA_NCA_ECC_Modified.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][2]; //title

            $subdomainTitle = $filteredData[0][4];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 1) {

            //because we dint have title in pci single excel sheet
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];

            $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();



            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $domainNames[$filteredData[0][0]]; // we dont have in excel

            $subdomainTitle = $filteredData[0][2];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[4]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 2) {

            //because we dint have title in pci single excel sheet
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];

            $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();



            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $domainNames[$filteredData[0][0]]; // we dont have in excel

            $subdomainTitle = $filteredData[0][2];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[4]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 3) {

            //because we dint have title in pci single excel sheet
            $domainNames = [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];

            $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();



            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $domainNames[$filteredData[0][0]]; // we dont have in excel

            $subdomainTitle = $filteredData[0][2];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[4]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 5) {

            $filepath = public_path('CY_SAMA.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }

        if ($project->project_type == 6) {

            $filepath = public_path('SBP_ETGRMF.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();



            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; // we dont have in excel

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[4] => (string) $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array



            $domainNames = [
                1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
                2 => 'INFORMATION SECURITY',
                3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
                4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
                5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
                6 => 'IT AUDIT'
            ];
        }

        if ($project->project_type == 8) {
            $filepath = public_path('UAE_IA.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[6]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 10) {
            $filepath = public_path('ISA 62443 Part 3-2.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 12) {
            $filepath = public_path('ISA 62443 Part 4-2.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array

        }

        if ($project->project_type == 13) {
            $filepath = public_path('ISA 62443 Part 3-3.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }

        if ($project->project_type == 11) {
            $filepath = public_path('ISA 62443 Part 2-1.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }

        if ($project->project_type == 9) {
            $filepath = public_path('ISA 62443 Part 4-1.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][3];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }








        if ($project->project_type == 4) {

            $filepath = public_path('ISO_SEC_2_2.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                $my_subdomain = explode(' ', $row[2]);

                return strval($my_subdomain[0]) === $subdomain;
            })->values()->all();



            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][1]; //title

            $subdomainTitle = $filteredData[0][2];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[4]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }

        if ($project->project_type == 18) {

            $filepath = public_path('COSO_Modified.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][2]; //title

            $subdomainTitle = $filteredData[0][4];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }

        if ($project->project_type == 19) {

            $filepath = public_path('SOC2_Type2_Modified.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)

            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();


            $MainDomainNum = $filteredData[0][0];
            $MainDomainTitle = $filteredData[0][2]; //title

            $subdomainTitle = $filteredData[0][4];


            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[3] => $row[5]];
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array


        }




        return view('compliance_map.subreq_map', [
            'project' => $project,
            'formattedResults' => $formattedResults,
            'results' => $results,
            'UniqueSubReqs' => $UniqueSubReqs,
            'MainDomainTitle' => $MainDomainTitle,
            'MainDomainNum' => $MainDomainNum,
            'service' => $service,
            'component' => $component,
            'group' => $group,
            'subgroup' => $subgroup,
            'subdomainTitle' => $subdomainTitle,
            'subdomainNum' => $subdomain
        ]);
    }

    public function download_excel_compliance_map_subreq($proj_id, $user_id, Request $req)
    {
        $results = json_decode($req->query('formattedResult'), true);
        $formattedResults = [];
        $totalCounts = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];

        foreach ($results as $result) {

            $domain = $result['SubReq'];
            $status = $result['comp_status'];
            $count = $result['status_count'];

            // Initialize domain
            if (!isset($formattedResults[$domain])) {
                $formattedResults[$domain] = [];
            }

            if (!isset($formattedResults[$domain][$status])) {
                $formattedResults[$domain][$status] = 0;
            }

            // Add the count to the respective comp_status
            $formattedResults[$domain][$status] += $count;

            // Update the grand totals for each status
            $totalCounts[$status] += $count;
        }

        // Calculate the total for each domain
        foreach ($formattedResults as $domain => $statuses) {
            $formattedResults[$domain]['rowTotal'] = array_sum($statuses);
        }
        // Add the total for all rows
        $totalCounts['total'] = array_sum($totalCounts);


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();



        $projectName = $project->project_name;


        return Excel::download(
            new ComplianceStatusSubDomainExport($formattedResults, $totalCounts),
            $projectName . '_compliance_map_sub_sub_domains.xlsx'
        );
    }

    public function comp_risk_analysis_menu($org_id)
    {
        return view('comp_analysis.navigation_menu');
    }

    public function analyze_comp_risk($org_id)
    {
        $projects = Project::join('project_details', 'projects.project_id', 'project_details.project_code')
            ->join('project_types', 'projects.project_type', 'project_types.id')
            ->join('iso_sec_2_1', 'projects.project_id', 'iso_sec_2_1.project_id')
            ->where('projects.org_id', $org_id)
            ->get([
                'projects.project_id',
                'project_name',
                'project_type',
                'type',
                'assessment_id',
                's_name',
                'g_name',
                'name',
                'c_name',
                'owner_dept',
                'physical_loc',
                'logical_loc',

            ]);

        $groupedServices = $projects->groupBy('s_name')->map(function ($items) {
            return [
                'project_names' => $items->pluck('project_name')->unique()->implode(', '),
                'project_types' => $items->pluck('type')->unique()->implode(', '),
                'g_names'       => $items->pluck('g_name')->unique()->implode(', '),
                'names'         => $items->pluck('name')->unique()->implode(', '),
                'c_names'       => $items->pluck('c_name')->unique()->implode(', '),
                'owner_depts'   => $items->pluck('owner_dept')->filter()->unique()->implode(', '),
                'physical_locs' => $items->pluck('physical_loc')->filter()->unique()->implode(', '),
                'logical_locs'  => $items->pluck('logical_loc')->filter()->unique()->implode(', '),
            ];
        });

        return view('comp_analysis.services_list', [
            'groupedServices' => $groupedServices
        ]);
    }

    public function select_projects_for_comp_analysis($s_name, $org_id)
    {
        $projects = DB::table('projects')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->join('iso_sec_2_1', 'projects.project_id', '=', 'iso_sec_2_1.project_id')
            ->where('projects.org_id', $org_id)
            ->where('s_name', $s_name)
            ->select(
                'projects.project_id',
                'projects.project_name',
                'projects.project_type',
                'project_types.type'
            )
            ->distinct()
            ->get();

        return view('comp_analysis.select_projects_view', [
            'serviceName' => $s_name,
            'projects' => $projects, // the collection with project_id, project_name, type
        ]);
    }

    public function submit_selected_projects_for_comp_analysis($org_id, Request $req)
    {
        $serviceName     = $req->input('s_name');                 // e.g. “Service 1”
        $projectIds      = $req->input('selected_projects', []);  // [11, 12]

        $rows = DB::table('projects')
            ->join('iso_sec_2_1', 'projects.project_id', '=', 'iso_sec_2_1.project_id')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->where('projects.org_id', $org_id)
            ->whereIn('projects.project_id', $projectIds)
            ->where('iso_sec_2_1.s_name', $serviceName)
            ->select(
                'projects.project_id',
                'projects.project_name',
                'iso_sec_2_1.c_name', // asset component
                'project_types.type'
            )
            ->get();


        $projects = $rows
            ->groupBy('project_id')
            ->map(function ($items) {
                return [
                    'name'       => $items->first()->project_name,
                    'type'       => $items->first()->type,
                    'components' => $items->pluck('c_name')->unique()->sort()->values()
                ];
            });


        return view('comp_analysis.choose_components_for_service', [
            'serviceName' => $serviceName,
            'projects'    => $projects,
        ]);
    }

    public function submit_components_for_comp_analysis($org_id, Request $req)
    {
        $req->validate([
            'selected_projects' => 'required|array|min:1',
            'components' => 'required|array|min:1'
        ]);
        $action = $req->input('action');
        if($action=="compliance"){

        $serviceName = $req->input('s_name');
        $selectedProjects = $req->input('selected_projects');
        $selectedComponents = $req->input('components');

        // Get project name & type
        $projects = DB::table('projects')
            ->join('project_types', 'projects.project_type', '=', 'project_types.id')
            ->whereIn('projects.project_id', $selectedProjects)
            ->select('projects.project_id', 'projects.project_name', 'projects.project_type', 'project_types.type')
            ->get();

        // Build view data structure
        $structuredData = [];

        foreach ($projects as $project) {
            $type = $project->project_type;
            $domainNames = config('domain-names')[$type] ?? [];

            $structuredData[] = [
                'id'          => $project->project_id,
                'name'        => $project->project_name,
                'type_label'  => $project->type,
                'components'  => $selectedComponents[$project->project_id] ?? [],
                'domains'     => $domainNames
            ];
        }

        return view('comp_analysis.select_domains', [
            'serviceName' => $serviceName,
            'projects'    => $structuredData,
        ]);
    }else{
        dd("Analyze risk to be built later");
    }
    }

    // public function selected_domains($org_id, Request $req)
    // {

    //     $selectedProjects   = $req->input('selected_projects', []);
    //     $selectedComponents = $req->input('components', []);
    //     $selectedDomains    = $req->input('domains', []);

    //     $results = collect();

    //     foreach ($selectedProjects as $proj_id) {
    //         $componentsInProject = $selectedComponents[$proj_id] ?? [];
    //         $domainsInProject    = $selectedDomains[$proj_id] ?? [];

    //         if (empty($componentsInProject) || empty($domainsInProject)) {
    //             continue;
    //         }

    //         $projectResults = DB::table('iso_sec_2_1 AS assets')
    //             ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
    //             ->select(
    //                 'compliance.comp_status',
    //                 DB::raw('COUNT(*) AS status_count')
    //             )
    //             ->where('assets.project_id', $proj_id)
    //             ->whereIn('assets.c_name', $componentsInProject)
    //             ->whereIn('compliance.title_num', $domainsInProject)
    //             ->groupBy('compliance.comp_status')
    //             ->get();

    //         $results = $results->merge($projectResults);
    //     }

    //     $totalCounts = ['yes' => 0, 'no' => 0, 'partial' => 0, 'not_tested' => 0, 'not_applicable' => 0];

    //     foreach ($results as $row) {
    //         $status = $row->comp_status;
    //         $count  = $row->status_count;

    //         if (isset($totalCounts[$status])) {
    //             $totalCounts[$status] += $count;
    //         }
    //     }

    //     $total = array_sum($totalCounts);
    //     $percentages = [];

    //     foreach ($totalCounts as $status => $count) {
    //         $percentages[$status] = $total > 0 ? round(($count / $total) * 100, 2) : 0;
    //     }

    //     $totalCounts['total'] = $total;




    //     return view('comp_analysis.compliance_summary_first_level', [
    //         'serviceName' => $req->s_name,
    //         'totalCounts' => $totalCounts,
    //         'percentages' => $percentages,
    //     ]);
    // }

    public function selected_domains($org_id, Request $req)
{
    $selectedProjects   = $req->input('selected_projects', []);
    $selectedComponents = $req->input('components', []);
    $selectedDomains    = $req->input('domains', []);

    $componentStats = [];

    foreach ($selectedProjects as $proj_id) {
        $componentsInProject = $selectedComponents[$proj_id] ?? [];
        $domainsInProject    = $selectedDomains[$proj_id] ?? [];

        if (empty($componentsInProject) || empty($domainsInProject)) {
            continue;
        }

        // Get project name
       $project = DB::table('projects')
    ->join('project_types', 'projects.project_type', '=', 'project_types.id')
    ->where('projects.project_id', $proj_id)
    ->select('projects.project_name', 'project_types.type AS project_type_name',
    'projects.project_type')
    ->first();
        $projectName = $project ? $project->project_name : 'Unknown Project';
        $projectType = $project?->project_type_name ?? 'N/A';

        $domainNamesForType = config('domain-names')[$project->project_type] ?? [];

        $domainList = collect($domainsInProject)
            ->map(function ($domainKey) use ($domainNamesForType) {
                return [
                    'number' => $domainKey,
                    'name'   => $domainNamesForType[$domainKey] ?? 'Unknown Domain',
                ];
            })
            ->values()
            ->all();


        foreach ($componentsInProject as $componentName) {
            $results = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->select(
                    'compliance.comp_status',
                    DB::raw('COUNT(*) AS status_count')
                )
                ->where('assets.project_id', $proj_id)
                ->where('assets.c_name', $componentName)
                ->whereIn('compliance.title_num', $domainsInProject)
                ->groupBy('compliance.comp_status')
                ->get();

            // Init counters
            $statusCounts = ['yes' => 0, 'no' => 0, 'partial' => 0, 'not_tested' => 0, 'not_applicable' => 0];

            foreach ($results as $row) {
                if (isset($statusCounts[$row->comp_status])) {
                    $statusCounts[$row->comp_status] += $row->status_count;
                }
            }

            $total = array_sum($statusCounts);
            $percentages = [];

            foreach ($statusCounts as $status => $count) {
                $percentages[$status] = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            }

            $componentStats[] = [
                'project_id'   => $proj_id,
                'project_name' => $projectName,
                'project_type' => $projectType,
                'component'    => $componentName,
                'counts'       => $statusCounts,
                'percentages'  => $percentages,
                'total'        => $total,
                'domains'       => $domainList
            ];
        }
    }

    return view('comp_analysis.compliance_summary_first_level', [
        'serviceName'     => $req->s_name,
        'componentStats'  => $componentStats,
    ]);
}

}
