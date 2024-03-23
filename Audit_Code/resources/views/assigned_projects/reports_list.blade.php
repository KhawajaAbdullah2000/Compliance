@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h2 class="text-center fw-bold">Reports for {{$project_name}}</h2>

    <div class="row text-center justify-content-center full-img h-100 w-100 d-inline-block">
        <div class="row mt-2">
            <div class="col-12">

         <a href="/assets_in_scope/{{$proj_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Services and/or Assets in Scope</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">

         <a href="/risk_assessment_report/{{$proj_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Risk Assessment by Asset/Service</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">

         <a href="/risk_treatment/{{$proj_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Risk Treatment by Asset/Service</p></a>
        </div>
        </div>








    </div>

</div>







@endsection
