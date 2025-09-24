

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Projects of Organization: {{auth()->user()->organization->name}}
        
    </h1>

    <!-- Projects Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover text-center" id="myTable">
                <thead class="table-secondary">
                    <tr>
                        <th style='text-align:center'>Project Name</th>
                        <th style='text-align:center'>Project Type</th>
                        <th style='text-align:center'>Project Status</th>
                        <th style='text-align:center'>My Permissions on Project</th>
                        <th style='text-align:center'>Data</th>
                        <th style='text-align:center'>Metadata</th>
                        <th style='text-align:center'>View Risk Register</th>
                        <th style='text-align:center'>User Actions</th>
                      
         
                        {{-- <th style='text-align:center'>Risk & Compliance Heatmap</th>  --}}
                        {{-- <th style='text-align:center'>Drill Down by Service</th>  --}}
                        {{-- <th style='text-align:center'>Project Visuals</th>
                        <th style='text-align:center'>Risk Visuals</th>
                        <th style='text-align:center'>Risk Distribution</th> --}}
                        {{-- <th style='text-align:center'>Reports</th> --}}
                        {{-- <th class="text-center">Compliance Status by Asset Component</th> --}}
               
                      
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $pro)
                    <tr style="border-bottom: 1px solid black;">
                        <!-- Project Name -->
                        <td style='text-align:center'>
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

                                 <!-- RIsk Register -->
                        <td style='text-align:center'>
                         
                            <a href="/one_link_risk_register/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                               data-toggle="tooltip" title="Risk Register">
                                <i class="fas fa-cloud fa-lg text-danger"></i>
                            </a>
                          
                        </td>


                                
                           

                          

                               
                               {{-- Storage Node --}}
                   



                            
                       
                

                        
                       
                         <td style='text-align:center'>
                                <a href="/user_actions_on_project/{{ $pro->project_code }}/{{ auth()->user()->id }}" 
                                   data-toggle="tooltip" title="User Actions">
                                    <i class="fas fa-eye fa-lg" style="color: rgb(235, 23, 147)"></i>
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
