
@extends('master')

@section('content')


{{-- <div class="container">

<h1 class="text-center mt-3">Login</h1>






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


</div> --}}



<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="{{asset('/login.jpg')}}"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-6 col-lg-5 col-xl-5 offset-xl-1 mt-5">
        <form method="post" action='/login'>
          @csrf
          <!-- Email input -->
          <div class="form-outline mb-3">
            <input type="email" id="form1Example13" class="form-control form-control-lg" placeholder="Email" name="email" value="{{ old('email') }}" />
          </div>
          @if($errors->has('email'))
          <div class="text-danger">{{ $errors->first('email') }}</div>
      @endif

          <!-- Password input -->
          <div class="form-outline mb-1">
            <input type="password" id="form1Example23" class="form-control form-control-lg" placeholder="Password" name="password" />
          </div>
          @if($errors->has('password'))
          <div class="text-danger">{{ $errors->first('password') }}</div>
      @endif

          <div class="mb-4">
    
            <a href="{{route('password.request')}}">Forgot password?</a>
          </div>

          <div class="text-center">
          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-md">Sign in</button>
        </div>



        </form>
      </div>
    </div>
  </div>
</section>



















@section('scripts')

@if(Session::has('sweetalert'))
<script>
    swal({
  title: "You are logged out",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script> 
@endif

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script> 
@endif

@endsection

@endsection