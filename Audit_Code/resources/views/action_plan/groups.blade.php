@extends('master')

@section('content')

@include('user-nav')

@php
    $actionPlanType = Session('action_plan_type') == "Mandatory" ? 'Compliance' : Session('action_plan_type');
@endphp

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

    <h3 class="fw-bold text-center mt-4 mb-4">View or Download {{$actionPlanType}} Action Plan
    </h3>


    <h4><span class="fw-bold">Service Selected :</span> 
        @if($service=='_all')

        All services - All Controls

        @else
        
        {{$service}} - All Controls</h4>

        @endif

    <h5 class="fw-bold mt-4">Select one option and proceed</h5>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white text-center">
                    <h2>Available Asset Types</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($groups as $group)
                            <li class="list-group-item">
                                <a href="{{ route('action_plan.service.groups.subgroups', ['service' => $service,'group'=>$group->g_name,'proj_id'=>$project->project_id]) }}">
                                    {{ $group->g_name }}
                                </a>
                            </li>
                        @endforeach

                        <li class="list-group-item">
                            <a href="{{ route('action_plan.service.groups.subgroups', ['service' => $service,'group'=>'_all','proj_id'=>$project->project_id]) }}">
                               All Asset Types
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        
        </div>
    </div>
   
</div>



@endsection