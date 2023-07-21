<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function organizations(){
        $orgs=Organization::query();

        //paginate

        return view('root_user.organizations',['organizations'=>$orgs->get()]);
    }
}
