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



<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card mt-2">
            <div class="card-header my_bg_color text-white text-center">
                <h3>Edit Asset {{$data->name}}</h3>
              </div>
            <div class="card-body">

        <form action="/iso_sec_2_1_submit_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="">Asset Group Name:</label>
                    <input type="text" name="g_name" class="form-control" value="{{old('g_name',$data->g_name)}}"></input>
                @if($errors->has('g_name'))
                <div class="text-danger">{{ $errors->first('g_name') }}</div>
            @endif
              </div>

                <div class="form-group mt-4">
                <label for="">Asset Name:</label>
                <input type="text" name="name" class="form-control" value="{{old('name',$data->name)}}"></input>
                @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Component Name:</label>
                <input type="text" name="c_name"  class="form-control" value="{{old('c_name',$data->c_name)}}"></textarea>
                @if($errors->has('c_name'))
                <div class="text-danger">{{ $errors->first('c_name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Owner Dept.:</label>
                <input type="text" name="owner_dept" class="form-control" value="{{old('owner_dept',$data->owner_dept)}}"></input>
                @if($errors->has('owner_dept'))
                <div class="text-danger">{{ $errors->first('owner_dept') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Physical Location:</label>
                <input type="text" name="physical_loc" class="form-control" value="{{old('physical_loc',$data->physical_loc)}}"></input>
                @if($errors->has('physical_loc'))
                <div class="text-danger">{{ $errors->first('physical_loc') }}</div>
            @endif
              </div>


              <div class="form-group mt-4">
                <label for="">Asset Logical Location:</label>
                <input type="text" name="logical_loc" class="form-control" value=" {{old('logical_loc',$data->logical_loc)}}">
               </input>
                @if($errors->has('logical_loc'))
                <div class="text-danger">{{ $errors->first('logical_loc') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Service Name for which this is an underlying asset:</label>
                <input type="text" name="s_name" class="form-control" value="{{old('s_name',$data->s_name)}}"></input>
                @if($errors->has('s_name'))
                <div class="text-danger">{{ $errors->first('s_name') }}</div>
            @endif
              </div>


              <div class="text-center">
                <button type="submit" class="btn my_bg_color text-white btn-md mt-2">Submit</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>




@endsection
