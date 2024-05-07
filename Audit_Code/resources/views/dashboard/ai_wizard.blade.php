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
                        <td><a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}">{{$project->project_name}}</a></td>
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

    @if($project->project_type==4)

    @if($results->count() > 0)

        @foreach ($results as $service_name => $components)
            <h2 class="fw-bold mt-5">Risk Levels for {{ $service_name }}</h2>
            <table class="table table-primary table-responsive">
                <thead>
                    <tr>
                        <th>Asset Component Name</th>
                        <th>Highest Risk level</th>
                        <th>Lowest Risk level</th>
                        <th>Mean Risk Level (Calculated)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($components as $res)
                        <tr>
                            <td>{{$res->c_name}}</td>
                            <td>{{$res->max_risk_level}}</td>
                            <td>{{$res->min_risk_level}}</td>
                            <td>{{ number_format($res->average_risk_level, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @else
        <h2 class="fw-bold">No risk assessment done yet</h2>
    @endif

    @endif
</div>

@endsection
