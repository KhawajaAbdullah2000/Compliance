<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
class PCI_Single_Sheet extends Controller
{
    public function pci_single_sheet_subsections($proj_id, $user_id, $asset_id, Request $req)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {

                if ($checkpermission->type_id == 1) {
                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    if ($req->evidenceLevel != null) {
                        $req->session()->forget('evidenceLevel');
                        $req->session()->put('evidenceLevel', $req->evidenceLevel);
                    }

                    $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();



                    return view('pci_single_sheet.sec_2_2_subsections', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project' => $project,
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_section_2_2($title_num, $proj_id, $user_id, $asset_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {

                if ($checkpermission->type_id == 1) {
                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $asset = Db::table('iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $filteredData = collect($data[0])->filter(function ($row) use ($title_num) {
                        return strval($row[0]) === $title_num;
                    })->values()->all();


                    return view('pci_single_sheet.pci_sec_2_2_main', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'title' => $title_num,
                        'project' => $project,
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_sec_2_2_req(Request $req, $main_req_num, $title, $proj_id, $user_id, $asset_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                if ($req->session()->exists('main_req_num')) {
                    $req->session()->forget('main_req_num');
                    $req->session()->put('main_req_num', $main_req_num);

                } else {
                    $req->session()->put('main_req_num', $main_req_num);

                }

                if ($checkpermission->type_id == 1) {



                    $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                    $data = Excel::toArray([], $filepath); //with header
                    $rows = array_slice($data[0], 1); //without header(first row)

                    $filteredData = collect($rows)->filter(function ($row) use ($main_req_num) {

                        return strval($row[1]) === $main_req_num;
                    })->values()->all();


                    $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                        ->where('projects.project_id', $proj_id)->first();

                    $asset = Db::table(table: 'iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                    return view('pci_single_sheet.pci_2_2_sub_reqs', [
                        'project_id' => $checkpermission->project_id,
                        'project_name' => $checkpermission->project_name,
                        'project_permissions' => $checkpermission->project_permissions,
                        'data' => $filteredData,
                        'main_req_num' => $main_req_num,
                        'title' => $title,
                        'project' => $project,
                        'asset' => $asset
                    ]);
                }
            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
    }

    public function pci_sec2_2_sub_req_edit($sub_req, $title, $proj_id, $user_id, $asset_id)
    {
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {

                if ($checkpermission->type_id == 1) {
                    $result = Db::table('iso_sec_2_2')->join('users', 'iso_sec_2_2.last_edited_by', 'users.id')
                        ->where('project_id', $proj_id)->where('sub_req', $sub_req)->first();
                }

                $filepath = public_path('PCI_DSS_4_Single_TSP.xlsx');
                $data = Excel::toArray([], $filepath); //with header
                $rows = array_slice($data[0], 1); //without header(first row)


                $filteredData = collect($rows)->filter(function ($row) use ($sub_req) {
                    return strval($row[3]) === $sub_req;
                })->values()->all();

                $project = Project::join('project_types', 'projects.project_type', 'project_types.id')
                    ->where('projects.project_id', $proj_id)->first();

                $asset = Db::table(table: 'iso_sec_2_1')->where('assessment_id', $asset_id)->first();


                return view('pci_single_sheet.pci_sec_2_2_sub_reqs_form', [
                    'project_id' => $checkpermission->project_id,
                    'project_name' => $checkpermission->project_name,
                    'project_permissions' => $checkpermission->project_permissions,
                    'title' => $title,
                    'sub_req' => $sub_req,
                    'result' => $result,
                    'filteredData' => $filteredData,
                    'project' => $project,
                    'asset' => $asset
                ]);

            }
        }
        return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);

    }

    public function pci_sec_2_2_form(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id)
    {
        $req->validate([
            'comp_status' => 'required'
        ]);
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 1) {

                    $evidenceLevel = $req->session()->get('evidenceLevel');


                    if (in_array('Data Inputter', $permissions)) {

                        $fileName = null;
                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                        }

                        if ($evidenceLevel == 'component') {


                            Db::table('iso_sec_2_2')->insert([
                                'asset_id' => $asset_id,
                                'project_id' => $proj_id,
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'title_num' => $title,
                                'sub_req' => $sub_req,
                                'attachment' => $fileName,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                            $mysessionreq = $req->session()->get('main_req_num');

                            return redirect()->route(
                                'pci_sec_2_2_req',
                                ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');

                        }

                        $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $assets = null;

                        if ($evidenceLevel == 'name') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get();
                        }

                        if ($evidenceLevel == 'group') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get();
                        }
                        if ($evidenceLevel == 'service') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get();
                        }

                        if ($evidenceLevel == 'project') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->get();
                        }



                        foreach ($assets as $ass) {
                            Db::table('iso_sec_2_2')->insert([
                                'asset_id' => $ass->assessment_id,
                                'project_id' => $proj_id,
                                'comp_status' => $req->comp_status,
                                'comments' => $req->comments,
                                'title_num' => $title,
                                'sub_req' => $sub_req,
                                'attachment' => $fileName,
                                'last_edited_by' => $user_id,
                                'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

                        }

                    }
                    $mysessionreq = $req->session()->get('main_req_num');

                    return redirect()->route(
                        'pci_sec_2_2_req',
                        ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                    )
                        ->with('success', 'Record Updated Successfully');

                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }

    }

    public function pci_sec_2_2_edit_form(Request $req, $sub_req, $title, $proj_id, $user_id, $asset_id)
    {
        $req->validate([
            'comp_status' => 'required',
            'attachment' => 'file|mimes:jpg,png,pdf,doc,docx,xlsx|max:5096',
        ]);
        if ($user_id == auth()->user()->id) {
            $checkpermission = Db::table('project_details')->select(
                'project_types.id as type_id',
                'project_details.project_code',
                'project_details.project_permissions',
                'projects.project_name',
                'projects.project_id'
            )
                ->join('projects', 'project_details.project_code', 'projects.project_id')
                ->join('project_types', 'projects.project_type', 'project_types.id')
                ->where('project_code', $proj_id)->where('assigned_enduser', $user_id)
                ->first();
            if ($checkpermission) {
                $permissions = json_decode($checkpermission->project_permissions);
                if ($checkpermission->type_id == 1) {
                    $evidenceLevel = $req->session()->get('evidenceLevel');
                    if (in_array('Data Inputter', $permissions)) {



                        if ($evidenceLevel == 'component') {


                            if ($req->attachment != null) {
                                $fileName = time() . '.' . $req->attachment->extension();
                                $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                                Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                                    ->where('asset_id', $asset_id)
                                    ->update([
                                        'comp_status' => $req->comp_status,
                                        'comments' => $req->comments,
                                        'attachment' => $fileName,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    ]);

                            } else {
                                Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                                    ->where('asset_id', $asset_id)
                                    ->update([
                                        'comp_status' => $req->comp_status,
                                        'comments' => $req->comments,
                                        'last_edited_by' => $user_id,
                                        'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    ]);

                            }


                            $mysessionreq = $req->session()->get('main_req_num');

                            return redirect()->route(
                                'pci_sec_2_2_req',
                                ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                            )
                                ->with('success', 'Record Updated Successfully');

                        }





                        $assetDetails = DB::table('iso_sec_2_1')->where('project_id', $proj_id)->where('assessment_id', $asset_id)->first();

                        $assets = null;

                        if ($evidenceLevel == 'name') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('name', $assetDetails->name)->get();
                        }

                        if ($evidenceLevel == 'group') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('g_name', $assetDetails->g_name)->get();
                        }
                        if ($evidenceLevel == 'service') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->where('s_name', $assetDetails->s_name)->get();
                        }

                        if ($evidenceLevel == 'project') {
                            $assets = Db::table('iso_sec_2_1')->where('project_id', $proj_id)->get();
                        }

                        if ($req->attachment != null) {
                            $fileName = time() . '.' . $req->attachment->extension();
                            $req->attachment->move(public_path('iso_sec_2_2'), $fileName);
                            foreach ($assets as $ass) {
                                Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                                    ->where('asset_id', $asset_id)->update([
                                            'comp_status' => $req->comp_status,
                                            'comments' => $req->comments,
                                            'title_num' => $title,
                                            'sub_req' => $sub_req,
                                            'attachment' => $fileName,
                                            'last_edited_by' => $user_id,
                                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                        ]);

                            }

                        } else {
                            foreach ($assets as $ass) {
                                Db::table('iso_sec_2_2')->where('project_id', $proj_id)->where('sub_req', $sub_req)
                                    ->where('asset_id', $asset_id)->update([
                                            'comp_status' => $req->comp_status,
                                            'comments' => $req->comments,
                                            'title_num' => $title,
                                            'sub_req' => $sub_req,
                                            'last_edited_by' => $user_id,
                                            'last_edited_at' => Carbon::now()->format('Y-m-d H:i:s')
                                        ]);

                            }

                        }




                        $mysessionreq = $req->session()->get('main_req_num');

                        return redirect()->route(
                            'pci_sec_2_2_req',
                            ['main_req_num' => $mysessionreq, 'title' => $title, 'proj_id' => $proj_id, 'user_id' => $user_id, 'asset_id' => $asset_id]
                        )
                            ->with('success', 'Record Updated Successfully');
                    }
                }
            }
            return redirect()->route('assigned_projects', ['user_id' => auth()->user()->id]);
        }
    }


}

