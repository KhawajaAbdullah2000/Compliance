@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Edit Associate Qsa info for project id: {{$ass_qsa->project_id}}</h4>
        <form method="post"
         action="/v3_2_editform_associate_qsa/{{$ass_qsa->assessment_id}}/{{$ass_qsa->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Associate Qsa Name:</label>
                <input type="text" class="form-control" id="" name='qsa_name' value="{{old('qsa_name',$ass_qsa->qsa_name)}}">
                @if($errors->has('qsa_name'))
                <div class="text-danger">{{ $errors->first('qsa_name') }}</div>
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
