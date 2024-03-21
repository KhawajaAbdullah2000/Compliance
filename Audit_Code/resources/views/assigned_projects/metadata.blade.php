@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h2 class="text-center fw-bold">Meta Data for Project: {{$org_data->project_name}}</h2>

    <div class="row">

        <div class="card mb-5">

            <div class="card-body">

    <label>Project ID</label>
   <p class="fw-bold">{{$org_data->project_id}}</p>


   <label>Organization Name: </label>
  <p class="fw-bold">{{$org_data->name}}</p>

  <label>Sub Organization: </label>
  <p class="fw-bold">{{$org_data->sub_org}}</p>

  <label>Country </label>
  <p class="fw-bold">{{$org_data->country}}</p>

  <label>Project Creation Date: </label>
  <p class="badge text-bg-warning">{{date('F d, Y', strtotime($org_data->project_creation_date))}}</p>

  <p>End Users Assigned:</p>


  @foreach($endusers as $user)
  <p > <span class="fw-bold">{{$user->first_name}} {{$user->last_name}}:</span>

      @php
          $permissions = json_decode($user->project_permissions);
      @endphp

      @foreach ($permissions as $index => $per)
          {{$per}}{{ $index < count($permissions) - 1 ? ', ' : ''}}
      @endforeach

  </p>
@endforeach

            </div>
        </div>
    </div>





</div>




@endsection
