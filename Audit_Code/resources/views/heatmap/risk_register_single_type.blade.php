@extends('master')

@section('content')

@include('user-nav')

<div class="container my-2">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->user()->id }}">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="text-center fw-bold">@if($risk_type=='risk_level')
        Data Confidentiality

        @elseif($risk_type=='risk_integrity')
        Data Integrity

        @elseif($risk_type=='risk_availability')
        Data Availability

        @endif Risk Register</h3>

        <div class="row">
            <div class="col-md-6">
    
        
                <h4><span class="fw-bold">Service Selected : </span>
                    @if($service=='_all')
                    All services - All Controls
                    @else
                    {{$service}} - All Controls
                    @endif
                </h4>
            
                <h4><span class="fw-bold">Assets Selected : </span> 
                    @isset($group)
                    @if($group=='_all')
                    All Asset Types -
                    @else
                    {{$group}} -
                    @endif
                    @endisset
            
            
                @isset($subgroup)
                @if($subgroup=='_all')
                All Asset Sub Types -
                @else
                {{$subgroup}} -
                @endif
                @endisset
            
            @if($component=='_all')
            
            All Asset Components 
            
            @else
            
            {{$component}}
            @endif
            </h4>
            </div>
    
            <div class="col-md-6 position-relative">
                <a href="/heatmap_all_services_all_risks/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">View another Risk Heatmap</a>
            </div>
        </div>


        <div class="float-end mb-4">
            <a href="{{ route('download_excel_risk_register_single_type', [
                'service' => $service,
                'component' => $component,
                'proj_id' => $project->project_id
            ]) }}?group={{ $group }}&subgroup={{ $subgroup }}" class="btn btn-success btn-md">Download Risk Register</a>

        </div>


        <table class="table table-primary table-responsive">
            <thead>
                <th>Control Number</th>
                <th>Title of Control</th>
                <th>Description of Control</th>
                <th>Control is Applicable?</th>
                <th>Control Compliance %</th>
                <th>Vulnerability %</th>
                <th>Threat %</th>
                <th>Risk to 
                    @if($risk_type=='risk_level')
                        Data Confidentiality
                    @elseif($risk_type=='risk_integrity')
                        Data Integrity
                    @elseif($risk_type=='risk_availability')
                        Data Availability
                    @endif
                </th>
            </thead>
        
            <tbody>
                @foreach($results as $result)
                    @php
                        // Find matching control details from $all_data
                        $controlDetails = collect($all_data)->firstWhere(0, $result->control_num);
                    @endphp
        
                    <tr>
                        <td>{{ $result->control_num }}</td>
                        <td>{{ $controlDetails[1] ?? 'N/A' }}</td>  
                        <td>
                            <p data-bs-toggle="tooltip" title="{!! $controlDetails[2] ?? 'N/A' !!}">
                                <i class="fas fa-comment fa-lg text-success"></i> </p>
                        </td>
                  
                        <td>{{ $result->applicability }}</td>
                        <td>{{ $result->control_compliance }}</td>
                        <td>{{ $result->vulnerability }}</td>
                        <td>{{ $result->threat }}</td>
                        <td>
                            @if($risk_type=='risk_level')
                                {{ $result->risk_level }}
                            @elseif($risk_type=='risk_integrity')
                                {{ $result->risk_integrity }}
                            @elseif($risk_type=='risk_availability')
                                {{ $result->risk_availability }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        

</div>

@section('scripts')
<script>
    $(function () {
      $('[data-bs-toggle="tooltip"]').tooltip()
    })
        </script>







@endsection
    @endsection