@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('root_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
    
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
        <a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>

      </div>
    </nav>

    <div class="card mt-4 shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <h3 class="card-title text-center fw-bold mb-4">Add New Department in {{$org->name}}</h3>
    
            <form class="row g-4" method="POST" action="/add_new_dept/{{$org->id}}">
                @csrf
    
                <!-- Department Name Input -->
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" 
                               name="name" id="name" placeholder="Enter department name" value="{{old('name')}}" required>
                        <label for="name">Department Name</label>
                    </div>
                    @if($errors->has('name'))
                        <div class="text-danger mt-2 small">{{ $errors->first('name') }}</div>
                    @endif
                </div>
    
                <!-- Submit Button -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-semibold">Add Department</button>
                </div>
            </form>
        </div>
    </div>
    
 


</div>
</div>


@section('scripts')

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