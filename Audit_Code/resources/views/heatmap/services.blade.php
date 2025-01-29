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

    <h5 class="fw-bold mt-4">Select one option and proceed</h5>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white text-center">
                    <h2>Available Services</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($services as $service)
                            <li class="list-group-item">
                                <a href="{{ route('heatmap.service.groups', ['service' => $service->s_name,'proj_id'=>$project->project_id]) }}" class="btn btn-primary">
                                    {{ $service->s_name }}
                                </a>
                            </li>
                        @endforeach

                        <li class="list-group-item">
                            <a href="{{ route('heatmap.service.groups', ['service' => '_all','proj_id'=>$project->project_id]) }}" class="btn btn-primary">
                                All Services
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        
        </div>
    </div>
   
</div>



@endsection