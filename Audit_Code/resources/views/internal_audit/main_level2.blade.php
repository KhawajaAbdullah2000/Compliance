
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

    <a href="{{route('iso_sections',[
    'proj_id'=>$project->project_id,
    'user_id'=>auth()->user()->id])}}" class="btn btn-secondary btn-md float-end">Back</a>


        <h3 class="fw-bold mb-4">{{$data[0][1]}}</h3>


        @foreach ($data as $d )
        

        <div class="row mt-2">
            <div class="col-6">
         <a href="/internal_audit_level_2/{{$d[0]}}/{{$d[2]}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align:left;">{{$d[3]}}</p></a>
        </div>
        </div>

        @endforeach

     

   



@endsection