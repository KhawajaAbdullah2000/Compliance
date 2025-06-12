<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;
use PhpParser\Node\Expr\FuncCall;

class RiskManagementFramework extends Controller
{
    public function select_projects_for_framework($org_id){
        $org_projects=DB::table('organization_project_types')
        ->join('project_types','organization_project_types.project_type_id','project_types.id')
        ->where('org_id',$org_id)
        ->select('project_type_id','type','org_id')
        ->get();
      
        return view('risk_management.select_projects',[
            'org_projects'=>$org_projects
        ]);
    }

    public function selected_projects_for_framework($org_id,Request $req){
        $req->validate([
            'risk_management_methodology'=>'required'
         ]);


        $project_types_selected = [];
        foreach ($req->risk_management_methodology as $proj_type) {
            $project_types_selected[] = $proj_type; // append to array
        }

        $projects=DB::table('project_types')->whereIn("id",$project_types_selected)->get();
        $frameworks=DB::table('risk_management_framework')->get();
     
        
        return view("risk_management.select_framework",[
            'projects'=>$projects,
            'frameworks'=>$frameworks
        ]);

    }

    public function selected_project_and_framework($org_id,Request $req){
   
        $req->validate([
            'framework'=>'required'
         ]);


         foreach($req->selected_projects as $proj){
            DB::table('org_projects_framework_selected')
            ->updateOrInsert([
                'org_id'=>$org_id,
                'project_type_id'=>$proj,
            ],
        [
            'framework_selected'=>$req->framework
        ]
    );
         }

    $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

    // $risk_management_framework=DB::table('org_projects_framework_selected')
    // ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
    // 'risk_management_framework.framework_id')
    // ->where('org_id',$org_id)->first();

     $risk_management_framework=Db::table('risk_management_framework')->where('framework_id',$req->framework)->first();


    if($req->framework==1){
        //default vanilla
        return redirect()->route('user_home')->with('success',"Default Vanilla Framework selected successfully");
    }
 
    
$framework_approaches=DB::table('framework_approach_types')->get();




      return view("risk_management.choose_framework_approach",[
        'projects'=>$projects,
        'framework_approaches'=>$framework_approaches,
        'framework_name'=>$risk_management_framework->framework_name

      ]);

    }

    public function selected_framework_approach($org_id,Request $req){
        $req->validate([
            'framework_approach'=>'required'
        ]);


        foreach($req->selected_projects as $proj){
            DB::table('org_framework_approach_selected')
            ->updateOrInsert([
                'project_type_id'=>$proj,
                'org_id'=>auth()->user()->organization->id,
                
            ],
        [
            'framework_approach_types'=>$req->framework_approach,
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
        ]
    );
         }

         $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

         $selected_project_ids = DB::table('project_types')
    ->whereIn("id", $req->selected_projects)
    ->pluck('id') // just get the IDs for filtering
    ->toArray();


         $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();


    

            $framework_approach=Db::table('framework_approach_types')
            ->where('framework_approach_types_id',$req->framework_approach)
            ->first();
         //Qualitative
         if($req->framework_approach==1){
         
            return view('risk_management.consequence_scale_qualitative',[
                'projects'=>$projects,
                'framework_name'=>$risk_management_framework->framework_name,
                'framework_approach'=>$framework_approach->approach_name
            ]);

         }

         //Quantitative
         if($req->framework_approach==2){

            $global_currency=DB::table("global_currency")->get();
         
            return view('risk_management.consequence_scale_quantitave',[
                'projects'=>$projects,
                'framework_name'=>$risk_management_framework->framework_name,
                'framework_approach'=>$framework_approach->approach_name,
                'global_currency'=>$global_currency
            ]);

         }

    }

