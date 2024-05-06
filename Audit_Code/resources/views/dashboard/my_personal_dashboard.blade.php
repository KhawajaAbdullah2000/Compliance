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
</script>

@endsection

@endsection
