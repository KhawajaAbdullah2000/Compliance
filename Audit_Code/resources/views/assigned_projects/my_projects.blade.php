@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">My Assigned Projects</h1>

<table class="table table-responsive table-hover mt-4" id="myTable">
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Project type</th>
            <th>Project status</th>
            <th>Project Permissions</th>
            <th>Edit Project</th>
            <th>View Project Users</th>
        </tr>
    </thead>
    <tbody>
      @foreach($projects as $pro)
      <tr>
        <td>{{$pro->project_name}}</td>
        <td>{{$pro->type}}</td>
        <td>{{$pro->status}}</td>
      <td>
       @php
          $permissions=json_decode($pro->project_permissions)
          @endphp
           @foreach ($permissions as $per)
           {{$per}},
           @endforeach
      </td>
      <td>

        <a href="/iso_sections/{{$pro->project_code}}/{{auth()->user()->id}}"
            data-toggle="tooltip" data-placement="top" title="Edit Project details">
        <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
        </a>
        </td>

        <td>
            <a href="/meta_data/{{$pro->project_code}}/{{auth()->user()->id}}"
                data-toggle="tooltip" data-placement="top" title="View Project Users">
            <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
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
