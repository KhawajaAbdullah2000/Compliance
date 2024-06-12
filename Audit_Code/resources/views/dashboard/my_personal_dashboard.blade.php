@extends('master')

@section('content')

@include('user-nav')

<div class="container-fluid">


    <h2 class="text-center fw-bold mb-4">Visual and AI Dashboard</h2>

    <div class="row">
        <div class="col-lg-12 text-center mt-4" >
            <h3 class="mb-3">Projects Created by me (by type)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
            <canvas id="projectsPieChart"></canvas>
            </div>
        </div>

        <div class="col-lg-12 text-center mt-4">
            <h3 class="mb-3">Projects where roles are assigned to me (by type)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
            <canvas id="projectsPieChart2"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-12 text-center mt-4">
            <h3 class="mb-3">Projects created by me (by Project Status)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
                <canvas id="projectsPieChart3"></canvas>
            </div>
        </div>

        <div class="col-lg-12 text-center mt-4">
            <h3 class="mb-3">Projects where roles are assigned to me (by Project Status)</h3>
            <div style="width: 400px; height: 400px; margin: auto;">
            <canvas id="projectsPieChart4"></canvas>
            </div>
        </div>
    </div>

</div>

@section('scripts')
<script>
 var ctx1 = document.getElementById('projectsPieChart').getContext('2d');
var projectsPieChart1 = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: {!! json_encode($projectsCreatedCount->pluck('type')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($projectsCreatedCount->pluck('total')) !!},
            backgroundColor: [
                'rgba(255, 59, 59, 0.8)',   // Vibrant Red
                'rgba(34, 202, 34, 0.8)',   // Vibrant Green
                'rgba(59, 130, 246, 0.8)',  // Vibrant Blue
                'rgba(255, 159, 64, 0.8)'   // Vibrant Orange
            ],
            borderColor: [
                'rgba(255, 59, 59, 1)',   // Vibrant Red
                'rgba(34, 202, 34, 1)',   // Vibrant Green
                'rgba(59, 130, 246, 1)',  // Vibrant Blue
                'rgba(255, 159, 64, 1)'   // Vibrant Orange
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

var ctx2 = document.getElementById('projectsPieChart2').getContext('2d');
var projectsPieChart2 = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: {!! json_encode($permissionsInaProjectCount->pluck('type')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($permissionsInaProjectCount->pluck('total')) !!},
            backgroundColor: [
                'rgba(255, 59, 59, 0.8)',   // Vibrant Red
                'rgba(34, 202, 34, 0.8)',   // Vibrant Green
                'rgba(59, 130, 246, 0.8)',  // Vibrant Blue
                'rgba(255, 159, 64, 0.8)'   // Vibrant Orange
            ],
            borderColor: [
                'rgba(255, 59, 59, 1)',   // Vibrant Red
                'rgba(34, 202, 34, 1)',   // Vibrant Green
                'rgba(59, 130, 246, 1)',  // Vibrant Blue
                'rgba(255, 159, 64, 1)'   // Vibrant Orange
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

var ctx3 = document.getElementById('projectsPieChart3').getContext('2d');
var projectsPieChart3 = new Chart(ctx3, {
    type: 'pie',
    data: {
        labels: {!! json_encode($projectsCreatedByMeByStatus->pluck('status')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($projectsCreatedByMeByStatus->pluck('total')) !!},
            backgroundColor: [
                'rgba(255, 59, 59, 0.8)',   // Vibrant Red
                'rgba(34, 202, 34, 0.8)',   // Vibrant Green
                'rgba(59, 130, 246, 0.8)',  // Vibrant Blue
                'rgba(255, 159, 64, 0.8)'   // Vibrant Orange
            ],
            borderColor: [
                'rgba(255, 59, 59, 1)',   // Vibrant Red
                'rgba(34, 202, 34, 1)',   // Vibrant Green
                'rgba(59, 130, 246, 1)',  // Vibrant Blue
                'rgba(255, 159, 64, 1)'   // Vibrant Orange
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

var ctx4 = document.getElementById('projectsPieChart4').getContext('2d');
var projectsPieChart4 = new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: {!! json_encode($projectsAssignedByStatus->pluck('status')) !!},
        datasets: [{
            label: 'Projects Count',
            data: {!! json_encode($projectsAssignedByStatus->pluck('total')) !!},
            backgroundColor: [
                'rgba(255, 59, 59, 0.8)',   // Vibrant Red
                'rgba(34, 202, 34, 0.8)',   // Vibrant Green
                'rgba(59, 130, 246, 0.8)',  // Vibrant Blue
                'rgba(255, 159, 64, 0.8)'   // Vibrant Orange
            ],
            borderColor: [
                'rgba(255, 59, 59, 1)',   // Vibrant Red
                'rgba(34, 202, 34, 1)',   // Vibrant Green
                'rgba(59, 130, 246, 1)',  // Vibrant Blue
                'rgba(255, 159, 64, 1)'   // Vibrant Orange
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
