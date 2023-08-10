@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

    <h1 class="text-center">Global Custom roles</h1>
    <a class="btn btn-success btn-md float-end mb-3" href="/add_global_role" role="button">Add new <i class="fas fa-plus"></i></a>

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
        @foreach ($permissions as $per)

        <tr>
            <td>{{$per->id}}</td>
            <td>{{$per->name}}</td>
            <td>{{$per->created_at}}</td>
           

     <td> <a href="/edit_global_role/{{$per->id}}" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit" style="color: #146e02;"></i></a>
         <a href="" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash" style="color: #d01616;"></i></a>
     </td>
        </tr>
        @endforeach

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