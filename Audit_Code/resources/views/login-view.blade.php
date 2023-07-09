
@extends('master')

@section('content')
    


<div class="container">

<h1 class="text-center mt-3">Login</h1>

@if(Session::has('error'))
<h3 class="text-danger">{{Session::get('error')}}</h3>
@endif

@if(Session::has('status'))
<h3 class="text-secondary">{{Session::get('status')}}</h3>
@endif
<div class="row justify-content-center">
    <div class="col-md-6">
<form method="post" action='/login'>
    @csrf
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" placeholder="Enter email" name="email" value="{{ old('email') }}" >
    </div>

    <div class="form-group">
    <small><a href="{{route('password.request')}}">Forgot password</a></small>
      </div>

    @if($errors->has('email'))
    <div class="text-danger">{{ $errors->first('email') }}</div>
@endif

    <div class="form-group">
      <label for="exampleInputPassword1" class="mt-3">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
    </div>
    @if($errors->has('password'))
    <div class="text-danger">{{ $errors->first('password') }}</div>
@endif

    <button type="submit" class="btn btn-primary mt-3">Submit</button>
  </form>
</div>
</div>


</div>


    
@endsection