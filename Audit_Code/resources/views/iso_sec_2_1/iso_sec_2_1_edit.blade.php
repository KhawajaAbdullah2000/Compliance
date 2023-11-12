@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h3 class="text-center fw-bold mb-3">Project name: {{$project_name}} Section2.1 Scope of Assets and Services</h3>
    @if($errors->has('applicability'))
    <div class="text-danger">{{ $errors->first('applicability') }}</div>
@endif



<div class="row">

    <div class="col-md-12">

        <div class="card mt-2">
            <div class="card-header bg-primary text-center">
                <h2>Edit Asset {{$data->name}}</h2>
              </div>
            <div class="card-body">

        <form action="/iso_sec_2_1_submit_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="">Asset Group Name:</label>
                    <textarea name="g_name" cols="70" rows="10" class="form-control">{{old('g_name',$data->g_name)}}</textarea>
                @if($errors->has('g_name'))
                <div class="text-danger">{{ $errors->first('g_name') }}</div>
            @endif
              </div>

                <div class="form-group mt-4">
                <label for="">Asset Name:</label>
                    <textarea name="name" cols="70" rows="10" class="form-control">{{old('name',$data->name)}}</textarea>
                @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Component Name:</label>
                    <textarea name="c_name" cols="70" rows="10" class="form-control">{{old('c_name',$data->c_name)}}</textarea>
                @if($errors->has('c_name'))
                <div class="text-danger">{{ $errors->first('c_name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Owner Dept.:</label>
                    <textarea name="owner_dept" cols="70" rows="10" class="form-control">{{old('owner_dept',$data->owner_dept)}}</textarea>
                @if($errors->has('owner_dept'))
                <div class="text-danger">{{ $errors->first('owner_dept') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Physical Location:</label>
                    <textarea name="physical_loc" cols="70" rows="10" class="form-control">{{old('physical_loc',$data->physical_loc)}}</textarea>
                @if($errors->has('physical_loc'))
                <div class="text-danger">{{ $errors->first('physical_loc') }}</div>
            @endif
              </div>


              <div class="form-group mt-4">
                <label for="">Asset Logical Location:</label>
                    <textarea name="logical_loc" cols="70" rows="10" class="form-control">{{old('logical_loc',$data->logical_loc)}}</textarea>
                @if($errors->has('logical_loc'))
                <div class="text-danger">{{ $errors->first('logical_loc') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Service Name for which this is an underlying asset:</label>
                    <textarea name="s_name" cols="70" rows="10" class="form-control">{{old('s_name',$data->s_name)}}</textarea>
                @if($errors->has('s_name'))
                <div class="text-danger">{{ $errors->first('s_name') }}</div>
            @endif
              </div>


              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>




@endsection
