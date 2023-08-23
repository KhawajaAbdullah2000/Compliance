@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id: {{$project_id}} Project name: {{$project_name}} Section2 Subsections</h1>

    <div class="row text-center justify-content-center section2_subsections">
{{-- section2.1 --}}
        <div class="row mt-2">
        <div class="col-12">
         <a href="/v3_2_s2_2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section 2- 2.1: Description of the entity's payment card business</p></a>
        </div>
        </div>

        {{-- Section2.2 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s2_2_2/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section2- 2.2: High-level network diagram(s)</p></a>

            </div>
        </div>


    </div>


</div>



@endsection
