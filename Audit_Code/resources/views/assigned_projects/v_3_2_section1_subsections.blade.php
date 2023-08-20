@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id: {{$project_id}} Project name: {{$project_name}} Section1 Subsections</h1>

    <div class="row text-center justify-content-center">
        <div class="col-6">
            {{-- section 1.1 --}}
         <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section 1- 1.1: Contact Information</a>
{{--
         Section 1.2 --}}
        </div>
           <div class="col-6">
            <a href="/v3_2_s1_1_2/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1- 1.2: Date and timeframe of assessment</a>
           </div>

           <div class="col-6 mt-3">
            <a href="" class="btn btn-lg btn-warning">Section1- 1.3</a>
           </div>

           <div class="col-6 mt-3">
            <a href="" class="btn btn-lg btn-warning">Section1- 1.4:</a>
           </div>




    </div>


</div>



@endsection
