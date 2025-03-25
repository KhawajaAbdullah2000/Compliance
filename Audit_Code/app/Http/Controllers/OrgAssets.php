<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use APP\Models\User;

class OrgAssets extends Controller
{
    public function select_assets($org_id)
    {
        $global_categories = Db::table('global_asset_categories')
            ->where('is_manual', 'no')
            ->get();

        //dd($global_categories);

        $org_categories = DB::table('org_assets_categories')->join('global_asset_categories', 'org_assets_categories.asset_category_selected', 'global_asset_categories.asset_category_id')
            ->where("org_id", $org_id)
            ->get();

        $custom_org_categories = DB::table('org_assets_categories')->join('global_asset_categories', 'org_assets_categories.asset_category_selected', 'global_asset_categories.asset_category_id')
            ->where("org_id", $org_id)
            ->where('global_asset_categories.is_manual', 'yes')
            ->get();

        //dd($custom_org_categories);


        return view('org_assets.select_assets', [
            'global_categories' => $global_categories,
            'org_categories' => $org_categories,
            'custom_org_categories' => $custom_org_categories
        ]);
    }

    public function add_new_category_in_org($org_id)
    {
        return view("org_assets.add_new_category");
    }

    public function add_new_asset_category($org_id, Request $req)
    {

        $category_id = DB::table('global_asset_categories')->insertGetId([
            'asset_category' => $req->asset_category,
            'is_manual' => 'yes'
        ]);

        // Step 2: Insert into org_asset_categories using the retrieved ID
        DB::table('org_assets_categories')->insert([
            'org_id' => $org_id,
            'asset_category_selected' => $category_id
        ]);

        return redirect()->route("select_assets", [
            'org_id' => $org_id
        ])->with('success', "New Asset Type Added Successfully");
    }

    public function edit_custom_category($category_id)
    {
        $asset_category = DB::table('global_asset_categories')
            ->where('asset_category_id', $category_id)->first();
        return view('org_assets.edit_category', [
            'asset_category' => $asset_category
        ]);
    }

    public function update_asset_category($category_id, Request $req)
    {
        DB::table('global_asset_categories')->where('asset_category_id', $category_id)
            ->update([
                'asset_category' => $req->asset_category
            ]);

        return redirect()->route('select_assets', [
            'org_id' => auth()->user()->organization->id
        ])->with("success", "Asset Type Updated");
    }

    public function delete_custom_category($category_id)
    {
        // DB::table('global_asset_categories')->where('asset_category_id', $category_id)
        //     ->delete();

        $assetTypeIds = DB::table('global_asset_types')
        ->where('asset_category', $category_id)
        ->pluck('asset_type_id');

    // Step 2: Delete related org asset types
    DB::table('org_assets_types')
        ->whereIn('asset_type_selected', $assetTypeIds)
        ->delete();

    // Step 3: Delete global asset types under this category
    DB::table('global_asset_types')
        ->where('asset_category', $category_id)
        ->delete();

    // Step 4: Delete related org asset categories
    DB::table('org_assets_categories')
        ->where('asset_category_selected', $category_id)
        ->delete();

    // Step 5: Delete the global asset category
    DB::table('global_asset_categories')
        ->where('asset_category_id', $category_id)
        ->delete();


        return redirect()->route('select_assets', [
            'org_id' => auth()->user()->organization->id
        ])->with('success', "Asset Type deleted from the Organization successfully");
    }

    public function add_asset_categories_in_org($org_id, Request $req)
    {

        $req->validate([
            'asset_categories' => 'required'
        ]);


        // DB::table('org_assets_categories')->join('global_asset_categories', 'org_assets_categories.asset_category_selected', 'global_asset_categories.asset_category_id')
        //     ->where('org_id', $org_id)
        //     ->where('is_manual', 'no')
        //     ->delete();
       
        $categoryIds = DB::table('org_assets_categories')
        ->join('global_asset_categories', 'org_assets_categories.asset_category_selected', '=', 'global_asset_categories.asset_category_id')
        ->where('org_assets_categories.org_id', $org_id)
        ->where('global_asset_categories.is_manual', 'no')
        ->pluck('global_asset_categories.asset_category_id');
    
    // Step 2: Get all asset type IDs under those categories
    $assetTypeIds = DB::table('global_asset_types')
        ->whereIn('asset_category', $categoryIds)
        ->pluck('asset_type_id');
    
    // Step 3: Delete related org asset types
    DB::table('org_assets_types')->whereIn('asset_type_selected', $assetTypeIds)->delete();
    

    
    // Step 5: Delete org asset categories
    DB::table('org_assets_categories')
        ->where('org_id', $org_id)
        ->whereIn('asset_category_selected', $categoryIds)
        ->delete();
    


        foreach ($req->asset_categories as $category) {
            DB::table('org_assets_categories')->insert([
                'org_id' => $org_id,
                'asset_category_selected' => $category
            ]);
        }

        return redirect()->route('select_assets', [
            'org_id' => $org_id
        ])->with('success', "Asset Types added to the Organization successfully");
    }

