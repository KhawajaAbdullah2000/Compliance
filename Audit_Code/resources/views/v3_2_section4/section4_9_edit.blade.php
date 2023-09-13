@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.9 Documentation Reviewed</h2>

    <div class="card-header bg-primary text-center py-2">
        <h2>Edit reviewed documen</h2>
    </div>

    <div class="card-body">

        <form method="post" action="/v3_2_s4_4_9_editform/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')

            <div class="form-group mt-3">
                <label for="requirement1">Reference Number  (optional)</label>
                <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1',$data->requirement1)}}">
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement2">Document Name (including version, if applicable)</label>
                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2',$data->requirement2)}}">
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>


              <div class="form-group mt-2">
                <label for="requirement3">Brief description of document purpose</label>
                <br>
                <textarea name="requirement3" id="" cols="100" rows="10" clas="form-control">{{old('requirement3',$data->requirement3)}}</textarea>
                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>

              <div class="form-group mt-2 col-6">
                <label for="requirement4">Document date (latest version date)</label>
                <input type="date" name="requirement4" id="requirement4" class="form-control" value="{{old('requirement4',$data->requirement4)}}">

                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>



              <div class="text-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
              </div>


        </form>

    </div>

</div>
