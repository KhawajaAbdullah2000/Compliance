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

    <form action="/selected_domains/{{auth()->user()->organization->id}}" method="POST">
        @csrf

        <input type="hidden" name="s_name" value="{{ $serviceName }}">

        <div class="col-md-8">
            @foreach ($projects as $project)
                <input type="hidden" name="selected_projects[]" value="{{ $project['id'] }}">

                @foreach ($project['components'] as $component)
                    <input type="hidden" name="components[{{ $project['id'] }}][]" value="{{ $component }}">
                @endforeach

                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">{{ $project['name'] }}</h4>
                        <p><strong>Project Type:</strong> {{ $project['type_label'] }}</p>

                        <h6 class="mt-3">Selected Components:</h6>
                   <div class="d-flex flex-wrap gap-2">
   @forelse ($project['components'] as $component)
    <span class="badge badge-md bg-secondary">{{ $component }}</span>
@empty
    <span class="text-muted">No components selected.</span>
@endforelse
</div>

                        <h6 class="mt-4">Select Domain Names:</h6>
                        <div class="row">
                            @foreach ($project['domains'] as $id => $domain)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="domains[{{ $project['id'] }}][]" 
                                               value="{{ $id }}"
                                               id="domain_{{ $project['id'] }}_{{ $id }}"
                                               checked>
                                        <label class="form-check-label" for="domain_{{ $project['id'] }}_{{ $id }}">
                                            <strong>{{ $id }}</strong>: {{ $domain }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Next</button>
    </form>

    <div class="mt-4">
        <a href="/select_projects_for_comp_analysis/{{ $serviceName }}/{{ auth()->user()->organization->id }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="text-end mt-4">
        <a href="/comp_risk_analysis_menu/{{ auth()->user()->organization->id }}" class="btn btn-info">Compliance and Risk Analytics Menu</a>
    </div>
</div>
@endsection
