@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h3 class="text-center fw-bold mb-3">Project id: {{$project_id}} Project name: {{$project_name}} Section2.3.2 Risk Treatment</h3>


    @if($assets->count()>0)

    <form action="/iso_sec2_3_1_find_asset_value/{{$project_id}}/{{auth()->user()->id}}" method="post">
@csrf

<input type="hidden" name="asset_id" value="{{$asset_id}}">


<div class="row">
    <label for="">Select Object of Risk Assesment</label>

<div class="col-lg-6 fw-bold">

<select name="asset" id="" class="form-control">
    <option value="">Select--</option>

    <option value="group+{{$group}}">{{$group}}</option>
    <option value="name+{{$name}}">{{$name}}</option>


    @foreach ($components as $c)
    <option value="component+{{$c->assessment_id}}">{{$c->c_name}}</option>
    @endforeach

</select>

</div>

<div class="col-lg-6">
<button type="submit" class="btn btn-primary btn-md">Select</button>
</div>

</div>

    </form>


@else
<h2>Please add Assets first in section 2.1</h2>
    @endif




</div>

@section('scripts')

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

@endsection



@endsection
