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
    public function select_assets($org_id){
        $global_categories=Db::table('global_asset_categories')
        ->where('is_manual','no')
        ->get();

        //dd($global_categories);
       
        $org_categories=DB::table('org_assets_categories')->join('global_asset_categories','org_assets_categories.asset_category_selected','global_asset_categories.asset_category_id')
        ->where("org_id",$org_id)
        ->get();

        $custom_org_categories=DB::table('org_assets_categories')->join('global_asset_categories','org_assets_categories.asset_category_selected','global_asset_categories.asset_category_id')
        ->where("org_id",$org_id)
        ->where('global_asset_categories.is_manual','yes')
        ->get();

        //dd($custom_org_categories);
  
        
        return view('org_assets.select_assets',[
            'global_categories'=>$global_categories,
            'org_categories'=>$org_categories,
            'custom_org_categories'=>$custom_org_categories
        ]);
       
    }

    public function add_new_category_in_org($org_id){
        return view("org_assets.add_new_category");
    }

    public function add_new_asset_category($org_id, Request $req){

        $category_id = DB::table('global_asset_categories')->insertGetId([
            'asset_category' => $req->asset_category,
            'is_manual' => 'yes'
        ]);
        
        // Step 2: Insert into org_asset_categories using the retrieved ID
        DB::table('org_assets_categories')->insert([
            'org_id' => $org_id,
            'asset_category_selected' => $category_id
        ]);

            return redirect()->route("select_assets",[
                'org_id'=>$org_id
            ])->with('success',"New Asset Category Added Successfully");
    }

    public function edit_custom_category($category_id){
        $asset_category=DB::table('global_asset_categories')
        ->where('asset_category_id',$category_id)->first();
        return view('org_assets.edit_category',[
            'asset_category'=>$asset_category
        ]);
    }

    public function update_asset_category($category_id,Request $req){
       DB::table('global_asset_categories')->where('asset_category_id',$category_id)
       ->update([
        'asset_category'=>$req->asset_category
       ]);

       return redirect()->route('select_assets',[
        'org_id'=>auth()->user()->organization->id
       ])->with("success","Asset Category Updated");

    }

    public function delete_custom_category($category_id){
        DB::table('global_asset_categories')->where('asset_category_id',$category_id)
        ->delete();

        return redirect()->route('select_assets',[
            'org_id'=>auth()->user()->organization->id
        ])->with('success',"Asset Category deleted from the Organization successfully");
      

    }

    public function add_asset_categories_in_org($org_id,Request $req){
 
        $req->validate([
            'asset_categories'=>'required'
        ]);

       
            DB::table('org_assets_categories')->join('global_asset_categories','org_assets_categories.asset_category_selected','global_asset_categories.asset_category_id')
            ->where('org_id',$org_id)
            ->where('is_manual','no')
            ->delete();
        
    
       foreach($req->asset_categories as $category){
        DB::table('org_assets_categories')->insert([
            'org_id'=>$org_id,
            'asset_category_selected'=>$category
        ]);
    }

        return redirect()->route('select_assets',[
            'org_id'=>$org_id
        ])->with('success',"Asset Categories added to the ORganization successfully");
       
    }
}
