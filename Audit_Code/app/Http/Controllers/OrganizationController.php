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

    public function user_action_all_projects_in_org($org_id){
    

        $users =User::with(['permissions'])
        ->leftJoin('projects', 'users.id', '=', 'projects.created_by')
        ->leftJoin('project_details', 'users.id', '=', 'project_details.assigned_enduser')
        ->select(
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.privilege_id',
       
            DB::raw('COUNT(DISTINCT projects.project_id) as created_projects'),
            DB::raw('COUNT(DISTINCT project_details.project_code) as assigned_projects')
        )
        ->where('users.org_id', $org_id)
        ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.privilege_id')
        ->get();

    

        return view('user_actions.all_projects_in_org',[
            'users'=>$users
        ]);

    }

    public function projects_created_by($org_id,$user_id){
        $projects = DB::table('projects')
    ->join('project_types', 'projects.project_type', '=', 'project_types.id')
    ->leftJoin('project_details', 'projects.project_id', '=', 'project_details.project_code')
    ->where('projects.org_id', $org_id)
    ->where('projects.created_by', $user_id)
    ->select(
        'projects.*',
        'project_types.type as project_type_name', // Adjust column name based on your schema
        DB::raw('GROUP_CONCAT(DISTINCT project_details.assigned_enduser) as assigned_users') // Ensure distinct users
    )
    ->groupBy(
        'projects.project_id',
        'project_types.type'  // Add all non-aggregated columns used in SELECT to GROUP BY
        
    )
    ->get();

      

        $user=Db::table('users')->where('id',$user_id)
        ->select('first_name','last_name')
        ->first();
     
        return view('user_actions.projects_created_by',[
            'projects'=>$projects,
            'user'=>$user
        ]);

    }

    public function projects_assigned($org_id,$user_id){
        $projects = DB::table('projects')
        ->join('project_details', 'projects.project_id', '=', 'project_details.project_code')
        ->join('project_types', 'projects.project_type', '=', 'project_types.id')
        ->where('project_details.assigned_enduser', $user_id) // Filter by assigned end user
        ->select(
            'projects.*',
            'project_types.type as project_type_name',
            DB::raw('GROUP_CONCAT(DISTINCT project_details.assigned_enduser) as assigned_users')
        )
        ->groupBy(
            'projects.project_id',
            'project_types.type',
       
        )
        ->get();



        $user=Db::table('users')->where('id',$user_id)
        ->select('first_name','last_name')
        ->first();
     
        return view('user_actions.projects_assigned',[
            'projects'=>$projects,
            'user'=>$user
        ]);

    }
}
