

@extends('master')

@section('content')

<section class="vh-100" style="background: linear-gradient(to right, #a96ceb, #2575fc);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <h3 class="mb-4">Sign In</h3>
            
            <form method="post" action="/login">
              @csrf
              
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="email" id="emailInput" class="form-control form-control-lg" placeholder="Email" name="email" value="{{ old('email') }}" />
                @if($errors->has('email'))
                  <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
              </div>
              
              <!-- Password input -->
              <div class="form-outline mb-4">
                <input type="password" id="passwordInput" class="form-control form-control-lg" placeholder="Password" name="password" />
                @if($errors->has('password'))
                  <small class="text-danger">{{ $errors->first('password') }}</small>
                @endif
              </div>
              
              <!-- Forgot Password -->
              <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{route('password.request')}}" class="text-primary">Forgot password?</a>
              </div>
              
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: #2575fc; border: none;">Login</button>
            </form>
            
            <!-- Divider -->
            <hr class="my-4">
      
          </div>
        </div>
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
