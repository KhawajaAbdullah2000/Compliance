@extends('master')

@section('content')

@include('user-nav')



<div class="container">

    @php
    function getValue($value) {
        if ($value >= 0 && $value <=20) {
            return 'L';
        } elseif ($value >20 && $value <= 70) {
            return 'M';
        } elseif ($value >70 && $value <= 100) {
            return 'H';
        }
        return 'NA';
    }

    function getRiskColor($value) {
        if ($value >= 0.0 && $value <0.9) {
            return 'lightgreen';
        } elseif ($value >= 0.9 && $value < 7.2) {
            return 'yellow';
        } elseif ($value >=7.2 && $value <= 10.0) {
            return 'pink';
        }
        return 'transparent'; // Default for values outside the range
    }


@endphp


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


<div class="row">
    <div class="col-md-4">
        <form method="GET">
            <!-- Select Service -->
            <div class="form-group">
                <label class="form-label fw-bold">Select Service</label>
                <select class="form-select" name="service">
                    <option value="all" {{ request('service') == 'all' ? 'selected' : '' }}>All</option>
                    @foreach ($servicesInProject as $s )
                        <option value="{{$s->s_name}}" {{ request('service') == $s->s_name ? 'selected' : '' }}>{{$s->s_name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Select Group -->
            <div class="form-group mt-2">
                <label class="form-label fw-bold">Select Group</label>
                <select class="form-select" name="group">
                    <option value="all" {{ request('group') == 'all' ? 'selected' : '' }}>All</option>
                    @foreach ($groupsInProject as $g )
                        <option value="{{$g->g_name}}" {{ request('group') == $g->g_name ? 'selected' : '' }}>{{$g->g_name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Select Asset -->
            <div class="form-group mt-2">
                <label class="form-label fw-bold">Select Asset</label>
                <select class="form-select" name="name">
                    <option value="all" {{ request('name') == 'all' ? 'selected' : '' }}>All</option>
                    @foreach ($namesInProject as $n )
                        <option value="{{$n->name}}" {{ request('name') == $n->name ? 'selected' : '' }}>{{$n->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Select Asset Component -->
            <div class="form-group mt-2">
                <label class="form-label fw-bold">Select Asset Component</label>
                <select class="form-select" name="component">
                    <option value="all" {{ request('component') == 'all' ? 'selected' : '' }}>All</option>
                    @foreach ($componentsInProject as $c )
                        <option value="{{$c->c_name}}" {{ request('component') == $c->c_name ? 'selected' : '' }}>{{$c->c_name}}</option>
                    @endforeach
                </select>
            </div>
    </div>

    <div class="col-md-4">
        <!-- Select Risk Type -->
        <div class="form-group mt-2">
            <label class="form-label fw-bold">Select Risk Type</label>
            <select class="form-select" name="risk_type">
                {{-- <option value="all" {{ request('risk_type') == 'all' ? 'selected' : '' }}>All</option> --}}
                <option value="risk_level" {{ request('risk_type') == 'risk_level' ? 'selected' : '' }}>Confidentiality Risk</option>
                <option value="risk_integrity" {{ request('risk_type') == 'risk_integrity' ? 'selected' : '' }}>Integrity Risk</option>
                <option value="risk_availability" {{ request('risk_type') == 'risk_availability' ? 'selected' : '' }}>Availability Risk</option>
            </select>
        </div>

        <!-- Select Control Group -->
        <div class="form-group mt-4">
            <label class="form-label fw-bold">Select Control Group</label>
            <select class="form-select" name="control_group">
                <option value="all" {{ request('control_group') == 'all' ? 'selected' : '' }}>All</option>
                <option value="5" {{ request('control_group') == '5' ? 'selected' : '' }}>ISO 27001:2022 Annex A Control Group 5</option>
                <option value="6" {{ request('control_group') == '6' ? 'selected' : '' }}>ISO 27001:2022 Annex A Control Group 6</option>
                <option value="7" {{ request('control_group') == '7' ? 'selected' : '' }}>ISO 27001:2022 Annex A Control Group 7</option>
                <option value="8" {{ request('control_group') == '8' ? 'selected' : '' }}>ISO 27001:2022 Annex A Control Group 8</option>
            </select>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">Compute Risk Distribution</button>
        </div>

        <div class="form-group mt-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#heatmapModal">
                View Risk Heatmap
            </button>
        </div>


    </div>
</form>


   <!-- Modal for heatmap -->
   <div class="modal fade" id="heatmapModal" tabindex="-1" aria-labelledby="heatmapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="heatmapModalLabel">Risk Heatmap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Heatmap canvas -->
                <canvas id="heatmapChart" width="600" height="400"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>

</div>




<h4 class="mt-4 text-center fw-bold">Risk Distribution Results</h4>

    @if($results->isEmpty())
        <p>No data available for the selected filters.</p>
    @else
        @if(request('component') == 'all'|| request('component')==null)
            @foreach($results->groupBy('c_name') as $componentName => $componentResults)



            <div class="card mt-4 bg-secondary text-white cursor-pointer" data-bs-toggle="collapse" href="#collapseTable{{ $loop->index }}" role="button" aria-expanded="false" aria-controls="collapseTable{{ $loop->index }}">
                <div class="card-body">
                        <h5 class="card-title">Component: {{ $componentName }}</h5>
                        <p class="card-text"><strong>Service Name:</strong> {{ $componentResults->first()->s_name }}</p>
                        <p class="card-text"><strong>Group Name:</strong> {{ $componentResults->first()->g_name }}</p>
                        <p class="card-text"><strong>Asset Name:</strong> {{ $componentResults->first()->name }}</p>
                    </div>
                </div>

                <div class="collapse" id="collapseTable{{ $loop->index }}">

                <table class="table table-bordered fw-bold">
                    <thead>
                        <tr>
                            <th>Control Number</th>
                            <th>Vulnerability %</th>
                            <th>Threat %</th>

                            <!-- Conditionally display risk columns -->

                            @if(request('risk_type') == 'all' || request('risk_type') == null)
                            <th>Confidentiality Risk</th>
                            {{-- <th>Integrity Risk</th>
                            <th>Availability Risk</th> --}}
                        @endif

                            @if(request('risk_type') == 'all' || request('risk_type') == 'risk_level')
                                <th>Confidentiality Risk</th>
                            @endif
                            @if(request('risk_type') == 'all' || request('risk_type') == 'risk_integrity')
                                <th>Integrity Risk</th>
                            @endif
                            @if(request('risk_type') == 'all' || request('risk_type') == 'risk_availability')
                                <th>Availability Risk</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($componentResults as $result)
                            <tr>
                                <td>{{ $result->control_num }}</td>
                                <td>{{ getValue($result->vulnerability) }}</td>
                                <td >{{ getValue($result->threat) }}</td>

                                <!-- Conditionally display risk values -->

                                @if(request('risk_type') == 'all' || request('risk_type') == null)
                                <td style="background-color: {{ getRiskColor($result->risk_level) }}">{{ $result->risk_level ?? 'N/A' }}</td>
                                {{-- <td style="background-color: {{ getRiskColor($result->risk_integrity) }}">{{ $result->risk_integrity ?? 'N/A' }}</td>
                                <td style="background-color: {{ getRiskColor($result->risk_availability) }}"> {{ $result->risk_availability ?? 'N/A' }}</td> --}}

                                @endif



                                @if(request('risk_type') == 'all' || request('risk_type') == 'risk_level')
                                    <td style="background-color: {{ getRiskColor($result->risk_level) }}">{{ $result->risk_level ?? 'N/A' }}</td>
                                @endif
                                @if(request('risk_type') == 'all' || request('risk_type') == 'risk_integrity')
                                    <td style="background-color: {{ getRiskColor($result->risk_integrity) }}">{{ $result->risk_integrity ?? 'N/A' }}</td>
                                @endif
                                @if(request('risk_type') == 'all' || request('risk_type') == 'risk_availability')
                                    <td style="background-color: {{ getRiskColor($result->risk_availability) }}">{{ $result->risk_availability ?? 'N/A' }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        @else
            <!-- Single table for All data -->
            <!-- Display Asset and Service Details Above the Table -->

            <div class="card mt-4 bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title"><strong>Service Name:</strong> {{ $results->first()->s_name }}</h5>

                </div>
            </div>




            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Control Number</th>
                        <th>Vulnerability %</th>
                        <th>Threat %</th>

                        <!-- Conditionally display risk columns -->

                        @if(request('risk_type') == 'all' || request('risk_type') == null)
                        <th>Risk Confidentiality</th>
                        {{-- <th>Risk Integrity</th>
                        <th>Risk Availability</th> --}}
                    @endif

                        @if(request('risk_type') == 'all' || request('risk_type') == 'risk_level')
                            <th>Risk Confidentiality</th>
                        @endif
                        @if(request('risk_type') == 'all' || request('risk_type') == 'risk_integrity')
                            <th>Risk Integrity</th>
                        @endif
                        @if(request('risk_type') == 'all' || request('risk_type') == 'risk_availability')
                            <th>Risk Availability</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                        <tr>
                            <td>{{ $result->control_num }}</td>
                            <td >{{ getValue($result->vulnerability) }}</td>
                            <td >{{ getValue($result->threat) }}</td>
                            <!-- Conditionally display risk values -->

                            @if(request('risk_type') == 'all' || request('risk_type') == null)
                            <td style="background-color: {{ getRiskColor($result->risk_level) }}">{{ $result->risk_level ?? 'N/A' }}</td>
                            {{-- <td style="background-color: {{ getRiskColor($result->risk_integrity) }}">{{ $result->risk_integrity ?? 'N/A' }}</td>
                            <td style="background-color: {{ getRiskColor($result->risk_availability) }}">{{ $result->risk_availability ?? 'N/A' }}</td> --}}

                            @endif

                            @if(request('risk_type') == 'all' || request('risk_type') == 'risk_level')
                                <td style="background-color: {{ getRiskColor($result->risk_level) }}">{{ $result->risk_level ?? 'N/A' }}</td>
                            @endif
                            @if(request('risk_type') == 'all' || request('risk_type') == 'risk_integrity')
                                <td style="background-color: {{ getRiskColor($result->risk_integrity) }}">{{ $result->risk_integrity ?? 'N/A' }}</td>
                            @endif
                            @if(request('risk_type') == 'all' || request('risk_type') == 'risk_availability')
                                <td style="background-color: {{ getRiskColor($result->risk_availability) }}">{{ $result->risk_availability ?? 'N/A' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</div>



@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('click', function () {
                const targetId = this.getAttribute('data-bs-target');
                const targetCollapse = document.querySelector(targetId);
                targetCollapse.classList.toggle('show');
            });
        });
    });
</script>

<script>
    const vulnerabilityLabels = ['Low', 'Medium', 'High'];
    const threatLabels = ['Low', 'Medium', 'High'];

    const scatterPlotData = [
        { x: 1, y: 1, r: {{ $scatterPlotData[0]['r'] }} },  // Low Vulnerability, Low Threat
        { x: 1, y: 2, r: {{ $scatterPlotData[1]['r'] }} },  // Low Vulnerability, Medium Threat
        { x: 1, y: 3, r: {{ $scatterPlotData[2]['r'] }} },  // Low Vulnerability, High Threat
        { x: 2, y: 1, r: {{ $scatterPlotData[3]['r'] }} },  // Medium Vulnerability, Low Threat
        { x: 2, y: 2, r: {{ $scatterPlotData[4]['r'] }} },  // Medium Vulnerability, Medium Threat
        { x: 2, y: 3, r: {{ $scatterPlotData[5]['r'] }} },  // Medium Vulnerability, High Threat
        { x: 3, y: 1, r: {{ $scatterPlotData[6]['r'] }} },  // High Vulnerability, Low Threat
        { x: 3, y: 2, r: {{ $scatterPlotData[7]['r'] }} },  // High Vulnerability, Medium Threat
        { x: 3, y: 3, r: {{ $scatterPlotData[8]['r'] }} }   // High Vulnerability, High Threat
    ];

    const ctx = document.getElementById('heatmapChart').getContext('2d');
    const scatterChart = new Chart(ctx, {
        type: 'scatter',  // Use 'bubble' for scatter plot with radius
        data: {
            datasets: [{
                label: 'Risk Count',
                data: scatterPlotData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',  // Color of bubbles
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                // Fixed size for each point
                radius: 10  // Fixed radius size
            }]
        },
        options: {
            responsive: true,
            animation: {
        duration: 1200,  // Animation duration in milliseconds
        easing: 'easeInQuad'  // Easing effect for the animation
    },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Vulnerability',
                        font: {
                            size: 16,  // Set font size
                            weight: 'bold'  // Make it bold
                        }
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return vulnerabilityLabels[index];
                        },
                        stepSize: 1,
                        beginAtZero: true,
                        max: 3
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Threat',
                        font: {
                            size: 16,  // Set font size
                            weight: 'bold'  // Make it bold
                        }
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return threatLabels[index];
                        },
                        stepSize: 1,
                        beginAtZero: true,
                        max: 3
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const vulnerability = vulnerabilityLabels[context.raw.x - 1];
                            const threat = threatLabels[context.raw.y - 1];
                            const riskCount = context.raw.r;
                            return `Vulnerability: ${vulnerability}, Threat: ${threat}, Risk Count: ${riskCount}`;
                        }
                    }
                }
            }
        }
    });
</script>



@endsection


@endsection
