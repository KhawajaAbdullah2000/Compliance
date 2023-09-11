@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.8 Third-party payment applications/solutions</h2>


    <div class="card-header bg-primary text-center">
        <h2>Add new Third Part</h2>
    </div>


    <div class="card-body">
        <form method="post" action="/v3_2_s4_4_8_insert_party/{{$project_id}}/{{auth()->user()->id}}">
            @csrf
            <div class="form-group">
              <label for="requirement1">Name of Third-Party Payment Application/Solution</label>
              <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
              @if($errors->has('requirement1'))
              <div class="text-danger">{{ $errors->first('requirement1') }}</div>
          @endif
            </div>

            <div class="form-group mt-2">
                <label for="requirement2">Version of Product</label>
                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">

                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement3">PA-DSS validated?</label>
                <select class="boxstyling bg-primary rounded form-select" name="requirement3">
                    <option value="">Select yes/no</option>
                    <option value="yes" {{old('requirement3')=='yes'? 'selected':''}}>Yes</option>
                    <option value="no" {{old('requirement3')=='no'? 'selected':''}}>No</option>
                </select>

                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>



              <div class="form-group mt-2">
                <label for="requirement4">P2PE validated?</label>
                <select class="boxstyling bg-primary rounded form-select" name="requirement4">
                    <option value="">Select yes/no</option>
                    <option value="yes" {{old('requirement4')=='yes'? 'selected':''}}>Yes</option>
                    <option value="no" {{old('requirement4')=='no'? 'selected':''}}>No</option>
                </select>

                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>


              <div class="form-group mt-2">
                <label for="requirement5">PCI SSC listing reference number</label>
                <input type="text" class="form-control" id="requirement5" name='requirement5' value="{{old('requirement5')}}">

                @if($errors->has('requirement5'))
                <div class="text-danger">{{ $errors->first('requirement5') }}</div>
            @endif
              </div>


              <div class="form-group mt-2 col-6">
                <label for="requirement6">Expiry date of listing, if applicable</label>
                <input type="date" class="form-control" name='requirement6' value="{{old('requirement6')}}">
                @if($errors->has('requirement6'))
                <div class="text-danger">{{ $errors->first('requirement6') }}</div>
            @endif
              </div>



              <div class="text-center mt-2">
                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
              </div>


        </form>

    </div>






</div>

@endsection
