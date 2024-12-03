
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
                        <td>{{ $distinctServiceCount }}</td>
                        <td class="fw-bold">No. of Assets:</td>
                        <td>{{ $distinctNameCount }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Asset Groups:</td>
                        <td>{{ $distinctGroupCount }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $distinctComponentCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-success text-white fw-bold" style="height: 150px;">
                <span class='fs-5 p-1'>% full compliance of
                    mandatory controls
                    </span>
                <span class='fs-4'>{{ round($yesCount, 2) }}%</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-primary text-white fw-bold" style="height: 150px;">
                <span class="fs-5 p-1">% Partial Compliance of
                    mandatory controls</span>
                <span class="fs-4">{{ round($partialCount, 2) }}%</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-danger text-white fw-bold" style="height: 150px;">
                <span class="fs-5 p-1">% Non Compliance of
                    mandatory controls</span>
                <span class="fs-4">{{ round($noCount, 2) }}%</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-warning text-white fw-bold" style="height: 150px;">
                <span class="fs-5 p-1">% Action Plan where
                    compliance is not full</span>
                <span class="fs-4">{{ round($actionPlanCount, 2) }}%</span>
            </div>
        </div>
    </div>
    

</div>





@endsection