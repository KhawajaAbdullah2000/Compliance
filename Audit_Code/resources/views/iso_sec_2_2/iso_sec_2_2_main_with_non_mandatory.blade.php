@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
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

    @if(session('evidenceLevel')!='project')
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark ">
            <tr>
                <th>Service</th>
                    <th>Asset Group</th>
                    <th>Asset</th>
                    <th>Asset Component</th>
                    <th>Asset Owner Dept</th>
                    <th>Asset Physical Location</th>
                    <th>Asset Logical Location</th>
                
            </tr>
        </thead>
        <tbody>
          
            <tr>
                <td>{{ $asset->s_name }}</td>
                <td>{{ $asset->g_name }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->c_name }}</td>
                <td>{{ $asset->owner_dept }}</td>
                <td>{{ $asset->physical_loc }}</td>
                <td>{{ $asset->logical_loc }}</td>
               
            </tr>
           
        </tbody>
    </table>
@endif

@if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif



<h3>Selet From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

</h3>

      <h2 class="text-center fw-bold mt-4 mb-4">
        @if($title==11)
       Annex A
        @endif
    </h2>
    

    <table class="table table-bordered table-responsive table-primary">

        <thead>
            <td>Title of Mandatory Requirement</td>
            <td>Actions</td>
        </thead>

        <tbody>
            <tr>

                <td>
                    <p>Organization Controls</p>
                    </td>
                <td><a href="/iso_sec_2_2_req/5/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">View</a></td>

                </tr>

                <tr>
                <td>
                    <p>People Controls</p>
                    </td>
                <td><a href="/iso_sec_2_2_req/6/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">View</a></td>

            </tr>

            <tr>
                <td>
                    <p>Physical Controls</p>
                    </td>
                <td><a href="/iso_sec_2_2_req/7/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">View</a></td>

            </tr>

            <tr>
                <td>
                    <p>Technological Controls</p>
                    </td>
                <td><a href="/iso_sec_2_2_req/8/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">View</a></td>

                </tr>











        </tbody>

    </table>

</div>

@endsection
