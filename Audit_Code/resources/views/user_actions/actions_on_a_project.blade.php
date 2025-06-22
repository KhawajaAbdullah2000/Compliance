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
                        <td>{{ $project->project_name }}</td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User actions on Project: {{$project->project_name}} </h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Last Status</th>
                        <th>Role in Project</th>
                        <th>Total Activities on Assets </th>
                        <th>Total Activities on Compliance </th>
                        <th>Total Activities on Risk Assessment </th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr style="text-align: center">
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{$user->status}}</td>
                            <td>
                                @php
                                    // Decode the JSON string properly
                                    $permissions = json_decode($user->project_permissions, true);
                                @endphp
                                {{ is_array($permissions) ? implode(', ', $permissions) : $user->project_permissions }}
                            </td>

                            <td>
                                @if( $user->asset_activities!=0)
                                {{-- for assets only --}}
                                <a href="/total_activities_on_project/{{$project->project_id}}/{{ $user->id }}" 
                                   class="btn btn-outline-success btn-md">
                                   <span class="fw-bold"> {{ $user->asset_activities }}</span>
                                </a>
                                @else
                                <a href="" 
                                    class="btn btn-outline-success btn-md">
                                    <span class="fw-bold"> {{ $user->asset_activities }}</span>
                                 </a>
                                @endif
                            </td>

                            <td>
                                @if( $user->iso_sec_2_2_activities!=0)
                                <a href="/total_activities_on_project_sec_2_2/{{$project->project_id}}/{{ $user->id }}" 
                                   class="btn btn-outline-primary btn-md">
                                   <span class="fw-bold"> {{ $user->iso_sec_2_2_activities }}</span>
                                </a>
                                @else
                                <a href="" 
                                    class="btn btn-outline-primary btn-md">
                                    <span class="fw-bold"> {{ $user->iso_sec_2_2_activities }}</span>
                                 </a>
                                @endif
                            </td>

                            <td>
                                @if( $user->iso_sec_2_3_1_activities!=0)
                                <a href="/total_activities_on_project_sec_2_3_1/{{$project->project_id}}/{{ $user->id }}" 
                                   class="btn btn-outline-warning btn-md">
                                   <span class="fw-bold"> {{ $user->iso_sec_2_3_1_activities }}</span>
                                </a>
                                @else
                                <a href="" 
                                    class="btn btn-outline-warning btn-md">
                                    <span class="fw-bold"> {{ $user->iso_sec_2_3_1_activities }}</span>
                                 </a>
                                @endif
                            </td>

                            <td>
                           
                                <a href="" 
                                   class="btn btn-outline-danger btn-md">
                                   <span class="fw-bold"> {{ $user->total_activities }}</span>
                                </a>
                                
                            </td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

    </div>



</div>


@endsection