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

    public function compliance_map_dashboard_all_services($proj_id,$user_id){
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


                return view('compliance_map.dashboard', [
                    'project' => $project,
                    'uniqueServicesCount' => $uniqueServicesCount,
                    'uniqueGroupsCount'=>$uniqueGroupsCount,
                    'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                    'uniqueComponentsCount'=>$uniqueComponentsCount,
                    'formattedResults' => $formattedResults,
                ]);


            

        }

    }
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

                //KSA
                if ($project->project_type == 7) {
                    
                return view('compliance_map.ksa_nca_all_services_all_controls', [
                    'project' => $project,
                    'uniqueServicesCount' => $uniqueServicesCount,
                    'uniqueGroupsCount'=>$uniqueGroupsCount,
                    'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                    'uniqueComponentsCount'=>$uniqueComponentsCount,
                    'formattedResults' => $formattedResults,
                ]);

                }

        

                //PCI SIngle
                if ($project->project_type == 1) {
                    
                    return view('compliance_map.pci_single_all_services_all_controls', [
                        'project' => $project,
                        'uniqueServicesCount' => $uniqueServicesCount,
                        'uniqueGroupsCount'=>$uniqueGroupsCount,
                        'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                        'uniqueComponentsCount'=>$uniqueComponentsCount,
                        'formattedResults' => $formattedResults,
                    ]);
    
                    }

                      //PCI Multi
                if ($project->project_type == 2) {
                    
                    return view('compliance_map.pci_multi_all_services_all_controls', [
                        'project' => $project,
                        'uniqueServicesCount' => $uniqueServicesCount,
                        'uniqueGroupsCount'=>$uniqueGroupsCount,
                        'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                        'uniqueComponentsCount'=>$uniqueComponentsCount,
                        'formattedResults' => $formattedResults,
                    ]);
    
                    }

                         //PCI Merchant
                if ($project->project_type == 3) {
                    
                    return view('compliance_map.pci_merchant_all_services_all_controls', [
                        'project' => $project,
                        'uniqueServicesCount' => $uniqueServicesCount,
                        'uniqueGroupsCount'=>$uniqueGroupsCount,
                        'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                        'uniqueComponentsCount'=>$uniqueComponentsCount,
                        'formattedResults' => $formattedResults,
                    ]);
    
                    }

                     //CY SAMA
                     if ($project->project_type == 5) {
                    
                        return view('compliance_map.cy_sama_all_services_all_controls', [
                            'project' => $project,
                            'uniqueServicesCount' => $uniqueServicesCount,
                            'uniqueGroupsCount'=>$uniqueGroupsCount,
                            'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                            'uniqueComponentsCount'=>$uniqueComponentsCount,
                            'formattedResults' => $formattedResults,
                        ]);
        
                        }

                         //SBP ETGRMF
                     if ($project->project_type == 6) {
                    
                        return view('compliance_map.sbp_etgrmf_all_services_all_controls', [
                            'project' => $project,
                            'uniqueServicesCount' => $uniqueServicesCount,
                            'uniqueGroupsCount'=>$uniqueGroupsCount,
                            'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                            'uniqueComponentsCount'=>$uniqueComponentsCount,
                            'formattedResults' => $formattedResults,
                        ]);
        
                        }

                          //UAE IA
                if ($project->project_type == 8) {


                    
                    return view('compliance_map.uae_ia_all_services_all_controls', [
                        'project' => $project,
                        'uniqueServicesCount' => $uniqueServicesCount,
                        'uniqueGroupsCount'=>$uniqueGroupsCount,
                        'uniqueSubGroupsCount'=>$uniqueSubGroupsCount,
                        'uniqueComponentsCount'=>$uniqueComponentsCount,
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
        } 

        if($project->project_type==1){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==2){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==3){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

    
        if($project->project_type==5){
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
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            }

            if($project->project_type==2){
                $domainNames = [
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            
            }

            if($project->project_type==3){
                $domainNames = [
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            
            }

            if($project->project_type==5){
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

            if($project->project_type==8){
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

        
            if($project->project_type==8){
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
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if($project->project_type==2){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==3){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==5){
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

        if ($project->project_type == 1) {
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if($project->project_type==2){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==5){
            $domainNames = [
                '3.1' => 'Cybersecurity Leadership and Governance',
                '3.2' => 'Cybersecurity Risk Management and Compliance',
                '3.3' => 'Cybersecurity Operations and Technology',
                '3.4' => 'Third-Party Cybersecurity',

            ];
        
        }

        
        if($project->project_type==8){
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

        if($project->project_type==3){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
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

            
            if($project->project_type==8){
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
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        }

        if($project->project_type==2){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==3){
            $domainNames = [
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];
        
        }

        if($project->project_type==5){
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


        }

        if($project->project_type==1){

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
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            
        }

        if($project->project_type==2){

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
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            
        }

        
        if($project->project_type==3){

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
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
            
        }

        if($project->project_type==5){
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
        if($project->project_type==6){
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

        
        if($project->project_type==8){

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

    public function compliance_map_sub_req($subdomain,$service,$component,$proj_id,Request $req){
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


        $MainDomainNum=$filteredData[0][0];
        $MainDomainTitle=$filteredData[0][2] ;//title
    
        $subdomainTitle=$filteredData[0][4];


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
                1=>'Install and Maintain Network Security Controls',
                2=>'Apply Secure Configurations to All System Components',
                3=>'Protect Stored Account Data',
                4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5=>'Protect All Systems and Networks from Malicious Software',
                6=>'Develop and Maintain Secure Systems and Software',
                7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8=>'Identify Users and Authenticate Access to System Components',
                9=>'Restrict Physical Access to Cardholder Data',
                10=>'Log and Monitor All Access to System Components and Cardholder Data',
                11=>'Test Security of Systems and Networks Regularly',
                12=>'Support Information Security with Organizational Policies and Programs',
                'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
            ];

            $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)
    
            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[1]) == $subdomain;
            })->values()->all();
    
    
    
            $MainDomainNum=$filteredData[0][0];
            $MainDomainTitle=$domainNames[$filteredData[0][0]] ;// we dont have in excel
        
            $subdomainTitle=$filteredData[0][2];
    
    
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
                    1=>'Install and Maintain Network Security Controls',
                    2=>'Apply Secure Configurations to All System Components',
                    3=>'Protect Stored Account Data',
                    4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                    5=>'Protect All Systems and Networks from Malicious Software',
                    6=>'Develop and Maintain Secure Systems and Software',
                    7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                    8=>'Identify Users and Authenticate Access to System Components',
                    9=>'Restrict Physical Access to Cardholder Data',
                    10=>'Log and Monitor All Access to System Components and Cardholder Data',
                    11=>'Test Security of Systems and Networks Regularly',
                    12=>'Support Information Security with Organizational Policies and Programs',
                    'A1'=>'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                    'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ];
    
                $filepath = public_path('PCI_DSS_4_Multi_TSP.xlsx');
                $data = Excel::toArray([], $filepath); //with header
                $rows = array_slice($data[0], 1); //without header(first row)
        
                $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                    return strval($row[1]) == $subdomain;
                })->values()->all();
        
        
        
                $MainDomainNum=$filteredData[0][0];
                $MainDomainTitle=$domainNames[$filteredData[0][0]] ;// we dont have in excel
            
                $subdomainTitle=$filteredData[0][2];
        
        
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
                        1=>'Install and Maintain Network Security Controls',
                        2=>'Apply Secure Configurations to All System Components',
                        3=>'Protect Stored Account Data',
                        4=>'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                        5=>'Protect All Systems and Networks from Malicious Software',
                        6=>'Develop and Maintain Secure Systems and Software',
                        7=>'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                        8=>'Identify Users and Authenticate Access to System Components',
                        9=>'Restrict Physical Access to Cardholder Data',
                        10=>'Log and Monitor All Access to System Components and Cardholder Data',
                        11=>'Test Security of Systems and Networks Regularly',
                        12=>'Support Information Security with Organizational Policies and Programs',
                        'A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                    ];
        
                    $filepath = public_path('PCI_DSS_4_Merchant.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)
            
                    $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                        return strval($row[1]) == $subdomain;
                    })->values()->all();
            
            
            
                    $MainDomainNum=$filteredData[0][0];
                    $MainDomainTitle=$domainNames[$filteredData[0][0]] ;// we dont have in excel
                
                    $subdomainTitle=$filteredData[0][2];
            
            
                    $UniqueSubReqs = collect($filteredData)
                        ->mapWithKeys(function ($row) {
                            return [$row[3] => $row[4]]; 
                        })
                        ->unique() // Ensure unique keys (1st index)
                        ->toArray(); // Convert to array
                
                    }

        if($project->project_type==5){

            $filepath = public_path('CY_SAMA.xlsx');
        $data = Excel::toArray([], $filepath); //with header
        $rows = array_slice($data[0], 1); //without header(first row)

        $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
            return strval($row[2]) == $subdomain;
        })->values()->all();


        $MainDomainNum=$filteredData[0][0];
        $MainDomainTitle=$filteredData[0][1] ;//title
    
        $subdomainTitle=$filteredData[0][3];


        $UniqueSubReqs = collect($filteredData)
            ->mapWithKeys(function ($row) {
                return [$row[4] => $row[5]]; 
            })
            ->unique() // Ensure unique keys (1st index)
            ->toArray(); // Convert to array
    

        }

        if($project->project_type==6){

            $filepath = public_path('SBP_ETGRMF.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)
    
            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();
    
    
    
            $MainDomainNum=$filteredData[0][0];
            $MainDomainTitle=$filteredData[0][1];// we dont have in excel
        
            $subdomainTitle=$filteredData[0][3];
    
    
            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [(string)$row[4] =>(string) $row[5]]; 
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

        if($project->project_type==8){
            $filepath = public_path('UAE_IA.xlsx');
            $data = Excel::toArray([], $filepath); //with header
            $rows = array_slice($data[0], 1); //without header(first row)
    
            $filteredData = collect($rows)->filter(function ($row) use ($subdomain) {
                return strval($row[2]) == $subdomain;
            })->values()->all();
    
    
            $MainDomainNum=$filteredData[0][0];
            $MainDomainTitle=$filteredData[0][1] ;//title
        
            $subdomainTitle=$filteredData[0][3];
    
    
            $UniqueSubReqs = collect($filteredData)
                ->mapWithKeys(function ($row) {
                    return [$row[4] => $row[6]]; 
                })
                ->unique() // Ensure unique keys (1st index)
                ->toArray(); // Convert to array
        
        }
        return view('compliance_map.subreq_map', [
            'project' => $project,
            'formattedResults' => $formattedResults,
            'results'=>$results,
            'UniqueSubReqs' => $UniqueSubReqs,
            'MainDomainTitle' => $MainDomainTitle,
            'MainDomainNum'=>$MainDomainNum,
            'service'=>$service,
            'component'=>$component,
            'group'=>$group,
            'subgroup'=>$subgroup,
            'subdomainTitle'=>$subdomainTitle,
            'subdomainNum'=>$subdomain
        ]);



    


    }

    public function download_excel_compliance_map_subreq($proj_id,$user_id,Request $req){
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
    
 

}