    public function qualititave_likelihood_scale($org_id,Request $req){
 
        $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

                 $selected_project_ids = DB::table('project_types')
    ->whereIn("id", $req->selected_projects)
    ->pluck('id') // just get the IDs for filtering
    ->toArray();

 $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();

           $framework_approach=Db::table('framework_approach_types')
           ->where('approach_name',$req->framework_approach)
           ->first();
         
        //Qualitative
           return view('risk_management.likelihood_scale_qualitative',[
               'projects'=>$projects,
               'framework_name'=>$risk_management_framework->framework_name,
               'framework_approach'=>$framework_approach->approach_name
           ]);

        
    }

    public function qualitative_info_security_risk_criteria($org_id,Request $req){
        $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

               $selected_project_ids = DB::table('project_types')
    ->whereIn("id", $req->selected_projects)
    ->pluck('id') // just get the IDs for filtering
    ->toArray();

 $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();


           $framework_approach=Db::table('framework_approach_types')
           ->where('approach_name',$req->framework_approach)
           ->first();
         
        //Qualitative
           return view('risk_management.qualitative_info_security_risk_criteria',[
               'projects'=>$projects,
               'framework_name'=>$risk_management_framework->framework_name,
               'framework_approach'=>$framework_approach->approach_name
           ]);
    }

    public function qualitative_risk_acceptance_criteria($org_id,Request $req){
        $req->validate([
            'risk_acceptance_criteria'=>'required'
        ]);

        foreach($req->selected_projects as $proj){
            DB::table('qualitative_risk_acceptance_criteria')
            ->updateOrInsert([
                'project_type_id'=>$proj,
                'org_id'=>auth()->user()->organization->id,
                
            ],
        [
            'criteria_selected'=>$req->risk_acceptance_criteria,
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
        ]
    );
         }

         $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

         $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();

         $framework_approach=Db::table('framework_approach_types')
         ->where('approach_name',$req->framework_approach)
         ->first();

         $risk_acceptance_criteria=DB::table('qualitative_risk_acceptance_criteria')
         ->where('org_id',$org_id)->first();
         //Qualitative

         $global_risk_assessment_approaches=DB::table('global_risk_assessment_approach')->get();
       
         
         
            return view('risk_management.risk_assessment_approach',[
                'projects'=>$projects,
                'framework_name'=>$risk_management_framework->framework_name,
                'framework_approach'=>$framework_approach->approach_name,
                'risk_acceptance_criteria'=>$risk_acceptance_criteria->criteria_selected,
                'global_risk_assessment_approaches'=>$global_risk_assessment_approaches
               
            ]);

        
    }

    public function risk_assessment_approach($org_id,Request $req){

        $req->validate([
            'risk_assessment_approach'=>'required'
        ]);

        foreach($req->selected_projects as $proj){
            DB::table('org_risk_assessment_approach')
            ->updateOrInsert([
                'project_type_id'=>$proj,
                'org_id'=>auth()->user()->organization->id,
                
            ],
        [
            'assessment_approach_selected'=>$req->risk_assessment_approach,
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
        ]
    );
         }

         $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

         $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();

         $framework_approach=Db::table('framework_approach_types')
         ->where('approach_name',$req->framework_approach)
         ->first();

         $risk_assessment_approach = DB::table('org_risk_assessment_approach')
         ->join('global_risk_assessment_approach', 
             'org_risk_assessment_approach.assessment_approach_selected', 
             'global_risk_assessment_approach.global_risk_assessment_approach_id')
         ->where('org_risk_assessment_approach.org_id', $org_id)
         ->first();


         if($framework_approach->approach_name=="Qualitative"){
            $risk_acceptance_criteria=DB::table('qualitative_risk_acceptance_criteria')
            ->where('org_id',$org_id)->first();
               return view('risk_management.qualitative_assessment_methodology_summary',[
                   'projects'=>$projects,
                   'framework_name'=>$risk_management_framework->framework_name,
                   'framework_approach'=>$framework_approach->approach_name,
                   'risk_acceptance_criteria'=>$risk_acceptance_criteria->criteria_selected,
                   'risk_assessment_approaches'=>$risk_assessment_approach->global_assessment_approach
                  
               ]);

         }

         if($framework_approach->approach_name=="Quantitative"){
            $risk_acceptance_criteria=DB::table('org_risk_acceptance_quantitative')
            ->where('org_id',$org_id)->first();
               return view('risk_management.quantitative_assessment_methodology_summary',[
                   'projects'=>$projects,
                   'framework_name'=>$risk_management_framework->framework_name,
                   'framework_approach'=>$framework_approach->approach_name,
                   'risk_acceptance_criteria'=>$risk_acceptance_criteria->threshold_risk_acceptance_value,
                   'risk_assessment_approaches'=>$risk_assessment_approach->global_assessment_approach
                  
               ]);

         }


        
   
    }