    public function select_asset_types_for_category($category_id)
    {
        $global_types = DB::table('global_asset_types')
            ->where('asset_category', $category_id)
            ->where('is_manual', 'no')
            ->get();
        // dd($global_types);

        $org_types = DB::table('org_assets_types')->join('global_asset_types', 'org_assets_types.asset_type_selected', 'global_asset_types.asset_type_id')
        ->where("org_id", auth()->user()->organization->id)
        ->where('global_asset_types.asset_category',$category_id)
        ->get();

        
        $custom_org_types = DB::table('org_assets_types')->join('global_asset_types', 'org_assets_types.asset_type_selected', 'global_asset_types.asset_type_id')
            ->where("org_id", auth()->user()->organization->id)
            ->where('global_asset_types.is_manual', 'yes')
            ->where('global_asset_types.asset_category',$category_id)
            ->get();


        $categoryDetails = DB::table('global_asset_categories')
            ->where('asset_category_id', $category_id)->first();

        return view('org_assets.select_types_for_category', [
            'global_types' => $global_types,
            'categoryDetails' => $categoryDetails,
            'custom_org_types'=>$custom_org_types,
            'org_types'=>$org_types
        ]);
    }

    public function add_new_asset_type_in_org($org_id,$category_id){
        $categoryDetails = DB::table('global_asset_categories')
        ->where('asset_category_id', $category_id)->first();
        return view('org_assets.add_new_asset_type',[
            'categoryDetails'=>$categoryDetails
        ]);
    }

    public function add_new_asset_type($org_id,$category_id,Request $req)
    {

        $asset_type_id = DB::table('global_asset_types')->insertGetId([
            'asset_type' => $req->asset_type,
            'is_manual' => 'yes',
            'asset_category'=>$category_id
        ]);

        // Step 2: Insert into org_asset_categories using the retrieved ID
        DB::table('org_assets_types')->insert([
            'org_id' => $org_id,
            'asset_type_selected' => $asset_type_id
        ]);

        return redirect()->route("select_asset_types_for_category", [
            'category_id' => $category_id
        ])->with('success', "New Asset Subtype Added Successfully");
    }

    public function add_asset_types_in_org($org_id,$category_id,Request $req)
    {

        $req->validate([
            'asset_types' => 'required'
        ]);


        DB::table('org_assets_types')->join('global_asset_types', 'org_assets_types.asset_type_selected', 'global_asset_types.asset_type_id')
            ->where('org_id', $org_id)
            ->where('is_manual', 'no')
            ->where('global_asset_types.asset_category',$category_id)
            ->delete();


        foreach ($req->asset_types as $category) {
            DB::table('org_assets_types')->insert([
                'org_id' => $org_id,
                'asset_type_selected' => $category
            ]);
        }

        return redirect()->route('select_asset_types_for_category', [
            'category_id' => $category_id
        ])->with('success', "Asset Subtype added to the Organization successfully");
    }

    public function edit_custom_asset_type($category_id)
    {
        $asset_type = DB::table('global_asset_types')
            ->where('asset_type_id', $category_id)->first();
        return view('org_assets.edit_asset_type', [
            'asset_type' => $asset_type
        ]);
    }

    public function update_asset_type($category_id,Request $req)
    {
        DB::table('global_asset_types')->where('asset_type_id', $category_id)
            ->update([
                'asset_type' => $req->asset_type
            ]);

            $asset_category=DB::table('global_asset_types')
            ->where('asset_type_id',$category_id)->first();

        return redirect()->route('select_asset_types_for_category', [
            'category_id'=>$asset_category->asset_category

        ])->with("success", "Asset SubType Updated");
    }

    public function delete_custom_asset_type($category_id)
    {
        $asset_category=DB::table('global_asset_types')
        ->where('asset_type_id',$category_id)->first();

        DB::table('global_asset_types')->where('asset_type_id', $category_id)
            ->delete();
       

        return redirect()->route('select_asset_types_for_category', [
            'category_id' =>$asset_category->asset_category
        ])->with('success', "Asset SubType deleted from the Organization successfully");
    }

    

      

    
        
    
}
