<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('risk_description_catalog')->get();
        return view('catalog.index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('risk_description_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }

    public function control_objective_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('control_objective_catalog')->get();
        return view('catalog.control_objective_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function control_objective_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('control_objective_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }



    public function control_description_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('control_description_catalog')->get();
        return view('catalog.control_description_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function control_description_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('control_description_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }


    public function control_type_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('control_type_catalog')->get();
        return view('catalog.control_type_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function control_type_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('control_type_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }

    public function document_reference_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('document_reference')->get();
        return view('catalog.document_reference_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function document_reference_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('document_reference')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }


    public function sub_process_reference_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('sub_process_reference')->get();
        return view('catalog.sub_process_reference_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function sub_process_reference_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('sub_process_reference')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }



    public function application_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('application')->get();
        return view('catalog.application_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function application_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('application')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }


    public function incident_reference_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('incident_reference_catalog')->get();
        return view('catalog.incident_reference_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function incident_reference_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('incident_reference_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }

    public function external_audit_observation_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('external_audit_observation_catalog')->get();
        return view('catalog.external_audit_observation_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function external_audit_observation_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('external_audit_observation_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }


    public function internal_audit_observation_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('internal_audit_observation_catalog')->get();
        return view('catalog.internal_audit_observation_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function internal_audit_observation_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('internal_audit_observation_catalog')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }

       public function risk_mitigation_plan_index($risk_record_id, $proj_id, $user_id)
    {
        $catalogs = DB::table('risk_mitigation_plan')->get();
        return view('catalog.risk_mitigation_plan_index', compact('catalogs', 'proj_id', 'risk_record_id', 'user_id'));
    }

    public function risk_mitigation_plan_store(Request $request)
    {
        $request->validate(['description' => 'required|unique:risk_description_catalog,description']);
        DB::table('risk_mitigation_plan')->insert([
            'description' => $request->description,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Catalog item added successfully.');
    }
}
