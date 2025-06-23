

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

    <form action="/submit_selected_projects_for_comp_analysis/{{auth()->user()->organization->id}}" method="POST">
        @csrf

        <input type="hidden" name="s_name" value="{{$serviceName}}">
        <div class="mb-3">
            <label class="form-label fw-bold">Select Projects:</label>
            <div class="list-group">
                @foreach ($projects as $project)
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <input
                                type="checkbox"
                                name="selected_projects[]"
                                value="{{ $project->project_id }}"
                                checked
                                class="form-check-input me-2"
                            >
                            <span class="fw-bold fs-5">{{ $project->project_name }}</span>
                            
                            <small class="fw-semibold d-block">Type: {{ $project->type }}</small>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

       <a href="/analyze_comp_risk/{{auth()->user()->organization->id}}" class="btn btn-secondary mt-3">Back</a>
        <button type="submit" class="btn btn-success mt-3">Submit Projects</button>
    </form>

            
    </div>

   


   <div class="text-end mt-4">
    <a href="/comp_risk_analysis_menu/{{auth()->user()->organization->id}}" class="btn btn-md btn-info">Compliance and Risk Analytics Menu</a>
   </div>





    @endsection