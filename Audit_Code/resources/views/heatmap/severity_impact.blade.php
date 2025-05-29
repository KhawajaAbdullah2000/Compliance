@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold">Severity of Adverse Impact for all services in the project</h3>

    <table class="table table-bordered text-center mt-4">
        <thead>
            <tr>
                <th></th>
                <th colspan="3" class="fs-5">Adverse Consequence to the Service</th>
                <th></th>
            </tr>
            <tr class="table-dark">
                <th>Service</th>
                <th>Data Confidentiality</th>
                <th>Data Integrity</th>
                <th>Data Availability</th>
                <th>Risk Heat Map by Service</th>
            </tr>
            
        </thead>
       
        <tbody>
            
            @foreach ($results as $result)
                <tr>
                    <!-- Service Name -->
                    <td>{{ $result->s_name }}</td>
                    
                    <!-- Data Confidentiality -->
                    <td>
                        @if ($result->risk_confidentiality == 10)
                            <span class="badge bg-danger fs-6">High</span>
                        @elseif ($result->risk_confidentiality == 5)
                            <span class="badge bg-warning text-dark fs-6">Medium</span>
                        @else
                            <span class="badge bg-success fs-6">Low</span>
                        @endif
                    </td>
                    
                    <!-- Data Integrity -->
                    <td>
                        @if ($result->risk_integrity == 10)
                            <span class="badge bg-danger fs-6">High</span>
                        @elseif ($result->risk_integrity == 5)
                            <span class="badge bg-warning text-dark fs-6">Medium</span>
                        @else
                            <span class="badge bg-success fs-6">Low</span>
                        @endif
                    </td>
                    
                    <!-- Data Availability -->
                    <td>
                        @if ($result->risk_availability == 10)
                            <span class="badge bg-danger fs-6">High</span>
                        @elseif ($result->risk_availability == 5)
                            <span class="badge bg-warning text-dark fs-6">Medium</span>
                        @else
                            <span class="badge bg-success fs-6">Low</span>
                        @endif
                    </td>
                    
                    <!-- Heat Map Button -->
                    <td>
                        <button class="btn btn-primary btn-sm">View</button>
                    </td>
                </tr>
            @endforeach

            <tr>
                <td>Risk Heatmap by Type of Risk</td>
                <td>
                    <button class="btn btn-primary btn-sm">View</button>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm">View</button>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm">View</button>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-center" style="margin-top: 30px;">
        <div class="row">
            <div class="">
                <a href="/heatmap_all_services_all_risks/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg">
                    View Risk Heat Map for all Services and all types of risk
                </a>
            </div>
        </div>
    </div>



</div>





@endsection