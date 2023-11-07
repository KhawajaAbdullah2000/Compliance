@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.13 Disclosure summary for "Not Tested" responses</h2>


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Edit summary for "Not Tested" responses</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s4_4_13_editform/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                @method('PUT')

                  <div class="form-group mt-2">
                    <label for="">Requirement/testing procedure with this result</label>
                <input name="requirement2" class="form-control" value="{{old('requirement2',$data->requirement2)}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2">
                    <label for="">Summary of the issue</label>
                    <br>
                    <textarea name="requirement3" cols="70" rows="10">{{old('requirement3',$data->requirement3)}}</textarea>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
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
