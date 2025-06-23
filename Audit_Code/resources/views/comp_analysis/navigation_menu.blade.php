

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Projects of Organization: {{auth()->user()->organization->name}}</h1>

    <a href="/user_action_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View User Action on All Projects</a>
    <a href="/compliances_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Compliances on All Projects</a>
    <a href="/action_plan_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Action Plan on All Projects</a>


    
    <!-- Link Card 1 -->
    <div class="col">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">
            <a href="https://example.com" class="stretched-link text-decoration-none text-dark">🔗 Analyze by Project</a>
          </h5>
        </div>
      </div>
    </div>

    <!-- Link Card 2 -->
    <div class="col">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">
            <a href="/analyze_comp_risk/{{auth()->user()->organization->id}}" class="stretched-link text-decoration-none text-dark">📄 Analyze by Service by Project by Asset Component by Control Domain</a>
          </h5>
        
        </div>
      </div>
    </div>






    @endsection