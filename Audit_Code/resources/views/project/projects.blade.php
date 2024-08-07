@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h2 class="text-center fw-bold">Projects Created By Me</h2>

<table class="table table-responsive table-hover mt-4" id="myTable">
    <thead>
        <tr>
            <th style="text-align:center;">Project ID</th>
            <th style="text-align:center;">Name</th>
            <th style="text-align:center;">Creation date</th>
            <th style="text-align:center;">Type</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">My Permissions</th>
            <th style="text-align:center;">Edit Project Name,Type,Status</th>
            <th style="text-align:center;">Dashboard</th>
            <th style="text-align:center;">Reports</th>
            <th style="text-align:center;">Delete</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($projects as $pro)

        <tr style="text-align:center;">
            <td>{{$pro->project_id}}</td>
            <td><a href="/edit_project/{{$pro->project_id}}">{{$pro->project_name}}</a></td>

            <td>{{$pro->project_creation_date}}</td>
            <td>{{$pro->type}}</td>
            <td>{{$pro->status}}</td>
            <td>Creator</td>
            <td>

        <a href="/edit_project/{{$pro->project_id}}"
            data-toggle="tooltip" data-placement="top" title="Edit Project details">
        <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
        </a>
                {{-- <a href="/edit_my_project/{{$pro->project_id}}" class="btn btn-warning btn-sm">Edit</a> --}}
                {{-- <a href="/assigned_endusers/{{$pro->project_id}}" class="btn btn-warning btn-dark">End users Assigned</a> --}}
            </td>
            <td>
                <a href="/dashboard/{{$pro->project_id}}/{{auth()->user()->id}}"
                    data-toggle="tooltip" data-placement="top" title="View Project Dashboard">
                <i class="fas fa-tachometer-alt fa-lg" style="color: #124903;"></i>

                </a>
            </td>

            <td>
                <a href="/reports/{{$pro->project_id}}/{{auth()->user()->id}}"
                    data-toggle="tooltip" data-placement="top" title="Project Report">
                <i class="fas fa-copy fa-lg" style="color: #124903;"></i>
                </a>
            </td>

          <td>
            <a href="/delete_my_project/{{$pro->project_id}}/{{auth()->user()->id}}"
                data-toggle="tooltip" data-placement="top" title="Delete Project">
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
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

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
