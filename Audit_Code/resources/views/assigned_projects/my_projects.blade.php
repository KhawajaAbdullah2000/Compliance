

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Risk and Compliance Projects of Organization: {{auth()->user()->organization->name}}</h1>

    <!-- Projects Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered text-center " id="myTable">
                <thead class="table-dark">
                    <tr >
                        <th style='text-align:center'>Project Name</th>
                        <th style='text-align:center'>Project Type</th>
                        <th style='text-align:center'>Project Status</th>
                        <th style='text-align:center'>Project Permissions</th>
                        <th style='text-align:center'>Edit Project</th>
                     <th>Risk & Compliance Heatmap</th> 
                        <th style='text-align:center'>Project Visuals</th>
                        <th style='text-align:center'>Risk Visuals</th>
                        <th style='text-align:center'>Risk Distribution</th>
                        <th style='text-align:center'>Reports</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $pro)
                    <tr style='text-align:center'>
                        <!-- Project Name -->
                        <td>
                            <a href="/iso_sections/{{ $pro->project_code }}/{{ auth()->user()->id }}" class="text-primary text-reset fw-bold">
                                {{ $pro->project_name }}
                            </a>
                        </td>

                        <!-- Project Type -->
                        <td>{{ $pro->type }}</td>

                        <!-- Project Status -->
                        <td> <p data-bs-toggle="tooltip" title="{{$pro->status}}">
                            <i style="color: blueviolet;" class="fas fa-inbox fa-lg"></i> </p></td>

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
                             <td>
                                <a href="/risk_compliance_heatmap/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="Risk and Compliance Heatmap">
                                    <i class="fas fa-bars fa-lg text-warning"></i>
                                </a>
                            </td>

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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

</script>

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
