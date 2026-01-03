@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <p class=" fw-bold fs-3">Organization: {{auth()->user()->organization->name}}</p>
            <p class=" fw-bold fs-3">Organization: {{auth()->user()->email}}
            </p>


    <a href="/user_action_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View User Action on All Projects</a>
    <a href="/compliances_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Compliances on All Projects</a>
    <a href="/action_plan_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Action Plan on All Projects</a>
    <a href="/comp_risk_analysis_menu/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">Compliance and Risk Analysis Menu</a>

    <h4 class="fw-bold">Projects by Type</h4>
    <p class="fs-6 text-decoration-underline">Compliance</p>
    <p class="fs-6 text-decoration-underline">Risk Assessment</p>
    <p class="fs-6 text-decoration-underline">Implementation</p>
    <p class="fs-6 text-decoration-underline">All</p>


    <!-- Projects by standard -->

    <h4 class="fw-bold">Projects by Standard</h4>
   <ul class="list-group">
    @foreach($project_types as $t)

        <a href="/assigned_projects/{{auth()->user()->id}}/{{$t->id}}" 
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <span>{{ $t->type }}</span>
            <span class="badge bg-primary rounded-pill">{{ $t->id }}</span>
        </a>
    @endforeach
  
    </ul>

</div>

@section('scripts')

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif


@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif


@endsection

@endsection
