@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-warning">
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

    <h4 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User actions audit trail on Project: {{$project->project_name}} for {{$user->email}} </h4>

    <div class="text-end">
        <a href="/user_actions_on_project/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary btn-md">Back</a>
    </div>
    <div class="badge text-bg-primary fs-4">
     Audit trail for Assets
      </div>
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Service</th>
                        <th>Group</th>
                        <th>Sub Group </th>
                        <th>Component </th>
                        <th>Owner Dept</th>
                        <th>Physical Location</th>
                        <th>Logical Location</th>
                        <th>Operation type</th>
                        <th>Updated </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asset_activities as $activity)
                        <tr>
                            <td>{{ $activity->s_name }} </td>
                            <td>{{ $activity->g_name }} </td>
                            <td>{{ $activity->name }} </td>
                            <td>{{ $activity->c_name }} </td>
                            <td>{{ $activity->owner_dept }} </td>
                            <td>{{ $activity->physical_loc }} </td>
                            <td>{{ $activity->logical_loc }} </td>
                            <td> <span class="badge 
                            @if($activity->operation_type == 'insert') text-bg-success 
                            @elseif($activity->operation_type == 'update') text-bg-warning 
                            @elseif($activity->operation_type == 'delete') text-bg-danger 
                            @else text-bg-info
                            @endif 
                            fs-6 text-center"
                                style="min-width: 100px;">
                                {{ $activity->operation_type }} 
                            </span>
                        </td>
                            <td>
                                <span class="badge text-bg-secondary fs-6 text-center">
                                
                                {{ date('d M Y, h:i A', strtotime($activity->performed_at)) }}</td>
                                </span>

                    
                           
                        </tr>
                    @endforeach

                   
                </tbody>
            </table>


        </div>

    </div>



</div>


@endsection