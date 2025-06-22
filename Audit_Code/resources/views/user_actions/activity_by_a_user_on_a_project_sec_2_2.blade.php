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

    <h4 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User actions audit trail for Compliance on Project: {{$project->project_name}} for {{$user->email}} </h4>


    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Service</th>
                        <th>Group</th>
                        <th>Sub Group </th>
                        <th>Component </th>
                        <th>Domain</th>
                        <th>Control No.</th>
                        <th>Last Activity</th>
                        <th>View or Edit Artifact</th>
                    
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities_2_2 as $activity)
                        <tr>
                            <td>{{ $activity->s_name }} </td>
                            <td>{{ $activity->g_name }} </td>
                            <td>{{ $activity->name }} </td>
                            <td>{{ $activity->c_name }} </td>
                            <td>{{ $activity->title_num }} </td>
                            <td>{{ $activity->sub_req }} </td>

                    
                            <td>
                                <span class="badge text-bg-secondary fs-6 text-center">
                                
                                {{ date('d M Y, h:i: A', strtotime($activity->last_edited_at)) }}
                                </span>
                            </td>

                            <td class="text-center">
    <a href="/ksa_nca_sec2_2_sub_req_edit/{{$activity->sub_req}}/{{$activity->title_num}}/{{$project->project_id}}/{{auth()->user()->id}}/{{$activity->assessment_id}}/{{$activity->subdomain}}">
     <svg xmlns="http://www.w3.org/2000/svg" width="35" height="30" fill="green" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg>

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