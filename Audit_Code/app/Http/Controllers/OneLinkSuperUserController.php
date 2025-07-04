<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Unit;
use App\Models\SubEntity;

class OneLinkSuperUserController extends Controller
{
    public function entities_list($user_id, $org_id)
    {
        // $departments = DB::table('departments')->where('org_id', $org_id)->get();
        $departments = Department::with('organization')->get();

        return view('one_link_super_user.departments', [
            'departments' => $departments
        ]);
    }

    public function sub_entities_list($user_id, $org_id)
    {
        $sub_entities = DB::table('one_link_sub_entities as se')
            ->leftJoin('users as u', 'se.created_by', '=', 'u.id')
            ->select(
                'se.*',
                'u.first_name',
                'u.last_name'
            )
            ->where('se.org_id', $org_id)

            ->get();

        return view('one_link_super_user.sub_entities', [
            'sub_entities' => $sub_entities,

        ]);
    }

    public function save_unit(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'unit_name' => 'required|string|max:100',
        ]);

        DB::table('units')->insert([
            'department_id' => $request->department_id,
            'name' => $request->unit_name,
        ]);

        return redirect()->back()->with('success', 'Unit added successfully.');
    }

    public function getUnits($id)
    {
        $units = DB::table('units')->where('department_id', $id)->get(['id', 'name']);
        return response()->json($units);
    }

    public function edit_unit($id)
    {
        $unit = Unit::with('department.organization')->findOrFail($id);
        return view('one_link_super_user.unit_edit', compact('unit'));
    }

    public function update_unit(Request $request, $id)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->name = $request->unit_name;
        $unit->save();

        return redirect()->route('entities_list', [
            'user_id' => auth()->user()->id,
            'org_id' => auth()->user()->organization->id
        ])
            ->with('success', 'Unit updated successfully.');
    }

    public function delete_unit($id)
    {
        Db::table('units')->where('id', $id)->delete();
        return redirect()->route('entities_list', [
            'user_id' => auth()->user()->id,
            'org_id' => auth()->user()->organization->id
        ])
            ->with('success', 'Unit deleted successfully.');
    }

    public function add_sub_entity($org_id, $user_id)
    {
        $user = User::find($user_id);

        return view('one_link_super_user.add_sub_entity_form', [
            'user' => $user,

        ]);
    }

    public function submit_sub_entities($org_id, $user_id, Request $request)
    {

        $types = [
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
                        'created_by'       => $user_id,
                    ]);
                }
            }
        }

        return redirect()->route('sub_entities_list', [
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

    public function sub_entity_edit($id)
{
    $subEntity = DB::table('one_link_sub_entities')->where('id', $id)->first();

    return view('one_link_super_user.edit_sub_entity', compact('subEntity'));
}

public function sub_entity_update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    DB::table('one_link_sub_entities')->where('id', $id)->update([
        'name' => $request->name,
        'updated_at' => now(),
    ]);

    return redirect()->route('sub_entities_list',[
        'user_id'=>auth()->user()->id,
        'org_id'=>auth()->user()->organization->id
    ])->with('success', 'Sub-entity updated successfully.');
}

public function sub_entity_destroy($id)
{
    DB::table('one_link_sub_entities')->where('id', $id)->delete();

    return redirect()->back()->with('success', 'Sub-entity deleted successfully.');
}

}
