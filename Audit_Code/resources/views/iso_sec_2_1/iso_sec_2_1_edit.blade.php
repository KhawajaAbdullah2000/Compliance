@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    @if($errors->has('applicability'))
    <div class="text-danger">{{ $errors->first('applicability') }}</div>
@endif



<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card mt-2">
            <div class="card-header my_bg_color text-white text-center">
                <h3>View/Edit Service or Asset</h3>
              </div>
            <div class="card-body">

        <form action="/iso_sec_2_1_submit_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group mt-4">
                <label for="">Service Name</label>
                <input type="text" name="s_name" class="form-control" value="{{old('s_name',$data->s_name)}}"></input>
                @if($errors->has('s_name'))
                <div class="text-danger">{{ $errors->first('s_name') }}</div>
            @endif
              </div>

            <div class="form-group mt-4">
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




              <div class="text-center">
                <button type="submit" class="btn my_bg_color text-white btn-md mt-2">Save Changes</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>




@endsection
