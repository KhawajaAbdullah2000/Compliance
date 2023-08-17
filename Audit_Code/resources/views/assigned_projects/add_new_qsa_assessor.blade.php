@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Add new Assessor for project id: {{$project_id}}</h4>
        <form method="post" action="/v3_2_s1_associate_qsa/{{$project_id}}/{{auth()->user()->id}}">
            @csrf
            <div class="form-group">
                <label for="name">Associate Qsa name:</label>
                <input type="text" class="form-control" id="" name='qsa_name' value="{{old('qsa_name')}}">
                @if($errors->has('qsa_name'))
                <div class="text-danger">{{ $errors->first('qsa_name') }}</div>
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
