@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Edit Assessor info for project id: {{$qa->project_id}}</h4>
        <form method="post" action="/v3_2_s1_qa_edit_form_submit/{{$qa->assessment_id}}/{{$qa->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Qa name:</label>
                <input type="text" class="form-control" id="" name='reviewer_name' value="{{old('reviewer_name',$qa->reviewer_name)}}">
                @if($errors->has('assessor_name'))
                <div class="text-danger">{{ $errors->first('assessor_name') }}</div>
            @endif
              </div>

              <div class="form-group">
                  <label for="name">Qa email:</label>
                  <input type="text" class="form-control" id="" name='reviewer_email' value="{{old('reviewer_email',$qa->reviewer_email)}}">
                  @if($errors->has('reviewer_email'))
                  <div class="text-danger">{{ $errors->first('reviewer_email') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">QA phone: </label>
                  <input type="text" class="form-control" id="" name='reviewer_phone' value="{{old('reviewer_phone',$qa->reviewer_phone)}}">
                  @if($errors->has('reviewer_phone'))
                  <div class="text-danger">{{ $errors->first('reviewer_phone') }}</div>
              @endif
                </div>


                <div class="text-center mt-2">
                  <button type="submit" class="btn btn-primary btn-md">Edit details</a>
                </div>



        </form>

    </div>
</div>

        </div>
    </div>

</div>





@endsection
