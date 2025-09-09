<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Support\RiskScheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use Illuminate\Support\Facades\File;

class RiskTreatmentController extends Controller
{
    public function asset_based_risk_treatment($asset_id, $proj_id, $user_id)
    {

        //route for risk assesment quality asset based with controls
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

            $asset = DB::table('iso_sec_2_1')
                ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                ->select(
                    'iso_sec_2_1.*',
                    DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                    DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                    DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                    DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                    DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                    DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                )
                ->where('iso_sec_2_1.assessment_id', $asset_id)
                ->first();


            $frameworkDetails = $this->getProjectFrameworkDetails($project);

            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && ($frameworkDetails['framework_approach']->framework_approach_types_id == 1 || $frameworkDetails['framework_approach']->framework_approach_types_id == 2)
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {
                //ISo 27005:2022 Qualitative Asset based
                $filename = 'ISO27K1_2022_' . $asset->g_name . '.xlsx';
                $filepath = public_path($filename);

                // Fallback to 'None' file if original doesn't exist
                if (!File::exists($filepath)) {
                    $filename = 'ISO27K1_2022_None.xlsx';
                    $filepath = public_path($filename);
                }

                $data2 = Excel::toArray([], $filepath); // Load Excel with header
                $rows = array_slice($data2[0], 1); // Remove header row

                foreach ($rows as &$row) {
                    if (isset($row[0])) {
                        $row[0] = trim((string) $row[0]); // keep it as-is
                    }
                }
                //dd($rows[0][0]);

                $check = DB::Table('iso27005_risk_assessment')
                    ->where('project_id', $project->project_id)
                    ->where('asset_id', $asset->assessment_id)
                    ->get();

                if ($check->count() == 0) {
                    return redirect()->back()->with('error', 'No Risk Assessment done yet for this asset');
                }


                $savedDataRawRiskAssessment = DB::Table('iso27005_risk_assessment')
                    ->where('project_id', $project->project_id)
                    ->where('asset_id', $asset->assessment_id)
                    ->pluck('vulnerability_due_to', 'control_num');


                $savedDataRiskAssessment = [];
                foreach ($savedDataRawRiskAssessment as $key => $value) {
                    $normalizedKey = trim((string) $key); // only trim, no number_format
                    $savedDataRiskAssessment[$normalizedKey] = $value;
                }

                $savedDataRawRiskTreatment = DB::Table('iso27005_risk_assessment')
                    ->where('project_id', $project->project_id)
                    ->where('asset_id', $asset->assessment_id)
                    ->pluck('risk_treatment_vulnerability_due_to', 'control_num');


                $savedDataRiskTreatment = [];
                foreach ($savedDataRawRiskTreatment as $key => $value) {
                    $normalizedKey = trim((string) $key); // only trim, no number_format
                    $savedDataRiskTreatment[$normalizedKey] = $value;
                }



                return view("risk_treatment.vulnerability", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'controls' => $rows,
                    'savedDataRiskTreatment' => $savedDataRiskTreatment,
                    'savedDataRiskAssessment' => $savedDataRiskAssessment



                ]);
            }


