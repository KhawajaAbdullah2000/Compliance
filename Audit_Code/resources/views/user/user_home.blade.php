@extends('master')

@section('content')
    
@include('user-nav')

<div class="mx-5">
    <h2>Welcome {{auth()->user()->first_name}}</h2>

    <br>
<a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>
</div>


@section('scripts')
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

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script> 
@endif


@endsection

@endsection


