@extends('master')

@section('content')

<div class="container">

    <h1 class="text-center mt-3">Reset Password</h1>
    
    @if(Session::has('status'))
    <h3 class="text-danger">{{Session::get('status')}}</h3>
    @endif

        
    @if(Session::has('email'))
    <h3 class="text-danger">{{Session::get('email')}}</h3>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
    <form method="post" action='/forgot-password'>
        @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" placeholder="Enter email" name="email" value="{{ old('email') }}" >
        </div>
    
        @if($errors->has('email'))
        <div class="text-danger">{{ $errors->first('email') }}</div>
    @endif
    
    
        <button type="submit" class="btn btn-primary mt-3">Send Reset password link</button>
      </form>
    </div>
    </div>
    
    
    </div>

@endsection