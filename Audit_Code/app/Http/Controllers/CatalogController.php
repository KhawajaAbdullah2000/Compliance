<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(?int $proj_id=null)
{
    $catalogs = DB::table('risk_description_catalog')->get();
    return view('catalog.index', compact('catalogs','proj_id'));
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
}
