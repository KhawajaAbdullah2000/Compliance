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
         <a href="/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Upload or enter evidence against the mandatory requirements of ISO 27001:2022</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_3/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Undertake information security risk assessment on the Services and/or Assets</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/risk_treatment/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Undertake information security risk treatment on the Services and/or Assets</p></a>
        </div>
        </div>

         {{-- <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_sec_2_3_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white"><p class="fw-bold">Section2.3.1- Information Security Risk Assessment And Treatment</p></a>
        </div>
        </div> --}}

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Create or Edit Statement of Applicability</p></a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white">Section1</a> --}}



    </div>

</div>




@endsection
