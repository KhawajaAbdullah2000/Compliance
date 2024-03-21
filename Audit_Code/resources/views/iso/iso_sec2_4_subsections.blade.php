@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

<div class="container">

    <h3 class="text-center mt-5">Project name: {{$project_name}} Section2.4 Statement of Applicability</h3>

    <div class="row text-center justify-content-center full-img-subsections">
        <div class="row mt-2">
        <div class="col-12">
        <a href="/iso_sec2_4_a5_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:5-Organizational Controls</p></a>

        </div>
        </div>

        {{-- Section1.2 --}}
        <div class="row">
            <div class="col-12">

                <a href="/iso_sec2_4_a6_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:6-People Controls</p></a>


            </div>
        </div>


<div class="row">
           <div class="col-12">
            <a href="/iso_sec2_4_a7_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:7-Physical Controls</p></a>
           </div>
        </div>

<div class="row mb-2">

           <div class="col-12">
            <a href="/iso_sec2_4_a8_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:8-Technological Controls</p></a>
           </div>
        </div>





    </div>


</div>



@endsection
