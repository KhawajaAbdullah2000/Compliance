<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;
use APP\Models\Organization;
use APP\Models\Department;
use App\Models\SubEntity;

class OneLinkSuperUserController extends Controller
{
    public function entities_list($user_id, $org_id)
    {
        $departments = DB::table('departments')->where('org_id', $org_id)->get();
        return view('one_link_super_user.departments', [
            'departments' => $departments
        ]);
    }

    public function add_sub_entity($org_id, $dept_id, $user_id)
    {
        $user = User::find($user_id);
        $department = Db::table('departments')->find($dept_id);
        return view('one_link_super_user.add_sub_entity_form', [
            'user' => $user,
            'department' => $department
        ]);
    }

    public function submit_sub_entities($org_id, $dept_id, $user_id, Request $request)
    {

        $types = [
            'functions'     => 'functions',
            'products'      => 'products',
            'cycles'        => 'cycles',
            'sub_processes' => 'sub_processes',
        ];

        foreach ($types as $key => $label) {
            $items = $request->input($key, []);
            foreach ($items as $value) {
                if (!empty($value)) {
                    SubEntity::create([
                        'name'             => $value,
                        'sub_entity_type'  => $label,
                        'org_id'           => $org_id,
                        'department_id'    => $dept_id,
                        'created_by'       => $user_id,
                    ]);
                }
            }
        }

        return redirect()->route('entities_list', [
            'user_id' => $user_id,
            'org_id' => $org_id
        ])->with('success', 'Sub Entities Entered Successfully');
    }

    public function view_sub_entities($org_id, $dept_id, $user_id)
    {
        $sub_entities = DB::table('one_link_sub_entities as se')
            ->leftJoin('users as u', 'se.created_by', '=', 'u.id')
            ->select(
                'se.*',
                'u.first_name',
                'u.last_name'
            )
            ->where('se.org_id', $org_id)
            ->where('se.department_id', $dept_id)
            ->get();
        $department = DB::table('departments')->find($dept_id);
        return view('one_link_super_user.department_sub_entities', [
            'sub_entities' => $sub_entities,
            'department' => $department
        ]);
    }
}
