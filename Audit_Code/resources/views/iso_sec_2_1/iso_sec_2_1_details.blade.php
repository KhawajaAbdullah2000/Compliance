@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">

<h3 class="text-center fw-bold mb-3"> Project name: {{$project_name}} </h3>

                   <h3 class="text-center">Asset : {{$data->name}}</h3>


        <div class="row">

            <div class="card mb-5">

                <div class="card-body">

        <label>Asset Group Name</label>
       <p><span class="fw-bold">Answer: </span>{{$data->g_name}}</p>


       <label>Asset Name</label>
      <p><span class="fw-bold">Answer: </span>{{$data->name}}</p>

      <label>Asset Component Name</label>
      <p><span class="fw-bold">Answer: </span>{{$data->c_name}}</p>

      <label>Asset Owner Department</label>
      <p><span class="fw-bold">Answer: </span>{{$data->owner_dept}}</p>

      <label>Asset Physical Location</label>
      <p><span class="fw-bold">Answer: </span>{{$data->physical_loc}}</p>

      <label>Asset LOgical Location</label>
      <p><span class="fw-bold">Answer: </span>{{$data->logical_loc}}</p>

      <label>Service Name for which this is an underlying Asset</label>
      <p><span class="fw-bold">Answer: </span>{{$data->s_name}}</p>


            <label for="">last edited by: </label>
            <span class="badge text-bg-success text-black">{{$data->first_name}} {{$data->last_name}}</span>

               <br>

            <label for="">last edited at: </label>
            <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($data->last_edited_at))}}</span>



        @if(in_array('Data Inputter',$permissions))

        <a href="/iso_sec_2_1_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
            class="float-end btn btn-primary btn-md mx-2">Edit</a>


        @endif

                </div>
            </div>
        </div>




</div>


@endsection
