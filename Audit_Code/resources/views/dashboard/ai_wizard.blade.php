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


        @if($servicesInProjects->count() > 0)

        <h3>AI Wizard for {{$project->project_name}} </h3>
        <div class="row mt-4">
            <div class="col-lg-12">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>No. of Services</th>
                            <th>Asset Components Risk Profile - Tabular</th>
                            <th>Asset Components Risk Profile - Graphical</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicesInProjects as $result)
                        <tr>
                            <td><a style="color:white" class="fw-bold" href="/iso_sections/{{$result->project_id}}/{{auth()->user()->id}}">
                                {{ $result->project_name }}</a>
                               </td>
                            <td><a class="btn btn-outline-primary btn-md px-4 text-white fw-bold" href="/dashboard_services_and_components/{{$result->project_id}}/{{auth()->user()->id}}">
                                {{ $result->services }}</a>
                               </td>

                               <td><a class="btn btn-success btn-md px-4" href="/dashboard_services_and_components/{{$result->project_id}}/{{auth()->user()->id}}">
                                Risk Profile Tabular</a>
                               </td>

                               <td><a class="btn btn-warning btn-md px-4" href="/risk_profile_graphical/{{$result->project_id}}/{{auth()->user()->id}}">
                                Risk Profile-Graphical</a>
                               </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        @else
            <h2 class="fw-bold">No Projects yet</h2>
        @endif


</div>

@endsection
