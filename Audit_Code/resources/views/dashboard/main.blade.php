@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td><a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}">{{$project->project_name}}</a></td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="/ai_wizard/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-success text-white btn-md">Go to AI wizard for this project</a>



    <div class="row mt-4">
        <div class="col-lg-6 text-center">
            <h3 class="mb-3">Asset Groups</h3>
            <canvas id="serviceChart" width="300" height="200"></canvas>
        </div>

        <div class="col-lg-6 text-center">
            <h3 class="mb-3">Asset Components</h3>
            <canvas id="groupChart" width="300" height="200"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 text-center">
            <h3 class="mb-3">Mandatory Requirements</h3>
            <div style="width: 500px; height: 500px; margin: auto;">
                <canvas id="requirementsChart"></canvas>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    var ctxService = document.getElementById('serviceChart').getContext('2d');
    var serviceChart = new Chart(ctxService, {
        type: 'bar',
        data: {
            labels: {!! json_encode($groupsPerService->pluck('s_name')) !!},
            datasets: [{
                label: 'Number of Unique Asset Groups',
                data: {!! json_encode($groupsPerService->pluck('unique_groups_count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });

    var ctxGroup = document.getElementById('groupChart').getContext('2d');
    var groupChart = new Chart(ctxGroup, {
        type: 'bar',
        data: {
            labels: {!! json_encode($componentsPerGroup->pluck('g_name')) !!},
            datasets: [{
                label: 'Number of Unique Components',
                data: {!! json_encode($componentsPerGroup->pluck('unique_components_count')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxRequirement = document.getElementById('requirementsChart').getContext('2d');
    var requirementsChart = new Chart(ctxRequirement, {
        type: 'pie',
        data: {
            labels: ['Mandatory Requirements Submitted', 'Mandatory Requirements Left'],
            datasets: [{
                data: [@json($mandatory_requirements_submitted), @json($mandatory_requirements_left)],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });
</script>
@endsection

@endsection
