@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td style="min-width: 150px;">All</td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>All</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td class="">All</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User action on all projects:</h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">

            <table class="table table-hover table-bordered text-center table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>User</th>
                        <th>Created Projects</th>
                        <th>Assigned as user on projects</th>
                        <th>Organization Super User (Note 1)</th>
                        <th>Organization Project Creator (Note 2) </th>
                        <th>Status</th>
                       

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->email }} </td>
                            <td>
                                @if ($user->created_projects > 0)
                                <a href="/projects_created_by/{{ auth()->user()->organization->id }}/{{ $user->id }}" 
                                   class="btn btn-outline-primary btn-md">
                                  <span class="fw-bold"> {{ $user->created_projects }}</span>
                                </a>
                                @else
                                <a 
                                    class="btn btn-outline-primary btn-md">
                                   <span class="fw-bold"> {{ $user->created_projects }}</span>
                                 </a>
                                @endif
                            </td>
                            <td>
                                @if($user->assigned_projects>0 )
                                <a href="/projects_assigned/{{ auth()->user()->organization->id }}/{{ $user->id }}" 
                                   class="btn btn-outline-success btn-md">
                                   <span class="fw-bold"> {{ $user->assigned_projects }}</span>
                                </a>
                                @else
                                <a
                                    class="btn btn-outline-success btn-md">
                                    <span class="fw-bold"> {{ $user->assigned_projects }}</span>
                                 </a>
                                @endif
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
                          
                        <td class="text-capitalize">{{$user->status}}</td>

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

<div class="mt-2">
    <p>Tip: Click on a user's email to see that user's activity audit trail</p>
</div>


</div>


@endsection