@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <div class="row justify-content-center">

        <div class="col-md-6">

           <h1 class="text-center">Add Date Spent Onsite</h1>

           <form action="/v3_2_s1_1_2_onsite_form/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name"> Date spent Onsite:</label>
                <input type="date" class="form-control" name='date_spent_onsite' value="{{old('date_spent_onsite')}}">
                @if($errors->has('date_spent_onsite'))
                <div class="text-danger">{{ $errors->first('date_spent_onsite') }}</div>
            @endif
              </div>

              <div class="text-center">
                <button type="submit" class="mt-3 btn btn-primary btn-md">Submit details</button>
              </div>


           </form>

        </div>
    </div>

</div>


@endsection
