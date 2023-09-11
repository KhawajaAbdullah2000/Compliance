@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.7 Service providers and other third parties with which the entity
        shares cardholder data or that could affect the security of cardholder data </h2>

        <div class="card-header bg-primary text-center py-2">
            <h2>Insert Service Provider/Third Party</h2>
        </div>


    <div class="card-body">


        <form method="post" action="/v3_2_s4_4_7_insert/{{$project_id}}/{{auth()->user()->id}}">
            @csrf


            <div class="form-group mt-3">
                <label for="requirement1">Company Name</label>
                <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement2">What data is shared</label>
                <br>
                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>



              <div class="form-group mt-2">
                <label for="requirement3">The purpose for sharing the data </label>
                <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3')}}">
                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement4">Status of PCI DSS Compliance</label>
                <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4')}}"
                placeholder="Date of AOC and version #">
                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>



              <div class="text-center mt-2 mb-2">
                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
              </div>


        </form>

    </div>


</div>

@endsection
