@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center mb-4">Assigned End users</h1>
    <a class="btn btn-success btn-md float-end mb-4"
     href="/assign_end_user/{{$project_id}}">Create new user <i class="fas fa-plus"></i></a>


     <div class="row mt-5">
        <div class="col-lg-6 d-flex flex-column align-items-start">
            <p><span class="fw-bold">Project Name: </span>{{$project->project_name}}</p>
            <p><span class="fw-bold">Project Type: </span>{{$project->type}}</p>
            <p><span class="fw-bold">Project Status: </span>{{$project->status}}</p>

        </div>

        <div class="col-lg-6 d-flex flex-column align-items-start">
            <p>Your Email: {{auth()->user()->email}}</p>
            <p>Organization Name: {{auth()->user()->organization->name}}</p>
            <p>Sub-Organization: {{auth()->user()->organization->sub_org}}</p>

        </div>
     </div>


<table class="table table-responsive table-hover mt-4" id="myTable">
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">Name</th>
            <th style="text-align: center;">Permissions</th>
            <th style="text-align: center;">Assign User Permissions</th>
            <th style="text-align: center;">Delete</th>

        </tr>
    </thead>
    <tbody>
      @foreach($endusers as $user)
      <tr style="text-align: center;">
        <td>{{$user->first_name}} {{$user->last_name}}</td>
      <td>
          @php
          $permissions=json_decode($user->project_permissions)
          @endphp
           @foreach ($permissions as $per)
           {{$per}},
           @endforeach
      </td>
     <td>
        <a href="/edit_permissions/{{$project_id}}/{{$user->assigned_enduser}}"
            data-toggle="tooltip" data-placement="top" title="Edit Project details">
        <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
        </a>
        </td>

        <td>
            <a href="/delete_user/{{$project_id}}/{{$user->assigned_enduser}}"
                data-toggle="tooltip" data-placement="top" title="Edit Project details">
            <i class="fas fa-trash fa-lg" style="color:red;"></i>
            </a>
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

</script>

@endsection


@endsection