            return redirect()->route('iso_sec_2_3_1', [
                'asset_id' => $asset_id,
                'proj_id' => $proj_id,
                'user_id' => $user_id
            ]);
        }
    }

    public function iso_27005_risk_treatment_vulnerability($proj_id, $user_id, $asset_id, Request $req)
    {
        foreach ($req->control_num as $key => $value) {
            DB::table('iso27005_risk_assessment')->updateOrInsert(
                [
                    'project_id' => $proj_id,
                    'asset_id' => $asset_id,
                    'control_num' => $value,
                ],
                [
                    'risk_treatment_vulnerability_due_to' => $req->risk_treatment_vulnerability_due_to[$key],
                    'last_edited_by' => $user_id,
                    'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );
        }

        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $proj_id)->first();

        $frameworkDetails = $this->getProjectFrameworkDetails($project);

        if (
            $frameworkDetails['complianceFramework']->framework_selected == 2
            && ($frameworkDetails['framework_approach']->framework_approach_types_id == 1 || $frameworkDetails['framework_approach']->framework_approach_types_id == 2)
            && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
        ) {
            return redirect()->route('asset_based_risk_treatment', [
                'asset_id' => $asset_id,
                'proj_id' => $proj_id,
                'user_id' => $user_id

            ])->with('success', 'Data Saved Successfully');
        }
    }


    public function iso_27005_likelihood_value_risk_treatment($proj_id, $user_id, $asset_id, $risk_type = '')
    {


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

            $asset =  DB::table('iso_sec_2_1')
                ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                ->select(
                    'iso_sec_2_1.*',
                    DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                    DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                    DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                    DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                    DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                    DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                )
                ->where('iso_sec_2_1.assessment_id', $asset_id)
                ->first();

            $frameworkDetails = $this->getProjectFrameworkDetails($project);


            $likelihood_timeframe = DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                ->value('risk_treatment_timeframe_' . $risk_type);
           



            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && $frameworkDetails['framework_approach']->framework_approach_types_id == 1
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {

                $risk_assessment_likelihood_value = DB::table('proj_asset_likelihood_value')
                    ->where('project_id', $proj_id)
                    ->where('asset_id', $asset_id)
                    ->value('qualitative_likelihood_' . $risk_type . '_selected');

                

                 $risk_treatment_likelihood_value = DB::table('proj_asset_likelihood_value')
                    ->where('project_id', $proj_id)
                    ->where('asset_id', $asset_id)
                    ->value('risk_treatment_likelihood_' . $risk_type);
                  

                return view("risk_treatment.likelihood_value", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'likelihood_timeframe' => $likelihood_timeframe,
                    'risk_treatment_likelihood_value' => $risk_treatment_likelihood_value,
                    'risk_assessment_likelihood_value'=>$risk_assessment_likelihood_value,
                    'risk_type' => $risk_type
                ]);
            }

            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && $frameworkDetails['framework_approach']->framework_approach_types_id == 2
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {

                
                //Quantitative Asset based
                $risk_assessment_likelihood_value = DB::table('proj_asset_likelihood_value')
                    ->where('project_id', $proj_id)
                    ->where('asset_id', $asset_id)
                    ->value('quantitative_likelihood_' . $risk_type . '_selected');

                

                 $risk_treatment_likelihood_value = DB::table('proj_asset_likelihood_value')
                    ->where('project_id', $proj_id)
                    ->where('asset_id', $asset_id)
                    ->value('risk_treatment_likelihood_' . $risk_type);
                  
                    
           

                return view("risk_treatment.quantitative_likelihood_value", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'likelihood_timeframe' => $likelihood_timeframe,
                    'risk_treatment_likelihood_value' => $risk_treatment_likelihood_value,
                    'risk_assessment_likelihood_value'=>$risk_assessment_likelihood_value,
                    'risk_type' => $risk_type
                ]);
            }
        }
    }


     public function qualitative_asset_likelihood_confidentiality_timeframe_risk_treatment($proj_id, $user_id, $asset_id, Request $req)
    {
        $req->validate([
            'timeframe' => 'required'
        ]);

        DB::table('proj_asset_likelihood_timeframe')->updateOrInsert(
            [
                'project_id' => $proj_id,
                'asset_id' => $asset_id
            ],
            [
                'risk_treatment_timeframe_' . $req->risk_type_input => $req->timeframe,
                'last_edited_by' => $user_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

            ]
        );




        return redirect()->route('iso_27005_likelihood_value_risk_treatment', [
            'proj_id' => $proj_id,
            'user_id' => $user_id,
            'asset_id' => $asset_id,
            'risk_type' => $req->risk_type_input
        ])->with('success', 'Data Saved Successfully');
    }

      public function save_likelihood_value_risk_treatment($proj_id, $user_id, $asset_id, Request $req)
    {
        $req->validate([
            'likelihood_value' => 'required'
        ]);


        DB::table('proj_asset_likelihood_value')->updateOrInsert([
            'project_id' => $proj_id,
            'asset_id' => $asset_id
        ], [
            'risk_treatment_likelihood_' . $req->risk_type_input => $req->likelihood_value,
            'last_edited_by' => $user_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        if ($req->action == 'save_next') {

            return redirect()->route('likelihood_and_consequence_risk_treatment', [
                'risk_type' => $req->risk_type_input,
                'proj_id'   => $proj_id,
                'user_id'   => $user_id,
                'asset_id'  => $asset_id
            ])->with('success', 'Data Saved Successfully');
        }


        return redirect()->route('iso_27005_likelihood_value_risk_treatment', [
            'proj_id' => $proj_id,
            'user_id' => $user_id,
            'asset_id' => $asset_id,
            'risk_type' => $req->risk_type_input
        ])->with('success', 'Data Saved Successfully');
    }


      public function likelihood_and_consequence_risk_treatment($risk_type, $proj_id, $user_id, $asset_id)
    {
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

            $asset =  DB::table('iso_sec_2_1')
                ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                ->select(
                    'iso_sec_2_1.*',
                    DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                    DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                    DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                    DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                    DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                    DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                )
                ->where('iso_sec_2_1.assessment_id', $asset_id)
                ->first();


            $frameworkDetails = $this->getProjectFrameworkDetails($project);



            $consequence_value = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value($risk_type);




            $likelihood_timeframe = DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                ->value('risk_treatment_timeframe_' . $risk_type);

            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && $frameworkDetails['framework_approach']->framework_approach_types_id == 1
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {
                //QUalitative asset based
                $likelihood_value = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)
                    ->value('risk_treatment_likelihood_' . $risk_type);


                return view("risk_treatment.likelihood_and_consequence_value_risk_treatment", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'consequence_value' => $consequence_value,
                    'likelihood_value' => $likelihood_value,
                    'risk_type' => $risk_type,
                    'likelihood_timeframe' => $likelihood_timeframe
                ]);
            }

            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && $frameworkDetails['framework_approach']->framework_approach_types_id == 2
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {
                //Quantitative Asset based
               $likelihood_value = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)
                    ->value('risk_treatment_likelihood_' . $risk_type);
                    
            
                return view("risk_treatment.quantitative_likelihood_and_consequence_value_risk_treatment", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'consequence_value' => $consequence_value,
                    'likelihood_value' => $likelihood_value,
                    'risk_type' => $risk_type,
                   
                    'likelihood_timeframe' => $likelihood_timeframe
                ]);
            }
        }
    }


       public function iso_27005_likelihood_value_all_risk_treatment($proj_id, $user_id, $asset_id)
    {

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

            $asset =  DB::table('iso_sec_2_1')
                ->join('users as editor', 'iso_sec_2_1.last_edited_by', '=', 'editor.id')
                ->leftJoin('users as service_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_owner.id')
                ->leftJoin('users as component_owner', 'iso_sec_2_1.component_risk_owner', '=', 'component_owner.id')
                ->leftJoin('users as service_custodian', 'iso_sec_2_1.service_custodian', '=', 'service_custodian.id')
                ->leftJoin('users as component_custodian', 'iso_sec_2_1.component_custodian', '=', 'component_custodian.id')
                ->leftJoin('users as service_risk_owner', 'iso_sec_2_1.service_risk_owner', '=', 'service_risk_owner.id')
                ->select(
                    'iso_sec_2_1.*',
                    DB::raw("CONCAT(editor.first_name, ' ', editor.last_name) as edited_by_name"),
                    DB::raw("CONCAT(service_owner.first_name, ' ', service_owner.last_name) as service_risk_owner_name"),
                    DB::raw("CONCAT(component_owner.first_name, ' ', component_owner.last_name) as component_risk_owner_name"),
                    DB::raw("CONCAT(service_custodian.first_name, ' ', service_custodian.last_name) as service_custodian_name"),
                    DB::raw("CONCAT(component_custodian.first_name, ' ', component_custodian.last_name) as component_custodian_name"),
                    DB::raw("CONCAT(service_risk_owner.first_name, ' ', service_risk_owner.last_name) as service_risk_owner")
                )
                ->where('iso_sec_2_1.assessment_id', $asset_id)
                ->first();


            $frameworkDetails = $this->getProjectFrameworkDetails($project);

          

            $likelihood_timeframe_confidentialilty = DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                ->value('risk_treatment_timeframe_risk_confidentiality');

            $likelihood_timeframe_integrity = DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                ->value('risk_treatment_timeframe_risk_integrity');

            $likelihood_timeframe_availability = DB::table('proj_asset_likelihood_timeframe')
                ->where('project_id', $proj_id)
                ->where('asset_id', $asset_id)
                ->value('risk_treatment_timeframe_risk_availability');


            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && $frameworkDetails['framework_approach']->framework_approach_types_id == 1
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {
                //QUalitative Asset based

                $consequence_value_confidentiality = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value('risk_confidentiality');


                $consequence_value_integrity = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value('risk_integrity');


                $consequence_value_availability = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value('risk_availability');

                $likelihood_value_confidentiality = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)->value('risk_treatment_likelihood_risk_confidentiality');


                $likelihood_value_integrity = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)->value('risk_treatment_likelihood_risk_integrity');


                $likelihood_value_availability = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)->value('risk_treatment_likelihood_risk_availability');




                return view("risk_treatment.all_likelihood_and_consequence_value_risk_treatment", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'consequence_value_confidentiality' => $consequence_value_confidentiality,
                    'consequence_value_integrity' => $consequence_value_integrity,
                    'consequence_value_availability' => $consequence_value_availability,
                    'likelihood_value_confidentiality' => $likelihood_value_confidentiality,
                    'likelihood_value_integrity' => $likelihood_value_integrity,
                    'likelihood_value_availability' => $likelihood_value_availability,
                   
                    'likelihood_timeframe_confidentialilty' => $likelihood_timeframe_confidentialilty,
                    'likelihood_timeframe_availability' => $likelihood_timeframe_availability,
                    'likelihood_timeframe_integrity' => $likelihood_timeframe_integrity

                ]);
            }

            if (
                $frameworkDetails['complianceFramework']->framework_selected == 2
                && $frameworkDetails['framework_approach']->framework_approach_types_id == 2
                && $frameworkDetails['risk_assessment_approach']->assessment_approach_selected == 2
            ) {
                //Quantitatve Asset based

                $consequence_value_confidentiality = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value('risk_confidentiality');


                $consequence_value_integrity = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value('risk_integrity');


                $consequence_value_availability = DB::table('iso_sec_2_1')->where('assessment_id', $asset_id)->value('risk_availability');

                $likelihood_value_confidentiality = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)->value('risk_treatment_likelihood_risk_confidentiality');


                $likelihood_value_integrity = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)->value('risk_treatment_likelihood_risk_integrity');


                $likelihood_value_availability = DB::table('proj_asset_likelihood_value')->where('asset_id', $asset_id)->value('risk_treatment_likelihood_risk_availability');

                

                return view("risk_treatment.quantitative_all_likelihood_and_consequence_value", [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'asset' => $asset,
                    'complianceFramework' => $frameworkDetails['complianceFramework'],
                    'risk_assessment_approach' => $frameworkDetails['risk_assessment_approach'],
                    'framework_approach' => $frameworkDetails['framework_approach'],
                    'consequence_value_confidentiality' => $consequence_value_confidentiality,
                    'consequence_value_integrity' => $consequence_value_integrity,
                    'consequence_value_availability' => $consequence_value_availability,
                    'likelihood_value_confidentiality' => $likelihood_value_confidentiality,
                    'likelihood_value_integrity' => $likelihood_value_integrity,
                    'likelihood_value_availability' => $likelihood_value_availability,
                    'likelihood_timeframe_confidentialilty' => $likelihood_timeframe_confidentialilty,
                    'likelihood_timeframe_availability' => $likelihood_timeframe_availability,
                    'likelihood_timeframe_integrity' => $likelihood_timeframe_integrity,
                  


                ]);
            }
        }
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
