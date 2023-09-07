@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.3 Cardholder Data Storage</h2>

    <div class="col-md-12">

        <div class="card-header bg-primary text-center">
            <h2>Cardholder Data Storage</h2>

        </div>

        <div class="card-body">

            <p>Identify and list all databases, tables, and files storing post-authorization cardholder
                data and provide the following details. </p>

            <form method="post" action="/v3_2_s4_4_3_insert/{{$project_id}}/{{auth()->user()->id}}">
                @csrf
                <div class="form-group">
                  <label for="requirement1">Data Store</label>
                  <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                  @if($errors->has('requirement1'))
                  <div class="text-danger">{{ $errors->first('requirement1') }}</div>
              @endif
                </div>

                <div class="form-group mt-2">
                    <label for="requirement2">Files/Tables</label>
                    <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-4" id="description">
                    <label for="requirement3">Cardholder data elements stored </label>
                        <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3')}}"
                         placeholder="for example, PAN, expiry, Name, any elements of SAD, etc">

                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-4" id="description">
                    <label for="requirement4">How data is secured (for example, what type of encryption and strength,
                         hashing algorithm and strength,
                        tokenization,  access controls, truncation, etc.)
                        </label>
                <textarea name="requirement4" id="" cols="100" rows="10" clas="form-control">{{old('requirement4')}}</textarea>
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-4" id="description">
                    <label for="requirement5">How access to data stores is logged
                        (description of logging mechanism used for logging access to data—for example,
                         describe the enterprise log management solution, application-level logging, operating system
                          logging, etc. in place)
                        </label>
                <textarea name="requirement5" id="" cols="100" rows="10" clas="form-control">{{old('requirement5')}}</textarea>
                    @if($errors->has('requirement5'))
                    <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                @endif
                  </div>


                  <div class="text-center mt-2 mb-2">
                    <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                  </div>


            </form>


        </div>


    </div>
</div>


@endsection
