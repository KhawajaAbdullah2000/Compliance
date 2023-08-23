@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id: {{$project_id}} Project name: {{$project_name}} Section1 Subsections</h1>

    <div class="row text-center justify-content-center full-img-subsections h-100 w-100 d-inline-block">
{{-- section1.1 --}}
        <div class="row mt-2">
        <div class="col-12">
         <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section 1- 1.1: Contact Information</a>
        </div>
        </div>

        {{-- Section1.2 --}}
        <div class="row mt-4">
            <div class="col-12">
                <a href="/v3_2_s1_1_2/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1- 1.2: Date and timeframe of assessment</a>

            </div>
        </div>

{{-- Section1.4 in documnet --}}
<div class="row mt-4">
           <div class="col-12">
            <a href="/v3_2_s1_1_4/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1- 1.3: Additional services provided by QSA company</a>
           </div>
        </div>
{{--
        Section 1.5 in socument --}}
<div class="row mt-4 mb-2">

           <div class="col-12">
            <a href="/v3_2_s1_1_5/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1- 1.4: Summary of Findings</a>
           </div>
        </div>





    </div>


</div>



@endsection
