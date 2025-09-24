@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>Projects assigned to : {{$user->email}}</h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">

            <table class="table table-hover table-bordered text-center table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Name</th>
                        <th>Creation Date</th>
                        <th>Type</th>
                        <th>Status </th>
                        <th>Last User Role</th>
                       

                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->project_name}}</td>
                            <td>{{ $project->project_creation_date}}</td>
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