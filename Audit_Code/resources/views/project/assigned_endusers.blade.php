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
            <th>Name</th>
            <th>Permissions</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      @foreach($endusers as $user)
      <tr>
        <td>{{$user->first_name}} {{$user->last_name}}</td>
      <td>
          @php
          $permissions=json_decode($user->project_permissions) 
          @endphp
           @foreach ($permissions as $per)
           {{$per}},
           @endforeach
      </td>
           <td><a href="/edit_permissions/{{$project_id}}/{{$user->assigned_enduser}}" class="btn btn-warning btn-md">Edit perimissions</a></td>

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

</script>

@endsection


@endsection