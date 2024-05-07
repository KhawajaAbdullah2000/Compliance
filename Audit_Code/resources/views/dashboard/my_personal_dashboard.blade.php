@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h2 class="text-center fw-bold mb-4">Visual and AI Dashboard</h2>

    <div class="row">
        <div class="col-lg-6 text-center" >
            <h3 class="mb-3">Projects Created by me (by type)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
            <canvas id="projectsPieChart"></canvas>
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <h3 class="mb-3">Projects where roles are assigned to me (by type)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
            <canvas id="projectsPieChart2"></canvas>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 text-center">
            <h3 class="mb-3">Projects created by me (by Project Status)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
                <canvas id="projectsPieChart3"></canvas>
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <h3 class="mb-3">Projects where roles are assigned to me (by Project Status)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
            <canvas id="projectsPieChart4"></canvas>
            </div>
        </div>
    </div>

</div>

@section('scripts')
<script>
    //projects created by me (by type)
    var ctx = document.getElementById('projectsPieChart').getContext('2d');
    var projectsPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($projectsCreatedCount->pluck('type')) !!},
            datasets: [{
                label: 'Projects Count',
                data: {!! json_encode($projectsCreatedCount->pluck('total')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    var ctx = document.getElementById('projectsPieChart2').getContext('2d');
    var projectsPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($permissionsInaProjectCount->pluck('type')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($permissionsInaProjectCount->pluck('total')) !!},
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(51, 153, 255, 0.5)',
                'rgba(0, 102, 204, 0.5)',
                'rgba(0, 51, 102, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(51, 153, 255, 1)',
                'rgba(0, 102, 204, 1)',
                'rgba(0, 51, 102, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

var ctx = document.getElementById('projectsPieChart3').getContext('2d');
var projectsPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($projectsCreatedByMeByStatus->pluck('status')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($projectsCreatedByMeByStatus->pluck('total')) !!},
            backgroundColor: [
                'rgba(0, 128, 128, 0.5)', // Darker shade of peacock green
                'rgba(0, 160, 160, 0.5)', // Slightly lighter shade
                'rgba(0, 192, 192, 0.5)', // Lighter shade
                'rgba(0, 224, 224, 0.5)'  // Lightest shade
            ],
            borderColor: [
                'rgba(0, 128, 128, 1)',   // Darker shade of peacock green
                'rgba(0, 160, 160, 1)',   // Slightly lighter shade
                'rgba(0, 192, 192, 1)',   // Lighter shade
                'rgba(0, 224, 224, 1)'    // Lightest shade
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

var ctx = document.getElementById('projectsPieChart4').getContext('2d');
var projectsPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($projectsAssignedByStatus->pluck('status')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($projectsAssignedByStatus->pluck('total')) !!},
            backgroundColor: [
                'rgba(255, 204, 188, 0.5)', // Light peach
                'rgba(255, 178, 153, 0.5)', // Medium peach
                'rgba(255, 153, 102, 0.5)', // Dark peach
                'rgba(255, 128, 77, 0.5)'   // Deeper peach
            ],
            borderColor: [
                'rgba(255, 204, 188, 1)', // Light peach
                'rgba(255, 178, 153, 1)', // Medium peach
                'rgba(255, 153, 102, 1)', // Dark peach
                'rgba(255, 128, 77, 1)'   // Deeper peach
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});


</script>

@endsection

@endsection
