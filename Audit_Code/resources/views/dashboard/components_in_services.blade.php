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


        @if($results->count() > 0)

        <h3>Services and Assets Components in {{$project->project_name}}</h3>
        <div class="row mt-4">
            <div class="col-lg-12">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>No. of Asset Components</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td><a style="color:white" href="/services_controls_dashboard/{{$result->project_id}}/{{auth()->user()->id}}/{{$result->s_name}}">
                                {{ $result->s_name }}</a>
                               </td>
                            <td><a class="btn btn-primary btn-md px-4" href="/components_control_dashboard/{{$project->project_id}}/{{auth()->user()->id}}/{{$result->s_name}}" >
                                {{ $result->component_count }}</a>
                               </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        @else
            <h2 class="fw-bold">No Services added yet</h2>
        @endif


</div>

@endsection
