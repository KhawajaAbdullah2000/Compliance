@extends('master')

@section('content')

@include('user-nav')

<div class="container">




    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td>  {{$project->project_name}}
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4 w-75">

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Upload or Enter Services and/or Assets in the scope of this project</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2_from_main/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Upload or enter evidence against the mandatory requirements of Cyber Security Framework - SAMA</p></a>
        </div>
        </div>





    </div>

</div>




@endsection
