@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Add new Assessor Quality Assurance (QA) for project id: {{$project_id}}</h4>
        <form method="post" action="/v3_2_s1_qa_insert/{{$project_id}}/{{auth()->user()->id}}">
            @csrf

            <div class="form-group">
                <label for="name"> QA name:</label>
                <input type="text" class="form-control" id="" name='reviewer_name' value="{{old('reviewer_name')}}">
                @if($errors->has('reviewer_name'))
                <div class="text-danger">{{ $errors->first('reviewer_name') }}</div>
            @endif
              </div>

              <div class="form-group">
                  <label for="name">QA Email:</label>
                  <input type="text" class="form-control" id="" name='reviewer_email' value="{{old('reviewer_email')}}">
                  @if($errors->has('reviewer_email'))
                  <div class="text-danger">{{ $errors->first('reviewer_email') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">QA Phone:</label>
                  <input type="text" class="form-control" id="" name='reviewer_phone' value="{{old('reviewer_phone')}}">
                  @if($errors->has('reviewer_phone'))
                  <div class="text-danger">{{ $errors->first('reviewer_phone') }}</div>
              @endif
                </div>



                <div class="text-center mt-2">
                  <button type="submit" class="btn btn-primary btn-md">Add Asssociate QSA</a>
                </div>



        </form>

    </div>
</div>

        </div>
    </div>

</div>





@endsection
