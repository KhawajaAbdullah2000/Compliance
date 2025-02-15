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

                    <tr>
                        <td class="fw-bold">No. of Services:</td>
                        <td>{{$uniqueServicesCount }}</td>
                        <td class="fw-bold">No. of Asset Subgroups:</td>
                        <td>{{ $uniqueSubGroupsCount }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Asset Groups:</td>
                        <td>{{$uniqueGroupsCount }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $uniqueComponentsCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="text-center fw-bold mt-2">Risk Heatmap fpr All Services-All Controls-All three types of risk</h3>


    <div class="row mt-4 d-flex align-items-stretch">
        <div class="col-md-4 d-flex flex-column">
            <table class="table table-responsive table-bordered flex-grow-1">
                <tr>
                    <td colspan="4" class="table-primary text-center fw-bold">Risk Map of Data Confidentiality</td>
                </tr>
                <tr>
                    <th>Adverse Business Impact</th>
                    <td colspan="3" class="text-center fw-bold" style="vertical-align: middle">Total Number of Risks: {{$totalConfidentialityCount}}</td>
                </tr>
        
              
                <tbody>
                    @foreach($data_confidentiality as $impactLevel => $counts)
                        <tr>
                            <td>{{ $impactLevel }}</td>
                            <td class="low" style="background-color: rgb(124, 251, 124)">
                         {{ $counts['low']['count'] }}
                
                            </td>
                            <td class="medium" style="background-color: orange">
                                {{ $counts['medium']['count'] }} 
                               
                            </td>
                            <td class="high" style="background-color: rgb(222, 72, 72)">
                                {{ $counts['high']['count'] }} 
                              
                            </td>
                        </tr>

                       
                    @endforeach
                    
                </tbody>

                <tfoot>
                    <tr>
                        <td></td>
                        <td class="low">
                            {{ $overallConfidentialityRanges['low']['min'] ?? '-' }} - {{ $overallConfidentialityRanges['low']['max'] ?? '-' }}
                        </td>
                        <td class="medium">
                            {{ $overallConfidentialityRanges['medium']['min'] ?? '-' }} - {{ $overallConfidentialityRanges['medium']['max'] ?? '-' }}
                        </td>
                        <td class="high">
                            {{ $overallConfidentialityRanges['high']['min'] ?? '-' }} - {{ $overallConfidentialityRanges['high']['max'] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" class="fw-bold text-center">Likelihood of Exploit Range</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center">
                <a href="/heatmap_select_assets/{{$project->project_id}}?risk_type=risk_level" class="btn btn-warning btn-md">View Risk Heatmap by Service</a>
            </div>
           
        </div>


        <div class="col-md-4 d-flex flex-column">
            <table class="table table-responsive table-bordered flex-grow-1">
                <tr>
                    <td colspan="4" class="table-primary text-center fw-bold">Risk Map of Data Integrity</td>
                </tr>
                <tr>
                    <th>Adverse Business Impact</th>
                    <td colspan="3" class="text-center fw-bold" style="vertical-align: middle">Total Number of Risks: {{$totalIntegrityCount}}</td>
                </tr>
        
              
                <tbody>
                    @foreach($data_integrity as $impactLevel => $counts)
                        <tr>
                            <td>{{ $impactLevel }}</td>
                            <td class="low" style="background-color: rgb(124, 251, 124)">
                         {{ $counts['low']['count'] }}
                
                            </td>
                            <td class="medium" style="background-color: orange">
                                {{ $counts['medium']['count'] }} 
                               
                            </td>
                            <td class="high" style="background-color: rgb(222, 72, 72)">
                                {{ $counts['high']['count'] }} 
                              
                            </td>
                        </tr>

                       
                    @endforeach
                    
                </tbody>

                <tfoot>
                    <tr>
                        <td></td>
                        <td class="low">
                            {{ $overallIntegrityRanges['low']['min'] ?? '-' }} - {{ $overallIntegrityRanges['low']['max'] ?? '-' }}
                        </td>
                        <td class="medium">
                            {{ $overallIntegrityRanges['medium']['min'] ?? '-' }} - {{ $overallIntegrityRanges['medium']['max'] ?? '-' }}
                        </td>
                        <td class="high">
                            {{ $overallIntegrityRanges['high']['min'] ?? '-' }} - {{ $overallIntegrityRanges['high']['max'] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" class="fw-bold text-center">Likelihood of Exploit Range</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center">
                <a href="/heatmap_select_assets/{{$project->project_id}}?risk_type=risk_integrity" class="btn btn-warning btn-md">View Risk Heatmap by Service</a>
            </div>
           
        </div>

        <div class="col-md-4 d-flex flex-column">
            <table class="table table-responsive table-bordered flex-grow-1">
                <tr>
                    <td colspan="4" class="table-primary text-center fw-bold">Risk Map of Data Availability</td>
                </tr>
                <tr>
                    <th>Adverse Business Impact</th>
                    <td colspan="3" class="text-center fw-bold" style="vertical-align: middle">Total Number of Risks: {{$totalAvailabilityCount}}</td>
                </tr>
        
              
                <tbody>
                    @foreach($data_availability as $impactLevel => $counts)
                        <tr>
                            <td>{{ $impactLevel }}</td>
                            <td class="low" style="background-color: rgb(124, 251, 124)">
                         {{ $counts['low']['count'] }}
                
                            </td>
                            <td class="medium" style="background-color: orange">
                                {{ $counts['medium']['count'] }} 
                               
                            </td>
                            <td class="high" style="background-color: rgb(222, 72, 72)">
                                {{ $counts['high']['count'] }} 
                              
                            </td>
                        </tr>

                       
                    @endforeach
                    
                </tbody>

                <tfoot>
                    <tr>
                        <td></td>
                        <td class="low">
                            {{ $overallAvailabilityRanges['low']['min'] ?? '-' }} - {{ $overallAvailabilityRanges['low']['max'] ?? '-' }}
                        </td>
                        <td class="medium">
                            {{ $overallAvailabilityRanges['medium']['min'] ?? '-' }} - {{ $overallAvailabilityRanges['medium']['max'] ?? '-' }}
                        </td>
                        <td class="high">
                            {{ $overallAvailabilityRanges['high']['min'] ?? '-' }} - {{ $overallAvailabilityRanges['high']['max'] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" class="fw-bold text-center">Likelihood of Exploit Range</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center">
                <a href="/heatmap_select_assets/{{$project->project_id}}?risk_type=risk_availability" class="btn btn-warning btn-md">View Risk Heatmap by Service</a>
            </div>
           
        </div>
    </div>
</div>



@endsection