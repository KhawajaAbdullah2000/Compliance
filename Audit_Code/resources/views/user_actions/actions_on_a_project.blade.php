@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="fw-bold" style='margin-top: 40px;margin-bottom:30px;'>User action on Project: </h3>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Name</th>
                        <th>Role in Project</th>
                        <th>Last Activity </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>
                                @php
                                    // Decode the JSON string properly
                                    $permissions = json_decode($user->project_permissions, true);
                                @endphp
                                {{ is_array($permissions) ? implode(', ', $permissions) : $user->project_permissions }}
                            </td>

                            <td>{{$user->total_activities}}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

    </div>



</div>


@endsection