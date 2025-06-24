@extends('master')

@section('content')
@include('user-nav')

<div class="container py-5">

    <h1 class="text-center fw-bold mb-5">Projects of Organization: {{ auth()->user()->organization->name }}</h1>

    <!-- Navigation Buttons -->
    <div class="mb-4">
        <a href="/user_action_all_projects_in_org/{{ auth()->user()->organization->id }}" class="btn btn-primary btn-md me-2">View User Actions on All Projects</a>
        <a href="/compliances_all_projects_in_org/{{ auth()->user()->organization->id }}" class="btn btn-primary btn-md me-2">View Compliances on All Projects</a>
        <a href="/action_plan_all_projects_in_org/{{ auth()->user()->organization->id }}" class="btn btn-primary btn-md">View Action Plan on All Projects</a>
    </div>

    <h3 class="mb-4">Service: <span class="text-primary">{{ $serviceName }}</span></h3>

      {{-- <div class="row mt-4 justify-content-center">

        <div class="col-md-2">
                <div class="card shadow-lg p-4 text-center bg-success h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                               {{ $percentages['yes'] ?? 0 }} %
                            </p>
                        </div>
                    </a>
                </div>
        </div>

          <div class="col-md-2">
             <div class="card shadow-lg p-4 text-center h-100 d-flex flex-column justify-content-between" style="background-color: orange">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">Partially in Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                               {{ $percentages['partial'] ?? 0 }} %
                            </p>
                        </div>
                    </a>
                </div>
        </div>

        <div class="col-md-2">
              <div class="card shadow-lg p-4 text-center bg-danger h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                               {{ $percentages['no'] ?? 0 }} %
                            </p>
                        </div>
                    </a>
                </div>
        </div>

      

        <div class="col-md-2">
                 <div class="card shadow-lg p-4 text-center bg-info h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                               {{ $percentages['not_applicable'] ?? 0 }} %
                            </p>
                        </div>
                    </a>
                </div>
        </div>

        <div class="col-md-2">
                 <div class="card shadow-lg p-4 text-center bg-secondary h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                               {{ $percentages['not_tested'] ?? 0 }} %
                            </p>
                        </div>
                    </a>
                </div>
        </div>

    </div> --}}
    @foreach ($componentStats as $stat)
    <div class="mb-5">
    <h4 class="mb-3">
    {{ $stat['component'] }}
    <small class="text-muted">
        (Project: {{ $stat['project_name'] }} — {{ $stat['project_type'] }})
    </small>
</h4>

        <div class="row g-3 justify-content-center">
            <div class="col-md-2">
                <div class="card shadow-lg p-4 text-center bg-success h-100">
                    <h5 class="card-title text-white">In Place</h5>
                    <p class="text-white fw-bold mt-3 fs-4">
                        {{ $stat['percentages']['yes'] ?? 0 }}%
                    </p>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-lg p-4 text-center" style="background-color: orange;">
                    <h5 class="card-title text-white">Partially in Place</h5>
                    <p class="text-white fw-bold mt-3 fs-4">
                        {{ $stat['percentages']['partial'] ?? 0 }}%
                    </p>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-lg p-4 text-center bg-danger h-100">
                    <h5 class="card-title text-white">Not in Place</h5>
                    <p class="text-white fw-bold mt-3 fs-4">
                        {{ $stat['percentages']['no'] ?? 0 }}%
                    </p>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-lg p-4 text-center bg-info h-100">
                    <h5 class="card-title text-white">Not Applicable</h5>
                    <p class="text-white fw-bold mt-3 fs-4">
                        {{ $stat['percentages']['not_applicable'] ?? 0 }}%
                    </p>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card shadow-lg p-4 text-center bg-secondary h-100">
                    <h5 class="card-title text-white">Not Tested</h5>
                    <p class="text-white fw-bold mt-3 fs-4">
                        {{ $stat['percentages']['not_tested'] ?? 0 }}%
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($stat['domains']))
    <div class="mt-3">
        <h6 class="fw-bold">Domains Selected:</h6>
        <ul class="list-group list-group-flush small">
            @foreach ($stat['domains'] as $domain)
                <li class="list-group-item px-2 py-1">
                    <span class="fw-semibold">{{ $domain['number'] }}</span> – {{ $domain['name'] }}
                </li>
            @endforeach
        </ul>
    </div>
@else
    <p class="text-muted small">No domains selected for this component.</p>
@endif
@endforeach
    <div class="mt-4">
        <a href="/select_projects_for_comp_analysis/{{ $serviceName }}/{{ auth()->user()->organization->id }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="text-end mt-4">
        <a href="/comp_risk_analysis_menu/{{ auth()->user()->organization->id }}" class="btn btn-info">Compliance and Risk Analytics Menu</a>
    </div>
</div>
@endsection
