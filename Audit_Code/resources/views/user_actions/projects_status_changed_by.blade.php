@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>Chnaged Status on Projects by:{{$user->first_name}} {{$user->last_name}}</h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">

            <table class="table table-hover table-bordered text-center table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Name</th>
                        <th>StatusChanged At</th>
                        <th>Status</th>
                         <th>Type</th>
                       
                       
                  
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->project_name}}</td>
                          <td>{{ \Carbon\Carbon::parse($project->status_changed_at)->format('d M Y, h:i A') }}</td>
                            <td>{{$project->status}}</td>
                            <td>{{ $project->project_type_name}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>



</div>


@endsection