

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Projects Where Roles Are Assigned to Me</h1>

    <!-- Projects Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered text-center align-middle" id="myTable">
                <thead class="table-dark">
                    <tr>
                        <th>Project Name</th>
                        <th>Project Type</th>
                        <th>Project Status</th>
                        <th>Project Permissions</th>
                        <th>Edit Project</th>
                        {{-- <th>Risk & Compliance Heatmap</th> --}}
                        <th>Project Visuals</th>
                        <th>Risk Visuals</th>
                        <th>Risk Distribution</th>
                        <th>Reports</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $pro)
                    <tr>
                        <!-- Project Name -->
                        <td>
                            <a href="/iso_sections/{{ $pro->project_code }}/{{ auth()->user()->id }}" class="text-primary text-reset fw-bold">
                                {{ $pro->project_name }}
                            </a>
                        </td>

                        <!-- Project Type -->
                        <td>{{ $pro->type }}</td>

                        <!-- Project Status -->
                        <td>{{ $pro->status }}</td>

                        <!-- Project Permissions -->
                        <td>
                            @php
                            $permissions = json_decode($pro->project_permissions);
                            @endphp
                            @foreach ($permissions as $per)
                                {{ $per }}@unless($loop->last), @endunless
                            @endforeach
                        </td>

                        <!-- Edit Project -->
                        <td>
                            <a href="/iso_sections/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Edit Project">
                                <i class="fas fa-edit fa-lg text-success"></i>
                            </a>
                        </td>

                             <!-- Risk and Compliance Heatmap -->
                             {{-- <td>
                                <a href="/risk_compliance_heatmap/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="Risk and Compliance Heatmap">
                                    <i class="fas fa-bars fa-lg text-warning"></i>
                                </a>
                            </td> --}}

                        <!-- Project Visuals -->
                        <td>
                            <a href="/dashboard/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="View Project Dashboard">
                                <i class="fas fa-tachometer-alt fa-lg text-info"></i>
                            </a>
                        </td>

                        <!-- Risk Visuals -->
                        <td>
                            <a href="/ai_wizard/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Risk Visuals">
                                <i class="fas fa-chart-line fa-lg text-warning"></i>
                            </a>
                        </td>

                        <!-- Risk Distribution -->
                        <td>
                            <a href="/risk_computation/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Risk Distribution">
                                <i class="fas fa-calculator fa-lg text-primary"></i>
                            </a>
                        </td>

                        <!-- Reports -->
                        <td>
                            <a href="/reports/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Project Report">
                                <i class="fas fa-copy fa-lg text-danger"></i>
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

<script>
    // Initialize DataTable
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
