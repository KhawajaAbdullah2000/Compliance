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

    @foreach($chartData as $component => $controls)
    <div class="my_margin_top">
        <h3>{{ $component }} - Risk Levels by Control Group</h3>
        <canvas id="chart-{{ $component }}" width="400" height="200"></canvas>
    </div>

    <script>
        const ctx{{ $component }} = document.getElementById('chart-{{ $component }}').getContext('2d');
        new Chart(ctx{{ $component }}, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($controls->toArray())) !!}, // Control groups (e.g., Control 5, Control 6)
                datasets: [
                    {
                        label: 'Low Risk',
                        backgroundColor: 'rgb(60, 179, 113)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        data: {!! json_encode(array_map(function($item) { return $item['Low'][0] ?? 0; }, $controls->toArray())) !!}
                    },
                    {
                        label: 'Medium Risk',
                        backgroundColor: 'rgb(255, 165, 0)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1,
                        data: {!! json_encode(array_map(function($item) { return $item['Medium'][0] ?? 0; }, $controls->toArray())) !!}
                    },
                    {
                        label: 'High Risk',
                        backgroundColor: 'rgb(255, 0, 0)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: {!! json_encode(array_map(function($item) { return $item['High'][0] ?? 0; }, $controls->toArray())) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Control Groups',
                            color:'black',
                            font:{
                                size:18,
                                weight:900
                            }

                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.5)', // Darker grid lines
                            lineWidth: 2 // Thicker grid lines
                        },
                        ticks: {
                            color: 'black', // Change label color
                            font: {
                                size: 14, // Change label font size
                                weight:700
                            }
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Risk Levels',
                            color:'black',
                            font:{
                                size:15,
                                weight:900
                            }
                        }

                    }
                }
            }
        });
    </script>
@endforeach





</div>

{{-- @section('scripts')
<script>

</script>
@endsection --}}

@endsection
