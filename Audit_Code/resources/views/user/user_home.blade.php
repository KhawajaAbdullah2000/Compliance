@extends('master')

@section('content')
    
@include('user-nav')

<div class="mx-5">
    <h2>Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2>

    <br>
<a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>
</div>


@role('end user')
<div class="container">
<h3 class="mt-4">Email: {{auth()->user()->email}}</h3>
<h3 class="mt-4">Global roles: @foreach (auth()->user()->permissions as $per)
                     {{ $per->name}}
                     @unless ($loop->last), @endunless
                      @endforeach
</h3>

@can('Project Creator')

 <a href="/create_project/{{auth()->user()->id}}" class='btn btn-primary'>Create new project</a>
@endcan


</div>
@endrole


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


