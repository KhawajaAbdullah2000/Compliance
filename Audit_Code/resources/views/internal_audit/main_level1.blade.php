
@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


@php
$permissions = json_decode($project_permissions);
@endphp
<div class="container my-2">

    <div class="row mt-5">
        <div class="col-lg-12">
         
            @include('components.topTable')
            
        </div>
    </div>



        <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/1/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Planning and Risk Management</p></a>
        </div>
        </div>

         <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/2/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Inspection</p></a>
        </div>
        </div>

         <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/3/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Observation</p></a>
        </div>
        </div>

         <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/4/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Confirmation</p></a>
        </div>
        </div>

         <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/5/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Reperformance</p></a>
        </div>
        </div>

           <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/6/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Analytical Procedures</p></a>
        </div>
        </div>

           <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_1/7/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">Inquiry</p></a>
        </div>
        </div>



@endsection