

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <h1 class="text-center fw-bold mb-5">Projects of Organization: {{auth()->user()->organization->name}}</h1>

    <a href="/user_action_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View User Action on All Projects</a>
    <a href="/compliances_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Compliances on All Projects</a>
    <a href="/action_plan_all_projects_in_org/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md mb-4">View Action Plan on All Projects</a>


    

   <div class="mt-4">
    <table class="table table-responsive">
           <thead class="table-dark">
        <tr>
            <th>Service Name</th>
            <th>Group Name</th>
            <th>Name</th>
            <th>Component Name</th>
            <th>Owner Dept.</th>
            <th>Physical Location</th>
            <th>Logical Location</th>
            <th>Project Name(s)</th>
            <th>Project Type(s)</th>
        </tr>
    </thead>
        <tbody>
        @foreach($groupedServices as $service => $data)
            <tr>
                <td><a href="/select_projects_for_comp_analysis/{{$service}}/{{auth()->user()->organization->id}}">{{ $service }}</a></td>
                <td>{{ $data['g_names'] }}</td>
                <td>{{ $data['names'] }}</td>
                <td>{{ $data['c_names'] }}</td>
                <td>{{ $data['owner_depts'] }}</td>
                <td>{{ $data['physical_locs'] }}</td>
                <td>{{ $data['logical_locs'] }}</td>
                <td>{{ $data['project_names'] }}</td>
                <td>{{ $data['project_types'] }}</td>
            </tr>
        @endforeach
    </tbody>

    </table>
   </div>

   


   <div class="text-end mt-4">
    <a href="/comp_risk_analysis_menu/{{auth()->user()->organization->id}}" class="btn btn-md btn-info">Compliance and Risk Analytics Menu</a>
   </div>





    @endsection