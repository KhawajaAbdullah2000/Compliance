@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h3 class="text-center fw-bold mb-3">Project name: {{$project_name}}</h3>
    @if($errors->has('applicability'))
    <div class="text-danger">{{ $errors->first('applicability') }}</div>
@endif



<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card mt-2">
            <div class="card-header my_bg_color text-white text-center">
                <h2>Add New Asset</h2>
              </div>
            <div class="card-body">

        <form action="/new_iso_sec_2_1/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Asset Group Name:</label>
                    <input type="text" name="g_name" class="form-control">{{old('g_name')}}</input>
                @if($errors->has('g_name'))
                <div class="text-danger">{{ $errors->first('g_name') }}</div>
            @endif
              </div>

                <div class="form-group mt-4">
                <label for="">Asset Name:</label>
                    <input type="text" name="name" class="form-control">{{old('name')}}</input>
                @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Component Name:</label>
                <input type="text" name="c_name"class="form-control">{{old('c_name')}}</input>
                @if($errors->has('c_name'))
                <div class="text-danger">{{ $errors->first('c_name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Owner Dept:</label>
                <input type="text" name="owner_dept" class="form-control">{{old('owner_dept')}}</input>
                @if($errors->has('owner_dept'))
                <div class="text-danger">{{ $errors->first('owner_dept') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Physical Location:</label>
                <input type="text" name="physical_loc" class="form-control">{{old('physical_loc')}}</input>
                @if($errors->has('physical_loc'))
                <div class="text-danger">{{ $errors->first('physical_loc') }}</div>
            @endif
              </div>


              <div class="form-group mt-4">
                <label for="">Asset Logical Location:</label>
                <input type="text" name="logical_loc" class="form-control">{{old('logical_loc')}}</input>
                @if($errors->has('logical_loc'))
                <div class="text-danger">{{ $errors->first('logical_loc') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Service Name for which this is an underlying asset:</label>
                <input type="text" name="s_name" class="form-control">{{old('s_name')}}</input>
                @if($errors->has('s_name'))
                <div class="text-danger">{{ $errors->first('s_name') }}</div>
            @endif
              </div>


              <div class="text-center mt-3 fw-bold">
                <button type="submit" class="btn my_bg_color btn-md mt-2 text-white">Submit </button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>




@endsection
