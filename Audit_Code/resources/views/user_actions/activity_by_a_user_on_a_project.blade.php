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
                        <td>{{ auth()->user()->organization->sub_org }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User actions audit trail on Project: {{$project->project_name}} for {{$user->first_name}} {{$user->last_name}}</h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Service</th>
                        <th>Group</th>
                        <th>Sub Group </th>
                        <th>Component </th>
                        <th>Control Number </th>
                        <th>Updated </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities_2_2 as $activity)
                        <tr>
                            <td>{{ $activity->s_name }} </td>
                            <td>{{ $activity->g_name }} </td>
                            <td>{{ $activity->name }} </td>
                            <td>{{ $activity->c_name }} </td>
                            <td>{{ $activity->sub_req }} </td>
                            <td>
                                <span class="badge text-bg-warning">
                                
                                {{ date('d M Y, h:i A', strtotime($activity->last_edited_at)) }}</td>
                                </span>

                    
                           
                        </tr>
                    @endforeach

                    @foreach ($activities_2_3_1 as $activity)
                        <tr>
                            <td>{{ $activity->s_name }} </td>
                            <td>{{ $activity->g_name }} </td>
                            <td>{{ $activity->name }} </td>
                            <td>{{ $activity->c_name }} </td>
                            <td>{{ $activity->control_num }} </td>
                            <td>
                                <span class="badge text-bg-warning">
                                
                                {{ date('d M Y, h:i A', strtotime($activity->last_edited_at)) }}</td>
                                </span>

                    
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

    </div>



</div>


@endsection