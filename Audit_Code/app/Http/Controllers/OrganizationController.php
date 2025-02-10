<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
class OrganizationController extends Controller
{
    public function organizations(Request $req){
        $orgs=Organization::query();

        if($req->has('search') and !empty($req->input('search'))){
            $orgs->where('name','like','%'.$req->input('search').'%')
            ->orwhere('country','like','%'.$req->input('search').'%')
            ->orwhere('type','like','%'.$req->input('search').'%');
        }

        return view('root_user.organizations',['organizations'=>$orgs->orderby('created_at','desc')->paginate(5)->withQueryString()]);
    }

    public function add_new_org(){
        $proj_types=DB::table('project_types')->get();
        
        return view('root_user.add_new_org', ['proj_types' => $proj_types]);

    }

    public function register_new_org(Request $req){
 
        $req->validate([
            'name'=>'required|max:100|unique:organizations',
            'type'=>'required',
            'status'=>'required',
            'project_types' => 'required|array',
            'project_types.*' => 'exists:project_types,id',
        ]
        );

        $currentDateTime = now();
        $currentTime = $currentDateTime->format('H:i:s');
        
        $org = Organization::create([
            'name' => $req->name,
            'type' => $req->type,
            'country' => $req->country,
            'state' => $req->state,
            'city' => $req->city,
            'zip_code' => $req->zip_code,
            'address' => $req->address,
            'status' => $req->status,
            'record_created_by' => $req->record_created_by,
            'record_creation_date' => Carbon::now()->format('Y-m-d'),
            'record_creation_time' => Carbon::now()->format('H:i:s'),
        ]);


           $projectTypes = $req->project_types;
        $projectTypeData = [];
        foreach ($projectTypes as $projectTypeId) {
            $projectTypeData[] = [
                'org_id' => $org->id, // Assuming `org_id` is the primary key
                'project_type_id' => $projectTypeId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('organization_project_types')->insert($projectTypeData);
           return redirect()->route('organizations')->with('success','Added Successfully');

           
    
        // }catch(Exception $e){
        //     return redirect()->route('organizations')->with('error','Could not add the organization');
        // }
       

    }

    public function edit_org($org_id){
        $org=Organization::where('id',$org_id)->first();
        if($org){
            $proj_types=DB::table('project_types')->get();
            $selected_proj_types = DB::table('organization_project_types')
            ->where('org_id', $org_id)
            ->pluck('project_type_id')
            ->toArray();
            return view('root_user.edit_org',['org'=>$org,'proj_types'=>$proj_types,'selected_proj_types'=>$selected_proj_types]);
        }
        else{
            return redirect()->route('organizations')->with('error','Organization not found');
        }
    }

    public function update_org(Request $req,$org_id){
        $req->validate([
           'name' => [
            'required',
            'max:100',
            Rule::unique('organizations')->ignore($org_id),
        ],
            'type'=>'required',
            'status'=>'required',
            'project_types' => 'required|array',
            'project_types.*' => 'exists:project_types,id',
        ]
        );


            try{
                DB::table('organizations')->where('id',$org_id)->
                update([
                'name'=>$req->name,
                'type'=>$req->type,
                'country'=>$req->country,
                'city'=>$req->city,
                'state'=>$req->state,
                'zip_code'=>$req->zip_code,
                'address'=>$req->address,
                'status'=>$req->status
            ]);

            DB::table('organization_project_types')->where('org_id', $org_id)->delete();
            $projectTypeData = [];
            foreach ($req->project_types as $project_type_id) {
                $projectTypeData[] = [
                    'org_id' => $org_id,
                    'project_type_id' => $project_type_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('organization_project_types')->insert($projectTypeData);
        


                return redirect()->route('organizations')->withSuccess('Record updated');
            }catch(Exception $e){
             
                return redirect()->route('organizations')->with('error','The record exists already. please check the name and department of the record you were editing');
            }
        


    }

    public function delete_org($org_id){
        Db::table('organizations')->where('id',$org_id)->delete();
        return redirect()->route('organizations')->withSuccess('Organization deleted');

    }

    public function add_department($org_id){
        $org=Organization::where('id',$org_id)->first();
        if($org){
            
            return view('root_user.add_department',['org'=>$org]);
        }
        else{
            return redirect()->route('organizations')->with('error','Organization not found');
        }
    }

    public function add_new_dept(Request $req,$org_id){
        $req->validate([
            'name' => [
                'required',
                Rule::unique('departments')->where(function ($query) use ($org_id) {
                    return $query->where('org_id', $org_id);
                }),
            ],
        ]);
    
        $department = new Department();
        $department->org_id = $org_id;
        $department->name = $req->name;
        $department->save();

        return redirect()->route('organizations')->with('success','Department added successfully');
    }

    public function departments($org_id){
        $org=DB::table('organizations')->where('id',$org_id)->first();
        $departments=Db::table('departments')->where('org_id',$org_id)->get();
        return view('root_user.departments',[
            'org'=>$org,
            'departments'=>$departments
        ]);
    }
}
