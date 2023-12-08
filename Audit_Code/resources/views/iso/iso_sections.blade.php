@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h1 class="text-center">Project id {{$project_id}} {{$project_name}}Sections</h1>

    <div class="row text-center justify-content-center full-img h-100 w-100 d-inline-block">
        <div class="row mt-2">
            <div class="col-12">

         <a href="" class="btn btn-lg btn-warning"><p class="fw-bold">Section1- Project Meta Data</p></a>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2.1- Scope of Assets and Services</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2.2- Mandatory Requirements</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2.3- Information Security Risk Assessment And Treatment</p></a>
        </div>
        </div>

         {{-- <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_sec_2_3_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2.3.1- Information Security Risk Assessment And Treatment</p></a>
        </div>
        </div> --}}

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2.4- Statement of Applicability</p></a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





    </div>

</div>




@endsection
