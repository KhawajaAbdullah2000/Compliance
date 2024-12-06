@extends('master')

@section('content')

@include('user-nav')

@php
    $totalPercentage = 0; // To store the sum of percentages
    $totalNames = count($complianceData); // Total number of 
    $totalDataConfidentiality=0;
    $totalDataIntegrity=0;
    $totalDataAvailability=0;
    $consolidated_risk=0;
@endphp

<div class="container">

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
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold text-center mt-2">Risk and Compliance Details by Asset for Service : {{$service_name}} and Group {{$group_name}}</h3>


    <table class='table table-hover table-responsive'>
        <thead class="table-dark">
            <tr>
                <th>Asset</th>
                <th>Mandatory Compliance %</th>
                <th>Risk of data confidentiality% </th>
                <th>Risk of data integrity% </th>
                <th>Risk of data availability% </th>
                <th>Consolidated risk of CIA %</th>
                <th>Risk and Compliance Heatmap</th>
                <th>Drill down by Asset Component</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($complianceData as $data)
                @php
                    $totalPercentage += $data['percentage']; // Add each service's percentage to the total
                    $totalDataConfidentiality+=$data['totalDataConfidentiality'];
                    $totalDataIntegrity+=$data['totalDataIntegrity'];
                    $totalDataAvailability+=$data['totalDataAvailability'];
                    $consolidated_risk+=$data['totalDataConfidentiality']+$data['totalDataIntegrity']+$data['totalDataAvailability'];
                @endphp
                <tr>
                    <td>{{ $data['asset_name'] }}</td>
                    <td>{{ number_format($data['percentage'], 2) }}%</td>
                    <td>{{number_format(($data['totalDataConfidentiality']/900)*100,5)}}%</td>
                    <td>{{number_format(($data['totalDataIntegrity']/870)*100,5)}}%</td>
                    <td>{{number_format(($data['totalDataAvailability']/900)*100,5)}}%</td>
                    <td>{{number_format((($data['totalDataConfidentiality']+$data['totalDataIntegrity']+$data['totalDataAvailability'])/2670)*100,5)}}</td>

                    <td>
                        <a href="/risk_compliance_heatmap_by_asset_from_asset_group/{{ $project->project_id }}/{{$service_name}}/{{$group_name}}/{{$data['asset_name']}}/{{ auth()->user()->id }}" 
                           data-toggle="tooltip" title="Risk and Compliance Heatmap for {{$data['asset_name']}}">
                            <i class="fas fa-map fa-lg text-warning"></i>
                        </a>
                    </td>

                    {{-- may add service_name group name also in path --}}
                    <td>
                        <a href="/drill_down_by_asset_component_from_asset/{{ $project->project_id }}/{{$service_name}}/{{$group_name}}/{{$data['asset_name']}}/{{ auth()->user()->id }}" 
                           data-toggle="tooltip" title="Drill down by asset group in Service: {{$data['asset_name']}}">
                            <i class="fas fa-eye fa-lg text-danger"></i>
                        </a>
                    </td>

                    


                </tr>
            @endforeach
            @php
                // Calculate the overall percentage
                $overallPercentage = $totalNames > 0 ? $totalPercentage / $totalNames : 0;
            @endphp
            <tr class="table-primary">
                <td class="fw-bold">All Assets</td>
                <td class="fw-bold">{{ number_format($overallPercentage, 5) }}%</td>
                <td class="fw-bold">{{ number_format(($totalDataConfidentiality/2700), 5) }}%</td>
                <td class="fw-bold">{{ number_format(($totalDataIntegrity/2610), 5) }}%</td>
                <td class="fw-bold">{{ number_format(($totalDataAvailability/2700), 5) }}%</td>
                <td class="fw-bold">{{ number_format(($consolidated_risk/8010), 5) }}%</td>
                <td></td>
                <td></td>


                


            </tr>
        </tbody>
    </table>
</div>

@endsection
