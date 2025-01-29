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
                        <td>{{ auth()->user()->organization->sub_org }}</td>
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

    <h3 class="fw-bold text-center mt-4 mb-4">Risk Heatmap for 
        @if($risk_type=='risk_level')
        Data Confidentiality

        @elseif($risk_type=='risk_integrity')
        Data Integrity

        @elseif($risk_type=='risk_availability')
        Data Availability

        @endif
    </h3>

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
                All Asset Groups -
                @else
                {{$group}} -
                @endif
                @endisset
        
        
            @isset($subgroup)
            @if($subgroup=='_all')
            All Asset Subgroups -
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

    <div class="row">
        <div class="col-md-6">
      
                <table class="table table-responsive table-bordered">
                    <tr>
                        <td colspan="4" class="table-primary text-center fw-bold">Risk Map of -  @if($risk_type=='risk_level')
                            Data Confidentiality
                    
                            @elseif($risk_type=='risk_integrity')
                            Data Integrity
                    
                            @elseif($risk_type=='risk_availability')
                            Data Availability
                    
                            @endif </td>
                    </tr>
                    <tr>
                        <th>Adverse Business Impact</th>
                        <td colspan="3" class="text-center fw-bold" style="vertical-align: middle">Total Number of Risks: {{$totalCount}}</td>
                    </tr>
            
                  
                    <tbody>
                        @foreach($data as $impactLevel => $counts)
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
                                {{ $overallRanges['low']['min'] ?? '-' }} - {{ $overallRanges['low']['max'] ?? '-' }}
                            </td>
                            <td class="medium">
                                {{ $overallRanges['medium']['min'] ?? '-' }} - {{ $overallRanges['medium']['max'] ?? '-' }}
                            </td>
                            <td class="high">
                                {{ $overallRanges['high']['min'] ?? '-' }} - {{ $overallRanges['high']['max'] ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3" class="fw-bold text-center">Likelihood of Exploit Range</td>
                        </tr>
                    </tfoot>
                </table>
                {{-- <div class="text-center">
                    <a href="/heatmap_select_assets/{{$project->project_id}}?risk_type=risk_level" class="btn btn-warning btn-md">View Risk Heatmap by Service</a>
                </div> --}}
               
        
        </div>
    </div>

</div>


@endsection