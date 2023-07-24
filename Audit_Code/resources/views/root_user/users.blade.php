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

    <h1 class="mt-3 mb-3 text-center users">Users</h1>
    
    <table class="table table-responsive table-hover mt-4" id="myTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Organization</th>
                <th>Sub-Organization</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)

            <tr>
                <td>{{$user->first_name}} {{$user->last_name}}</td>
                <td>{{$user->organization_name}}</td>
                <td>{{$user->organizations_sub_org}}</td>
                <td>{{$user->email}}</td>
                @if($user->privilege_id==1)
                <td><h5><span class="badge bg-primary rounded-pill ">{{$user->privilege_name}}</span></h5></td>
                @endif
                @if($user->privilege_id==2)
                <td><h5><span class="badge bg-warning rounded-pill ">{{$user->privilege_name}}</span></h5></td>
                @endif
                @if($user->privilege_id==3)
                <td><h5><span class="badge bg-success rounded-pill ">{{$user->privilege_name}}</span></h5></td>
                @endif

                @if($user->privilege_id==5)
                <td><h5><span class="badge bg-info rounded-pill ">{{$user->privilege_name}}</span></h5></td>
                @endif

                <td> <a href="/users/edit/{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit" style="color: #146e02;"></i></a>
                    <a href="" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash" style="color: #d01616;"></i></a>
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "success",
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