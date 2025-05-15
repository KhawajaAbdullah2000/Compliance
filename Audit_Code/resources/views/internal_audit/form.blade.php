
@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


@php
$permissions = json_decode($project_permissions);
$row = $data[0];
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


      <p>Level 1: {{ $row[0] }}</p>
<p>Level 1 Title: {{ $row[1] }}</p>
<p>Level 2: {{ $row[2] }}</p>
<p>Level 2 Title: {{ $row[3] }}</p>
   


@endsection