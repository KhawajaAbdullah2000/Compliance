@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h2 class="text-center">
        Section 3.5 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>


<div class="row">

    <div class="col-md-12">

        <div class="card mt-2">
            <div class="card-header bg-primary text-center">
                <h2>Connected entities for payment processing and transmission</h2>
              </div>
            <div class="card-body">


        <form action="/v3_2_s3_3_5_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Identify a Processing and Transmitting Entity </label>
                    <textarea name="requirement1" cols="70" rows="5" class="form-control">{{old('requirement1')}}</textarea>
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>



        <div class="form-group col-md-6 mt-2">
            <label for="type" class="form-label">Directly Conected?</label>
            <select class="boxstyling bg-primary form-select fw-bold" name="requirement2">
                <option value="yes" {{ old('requirement2') == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('requirement2') == 'no' ? 'selected' : '' }}>No</option>
            </select>
            @if($errors->has('requirement2'))
            <div class="text-danger">{{ $errors->first('requirement2') }}</div>
        @endif

        </div>

        <div class="form-group col-md-6 mt-4">
            <label for="type" class="form-label fw-bold">Reason(s) for Connection:</label>
            <label for="processing">Procesing</label>
            <input type="checkbox" id="processing" name="requirement3[]" value="processing"
            @if(is_array(old('requirement3')) && in_array('processing', old('requirement3'))) checked @endif>

            <label for="processing">Transmission</label>
            <input type="checkbox" id="transmission" name="requirement3[]" value="transmission"
            @if(is_array(old('requirement3')) && in_array('transmission', old('requirement3'))) checked @endif>

            @if($errors->has('requirement3'))
            <div class="text-danger">{{ $errors->first('requirement3') }}</div>
        @endif

        </div>

        <div class="form-group mt-3">
            <label for="">Description of any discussions/issues between the
                QSA and Processing Entity on behalf of the
                Assessed Entity for this PCI DSS Assessment(if any)
                </label>
                <textarea name="requirement4" cols="70" rows="10" class="form-control">{{old('requirement4')}}</textarea>
            @if($errors->has('requirement4'))
            <div class="text-danger">{{ $errors->first('requirement4') }}</div>
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
