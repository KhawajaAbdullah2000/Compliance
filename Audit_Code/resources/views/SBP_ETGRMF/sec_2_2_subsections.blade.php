@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
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

    <div class="row h-100 w-75">
        <div class="row mt-2" >
            <div class="col-12">

         <a href="/sbp_etgrmf_section_2_2/{{1}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">1. INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)</p></a>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
         <a href="/sbp_etgrmf_section_2_2/{{2}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">2. INFORMATION SECURITY</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/sbp_etgrmf_section_2_2/{{3}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">3. IT SERVICES DELIVERY & OPERATIONS MANAGEMENT</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/sbp_etgrmf_section_2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">4. ACQUISITION & IMPLEMENTATION OF IT SYSTEMS</p></a>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
         <a href="/sbp_etgrmf_section_2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5. BUSINESS CONTINUITY AND DISASTER RECOVERY</p></a>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
         <a href="/sbp_etgrmf_section_2_2/{{6}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">6. IT AUDIT</p></a>
        </div>
        </div>

    </div>

</div>




@endsection
