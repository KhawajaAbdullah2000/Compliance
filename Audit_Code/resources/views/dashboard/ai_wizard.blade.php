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

    @if($project->project_type == 4)

        @if($results->count() > 0)

        <h3>Report Name: ISO 27001:2022 Statement of Applicability (SoA) Analytics </h3>
        <div class="row mt-4">
            <div class="col-lg-12">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Total Asset Components</th>
                            <th>On which Annex A controls are applicable</th>
                            <th>On which Annex A controls are not applicable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result->s_name }}</td>
                            <td>{{ $result->total_asset_components }}</td>
                            <td>{{ $result->applicable_asset_components }}</td>
                            <td>{{ $result->not_applicable_asset_components }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <h3 class="mt-4">Report Name: Information Security Risk Analytics </h3>

        <div class="row mt-4">

            <div class="col-md-12">
                <table class="table table-hover table-primary">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Total Asset Components</th>
                            <th>High risk for all controls</th>
                            <th>Medium risk for all controls</th>
                            <th>Low risk for all controls</th>
                            <th>Highest for any asset component</th>
                            <th>Lowst for any assest component</th>
                            <th>Median for any asset component</th>
                            <th>Project Creation Date</th>
                            <th>Earliest Treatment Target Date for any asset component</th>
                            <th>Farthest Treatment Target Date for any asset component</th>
                            <th>Earliest Treatment Actual COmpletion Date for any asset component</th>
                            <th>Farthest Treatment Actual COmpletion Date for any asset component</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results2 as $result)
                            <tr>
                                <td>{{ $result->s_name }}</td>
                                <td>{{$result->total_asset_components}}</td>
                                <td>{{ $result->high_risk_count }}</td>
                                <td>{{ $result->medium_risk_count }}</td>
                                <td>{{ $result->low_risk_count }}</td>
                                <td>{{ $result->max_risk }}</td>
                                <td>{{ $result->min_risk }}</td>
                                <td>{{ number_format($result->avg_risk, 5) }}</td>
                                <td>{{$project_date}}</td>
                                <td>{{ $result->earliest_treatment_target_date }}</td>
                                <td>{{ $result->farthest_treatment_target_date }}</td>
                                <td>{{ $result->earliest_acceptance_actual_date }}</td>
                                <td>{{ $result->farthest_acceptance_actual_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        @else
            <h2 class="fw-bold">No risk assessment done yet</h2>
        @endif

    @endif
</div>

@endsection
