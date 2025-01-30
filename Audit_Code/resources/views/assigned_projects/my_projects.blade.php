

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Risk and Compliance Projects of Organization: {{auth()->user()->organization->name}}
        @if(auth()->user()->organization->sub_org)
        
        - {{auth()->user()->organization->sub_org}}
    @endif</h1>

    <!-- Projects Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered text-center" id="myTable">
                <thead class="table-dark">
                    <tr >
                        <th style='text-align:center'>Project Name</th>
                        <th style='text-align:center'>Project Type</th>
                        <th style='text-align:center'>Project Status</th>
                        <th style='text-align:center'>My Permissions on Project</th>
                        <th style='text-align:center'>Data</th>
                        <th style='text-align:center'>Metadata</th>
                        <th style='text-align:center'>View Compliance Map</th>
                        <th style='text-align:center'>View Action Plan</th>
                        <th style='text-align:center'>View Risk Heatmap</th>
                     
                        <th style='text-align:center'>Switch Storage Node</th>

                        {{-- <th style='text-align:center'>Risk & Compliance Heatmap</th>  --}}
                        {{-- <th style='text-align:center'>Drill Down by Service</th>  --}}
                        {{-- <th style='text-align:center'>Project Visuals</th>
                        <th style='text-align:center'>Risk Visuals</th>
                        <th style='text-align:center'>Risk Distribution</th> --}}
                        {{-- <th style='text-align:center'>Reports</th> --}}
                        {{-- <th class="text-center">Compliance Status by Asset Component</th> --}}
               
                        <th class="text-center">Duplicate Project</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $pro)
                    <tr>
                        <!-- Project Name -->
                        <td style='text-align:initial'>
                                {{ $pro->project_name }}
                        </td>

                        <!-- Project Type -->
                        <td style='text-align:initial'>{{ $pro->type }}</td>

                        <!-- Project Status -->
                        <td> <p data-bs-toggle="tooltip" title="{{$pro->status}}">
                            <i style="color: blueviolet;" class="fas fa-inbox fa-lg"></i> </p></td>

                        <!-- Project Permissions -->
                        <td style='text-align:initial'>
                            @php
                            $permissions = json_decode($pro->project_permissions);
                            @endphp
                            @foreach ($permissions as $per)
                                {{ $per }}@unless($loop->last), @endunless
                            @endforeach
                        </td>

                        <!-- Edit Project -->
                        <td style='text-align:center'>
                            <a href="/iso_sections/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Edit Project Data">
                                <i class="fas fa-edit fa-lg text-success"></i>
                            </a>
                        </td>

                            <!-- Edit Project Metadata-->
                            <td style='text-align:center'>
                                @if($pro->created_by==auth()->user()->id)
                                <a href="/edit_project/{{ $pro->project_code }}" data-toggle="tooltip" data-placement="top" title="Edit Project">
                                    <i class="fas fa-edit fa-lg text-secondary"></i>
                                </a>
                                @else
                                <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>


                                @endif
                            </td>
{{-- 
                            Compliance Map - ALlservices all controls --}}
                            <td style='text-align:center'>
                                <a href="/compliance_map_dashboard_all_services/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="Compliance Map for All Services - All Controls">
                                   {{-- <img src="{{asset('compliance_report_icon.jpg')}}" style="width:30px;height:30px;"></img> --}}
                                   <i class="fas fa-cloud fa-lg" style="color: red"></i>
                                </a>
                            </td>


                            {{-- Action Plan --}}
                            <td style='text-align:center'>
                                <a href="/action_plan/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="Action Plan">
                                    <i class="fas fa-book fa-lg text-warning"></i>
                                </a>
                            </td>

                               {{-- Risk Heatmap --}}
                               <td style='text-align:center'>
                                <a href="/heatmap_all_services_all_risks/{{$pro->project_code}}/{{auth()->user()->id}}" 
                                   data-toggle="tooltip" title="View Risk Heatmap">
                                   <i class="fas fa-chart-area text-success" style="font-size: 1.8em;"></i>

                                </a>
                            </td>

                               {{-- Statement of Applicability --}}
                               {{-- <td style='text-align:center'>
                                <a href="/" 
                                   data-toggle="tooltip" title="View Statement of Applicability">
                                   <i class="fas fa-caret-square-up" style="font-size: 1.7em;"></i>

                                </a>
                            </td> --}}

                               {{-- Storage Node --}}
                               <td style='text-align:center'>

                                <select name="" id="">
                                    <option value="">Storage 1</option>
                                    <option value="">Storage 2</option>
                                </select>
                            </td>








                             <!-- Risk and Compliance Heatmap -->
                             {{-- <td style='text-align:center'>
                                <a href="/risk_compliance_heatmap/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="Risk and Compliance Heatmap">
                                    <i class="fas fa-book fa-lg text-warning"></i>
                                </a>
                            </td> --}}

                               <!-- Drill down by service -->
                               {{-- <td style='text-align:center'>
                                <a href="/drill_down_by_service/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="Drill down by service">
                                    <i class="fas fa-eye fa-lg" style="color: rgb(181, 48, 0)"></i>
                                </a>
                            </td> --}}

                        <!-- Project Visuals -->
                        {{-- <td style='text-align:center'>
                            <a href="/dashboard/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="View Project Dashboard">
                                <i class="fas fa-tachometer-alt fa-lg text-info"></i>
                            </a>
                        </td> --}}

                        <!-- Risk Visuals -->
                        {{-- <td style='text-align:center'>
                            <a href="/ai_wizard/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Risk Visuals">
                                <i class="fas fa-chart-line fa-lg text-warning"></i>
                            </a>
                        </td> --}}

                        <!-- Risk Distribution -->
                        {{-- <td style='text-align:center'>
                            <a href="/risk_computation/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Risk Distribution">
                                <i class="fas fa-calculator fa-lg text-primary"></i>
                            </a>
                        </td> --}}

                        <!-- Reports -->
                        {{-- <td style='text-align:center'>
                            <a href="/reports/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Project Report">
                                <i class="fas fa-eye fa-lg text-success"></i>
                            </a>
                        </td> --}}

                        {{-- <td style='text-align:center'>
                            //compliance Status service wise
                            <a href="/compliance_status/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Compliance Status">
                               <img src="{{asset('compliance_report_icon.jpg')}}" style="width:30px;height:30px;"></img>
                             
                            </a>
                        </td> --}}

                

                        <td style='text-align:center'>
                            <i 
                                class="fas fa-copy fa-lg text-danger" 
                                data-toggle="modal" 
                                data-target="#duplicateProjectModal" 
                                data-project-code="{{ $pro->project_code }}" 
                                title="Duplicate Project">
                            </i>
                        </td>
                        <div class="modal fade" id="duplicateProjectModal" tabindex="-1" aria-labelledby="duplicateProjectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="duplicateProjectModalLabel">Duplicate Project</h5>
                                    </div>
                                    <form id="duplicateProjectForm" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group mb-2">
                                                <label for="projectName">New Project Name</label>
                                                <input type="text" name="project_name" id="projectName" class="form-control" placeholder="Enter project name" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Duplicate</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
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

<script>
    $(document).on('click', '[data-toggle="modal"]', function () {
        var projectCode = $(this).data('project-code');
        var userId = "{{ auth()->user()->id }}";
        var formAction = `/duplicate_project/${projectCode}/${userId}`;
        $('#duplicateProjectForm').attr('action', formAction);
    });
</script>


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
