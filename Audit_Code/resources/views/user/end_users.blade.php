@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">




<h1 class="text-center">End Users</h1>

<table class="table table-responsive table-hover mt-4" id="myTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Organization</th>
            <th>Sub-Organization</th>
            <th>Email</th>
            <th>Global Roles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($end_users as $user)

        <tr>
            <td>{{$user->first_name}} {{$user->last_name}}</td>
            <td>{{$user->organization_name}}</td>
            <td>{{$user->organizations_sub_org}}</td>
            <td>{{$user->email}}</td>
            <td>
            @foreach ($user->permissions as $per)
           {{$per->name}}
           @unless ($loop->last), @endunless
                
            @endforeach
            </td>
         

     <td> <a href="/end_user/edit/{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit" style="color: #146e02;"></i></a>
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
