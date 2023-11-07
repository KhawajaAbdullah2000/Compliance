@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.12 Disclosure summary for "In Place with Compensating Control" responses</h2>

    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>summary for "In Place with Compensating Control" responses</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s4_4_12_yes_no_editform/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="">Identify whether there were any responses indicated as “In Place with Compensating Control.” </label>
                    <div class="col-6">
                    <select class="boxstyling bg-primary rounded form-select" name="requirement1" id="requirement1">
                    <option value="">Select yes/no</option>
                    <option value="yes" {{old('requirement1',$data->requirement1)=='yes'? 'selected':''}}>Yes</option>
                    <option value="no" {{old('requirement1',$data->requirement1)=='no'? 'selected':''}}>No</option>
                </select>
            </div>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
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


{{-- //dependemt form --}}


@endsection