    public function quantitave_consequence_scale($org_id,Request $req){
        $projectTypeIds = $req->selected_projects;
        $currencies = $req->currency_selected;
        $logExpressions = $req->log_expression;
        $scales = $req->scale;
        
        foreach ($projectTypeIds as $projectTypeId) {
            foreach ($scales as $i => $scale) {
                DB::table('org_quantitavie_consequence_scale')->updateOrInsert(
                    [
                        'org_id' => $org_id,
                        'project_type_id' => $projectTypeId,
                        'scale' => $scale,
                        'log_expression' => $logExpressions[$i],
                    ],
                    [
                        'currency_selected' => $currencies[$i],
                        'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                        'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                    ]
                );
            }
        }

        $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

        $risk_management_framework=DB::table('org_projects_framework_selected')
        ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
        'risk_management_framework.framework_id')
        ->where('org_id',$org_id)->first();

           $framework_approach=Db::table('framework_approach_types')
           ->where('approach_name',$req->framework_approach)
           ->first();


        
        return view('risk_management.likelihood_scale_quantitative',[
            'projects'=>$projects,
            'framework_name'=>$risk_management_framework->framework_name,
            'framework_approach'=>$framework_approach->approach_name
           
        ]);
    }

    public function quantitative_risk_acceptance($org_id,Request $req){
        $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

        $risk_management_framework=DB::table('org_projects_framework_selected')
        ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
        'risk_management_framework.framework_id')
        ->where('org_id',$org_id)->first();

           $framework_approach=Db::table('framework_approach_types')
           ->where('approach_name',$req->framework_approach)
           ->first();

           return view('risk_management.risk_acceptance_quantitative',[
            'projects'=>$projects,
            'framework_name'=>$risk_management_framework->framework_name,
            'framework_approach'=>$framework_approach->approach_name
           
        ]);


    }

    public function save_risk_acceptance_quantitative($org_id,Request $req){
        $req->validate([
            'risk_acceptance_quantitative'=>'required'
        ]);

        foreach($req->selected_projects as $proj){
            DB::table('org_risk_acceptance_quantitative')
            ->updateOrInsert([
                'project_type_id'=>$proj,
                'org_id'=>auth()->user()->organization->id,
                
            ],
        [
            'threshold_risk_acceptance_value'=>$req->risk_acceptance_quantitative,
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')
        ]
    );
         }

         $projects=DB::table('project_types')->whereIn("id",$req->selected_projects)->get();

         $risk_management_framework=DB::table('org_projects_framework_selected')
         ->join('risk_management_framework','org_projects_framework_selected.framework_selected',
         'risk_management_framework.framework_id')
         ->where('org_id',$org_id)->first();

         $framework_approach=Db::table('framework_approach_types')
         ->where('approach_name',$req->framework_approach)
         ->first();

         $risk_acceptance_criteria=DB::table('org_risk_acceptance_quantitative')
         ->where('org_id',$org_id)->first();

         $global_risk_assessment_approaches=DB::table('global_risk_assessment_approach')->get();


      
            return view('risk_management.quantitative_risk_assessment_approach',[
                'projects'=>$projects,
                'framework_name'=>$risk_management_framework->framework_name,
                'framework_approach'=>$framework_approach->approach_name,
                'risk_acceptance_criteria'=>$risk_acceptance_criteria->threshold_risk_acceptance_value,
               'global_risk_assessment_approaches'=>$global_risk_assessment_approaches
            ]);


    }
}
