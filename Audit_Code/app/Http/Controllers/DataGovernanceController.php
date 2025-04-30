<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

use Illuminate\Http\Request;

class DataGovernanceController extends Controller
{
    public function data_catalog_sections($proj_id,$user_id){
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
              
                // if (in_array('Data Inputter', $permissions)) {
                // }
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                $frameworkDetails = $this->getProjectFrameworkDetails($project);

        
                return view("data_governance.main_sections",[
                 
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach']
                    ]);
            }

        }
    }

    public function data_catalog_list($proj_id,$user_id){
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
              
                // if (in_array('Data Inputter', $permissions)) {
                // }
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                $data_catalog=DB::table('data_catalog')->where('project_id',$proj_id)
                ->get();
              //  dd($data_catalog);
            
                return view("data_governance.data_catalog_list",[
                 
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'data_catalog'=>$data_catalog
                    ]);
            }

        }
    }

    public function data_catalog_new($proj_id,$user_id){
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
              
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                $frameworkDetails = $this->getProjectFrameworkDetails($project);

               $sub_orgs=DB::table('departments')->where('org_id',auth()->user()->organization->id)
               ->get();
              
              
            
                return view("data_governance.data_catalog_new_form",[
                 
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'sub_orgs'=>$sub_orgs
                    
                    ]);
            }

        }

        }

    }

    public function new_data_catalog_submit($proj_id,$user_id,Request $req){

        $fileName=null;
        if ($req->hasFile('governance_policy')) {
            $file = $req->file('governance_policy');
            $fileName = time() . '.' . $file->extension();
            $file->move(public_path('data_catalog'), $fileName);
        }

        Db::table('data_catalog')->insert([
            'name'=>$req->name,
            'project_id'=>$proj_id,
            'data_source'=>$req->data_source,
            'data_type'=>$req->data_type,
            'data_definition'=>$req->data_definition,
            'user_dept'=>$req->user_dept,
            'owner_dept'=>$req->owner_dept,
            'governance_policy'=>$fileName,
            'confidentiality_tag'=>$req->confidentiality_tag,
            'integrity_tag'=>$req->integrity_tag,
            'availability_tag'=>$req->availability_tag,
            'last_edited_by'=>$user_id,
            'last_edited_at'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('data_catalog_list',[
            'proj_id'=>$proj_id,
            'user_id'=>$user_id
        ])->with('success','Data Added Successfully');
    }

    public function datasets_list($catalog_id,$proj_id,$user_id){
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
              
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                $data_catalog=DB::table('data_catalog')->find($catalog_id);
          
                $datasets = DB::table('datasets')
                ->where('data_catalog_id', $catalog_id)
                ->orderBy('id', 'asc')
                ->get();
        
            // For each dataset, get its attributes
            $datasetsWithAttributes = $datasets->map(function ($dataset) {
                $attributes = DB::table('dataset_attributes')
                    ->where('dataset_id', $dataset->id)
                    ->get();
        
                $dataset->attributes = $attributes;
                return $dataset;
            });               
              
            
                return view("data_governance.datasets",[
                 
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'datasets' => $datasetsWithAttributes,
                    'data_catalog'=>$data_catalog
                    
                    ]);
            

        }

        }
    }
    
    public function dataset_attributes($catalog_id,$proj_id,$user_id){
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
           
              
                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();

                $frameworkDetails = $this->getProjectFrameworkDetails($project);

                $data_catalog=DB::table('data_catalog')->find($catalog_id);

                $firstDataset = DB::table('datasets')
                ->where('data_catalog_id', $catalog_id)
                ->orderBy('id')
                ->first();

            $templateAttributes = [];

            if ($firstDataset) {
                $templateAttributes = DB::table('dataset_attributes')
                    ->where('dataset_id', $firstDataset->id)
                    ->orderBy('id')
                    ->get();
                }
                         
              
            
                return view("data_governance.dataset_attributes_new",[
                 
                    'project_permissions' => $checkpermission->project_permissions,
                    'project' => $project,
                    'complianceFramework'=>$frameworkDetails['complianceFramework'],
                    'risk_assessment_approach'=>$frameworkDetails['risk_assessment_approach'],
                    'framework_approach'=>$frameworkDetails['framework_approach'],
                    'template_attributes'=>$templateAttributes,
                    'data_catalog'=>$data_catalog
                    
                    ]);
            
                }
        }

        }
    }

    public function dataset_attributes_submit($proj_id,$user_id,Request $req){
        $req->validate([
            'data_catalog_id' => 'required|exists:data_catalog,id',
            'attributes' => 'required|array|min:1|max:30',
            'attributes.*.name' => 'required|string|max:100',
            'attributes.*.type' => 'required|in:string,date',
            'attributes.*.value' => 'nullable|string', // validated as string, can parse if date
        ]);



        // $datasetId = DB::table('datasets')->insertGetId([
        //     'data_catalog_id' => $req->data_catalog_id,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    
        // // Confirm dataset inserted
        // if (!$datasetId) {
        //     return response()->json(['error' => 'Failed to insert dataset.'], 500);
        // }
    
        // // Prepare attributes
        // $attributes = [];
        // foreach ($req->input('attributes') as $attr) {
        //     $attributes[] = [
        //         'dataset_id' => $datasetId,
        //         'attribute_name' => $attr['name'],
        //         'attribute_type' => $attr['type'],
        //         'attribute_value' => $attr['value'],
        //     ];
        // }

        // // Insert attributes
        // if (!empty($attributes)) {
        //     try {
        //         DB::table('dataset_attributes')->insert($attributes);
        //     } catch (\Exception $e) {
        //         return response()->json(['error' => 'Attribute insert failed: ' . $e->getMessage()], 500);
        //     }
        // }

        $catalogId = $req->input('data_catalog_id');
        $submittedAttributes = collect($req->input('attributes'))->map(function ($attr) {
            return ['name' => $attr['name'], 'type' => $attr['type']];
        });
    
        // Check if this catalog already has datasets
        $firstDataset = DB::table('datasets')
            ->where('data_catalog_id', $catalogId)
            ->orderBy('id')
            ->first();
    
        if ($firstDataset) {
            // Fetch the attributes of the first dataset as the template
            $template = DB::table('dataset_attributes')
                ->where('dataset_id', $firstDataset->id)
                ->orderBy('id') // Ensure consistent order
                ->get()
                ->map(function ($row) {
                    return ['name' => $row->attribute_name, 'type' => $row->attribute_type];
                });
    
            // Validation: count
            if ($submittedAttributes->count() !== $template->count()) {
                return back()->withErrors(['attributes' => 'Attribute count must match existing datasets in this catalog.']);
            }
    
            // Validation: name and type (case-insensitive)
            foreach ($template->values() as $i => $expected) {
                $submitted = $submittedAttributes[$i];
                if (
                    strtolower($submitted['name']) !== strtolower($expected['name']) ||
                    $submitted['type'] !== $expected['type']
                ) {
                    return back()->withErrors(['attributes' => 'Attribute names and types must match existing datasets.']);
                }
            }
        }
    
        // Insert new dataset
        $datasetId = DB::table('datasets')->insertGetId([
            'data_catalog_id' => $catalogId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Prepare attribute rows
        $attributes = [];
        foreach ($req->input('attributes') as $attr) {
            $attributes[] = [
                'dataset_id' => $datasetId,
                'attribute_name' => $attr['name'],
                'attribute_type' => $attr['type'],
                'attribute_value' => $attr['value'],
            ];
        }
    
        DB::table('dataset_attributes')->insert($attributes);
    
 

     
        return redirect()->route('datasets_list',[
            'catalog_id'=>$req->data_catalog_id,
            'proj_id'=>$proj_id,
            'user_id'=>$user_id
        ])->with('success','Dataset Added successfully');
  

        
    }


    function getProjectFrameworkDetails($project)
    {
        $orgId = auth()->user()->organization->id;
    
        $complianceFramework = DB::table('org_projects_framework_selected')
            ->join('risk_management_framework','org_projects_framework_selected.framework_selected', '=', 'risk_management_framework.framework_id')
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
