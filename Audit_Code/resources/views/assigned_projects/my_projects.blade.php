@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center mb-4">Projects where roles are assigned to me</h1>




<table class="table table-responsive table-hover mt-4" id="myTable">
    <thead>
        <tr >
            <th style="text-align: center">Project Name</th>
            <th style="text-align: center">Project type</th>
            <th style="text-align: center">Project status</th>
            <th style="text-align: center">Project Permissions</th>
            <th style="text-align: center">Edit Project</th>
            <th style="text-align: center">Project Visuals</th>
             <th style="text-align: :center">Risk Visuals</th>
            <th style="text-align: center">Reports</th>
        </tr>
    </thead>
    <tbody>
      @foreach($projects as $pro)
      <tr style="text-align: center;vertical-align:middle">
        <td> <a href="/iso_sections/{{$pro->project_code}}/{{auth()->user()->id}}"> {{$pro->project_name}}</a> </td>
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

        <a href="/ai_wizard/{{$pro->project_code}}/{{auth()->user()->id}}"
            data-toggle="tooltip" data-placement="top" title="Edit Project details">
        <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
        </a>
        </td>

        <td>
            <a href="/dashboard/{{$pro->project_code}}/{{auth()->user()->id}}"
                data-toggle="tooltip" data-placement="top" title="View Project Dashboard">
            <i class="fas fa-tachometer-alt fa-lg" style="color: #124903;"></i>
            </a>
        </td>

      <td>

        <a href="/ai_wizard/{{$pro->project_code}}/{{auth()->user()->id}}"
            data-toggle="tooltip" data-placement="top" title="Edit Project details">
        <i class="fas fa-chart-line fa-lg" style="color: #124903;"></i>
        </a>
        </td>




        <td>
            <a href="/reports/{{$pro->project_code}}/{{auth()->user()->id}}"
                data-toggle="tooltip" data-placement="top" title="Project Report">
            <i class="fas fa-copy fa-lg" style="color: #124903;"></i>
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
