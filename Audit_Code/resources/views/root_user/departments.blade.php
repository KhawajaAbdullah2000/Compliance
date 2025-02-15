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

<h3 class="fw-bold mt-4">Sub-Organizations in {{$org->name}}</h3>
 
<table class="table table-responsive table-striped border rounded">
    <thead class="table-dark">
        <tr>
            <th>Sub-Organization Name</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($departments as $dept)
        <tr>
            <td>{{ $dept->name }}</td>
            <td class="text-center">
                <a href="" class="btn btn-sm btn-warning">Edit</a>
                <a href="" class="btn btn-sm btn-danger">Delete</a>
               
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



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