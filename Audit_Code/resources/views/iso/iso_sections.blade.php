@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h2 class="text-center mb-5 fw-bold"> {{$project_name}}Sections</h2>

    <div class="row text-center justify-content-center full-img h-100 w-100 d-inline-block">

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section 2.1- Services and/or Assets in Scope</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section 2.2- Mandatory Requirements</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section 2.3- Information Security Risk Treatment</p></a>
        </div>
        </div>

         {{-- <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_sec_2_3_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2.3.1- Information Security Risk Assessment And Treatment</p></a>
        </div>
        </div> --}}

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section 2.4- Statement of Applicability</p></a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





    </div>

</div>




@endsection
