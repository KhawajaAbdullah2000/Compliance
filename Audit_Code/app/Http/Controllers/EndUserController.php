<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;


class EndUserController extends Controller
{


    public function projects($user_id)
    {
        $projects = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.created_by', $user_id)->latest('project_creation_date')->get();
        return view('project.projects', ['projects' => $projects]);
    }

    public function editProject($id)
    {
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $id)->first();
        $project_types = DB::table('project_types')->get();
        return view('project.editProject', ['project' => $project, 'types' => $project_types]);
    }

    public function create_project($userid)
    {
        $project_types = DB::table('project_types')->get();
        return view('project.create_project', ['types' => $project_types]);

    }
    public function submit_create_project(Request $req, $user_id)
    {
        $req->validate([
            'project_name' => 'required|max:80|min:5|unique:projects',
            'project_type' => 'required',
        ]);

        $project = new Project();
        $project->project_name = $req->project_name;
        $project->created_by = $user_id;
        $project->org_id = auth()->user()->org_id;
        $project->project_creation_date = Carbon::now()->format('Y-m-d');
        $project->project_creation_time = Carbon::now()->format('H:i:s');
        $project->project_type = $req->project_type;
        $project->status_last_changed_by = $user_id;
        $project->save();
        return redirect()->route('projects', ['user_id' => $user_id])->with('success', 'Project Created Successfully');

    }
    public function edit_my_project($id)
    {
        $project_types = DB::table('project_types')->get();
        $project = Project::where('project_id', $id)->where('created_by', auth()->user()->id)->first();
        if ($project) {
            return view('project.edit_my_project', ['project' => $project, 'types' => $project_types]);
        } else {
            return redirect()->route('projects', ['user_id' => auth()->user()->id])->with('error', 'Project not found');
        }
    }
    public function edit_project_submit(Request $req, $id)
    {
        //$id is project id to edit
        $req->validate([
            'project_name' => ['required', 'min:5', 'max:80', Rule::unique('projects')->ignore($id, 'project_id')],
            'project_type' => 'required',
            'status' => 'required',
        ]);



        $project = Project::where('project_id', $id)->where('created_by', auth()->user()->id)->first();
        if ($project) {
            $project->project_name = $req->project_name;
            $project->project_type = $req->project_type;
            $project->status = $req->status;
            $project->status_last_changed_by = auth()->user()->id;
            $project->save();
            return redirect()->route('projects', ['user_id' => auth()->user()->id])->with('success', 'Project edited successfully');
        } else {
            return redirect()->route('projects', ['user_id' => auth()->user()->id])->with('error', 'Couldnt edit the project');

        }

    }

    public function deleteUser($proj_id, $user_id)
    {
        $user_deleted = Db::table('project_details')->where('project_code', $proj_id)->where('assigned_enduser', $user_id)->delete();
        return redirect()->route('assigned_endusers', ['id' => $proj_id])->with('success', "User Deleted");
    }

    public function assigned_endusers($id)
    {
        //$id is project id
        $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
            ->where('projects.project_id', $id)->first();

        $endusers = Db::table('project_details')->join('users', 'project_details.assigned_enduser', 'users.id')
            ->where('project_details.project_code', $id)->get(['users.first_name', 'users.last_name', 'project_details.project_permissions', 'project_details.assigned_enduser']);
        return view('project.assigned_endusers', ['project_id' => $id, 'endusers' => $endusers, 'project' => $project]);

    }

    public function assign_end_user($id)
    {
        //$id is project id

        //find superusers
        $super = Db::table('users')->where('privilege_id', 1)->pluck('id')->toArray();

        //superusers of that organization
        $superusers_of_that_org = DB::table('superusers')->wherein('user_id', $super)
            ->where('org_id', auth()->user()->org_id)->pluck('user_id')->toArray();
        // dd($superusers_of_that_org);

        //organziatons of those superusers
        $orgs = Db::table('users')->wherein('id', $superusers_of_that_org)->pluck('org_id')->toArray();

        $users = User::where('privilege_id', 5)->wherein('org_id', $orgs)->get(['id', 'first_name', 'last_name']);
        $permissions = Permission::all();
        $project = Db::table('projects')->where('project_id', $id)->first();
        return view('project.assign_enduser_form', ['users' => $users, 'project_id' => $id, 'permissions' => $permissions, 'project' => $project]);

    }
    public function submit_end_user(Request $req, $proj_id)
    {
        $req->validate(
            [
                'assigned_enduser' => [
                    'required',
                    Rule::unique('project_details')->where(function ($query) use ($proj_id) {
                        return $query->where('project_code', $proj_id);
                    })
                ],
                'project_permissions' => 'required'
            ],
            [
                'assigned_enduser.unique' => 'This user is already assigned to this project'
            ]
        );
        $check = Project::where('project_id', $proj_id)->first();
        if ($check) {
            //project exists
            Db::table('project_details')->insert(
                [
                    'project_code' => $proj_id,
                    'assigned_enduser' => $req->assigned_enduser,
                    'project_permissions' => json_encode($req->project_permissions),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );
            return redirect()->route('assigned_endusers', ['id' => $proj_id]);

        } else {
            return redirect()->route('projects', ['user_id' => auth()->user()->id])->with('error', 'Couldnot find the project');
        }
    }

    public function edit_permissions($proj_id, $user_id)
    {
        $user = Db::table('project_details')->where('project_code', $proj_id)->where('assigned_enduser', $user_id)->first();
        if ($user) {
            $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                ->where('projects.project_id', $proj_id)->first();
            $permissions = Permission::all();

            $userDetails = Db::table('users')->where('id', $user_id)->first();

            return view('project.edit_permissions', [
                'user' => $user,
                'permissions' => $permissions,
                'project' => $project,
                'userDetails' => $userDetails
            ]);
        } else {
            return redirect()->back()->with('error', 'Error occured');
        }
    }

    public function edit_permissions_submit(Request $req, $proj_id, $user_id)
    {
        $req->validate(
            [
                'project_permissions' => 'required'
            ]
        );
        $user = Db::table('project_details')->where('project_code', $proj_id)->where('assigned_enduser', $user_id)->first();
        if ($user) {
            Db::table('project_details')->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->update(
                    [
                        'project_permissions' => json_encode($req->project_permissions),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]
                );
            return redirect()->route('assigned_endusers', ['id' => $proj_id])->with('success', 'Permissions Updated');

        } else {
            return redirect()->back()->with('error', 'Project not found');
        }

    }
}
