
@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Projects Created By Me</h2>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover text-center align-middle" id="myTable">
                <thead class="table-dark">
                    <tr>
                        
                        <th class="text-center">Name</th>
                        <th class="text-center">Creation Date</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Dashboard</th>
                        <th class="text-center">Reports</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $pro)
                    <tr>
                        
                        <td class="text-center align-middle">
                            <a href="/edit_project/{{ $pro->project_id }}" class="fw-bold text-reset text-underline">{{ $pro->project_name }}</a>
                        </td>
                        
                        <td class="text-center align-middle">{{ $pro->project_creation_date }}</td>
                        <td class="text-center align-middle">{{ $pro->type }}</td>
                        <td class="text-center align-middle">{{ $pro->status }}</td>
                        <td class="text-center align-middle">
                            <a href="/edit_project/{{ $pro->project_id }}" data-toggle="tooltip" data-placement="top" title="Edit Project">
                                <i class="fas fa-edit fa-lg text-success"></i>
                            </a>
                        </td>
                        <td class="text-center align-middle">
                            <a href="/dashboard/{{ $pro->project_id }}/{{ auth()->user()->id }}" data-toggle="tooltip" data-placement="top" title="View Project Dashboard">
                                <i class="fas fa-tachometer-alt fa-lg text-primary"></i>
                            </a>
                        </td>
                        <td class="text-center align-middle">
                            <a href="/reports/{{ $pro->project_id }}/{{ auth()->user()->id }}" data-toggle="tooltip" data-placement="top" title="Project Report">
                                <i class="fas fa-copy fa-lg text-warning"></i>
                            </a>
                        </td>
                        <td class="text-center align-middle">
                            <a href="/delete_my_project/{{ $pro->project_id }}/{{ auth()->user()->id }}" data-toggle="tooltip" data-placement="top" title="Delete Project">
                                <i class="fas fa-trash fa-lg text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif

@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}",
        icon: "error",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif

<!-- DataTables Script -->
<script>
   $(document).ready(function () {
    $('#myTable').DataTable({
        language: {
            searchPlaceholder: "Search projects...",
            search: "_INPUT_",
        },
        paging: true,
        ordering: false,
        info: true,
        lengthChange: false,
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

</script>

@endsection

@endsection
