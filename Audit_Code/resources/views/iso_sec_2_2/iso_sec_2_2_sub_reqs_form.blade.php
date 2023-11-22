@extends('master')

@section('content')

@include('user-nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">
    <h1 class="text-center">Project id {{$project_id}} {{$project_name}} </h1>


    <h2 class="text-center fw-bold mt-4 mb-4">
    {{$title}}: Req No. {{$filteredData[0][3]}}
         </h2>

         <p class="fw-bold">ISO 27001:2022 Mandatory Requirement: </p>
        <p>{{$filteredData[0][4]}} </p>

        @isset($result)

        <div class="row">

            <div class="col-md-12">

                <div class="card mt-2">
                    <div class="card-header bg-primary text-center">
                        <h2>Mandatory Requirement</h2>
                      </div>
                    <div class="card-body">

                <form action="/iso_sec_2_2_edit_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for=""> Compliance Status</label>
                        <select class="boxstyling bg-primary form-select" name="comp_status">


             <option value="yes" {{ old('comp_status',$result->comp_status) == 'yes' ? 'selected' : '' }}>Yes</option>
             <option value="no" {{ old('comp_status',$result->comp_status) == 'no' ? 'selected' : '' }}>No</option>
             <option value="partial" {{ old('comp_status',$result->comp_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                            </select>
                            @if($errors->has('comp_status'))
                            <div class="text-danger">{{ $errors->first('comp_status') }}</div>
                        @endif
                      </div>


                      <div class="form-group mt-4">
                        <label for="">Comments (Optional):</label>
                            <textarea name="comments" cols="70" rows="10" class="form-control">{{old('comments',$result->comments)}}</textarea>
                        @if($errors->has('comments'))
                        <div class="text-danger">{{ $errors->first('comments') }}</div>
                    @endif
                      </div>

                      <div class="form-group mt-4">
                        <label for="" class="mb-2">Attachment (Optional)</label>

                        <label class="btn btn-secondary">
                 <input type="file" name="attachment">
                        </label>


                      </div>

                      @isset($result->attachment)
                      <p>  Current Attachment:</p>
                      <img src="{{asset('iso_sec_2_2/'.$result->attachment)}}" alt="Document attached" height="200" width="200">
                      @endisset






                      <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
                      </div>


                </form>

            </div>
        </div>


            </div>
        </div>


        @else


<div class="row">

    <div class="col-md-12">

        <div class="card mt-2">
            <div class="card-header bg-primary text-center">
                <h2>Mandatory Requirement</h2>
              </div>
            <div class="card-body">

        <form action="/iso_sec_2_2_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for=""> Compliance Status</label>
                <select class="boxstyling bg-primary form-select" name="comp_status">
                    <option value="">Select --</option>

     <option value="yes" {{ old('comp_status') == 'yes' ? 'selected' : '' }}>Yes</option>
     <option value="no" {{ old('comp_status') == 'no' ? 'selected' : '' }}>No</option>
     <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    @if($errors->has('comp_status'))
                    <div class="text-danger">{{ $errors->first('comp_status') }}</div>
                @endif
              </div>


              <div class="form-group mt-4">
                <label for="">Comments (Optional):</label>
                    <textarea name="comments" cols="70" rows="10" class="form-control"></textarea>
                @if($errors->has('comments'))
                <div class="text-danger">{{ $errors->first('comments') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="" class="mb-2">Attachment (Optional)</label>

                <label class="btn btn-secondary">
         <input type="file" name="attachment">
                </label>


              </div>




              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>

        @endisset

</div>




@endsection
