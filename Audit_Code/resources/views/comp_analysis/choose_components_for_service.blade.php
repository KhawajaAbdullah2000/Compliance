

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Projects of Organization: {{auth()->user()->organization->name}}</h1>

    <a href="/user_action_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View User Action on All Projects</a>
    <a href="/compliances_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Compliances on All Projects</a>
    <a href="/action_plan_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Action Plan on All Projects</a>


    
    <h3 class="mb-4">Service: <span class="text-primary">{{ $serviceName }}</span></h3>



   <div class="col-md-6">
     <form action="/submit_components_for_comp_analysis/{{auth()->user()->organization->id}}" method="POST">
        @csrf

        <input type="hidden" name="s_name" value="{{ $serviceName }}">
              <label class="form-label fw-bold">Select Components:</label>

        @foreach ($projects as $projectId => $project)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $project['name'] }} - <span class="fs-6">{{$project['type']}}</span></h5>

                    <input type="hidden" name="selected_projects[]" value="{{ $projectId }}">

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2">
                        @foreach ($project['components'] as $component)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="components[{{ $projectId }}][]" 
                                        value="{{ $component }}" 
                                        id="chk_{{ $projectId }}_{{ \Illuminate\Support\Str::slug($component) }}"
                                        checked>
                                    <label class="form-check-label" for="chk_{{ $projectId }}_{{ \Illuminate\Support\Str::slug($component) }}">
                                        {{ $component }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    <div class="d-flex gap-3">
        <button type="submit" name="action" value="compliance" class="btn btn-success">Analyze Compliance</button>
        <button type="submit" name="action" value="risk" class="btn btn-warning">Analyze Risk</button>
    </div>
    </form>
   </div>

    <a href="/select_projects_for_comp_analysis/{{$serviceName}}/{{auth()->user()->organization->id}}" class="btn btn-secondary mt-4">Back</a>
   


   <div class="text-end mt-4">
    <a href="/comp_risk_analysis_menu/{{auth()->user()->organization->id}}" class="btn btn-md btn-info">Compliance and Risk Analytics Menu</a>
   </div>





    @endsection