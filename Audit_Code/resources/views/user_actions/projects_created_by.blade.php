@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>Projects created by : {{$user->first_name}} {{$user->last_name}}</h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">

            <table class="table table-hover table-bordered text-center table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Name</th>
                        <th>Creation At</th>
                        <th>Type</th>
                        <th>Status </th>
                        <td>Last User Role</td>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->project_name}}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($project->project_creation_date . ' ' . $project->project_creation_time)->format('d M Y, h:i A') }}
                        </td>

                        <td>{{ $project->project_type_name}}</td>
                        <td>{{ $project->status}}</td>
                        <td>{{ implode(', ', json_decode($project->project_permissions, true)) }}</td>


                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>



</div>


@endsection
