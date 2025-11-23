<?php

namespace App\Http\Controllers;

use App\Exports\BothActionPlan;
use App\Exports\MandatoryActionPlan;
use App\Exports\TreatmentActionPlan;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;



use Illuminate\Http\Request;
use Session;

class ActionPlanController extends Controller
{
    public function action_plan($proj_id, $user_id)
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

            return view('action_plan.select_risk_type', [
                'project' => $project
            ]);
        }
    }

    public function action_plan_all_projects_in_org($org)
    {

        return view('action_plan.all_projects_select_risk_type');
    }

    public function select_assets($action_plan_type, $proj_id)
    {
        session(['action_plan_type' => $action_plan_type]);
        $value = Session('action_plan_type');

        $services = DB::table('iso_sec_2_1')->where('project_id', $proj_id)
            ->where('s_name', '!=', 'null')
            ->select('s_name')
            ->distinct()
            ->get();


        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();


        return view('action_plan.services', [
            'services' => $services,
            'project' => $project
        ]);
    }



    public function getGroups($service, $proj_id)
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

        if ($groups->count() == 0) {
            return redirect()->route(
                'action_plan_no_groups_for_compliance_map',
                [
                    'proj_id' => $project->project_id,
                    'service' => $service,

                ]
            );
        }


        return view('action_plan.groups', [
            'project' => $project,
            'service' => $service,
            'groups' => $groups
        ]);
    }

    public function no_groups_for_compliance_map($proj_id, $service)
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

            return view('action_plan.components', [
                'project' => $project,
                'service' => $service,
                'group' => null,
                'subgroup' => null,
                'components' => $components,

            ]);
        }

        return view('action_plan.from_service_to_subgroup', [
            'project' => $project,
            'service' => $service,
            'subgroups' => $subgroups,

        ]);
    }

    public function getSubgroups($service, $group, $proj_id)
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

            return view('action_plan.components', [
                'project' => $project,
                'service' => $service,
                'group' => $group,
                'subgroup' => null,
                'components' => $components,

            ]);
        }


        return view('action_plan.subgroups', [
            'project' => $project,
            'group' => $group,
            'service' => $service,
            'subgroups' => $subgroups,

        ]);
    }

    public function service_subgroups_to_components($service, $subgroup, $proj_id)
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


        return view('action_plan.components', [
            'project' => $project,
            'service' => $service,
            'group' => null,
            'subgroup' => $subgroup,
            'components' => $components
        ]);
    }


    public function getComponents($service, $group, $subgroup, $proj_id)
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



        return view('action_plan.components', [
            'project' => $project,
            'group' => $group,
            'service' => $service,
            'subgroup' => $subgroup,
            'components' => $components,

        ]);
    }


    public function action_plan_show($service, $component, $proj_id, Request $req)
{
    $group = $req->query('group');
    $subgroup = $req->query('subgroup');
    $action_plan_type = Session('action_plan_type');

    // Get project (with project_type)
    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)
        ->first();

    // Get relevant assets
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
        ->pluck('assessment_id')
        ->toArray();

    $mandatory_action_plan = null;
    $treatment_action_plan = null;
    $filepath = '';

    // ---------------------------
    // Mandatory / Compliance plan
    // ---------------------------
    if ($action_plan_type == 'Mandatory' || $action_plan_type == 'Both') {

        $mandatory_action_plan = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
            ->where('assets.project_id', $proj_id)
            ->where('compliance.project_id', $proj_id)
            ->whereIn('compliance.asset_id', $assetIds)
            ->select(
                'compliance.*',  // includes title_num, subdomain, sub_req, comp_status, etc.
                'assets.*',
                'users.first_name',
                'users.last_name'
            )
            ->paginate(10, ['*'], 'mandatory_page');

       
        $fileMap = [
            7  => 'KSA_NCA_ECC.xlsx',
            18 => 'COSO.xlsx',
            19 => 'SOC2_Type2.xlsx',
            5  => 'CY_SAMA.xlsx',
            1  => 'PCI_DSS_4_Single_TSP.xlsx',
            16 => 'COBIT_2019.xlsx',
            2  => 'PCI_DSS_4_Multi_TSP.xlsx',
            3  => 'PCI_DSS_4_Merchant_TSP.xlsx',
            10 => 'ISA_62443_Part 3-2.xlsx',
            12 => 'ISA 62443 Part 4-2.xlsx',
            13 => 'ISA 62443 Part 3-3.xlsx',
            11 => 'ISA 62443 Part 2-1.xlsx',
            9  => 'ISA 62443 Part 4-1.xlsx',
            4  => 'KM_ISO27K1_2022_Compliance_18Jul25.xlsx',
            23 => 'NIST_CSF.xlsx',
            24 => 'ISO27701_2019v2.xlsx',
            6  => 'SBP_ETGRMF.xlsx',
            25 => 'DigitalBankingSecurity.xlsx',
            26 => 'SBP_Payment_Card_Security_Standard.xlsx',
            29 => 'ISO_22301.xlsx',
            30 => 'ISO_27701_2025.xlsx'
        ];

        $rows = [];

           
            $filepath = $fileMap[$project->project_type];

                $data = Excel::toArray([], $filepath);  
                $rows = array_slice($data[0], 1);      
            


    
        // Attach Domain / Subdomain / Control from Excel to each row
        if (!empty($rows)) {
            $mandatory_action_plan->getCollection()->transform(function ($item) use ($rows) {

                $domain    = strval($item->title_num);
                $subdomain = strval($item->subdomain);
                $subreq    = strval($item->sub_req);

                // Filter Excel based on your preferred style
                $match = collect($rows)->first(function ($row) use ($domain, $subdomain, $subreq) {
                 
                    return strval($row[0]) === $domain
                        && strval($row[2]) === $subdomain
                        && strval($row[4]) === $subreq;
                });
              
                if ($match) {
                    $item->domain_no      = $match[0];
                    $item->domain_name    = $match[1];
                    $item->subdomain_no   = $match[2];
                    $item->subdomain_name = $match[3];
                    $item->sub_req_no     = $match[4];
                    $item->control_full   = $match[5];
                }

                return $item;
            });
        }
    }

    // ---------------------------
    // Risk Treatment plan
    // ---------------------------
    if ($action_plan_type == 'Treatment' || $action_plan_type == 'Both') {
        $treatment_action_plan = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_risk_treatment AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
            ->where('assets.project_id', $proj_id)
            ->whereIn('compliance.asset_id', $assetIds)
            ->paginate(10, ['*'], 'treatment_page');
        // add where compliance.project_id == $proj_id if needed later
    }

    // Re-fetch project (if you really need it again)
    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)
        ->first();

    return view('action_plan.show_action_plan', [
        'project'               => $project,
        'treatment_action_plan' => $treatment_action_plan,
        'mandatory_action_plan' => $mandatory_action_plan,
        'service'               => $service,
        'group'                 => $group,
        'subgroup'              => $subgroup,
        'component'             => $component,
        'action_plan_type'      => $action_plan_type,
        'filepath'              => $filepath, // just filename, if you want to show it / debug
    ]);
}


    public function all_projects_action_plan($action_plan_type, $org_id)
    {
        $projects = DB::table("projects")->where('org_id', $org_id)
            ->pluck('project_id')->toArray();


        $assetIds = DB::table('iso_sec_2_1')
            ->wherein('project_id', $projects)
            ->pluck('assessment_id')->toArray();

        $mandatory_action_plan = null;
        $treatment_action_plan = null;

        if ($action_plan_type == 'Mandatory' || $action_plan_type == 'Both') {
            //iso_sec_2_2
            $mandatory_action_plan = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
                ->whereIn('compliance.asset_id', $assetIds)
                ->paginate(10, ['*'], 'mandatory_page');
        }

        if ($action_plan_type == 'Treatment' || $action_plan_type == 'Both') {
            $treatment_action_plan = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_risk_treatment AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
                ->whereIn('compliance.asset_id', $assetIds)
                ->paginate(10, ['*'], 'treatment_page');
        }



        return view('action_plan.all_projects_show_action_plan', [
            'treatment_action_plan' => $treatment_action_plan,
            'mandatory_action_plan' => $mandatory_action_plan,
            'action_plan_type' => $action_plan_type

        ]);
    }

    // public function action_plan_download($proj_id, $service, $component, Request $req)
    // {

    //     $group = $req->query('group');
    //     $subgroup = $req->query('subgroup');

    //     $action_plan_type = Session('action_plan_type');


    //     $assetIds = DB::table('iso_sec_2_1')
    //         ->where('project_id', $proj_id)
    //         ->when($service != '_all', function ($query) use ($service) {
    //             return $query->where('s_name', $service);
    //         })
    //         ->when($group, function ($query, $group) {
    //             return $query->when($group != '_all', function ($query) use ($group) {
    //                 return $query->where('g_name', $group);
    //             });
    //         })
    //         ->when($subgroup, function ($query, $subgroup) {
    //             return $query->when($subgroup != '_all', function ($query) use ($subgroup) {
    //                 return $query->where('name', $subgroup);
    //             });
    //         })
    //         ->when($component != '_all', function ($query) use ($component) {
    //             return $query->where('c_name', $component);
    //         })
    //         ->pluck('assessment_id')->toArray();

    //     $mandatory_action_plan = null;
    //     $treatment_action_plan = null;

    //     if ($action_plan_type == 'Mandatory' || $action_plan_type == 'Both') {
    //         //iso_sec_2_2
    //         $mandatory_action_plan = DB::table('iso_sec_2_1 AS assets')
    //             ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
    //             ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
    //             ->where('compliance.project_id', $proj_id)
    //             ->where('assets.project_id', $proj_id)
    //             ->whereIn('compliance.asset_id', $assetIds)
    //             ->get();
    //     }

    //     if ($action_plan_type == 'Treatment' || $action_plan_type == 'Both') {
    //         $treatment_action_plan = DB::table('iso_sec_2_1 AS assets')
    //             ->join('iso_risk_treatment AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
    //             ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
    //             ->where('assets.project_id', $proj_id)
    //             ->whereIn('compliance.asset_id', $assetIds)
    //             ->get();
    //     }


    //     $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
    //         ->where('projects.project_id', $proj_id)->first();
    //     $projectName = $project->project_name;




    //     if ($action_plan_type == 'Mandatory') {
    //         return Excel::download(
    //             new MandatoryActionPlan($mandatory_action_plan),
    //             $projectName . '_mandatoryActionPlan.xlsx'
    //         );
    //     }

    //     if ($action_plan_type == 'Treatment') {
    //         return Excel::download(
    //             new TreatmentActionPlan($treatment_action_plan),
    //             $projectName . '_treatmentActionPlan.xlsx'
    //         );
    //     }

    //     if ($action_plan_type == 'Both') {
    //         return Excel::download(
    //             new BothActionPlan($mandatory_action_plan, $treatment_action_plan),
    //             $projectName . '_ActionPlan.xlsx'
    //         );
    //     }
    // }

    public function action_plan_download($proj_id, $service, $component, Request $req)
{
    $group = $req->query('group');
    $subgroup = $req->query('subgroup');

    $action_plan_type = Session('action_plan_type');

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
        ->pluck('assessment_id')
        ->toArray();

    $mandatory_action_plan = null;
    $treatment_action_plan = null;

    // These will be used to read column names + mapping from the framework Excel
    $frameworkHeader = null;   // first row (column names)
    $frameworkRows   = [];     // remaining rows (data)

    // Get project (to know project_type)
    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
        ->where('projects.project_id', $proj_id)
        ->first();
    $projectName = $project->project_name;

    if ($action_plan_type == 'Mandatory' || $action_plan_type == 'Both') {
        // iso_sec_2_2
        $mandatory_action_plan = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
            ->where('compliance.project_id', $proj_id)
            ->where('assets.project_id', $proj_id)
            ->whereIn('compliance.asset_id', $assetIds)
            ->select(
                'compliance.*',   // includes title_num, subdomain, sub_req, comp_status, attachment, etc.
                'assets.*',
                'users.first_name',
                'users.last_name'
            )
            ->get();

        // map project_type -> framework Excel file
        $fileMap = [
            7  => 'KSA_NCA_ECC.xlsx',
            18 => 'COSO.xlsx',
            19 => 'SOC2_Type2.xlsx',
            5  => 'CY_SAMA.xlsx',
            1  => 'PCI_DSS_4_Single_TSP.xlsx',
            16 => 'COBIT_2019.xlsx',
            2  => 'PCI_DSS_4_Multi_TSP.xlsx',
            3  => 'PCI_DSS_4_Merchant_TSP.xlsx',
            10 => 'ISA_62443_Part 3-2.xlsx',
            12 => 'ISA 62443 Part 4-2.xlsx',
            13 => 'ISA 62443 Part 3-3.xlsx',
            11 => 'ISA 62443 Part 2-1.xlsx',
            9  => 'ISA 62443 Part 4-1.xlsx',
            4  => 'KM_ISO27K1_2022_Compliance_18Jul25.xlsx',
            23 => 'NIST_CSF.xlsx',
            24 => 'ISO27701_2019v2.xlsx',
            6  => 'SBP_ETGRMF.xlsx',
            25 => 'DigitalBankingSecurity.xlsx',
            26 => 'SBP_Payment_Card_Security_Standard.xlsx',
            29 => 'ISO_22301.xlsx',
            30 => 'ISO_27701_2025.xlsx',
        ];


            $fullPath = $fileMap[$project->project_type];

                // with header
                $data = Excel::toArray([], $fullPath);
                // $data[0][0] = header row; $data[0][1..] = data rows
                if (!empty($data[0])) {
                    $frameworkHeader = $data[0][0];         // first row = column names
                    $frameworkRows   = array_slice($data[0], 1); // data without header
                }
            
        
    }

    if ($action_plan_type == 'Treatment' || $action_plan_type == 'Both') {
        $treatment_action_plan = DB::table('iso_sec_2_1 AS assets')
            ->join('iso_risk_treatment AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
            ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
            ->where('assets.project_id', $proj_id)
            ->whereIn('compliance.asset_id', $assetIds)
            ->get();
    }

    // Now use export classes

    if ($action_plan_type == 'Mandatory') {
        return Excel::download(
            new MandatoryActionPlan($mandatory_action_plan, $frameworkRows, $frameworkHeader),
            $projectName . '_mandatoryActionPlan.xlsx'
        );
    }

    if ($action_plan_type == 'Treatment') {
        return Excel::download(
            new TreatmentActionPlan($treatment_action_plan),
            $projectName . '_treatmentActionPlan.xlsx'
        );
    }

    if ($action_plan_type == 'Both') {
        //only mandatory ready yet
          return Excel::download(
            new MandatoryActionPlan($mandatory_action_plan, $frameworkRows, $frameworkHeader),
            $projectName . '_mandatoryActionPlan.xlsx'
        );
    }
}


    public function all_projects_action_plan_download($action_plan_type, $org_id)
    {
        $projects = DB::table("projects")->where('org_id', $org_id)
            ->pluck('project_id')->toArray();

        $assetIds = DB::table('iso_sec_2_1')
            ->wherein('project_id', $projects)
            ->pluck('assessment_id')->toArray();

        if ($action_plan_type == 'Mandatory' || $action_plan_type == 'Both') {
            //iso_sec_2_2
            $mandatory_action_plan = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_sec_2_2 AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
                ->whereIn('compliance.asset_id', $assetIds)
                ->get();
        }

        if ($action_plan_type == 'Treatment' || $action_plan_type == 'Both') {
            $treatment_action_plan = DB::table('iso_sec_2_1 AS assets')
                ->join('iso_risk_treatment AS compliance', 'assets.assessment_id', '=', 'compliance.asset_id')
                ->leftJoin('users', 'compliance.responsibility_for_treatment', 'users.id')
                ->whereIn('compliance.asset_id', $assetIds)
                ->get();
        }



        if ($action_plan_type == 'Mandatory') {
            return Excel::download(
                new MandatoryActionPlan($mandatory_action_plan),
                'AllProjects_mandatoryActionPlan.xlsx'
            );
        }

        if ($action_plan_type == 'Treatment') {
            return Excel::download(
                new TreatmentActionPlan($treatment_action_plan),
                'AllProjects_treatmentActionPlan.xlsx'
            );
        }

        if ($action_plan_type == 'Both') {
            return Excel::download(
                new BothActionPlan($mandatory_action_plan, $treatment_action_plan),
                'AllProjects_ActionPlan.xlsx'
            );
        }
    }
}
