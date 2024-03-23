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
            ->where('project_details.assigned_enduser', $user_id)->where('project_types.id', 4)->get(
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




    //section 1.1
    // public function v_3_2_sections($proj_id,$user_id){
    //     $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    //     'project_details.project_permissions','projects.project_name')
    //    -> join('projects','project_details.project_code','projects.project_id')
    //     ->join('project_types','projects.project_type','project_types.id')
    //     ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    //     ->first();


    //     if($checkpermission){
    //         $permissions=json_decode($checkpermission->project_permissions);
    //                 if($checkpermission->type_id==2){
    //                     return view('assigned_projects.v_3_2_sections',
    //                     ['project_id'=>$proj_id,'project_name'=>$checkpermission->project_name]);
    //                 }

    //     }else{
    //         return redirect()->route('assigned_projects',['user_id'=>$user_id]);
    //     }

    // }

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
                if ($req->session()->exists('projectid')) {
                    $req->session()->forget('projectid');
                    $req->session()->put('projectid', $proj_id);
                } else {
                    $req->session()->put('projectid', $proj_id);
                }


                return view(
                    'iso.iso_sections',
                    ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name]
                );
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }


    public function metaData($proj_id, $user_id)
    {
        $org_data = Db::table('projects')->join('organizations', 'projects.org_id', 'organizations.org_id')
            ->where('project_id', $proj_id)
            ->first();
        // dd($org_data);

        $endusers = Db::table('project_details')->join('users', 'project_details.assigned_enduser', 'users.id')
            ->where('project_details.project_code', $proj_id)->get(['users.first_name', 'users.last_name', 'project_details.project_permissions', 'project_details.assigned_enduser']);
        return view('assigned_projects.metadata', ['org_data' => $org_data, 'endusers' => $endusers]);
    }

    public function reports($proj_id, $user_id)
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

            return view('assigned_projects.reports_list', ['proj_id' => $proj_id, 'project_name' => $checkpermission->project_name]);
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
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
                'g_name', 'name', 'c_name', 'owner_dept', 'physical_loc',
                'logical_loc', 's_name'
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

    public function risk_assessment_report($proj_id, $user_id)
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

            $report_data = Db::table('iso_sec_2_1')->join('iso_sec_2_3_1','iso_sec_2_1.assessment_id','iso_sec_2_3_1.asset_id')
            ->where('iso_sec_2_1.project_id', $proj_id)->orderBy('control_num','asc')->orderBy('asset_id','asc')
            ->get(
                [
                    'g_name', 'name', 'c_name', 'owner_dept', 'physical_loc',
                    'logical_loc', 's_name','control_num','applicability','asset_value','control_compliance',
                    'vulnerability','threat','risk_level'
                ]
            );


          //  dd($report_data);
            if ($report_data->count() > 0) {

                 $safeProjectName = Str::slug($project->project_name, '_'); // Example: converting "Project Name!" to "Project_Name"

                //Append the project name to the report filename
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

    public function risk_treatment($proj_id,$user_id){

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

            if($checkpermission){
                $projectName=Db::table('projects')->where('project_id', $proj_id)->first('project_name')->project_name;
                $report_data = Db::table('iso_sec_2_1')->join('iso_sec_2_3_1','iso_sec_2_1.assessment_id','iso_sec_2_3_1.asset_id')
                ->where('iso_sec_2_1.project_id', $proj_id)->orderBy('asset_id','asc')->orderBy('control_num','asc')
                ->get(
                    [
                        'g_name', 'name', 'c_name', 'owner_dept', 'physical_loc',
                        'logical_loc', 's_name','control_num','applicability','asset_value','residual_risk_treatment',
                        'treatment_action','treatment_target_date','treatment_comp_date','responsibility_for_treatment'
                    ]
                );

                if ($report_data->count()>0){
                    $safeProjectName = Str::slug($projectName, '_'); // Example: converting "Project Name!" to "Project_Name"

                    //Append the project name to the report filename
                    $filename = 'RiskTreatmentReport_' . $safeProjectName . '.xlsx';

                    $export = new RiskTreatmentReport($proj_id);
                    return Excel::download($export, $filename);



                }else{
                    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

                }



            }else{
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
                    return view(
                        'iso.iso_sec2_4_subsections',
                        ['project_id' => $proj_id, 'project_name' => $checkpermission->project_name]
                    );
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }






    //     public function v_3_2_section1($proj_id,$user_id){
    //         if($user_id==auth()->user()->id){
    //         $checkpermission=Db::table('project_details')->select('project_types.id as type_id','project_details.project_code',
    //         'project_details.project_permissions','projects.project_name','projects.project_id')
    //        -> join('projects','project_details.project_code','projects.project_id')
    //         ->join('project_types','projects.project_type','project_types.id')
    //         ->where('project_code',$proj_id)->where('assigned_enduser',$user_id)
    //         ->first();


    //     if($checkpermission){
    //         $permissions=json_decode($checkpermission->project_permissions);
    //                 if($checkpermission->type_id==2){

    //                     $clientinfo= Db::table('pci-dss v3_2_1 client info')->join('users','pci-dss v3_2_1 client info.last_edited_by','users.id')
    //                        ->where('pci-dss v3_2_1 client info.project_id',$proj_id)->first();

    //                     $assessorComapany=Db::table('pci-dss v3_2_1 assessor company')->join('users','pci-dss v3_2_1 assessor company.last_edited_by','users.id')
    //                     ->where('pci-dss v3_2_1 assessor company.project_id',$proj_id)->first();

    //                     $assessors=Db::table('pci-dss v3_2_1 assessors')
    //                     ->join('users','pci-dss v3_2_1 assessors.last_edited_by','users.id')
    //                     ->where('pci-dss v3_2_1 assessors.project_id',$proj_id)->get();

    //                     $associate_qsas=Db::table('pci-dss v3_2_1 associate_qsa')
    //                     ->join('users','pci-dss v3_2_1 associate_qsa.last_edited_by','users.id')
    //                     ->where('pci-dss v3_2_1 associate_qsa.project_id',$proj_id)->get();

    //                     $qas=Db::table('pci_dss v3_2_1 qa')
    //                     ->join('users','pci_dss v3_2_1 qa.last_edited_by','users.id')
    //                     ->where('pci_dss v3_2_1 qa.project_id',$proj_id)->get();



    //                        return view('assigned_projects.v_3_2_section1',
    //                        ['clientinfo'=>$clientinfo,
    //                        'assessorCompany'=>$assessorComapany,
    //                        'associate_qsas'=>$associate_qsas,
    //                        'assessors'=>$assessors,
    //                        'qas'=>$qas,
    //                        'project_id'=>$checkpermission->project_id,
    //                        'project_name'=>$checkpermission->project_name,
    //                         'project_permissions'=>$checkpermission->project_permissions]);

    //                 }



    //     }else{
    //         return redirect()->route('assigned_projects',['user_id'=>$user_id]);

    //         }

    //     }

    // }

    public function v3_2_s1_clientinfo(Request $req, $proj_id, $user_id)
    {

        $req->validate([
            'company_name' => 'required|max:50',
            'company_address' => 'required|max:100',
            'company_url' => 'required|max:50',
            'company_contact_name' => 'required|max:50',
            'company_number' => 'required|numeric',
            'company_email' => 'required|max:100'
        ]);

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
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {
                        //v3.2 pci
                        $clientinfo = Db::table('pci-dss v3_2_1 client info')->where('project_id', $proj_id)->first();
                        if (!$clientinfo) {
                            Db::table('pci-dss v3_2_1 client info')->insert([
                                'project_id' => $proj_id,
                                'company_name' => $req->company_name,
                                'company_address' => $req->company_address,
                                'company_url' => $req->company_url,
                                'company_contact_name' => $req->company_contact_name,
                                'company_contact_number' => $req->company_number,
                                'company_email' => $req->company_email,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                            ]);
                            return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                                ->with('success', 'Record added successfully');
                        }
                    } else {
                        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                }
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }


    public function edit_3_2_s1_clientinfo($proj_id, $user_id)
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
                $permissions = json_decode($checkpermission->project_permissions);
                if (in_array('Data Inputter', $permissions)) {
                    if ($checkpermission->type_id == 2) {
                        //v3.2 pci
                        $clientinfo = Db::table('pci-dss v3_2_1 client info')->where('project_id', $proj_id)->first();
                        if ($clientinfo) {
                            return view('assigned_projects.edit_3_2_s1_clientinfo', ['clientinfo' => $clientinfo]);
                        } else {
                            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                        }
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }

    public function edit_3_2_s1_clientinfo_form(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'company_name' => 'required|max:50',
            'company_address' => 'required|max:100',
            'company_url' => 'required|max:50',
            'company_contact_name' => 'required|max:50',
            'company_number' => 'required|numeric',
            'company_email' => 'required|max:100'
        ]);

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
                    //v3.2 pci
                    $clientinfo = Db::table('pci-dss v3_2_1 client info')->where('project_id', $proj_id)->update([
                        'company_name' => $req->company_name,
                        'company_address' => $req->company_address,
                        'company_url' => $req->company_url,
                        'company_contact_name' => $req->company_contact_name,
                        'company_contact_number' => $req->company_number,
                        'company_email' => $req->company_email,
                        'last_edited_by' => $user_id,
                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                    ]);

                    return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                        ->with('success', 'Record updated successfully');
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => $user_id]);
        }
    }



    public function v3_2_s1_assessorcompany(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'comp_name' => 'required|max:50',
            'comp_address' => 'required|max:100',
            'comp_website' => 'required|max:50',

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
                        //v3.2 pci
                        Db::table('pci-dss v3_2_1 assessor company')->insert([
                            'project_id' => $proj_id,
                            'comp_name' => $req->comp_name,
                            'comp_address' => $req->comp_address,
                            'comp_website' => $req->comp_website,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),

                        ]);

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record added successfully');
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function edit_v_3_2_s1_assessorcomp($proj_id, $user_id)
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
                        //v3.2 pci
                        $assessor_comp = Db::table('pci-dss v3_2_1 assessor company')->where('project_id', $proj_id)->first();
                        if ($assessor_comp) {
                            return view('assigned_projects.v_3_2_edit_sec1_assessorcomp', ['assessor_company' => $assessor_comp]);
                        } else {
                            return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id]);
                        }
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }

    public function edit_v3_2_assessorcompany_form(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'comp_name' => 'required|max:50',
            'comp_address' => 'required|max:100',
            'comp_website' => 'required|max:50',

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
                        //v3.2 pci
                        $assessor_comp = Db::table('pci-dss v3_2_1 assessor company')->where('project_id', $proj_id)->first();
                        if ($assessor_comp) {
                            Db::table('pci-dss v3_2_1 assessor company')->where('project_id', $proj_id)->update(
                                [
                                    'comp_name' => $req->comp_name,
                                    'comp_address' => $req->comp_address,
                                    'comp_website' => $req->comp_website,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]
                            );

                            return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id]);
                        } else {
                            return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                                ->with('success', 'Record updated successfully');
                        }
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }



    public function v_3_2_s1_assessors(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'assessor_name' => 'required|max:50',
            'assessor_pci_cred' => 'required|max:100',
            'assessor_phone' => 'required|numeric',
            'assessor_email' => 'required|max:100',
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
                        //v3.2 pci
                        Db::table('pci-dss v3_2_1 assessors')->insert([
                            'project_id' => $proj_id,
                            'assessor_name' => $req->assessor_name,
                            'assessor_pci_cred' => $req->assessor_pci_cred,
                            'assessor_phone' => $req->assessor_phone,
                            'assessor_email' => $req->assessor_email,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);


                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id]);
                    } else {
                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id]);
                    }
                } else {
                    return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => $user_id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }



    public function edit_v3_2_s1_assesssor($assessment_id, $user_id, $proj_id)
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
                        //v3_2
                        $assessor = Db::table('pci-dss v3_2_1 assessors')->where('assessment_id', $assessment_id)->first();
                        if ($assessor) {
                            return view('assigned_projects.edit_3_2_s1_assessor', ['assessor' => $assessor]);
                        } else {
                            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
                        }
                    } else {
                        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }



    public function v3_2_s1_edit_assessors_form(Request $req, $assessment_id, $proj_id, $user_id)
    {

        $req->validate([
            'assessor_name' => 'required|max:50',
            'assessor_pci_cred' => 'required|max:100',
            'assessor_phone' => 'required|numeric',
            'assessor_email' => 'required|max:100|email'

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
                        //v3.2 pci
                        $assessor = Db::table('pci-dss v3_2_1 assessors')->where('assessment_id', $assessment_id)->first();
                        if ($assessor) {
                            Db::table('pci-dss v3_2_1 assessors')->where('assessment_id', $assessment_id)->update(
                                [
                                    'assessor_name' => $req->assessor_name,
                                    'assessor_pci_cred' => $req->assessor_pci_cred,
                                    'assessor_phone' => $req->assessor_phone,
                                    'assessor_email' => $req->assessor_email,
                                    'last_edited_by' => $user_id,
                                    'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                ]
                            );

                            return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                                ->with('success', 'Assessor Info completed successfully');
                        } else {
                            return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id]);
                        }
                    }
                } else {
                    return redirect()->route('assigned_projects', ['user_id' => $user_id]);
                }
            } else {
                return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


    public function v3_2_s1_add_new_assessor($proj_id, $user_id)
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
                        return view('assigned_projects.add_new_assessor', ['project_id' => $checkpermission->project_id]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    }



    public function v3_2_s1_delete_assessor(Request $req, $assessment_id, $proj_id, $user_id)
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

                        Db::table('pci-dss v3_2_1 assessors')->where('assessment_id', $assessment_id)->delete();

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record deleted');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function v3_2_s1_associate_qsa(Request $req, $proj_id, $user_id)
    {
        $req->validate([
            'qsa_name' => 'required|max:100'
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

                        Db::table('pci-dss v3_2_1 associate_qsa')->insert([
                            'project_id' => $proj_id,
                            'qsa_name' => $req->qsa_name,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Associate QSA Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_s1_associateqsa_edit($assessment_id, $proj_id, $user_id)
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

                        $ass_qsa = Db::table('pci-dss v3_2_1 associate_qsa')->where('assessment_id', $assessment_id)->first();
                        return view('assigned_projects.v3_2s1_edit_associate_qsa', ['ass_qsa' => $ass_qsa]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function v3_2_editform_associate_qsa(Request $req, $assessment_id, $proj_id, $user_id)
    {

        $req->validate([
            'qsa_name' => 'required'
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

                        Db::table('pci-dss v3_2_1 associate_qsa')->where('assessment_id', $assessment_id)
                            ->update([
                                'qsa_name' => $req->qsa_name,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')

                            ]);

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Associate QSA edited successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function v3_2_s1_newassociate_qsa($proj_id, $user_id)
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
                        return view('assigned_projects.add_new_qsa_assessor', ['project_id' => $checkpermission->project_id]);
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => $user_id]);
    }

    public function v3_2_s1_delete_associate_qsa($assessment_id, $proj_id, $user_id)
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

                        Db::table('pci-dss v3_2_1 associate_qsa')->where('assessment_id', $assessment_id)->delete();

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'Record deleted');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }


    public function v3_2_s1_qa_insert(Request $req, $proj_id, $user_id)
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

                        Db::table('pci_dss v3_2_1 qa')->insert([
                            'project_id' => $proj_id,
                            'reviewer_name' => $req->reviewer_name,
                            'reviewer_email' => $req->reviewer_email,
                            'reviewer_phone' => $req->reviewer_phone,
                            'last_edited_by' => $user_id,
                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        return redirect()->route('v_3_2_section1', ['proj_id' => $proj_id, 'user_id' => $user_id])
                            ->with('success', 'QA Added successfully');
                    }
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
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
