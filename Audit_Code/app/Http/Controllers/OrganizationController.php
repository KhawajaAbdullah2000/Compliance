<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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
        return view('root_user.add_new_org');
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
            'status'=>'required'
        ],
             [           
                'sub_org.unique'=>'The department in this organization already exists'
            ]

        );
        $currentDateTime = now();
        $currentTime = $currentDateTime->format('H:i:s');
        try{
            $org=new Organization();
            $org->name=$req->name;
            $org->sub_org=$req->sub_org;
            $org->type=$req->type;
            $org->country=$req->country;
            $org->state=$req->state;
            $org->city=$req->city;
            $org->zip_code=$req->zip_code;
            $org->address=$req->address;
            $org->status=$req->status;
            $org->record_created_by=$req->record_created_by;
            $org->record_creation_date=Carbon::now()->format('Y-m-d');
           $org->record_creation_time=$currentTime;
    
           $org->save();
           return redirect()->route('organizations')->with('success','Added Successfully');

    
        }catch(Exception $e){
            return redirect()->route('organizations')->with('error','Could not add the organization');
        }
       

    }

    public function edit_org($name,$sub_org){
        $org=Organization::where('name',$name)->where('sub_org',$sub_org)->first();
        if($org){
            return view('root_user.edit_org',['org'=>$org]);
        }
        else{
            return redirect()->route('organizations')->with('error','Organization not found');
        }
    }

    public function update_org(Request $req,$name,$sub_org){
        $req->validate([
            'name'=>'required|max:100|',
            'sub_org'=>'required',
            'type'=>'required',
            'country'=>'required|max:100',
            'state'=>'required|max:100',
            'city'=>'required|max:100',
            'zip_code'=>'required|numeric',
            'address'=>'required|max:100',
            'status'=>'required'
        ]
        );
   
            try{
                DB::table('organizations')->where('name',$name)->where('sub_org',$sub_org)->
                update(['name'=>$req->name,
                'sub_org'=>$req->sub_org,
                'type'=>$req->type,
                'country'=>$req->country,
                'city'=>$req->city,
                'state'=>$req->state,
                'zip_code'=>$req->zip_code,
                'address'=>$req->address,
                'status'=>$req->status
            ]);
                return redirect()->route('organizations')->withSuccess('Record updated');
            }catch(Exception $e){
             
                return redirect()->route('organizations')->with('error','The record exists already. please check the name and department of the record you were editing');
            }
        


    }

    public function delete_org($name,$sub_org){
        Db::table('organizations')->where('name',$name)->where('sub_org',$sub_org)->delete();
        return redirect()->route('organizations')->withSuccess('Organization deleted');

    }
}
