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
    public function compliance_map_all_services($proj_id, $user_id)
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

            $uniqueServices = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->select('s_name')
                ->distinct()
                ->get();

            if ($project->project_type == 7) {
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


                return view('compliance_map.ksa_nca_all_services_all_controls', [
                    'project' => $project,
                    'uniqueServices' => $uniqueServices,
                    'formattedResults' => $formattedResults,
                ]);


            }

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
        } else {
            $domainNames = [];
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

            if ($project->project_type == 7) {
                $domainNames = [
                    1 => 'Cybersecurity Governance',
                    2 => 'Cybersecurity Defense',
                    3 => 'Cybersecurity Resilience',
                    4 => 'Third-Party and Cloud Computing Cybersecurity',
                    5 => 'Industrial Control Systems Cybersecurity',
                ];
            } else {
                $domainNames = [];
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

        $groups = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->where('s_name', $service)
            ->whereNotNull('g_name')
            ->select('g_name')
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
        } else {
            $domainNames = [];
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
            ->where('s_name', $service)
            ->where('g_name', $group)
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
        } else {
            $domainNames = [];
        }

        if ($subgroups->count() == 0) {

            $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->where('s_name', $service)
                ->where('g_name', $group)
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
            ->where('s_name', $service)
            ->where('g_name', $group)
            ->where('name', $subgroup)
            ->whereNotNull('c_name')
            ->select('c_name')
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
        } else {
            $domainNames = [];
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
            ->where('s_name', $service)
            ->whereNotNull('name')
            ->select('name')
            ->distinct()
            ->get();

        if ($subgroups->count() == 0) {
            $components = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
                ->where('s_name', $service)
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
            ->where('s_name', $service)
            ->where('name', $subgroup)
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
            ->where('s_name', $service)
            ->when($group, function ($query, $group) {
                return $query->where('g_name', $group);
            })
            ->when($subgroup, function ($query, $subgroup) {
                return $query->where('name', $subgroup);
            })
            ->where('c_name', $component)
            ->pluck('assessment_id')->toArray();


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


            return view('compliance_map.subdomains_map', [
                'project' => $project,
                'formattedResults' => $formattedResults,
                'results'=>$results,
                'UniqueSubDomains' => $UniqueSubDomains,
                'domain' => $title,
                'domainName' => $domainNames[$title],
                'service'=>$service,
                'component'=>$component,
                'group'=>$group,
                'subgroup'=>$subgroup
            ]);



        }

    }

    public function download_excel_compliance_map_subdomain($proj_id,$user_id,Request $req){
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

 

}

