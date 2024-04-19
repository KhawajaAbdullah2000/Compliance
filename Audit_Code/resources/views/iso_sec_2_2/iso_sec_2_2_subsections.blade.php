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

    <div class="row text-center justify-content-center full-img h-100 w-100 d-inline-block">
        <div class="row mt-2">
            <div class="col-12">

         <a href="/iso_section2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">4- Context Of The Organization</p></a>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">5- Leadership</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{6}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">6- Planning</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{7}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">7- Support</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{8}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">8- Operation</p></a>
        </div>
        </div>


        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{9}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">9- Performance Evaluation</p></a>
        </div>
        </div>


        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">10- Improvement</p></a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





    </div>

</div>




@endsection
