@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.6 Sample sets for reporting</h2>
    <div class="card-header bg-primary text-center py-2">
        <h2>Insert First Sample Set</h2>
    </div>

    <div class="card-body">


        <form method="post" action="/v3_2_s4_4_6_insert/{{$project_id}}/{{auth()->user()->id}}">
            @csrf


            <div class="form-group">
                <label for="requirement1">Sample Set Reference Number</label>
                <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>

              <div class="form-group mt-2" id="description">
                <label for="requirement2">Sample Type/ Description </label>
                <br>
            <textarea name="requirement2" id="" cols="100" rows="10" clas="form-control">{{old('requirement2')}}</textarea>
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>


              <div class="form-group mt-2" id="requirement3">
                <label for="requirement3">Items in Sample Set</label>
                <br>
            <textarea name="requirement3" id="" cols="100" rows="10" clas="form-control">{{old('requirement3')}}</textarea>
                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>

              <div class="form-group">
                <label for="requirement4">Make/Model of Hardware Components or Version/Release of Software Components</label>
                <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4')}}">
                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>

              <div class="form-group">
                <label for="requirement5">Total Sampled</label>
                <input type="text" class="form-control" id="requirement5" name='requirement5' value="{{old('requirement5')}}">
                @if($errors->has('requirement5'))
                <div class="text-danger">{{ $errors->first('requirement5') }}</div>
            @endif
              </div>


              <div class="form-group">
                <label for="requirement6">Total Population</label>
                <input type="text" class="form-control" id="requirement6" name='requirement6' value="{{old('requirement6')}}">
                @if($errors->has('requirement6'))
                <div class="text-danger">{{ $errors->first('requirement6') }}</div>
            @endif
              </div>

              <div class="text-center mt-2 mb-2">
                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
              </div>


        </form>

    </div>

</div>

@endsection
