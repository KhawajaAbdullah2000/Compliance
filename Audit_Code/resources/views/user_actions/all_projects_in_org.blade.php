@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User action on all projects for : {{auth()->user()->organization->name}}</h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">

            <table class="table table-hover table-bordered text-center table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>User</th>
                        <th>Created Projects</th>
                        <th>Assigned as user or projects</th>
                        <th>Organization Super User (Note 1)</th>
                        <th>Organization Project Creator (Note 2) </th>
                       

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>
                                <a href="/projects_created_by/{{ auth()->user()->organization->id }}/{{ $user->id }}" 
                                   class="btn btn-outline-primary btn-md">
                                  <span class="fw-bold"> {{ $user->created_projects }}</span>
                                </a>
                            </td>
                            <td>
                                <a href="/projects_assigned/{{ auth()->user()->organization->id }}/{{ $user->id }}" 
                                   class="btn btn-outline-success btn-md">
                                   <span class="fw-bold"> {{ $user->assigned_projects }}</span>
                                </a>
                            </td>
                            
                            @if($user->privilege_id==1)
                            <td>Yes </td>
                            @else
                            <td></td>
                            @endif

                            
                           <td>
                            @php
                                $isProjectCreator = false;
                            @endphp
        
                            @foreach ($user->permissions as $per)
                                @if ($per->name == 'Project Creator')
                                    @php
                                        $isProjectCreator = true;
                                    @endphp
                                    @break
                                @endif
                            @endforeach
        
                            @if ($isProjectCreator)
                                Yes
                            @endif
                        </td>
                          

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

<div class="mt-4">
    <p>Note 1: An organization Super User can create organization's end-users and assign roles to end users</p>
    <p>Note 2: An organization Project Creator end-user can create the organization's projects, add other end-users to the project and assign roles to the end users added to the projects </p>


</div>


</div>


@endsection