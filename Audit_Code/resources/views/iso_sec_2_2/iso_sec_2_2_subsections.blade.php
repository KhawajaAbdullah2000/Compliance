@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h1 class="text-center">Project id {{$project_id}} {{$project_name}} Sections</h1>

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
         <a href="/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">6- Planning</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_sec_2_3/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">7- Support</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">8- Operation</p></a>
        </div>
        </div>


        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">9- Performance Evaluation</p></a>
        </div>
        </div>


        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-25"><p class="fw-bold">10- Improvement</p></a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





    </div>

</div>




@endsection
