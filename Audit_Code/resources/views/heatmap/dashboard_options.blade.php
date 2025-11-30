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

  

    <div class="container my-5">
    <div class="row text-center mb-4">
        <!-- Row 1 -->
        <div class="col-md-3 mb-4">
            <a href="/compliance_map_dashboard_all_services/{{$project->project_id}}/{{auth()->user()->id}}">
                <img src="{{ asset('compliance-register.png') }}" alt="Compliance Register" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Compliance Register</p>
               
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="">
                <img src="{{ asset('health-assets.png') }}" alt="Health of Assets" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Health of Assets</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="/health_of_controls/{{$project->project_id}}">
                <img src="{{ asset('health-controls.png') }}" alt="Health of Controls" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Health of Controls</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="">
                <img src="{{ asset('compliance-trends.png') }}" alt="Compliance Trends" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Compliance Trends</p>
            </a>
        </div>
    </div>

    <div class="row text-center">
        <!-- Row 2 -->
        <div class="col-md-3 mb-4">
            <a href="/risk_register_dashboard/{{$project->project_id}}/{{auth()->user()->id}}">
                <img src="{{ asset('risk-register.png') }}" alt="Risk Register" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Risk Register</p>
               
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="">
                <img src="{{ asset('risk-heatmap.png') }}" alt="Risk Heat Map" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Risk Heat Map</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="">
                <img src="{{ asset('risk-trends.png') }}" alt="Risk Trends" class="img-fluid" style="height: 100px;">
                <p class="fw-bold mt-2">Risk Trends</p>
            </a>
        </div>
    </div>
</div>







</div>

@section('scripts')





@endsection
    @endsection