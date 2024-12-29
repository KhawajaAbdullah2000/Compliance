<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class OrganizationController extends Controller
{
    public function organizations(Request $req){
        $orgs=Organization::query();

        if($req->has('search') and !empty($req->input('search'))){
            $orgs->where('name','like','%'.$req->input('search').'%')
            ->orwhere('country','like','%'.$req->input('search').'%')
            ->orwhere('sub_org','like','%'.$req->input('search').'%')
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
            'name'=>'required|max:100',
            'sub_org'=>['required','max:100', Rule::unique('organizations')->where(function ($query) use ($req) {
                return $query->where('name', $req->input('name'));
            })],
            'type'=>'required',
            'country'=>'required|max:100',
            'state'=>'required|max:100',
            'city'=>'required|max:100',
            'zip_code'=>'required|numeric',
            'address'=>'required|max:100',
            'status'=>'required',
            'project_types' => 'required|array',
            'project_types.*' => 'exists:project_types,id',
        ],
             [           
                'sub_org.unique'=>'The department in this organization already exists'
            ]

        );

        $currentDateTime = now();
        $currentTime = $currentDateTime->format('H:i:s');
        
        $org = Organization::create([
            'name' => $req->name,
            'sub_org' => $req->sub_org,
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
                'org_id' => $org->org_id, // Assuming `org_id` is the primary key
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
        $org=Organization::where('org_id',$org_id)->first();
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
            'name'=>'required|max:100|',
            'sub_org'=>'required',
            'type'=>'required',
            'country'=>'required|max:100',
            'state'=>'required|max:100',
            'city'=>'required|max:100',
            'zip_code'=>'required|numeric',
            'address'=>'required|max:100',
            'status'=>'required',
            'project_types' => 'required|array',
            'project_types.*' => 'exists:project_types,id',
        ]
        );
        $org= DB::table('organizations')->where('org_id',$org_id)->first();

            try{
                DB::table('organizations')->where('org_id',$org_id)->
                update([
                'name'=>$req->name,
                'sub_org'=>$req->sub_org,
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
        Db::table('organizations')->where('org_id',$org_id)->delete();
        return redirect()->route('organizations')->withSuccess('Organization deleted');

    }
}
