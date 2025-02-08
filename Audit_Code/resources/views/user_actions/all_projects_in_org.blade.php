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
                        <th>Assigned Projects</th>
                        <th>Super User </th>
                       

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>
                                <a href="/projects_created_by/{{ auth()->user()->organization->org_id }}/{{ $user->id }}" 
                                   class="btn btn-outline-primary btn-md">
                                  <span class="fw-bold"> {{ $user->created_projects }}</span>
                                </a>
                            </td>
                            <td>
                                <a href="/projects_assigned/{{ auth()->user()->organization->org_id }}/{{ $user->id }}" 
                                   class="btn btn-outline-success btn-md">
                                   <span class="fw-bold"> {{ $user->assigned_projects }}</span>
                                </a>
                            </td>
                            
                            @if($user->privilege_id==1)
                            <td>Yes </td>
                            @else
                            <td></td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>



</div>


@endsection