@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

    <h1 class="text-center">Assigned End users for {{$project_id}}</h1>
    <a class="btn btn-success btn-md float-end mb-3"
     href="/assign_end_user/{{$project_id}}">Add new to this project<i class="fas fa-plus"></i></a>

<table class="table table-responsive table-hover mt-4" id="myTable">
    <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
       
    </tbody>

</table>

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

<script>

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "search"
    },
      "ordering": false



     } 
     );
     $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

</script>

@endsection


@endsection