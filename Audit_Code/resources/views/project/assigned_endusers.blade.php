
@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-4">Assigned End Users</h1>



    <!-- Project and User Details -->
    <div class="row mb-5">
        <!-- Project Details -->
        <div class="col-lg-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <h5 class="fw-bold">Project Details</h5>
                <p><span class="fw-semibold">Project Name: </span>{{ $project->project_name }}</p>
                <p><span class="fw-semibold">Project Type: </span>{{ $project->type }}</p>
                <p><span class="fw-semibold">Project Status: </span>{{ $project->status }}</p>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-lg-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <h5 class="fw-bold">Your Details</h5>
                <p><span class="fw-semibold">Your Email: </span>{{ auth()->user()->email }}</p>
                <p><span class="fw-semibold">Organization Name: </span>{{ auth()->user()->organization->name }}</p>
                <p><span class="fw-semibold">Sub-Organization: </span>{{ auth()->user()->organization->sub_org }}</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center mb-4">
    
        <a class="btn btn-success btn-md" href="/assign_end_user/{{$project_id}}">
            <i class="fas fa-plus"></i> Assign a new End User
        </a>
    </div>
    <!-- Assigned Users Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered text-center align-middle" id="myTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Permissions</th>
                        <th class="text-center">Assign User Permissions</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($endusers as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>
                            @php
                            $permissions = json_decode($user->project_permissions);
                            @endphp
                            @foreach ($permissions as $per)
                                {{ $per }} @unless($loop->last), @endunless
                            @endforeach
                        </td>
                        <td>
                            <a href="/edit_permissions/{{ $project_id }}/{{ $user->assigned_enduser }}" 
                               class="text-success" data-toggle="tooltip" title="Edit Permissions">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                        </td>
                        <td>
                            <a href="/delete_user/{{ $project_id }}/{{ $user->assigned_enduser }}" 
                               class="text-danger" data-toggle="tooltip" title="Delete User">
                                <i class="fas fa-trash fa-lg"></i>
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
                searchPlaceholder: "Search users...",
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
