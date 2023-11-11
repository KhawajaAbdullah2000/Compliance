@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id: {{$project_id}} Project name: {{$project_name}} Section2.4 Statement of Applicability</h1>

    <div class="row text-center justify-content-center full-img-subsections">
        <div class="row mt-2">
        <div class="col-12">
         <a href="/iso_sec2_4_a5/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:5-Organizational Controls</p></a>
        </div>
        </div>

        {{-- Section1.2 --}}
        <div class="row">
            <div class="col-12">
                <a href="/iso_sec2_4_a6/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:6-People Controls</p></a>

            </div>
        </div>

{{-- Section1.4 in documnet --}}
<div class="row">
           <div class="col-12">
            <a href="/iso_sec2_4_a7/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:7-Physical Controls</p></a>
           </div>
        </div>
{{--
        Section 1.5 in socument --}}
<div class="row mb-2">

           <div class="col-12">
            <a href="/iso_sec2_4_a8/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Annex A:8-Technological Controls</p></a>
           </div>
        </div>





    </div>


</div>



@endsection
