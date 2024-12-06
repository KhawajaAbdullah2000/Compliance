
@extends('master')

@section('content')

@include('user-nav')



<div class="container my-2">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->user()->id }}">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ auth()->user()->organization->sub_org }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">Service</td>
                        <td>{{ $s_name }}</td>
                        <td class="fw-bold">Asset</td>
                        <td>{{ $name }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">Group</td>
                        <td>{{ $g_name }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $distinctComponentCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="text-center fw-bold">Risk and Compliance Heatmap for Service: {{$s_name}} Group: {{$g_name}} and Asset: {{$name}}</h3>

    <div class="row text-center">
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-success text-white fw-bold" style="height: 150px;">
                <span class='fs-5 p-1'>% full compliance of
                    mandatory controls
                    </span>
                <span class='fs-4'>{{ round($yesCount, 2) }}%</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-primary text-white fw-bold" style="height: 150px;">
                <span class="fs-5 p-1">% Partial Compliance of
                    mandatory controls</span>
                <span class="fs-4">{{ round($partialCount, 2) }}%</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-danger text-white fw-bold" style="height: 150px;">
                <span class="fs-5 p-1">% Non Compliance of
                    mandatory controls</span>
                <span class="fs-4">{{ round($noCount, 2) }}%</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center border bg-warning text-white fw-bold" style="height: 150px;">
                <span class="fs-5 p-1">% Action Plan where
                    compliance is not full</span>
                <span class="fs-4">{{ round($actionPlanCount, 2) }}%</span>
            </div>
        </div>
    </div>

    <div class="modal fade" id="heatmapRiskConfidentialityModal" tabindex="-1" aria-labelledby="heatmapRiskConfidentialityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="heatmapRiskConfidentialityModalLabel">Risk Confidentiality Heatmap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Heatmap canvas -->
                    <canvas id="heatmapRiskConfidentialityChart" width="600" height="400"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="heatmapRiskIntegrityModal" tabindex="-1" aria-labelledby="heatmapRiskIntegrityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="heatmapRiskIntegrityModalLabel">Risk Integrity Heatmap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Heatmap canvas -->
                    <canvas id="heatmapRiskIntegrityChart" width="600" height="400"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="heatmapRiskAvailabilityModal" tabindex="-1" aria-labelledby="heatmapRiskAvailabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="heatmapRiskAvailabilityModalLabel">Risk Integrity Heatmap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Heatmap canvas -->
                    <canvas id="heatmapRiskAvailabilityChart" width="600" height="400"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    
    {{-- Heatmap --}}
    <div class="row mt-4" >

        <div class="col-md-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#heatmapRiskConfidentialityModal">
                View Risk Heatmap for Risk Confidentiality
            </button>

        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#heatmapRiskIntegrityModal">
                View Risk Heatmap for Risk Integrity
            </button>

        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#heatmapRiskAvailabilityModal">
                View Risk Heatmap for Risk Availability
            </button>

        </div>


    </div>











</div>




@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


<script>
    const vulnerabilityLabels = ['Low', 'Medium', 'High'];
    const threatLabels = ['Low', 'Medium', 'High'];

    const scatterPlotDataRiskConfidentiality = [
    { x: 1, y: 1, riskCount: {{ $scatterPlotDataRiskConfidentiality[0]['r'] ?? 0 }} },  // Low Vulnerability, Low Threat
    { x: 1, y: 2, riskCount: {{ $scatterPlotDataRiskConfidentiality[1]['r'] ?? 0 }} },  // Low Vulnerability, Medium Threat
    { x: 1, y: 3, riskCount: {{ $scatterPlotDataRiskConfidentiality[2]['r'] ?? 0 }} },  // Low Vulnerability, High Threat
    { x: 2, y: 1, riskCount: {{ $scatterPlotDataRiskConfidentiality[3]['r'] ?? 0 }} },  // Medium Vulnerability, Low Threat
    { x: 2, y: 2, riskCount: {{ $scatterPlotDataRiskConfidentiality[4]['r'] ?? 0 }} },  // Medium Vulnerability, Medium Threat
    { x: 2, y: 3, riskCount: {{ $scatterPlotDataRiskConfidentiality[5]['r'] ?? 0 }} },  // Medium Vulnerability, High Threat
    { x: 3, y: 1, riskCount: {{ $scatterPlotDataRiskConfidentiality[6]['r'] ?? 0 }} },  // High Vulnerability, Low Threat
    { x: 3, y: 2, riskCount: {{ $scatterPlotDataRiskConfidentiality[7]['r'] ?? 0 }} },  // High Vulnerability, Medium Threat
    { x: 3, y: 3, riskCount: {{ $scatterPlotDataRiskConfidentiality[8]['r'] ?? 0 }} }   // High Vulnerability, High Threat
];


// Function to scale the radius based on risk count
function scaleRadius(riskCount, minRisk, maxRisk, minRadius, maxRadius) {
    if (minRisk === maxRisk) {
        return minRadius; // Avoid division by zero
    }
    return ((riskCount - minRisk) / (maxRisk - minRisk)) * (maxRadius - minRadius) + minRadius;
}

// Find min and max risk counts
const riskCountsConfidentiality = scatterPlotDataRiskConfidentiality.map(data => data.riskCount);
const minRiskscatterPlotDataRiskConfidentiality = Math.min(...riskCountsConfidentiality);
const maxRiskscatterPlotDataRiskConfidentiality = Math.max(...riskCountsConfidentiality);



const minRadius = 10;  // Minimum bubble size
const maxRadius = 30; // Maximum bubble size

// Update scatterPlotData to include scaled radius
const scaledScatterPlotDataRiskConfidentiality = scatterPlotDataRiskConfidentiality.map(data => ({
    ...data,
    r: scaleRadius(data.riskCount, minRiskscatterPlotDataRiskConfidentiality, maxRiskscatterPlotDataRiskConfidentiality, minRadius, maxRadius)  // Scale radius
}));

const ctxConfidentiality = document.getElementById('heatmapRiskConfidentialityChart').getContext('2d');
Chart.register(ChartDataLabels);

const scatterChartConfidentiality = new Chart(ctxConfidentiality, {
    type: 'bubble',  // Use 'bubble' type to enable variable radius
    data: {
        datasets: [{
            label: 'Data Confidentiality Risk Count',
            data: scaledScatterPlotDataRiskConfidentiality,  // Use data with scaled radius
            backgroundColor: 'rgba(54, 162, 235, 0.5)',  // Bubble color
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const vulnerability = vulnerabilityLabels[context.raw.x - 1];
                        const threat = threatLabels[context.raw.y - 1];
                        const riskCount = context.raw.riskCount;
                        return `Vulnerability: ${vulnerability}, Threat: ${threat}, Risk Count: ${riskCount}`;
                    }
                }
            },
            datalabels: {
                align: 'center',
                anchor: 'center',
                formatter: function(value) {
                    return value.riskCount;  // Show the risk count on the bubble
                },
                color: '#000',  // Text color for the count
                font: {
                    weight: 'bold'
                }
            }
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
                    font: {
                        size: 12,  // Set font size

                    },
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
                    font: {
                        size: 12,  // Set font size

                    },
                    beginAtZero: true,
                    max: 3
                }
            }
        }
    }
});


//FOr Data Integrity
const scatterPlotDataRiskIntegrity = [
    { x: 1, y: 1, riskCount: {{ $scatterPlotDataRiskIntegrity[0]['r'] ?? 0 }} },  // Low Vulnerability, Low Threat
    { x: 1, y: 2, riskCount: {{ $scatterPlotDataRiskIntegrity[1]['r'] ?? 0 }} },  // Low Vulnerability, Medium Threat
    { x: 1, y: 3, riskCount: {{ $scatterPlotDataRiskIntegrity[2]['r'] ?? 0 }} },  // Low Vulnerability, High Threat
    { x: 2, y: 1, riskCount: {{ $scatterPlotDataRiskIntegrity[3]['r'] ?? 0 }} },  // Medium Vulnerability, Low Threat
    { x: 2, y: 2, riskCount: {{ $scatterPlotDataRiskIntegrity[4]['r'] ?? 0 }} },  // Medium Vulnerability, Medium Threat
    { x: 2, y: 3, riskCount: {{ $scatterPlotDataRiskIntegrity[5]['r'] ?? 0 }} },  // Medium Vulnerability, High Threat
    { x: 3, y: 1, riskCount: {{ $scatterPlotDataRiskIntegrity[6]['r'] ?? 0 }} },  // High Vulnerability, Low Threat
    { x: 3, y: 2, riskCount: {{ $scatterPlotDataRiskIntegrity[7]['r'] ?? 0 }} },  // High Vulnerability, Medium Threat
    { x: 3, y: 3, riskCount: {{ $scatterPlotDataRiskIntegrity[8]['r'] ?? 0 }} }   // High Vulnerability, High Threat
];




// Find min and max risk counts
const riskCountsIntegrity = scatterPlotDataRiskIntegrity.map(data => data.riskCount);
const minRiskscatterPlotDataRiskIntegrity = Math.min(...riskCountsIntegrity);
const maxRiskscatterPlotDataRiskIntegrity = Math.max(...riskCountsIntegrity);

console.log("MIn risk for integrity ",minRiskscatterPlotDataRiskIntegrity)
console.log("Max risk for integrity ",maxRiskscatterPlotDataRiskIntegrity)


// Update scatterPlotData to include scaled radius
const scaledScatterPlotDataRiskIntegrity = scatterPlotDataRiskIntegrity.map(data => ({
    ...data,
    r: scaleRadius(data.riskCount, minRiskscatterPlotDataRiskIntegrity, maxRiskscatterPlotDataRiskIntegrity, minRadius, maxRadius)  // Scale radius
}));


const ctxIntegrity = document.getElementById('heatmapRiskIntegrityChart').getContext('2d');
Chart.register(ChartDataLabels);

const scatterChartIntegrity = new Chart(ctxIntegrity, {
    type: 'bubble',  // Use 'bubble' type to enable variable radius
    data: {
        datasets: [{
            label: 'Data Integrity Risk Count',
            data: scaledScatterPlotDataRiskIntegrity,  // Use data with scaled radius
            backgroundColor: 'rgba(54, 162, 235, 0.5)',  // Bubble color
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const vulnerability = vulnerabilityLabels[context.raw.x - 1];
                        const threat = threatLabels[context.raw.y - 1];
                        const riskCount = context.raw.riskCount;
                        return `Vulnerability: ${vulnerability}, Threat: ${threat}, Risk Count: ${riskCount}`;
                    }
                }
            },
            datalabels: {
                align: 'center',
                anchor: 'center',
                formatter: function(value) {
                    return value.riskCount;  // Show the risk count on the bubble
                },
                color: '#000',  // Text color for the count
                font: {
                    weight: 'bold'
                }
            }
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
                    font: {
                        size: 12,  // Set font size

                    },
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
                    font: {
                        size: 12,  // Set font size

                    },
                    beginAtZero: true,
                    max: 3
                }
            }
        }
    }
});

//FOr Data Availability
const scatterPlotDataRiskAvailability = [
    { x: 1, y: 1, riskCount: {{ $scatterPlotDataRiskAvailability[0]['r'] ?? 0 }} },  // Low Vulnerability, Low Threat
    { x: 1, y: 2, riskCount: {{ $scatterPlotDataRiskAvailability[1]['r'] ?? 0 }} },  // Low Vulnerability, Medium Threat
    { x: 1, y: 3, riskCount: {{ $scatterPlotDataRiskAvailability[2]['r'] ?? 0 }} },  // Low Vulnerability, High Threat
    { x: 2, y: 1, riskCount: {{ $scatterPlotDataRiskAvailability[3]['r'] ?? 0 }} },  // Medium Vulnerability, Low Threat
    { x: 2, y: 2, riskCount: {{ $scatterPlotDataRiskAvailability[4]['r'] ?? 0 }} },  // Medium Vulnerability, Medium Threat
    { x: 2, y: 3, riskCount: {{ $scatterPlotDataRiskAvailability[5]['r'] ?? 0 }} },  // Medium Vulnerability, High Threat
    { x: 3, y: 1, riskCount: {{ $scatterPlotDataRiskAvailability[6]['r'] ?? 0 }} },  // High Vulnerability, Low Threat
    { x: 3, y: 2, riskCount: {{ $scatterPlotDataRiskAvailability[7]['r'] ?? 0 }} },  // High Vulnerability, Medium Threat
    { x: 3, y: 3, riskCount: {{ $scatterPlotDataRiskAvailability[8]['r'] ?? 0 }} }   // High Vulnerability, High Threat
];




// Find min and max risk counts
const riskCountsAvailability = scatterPlotDataRiskAvailability .map(data => data.riskCount);
const minRiskscatterPlotDataRiskAvailability = Math.min(...riskCountsAvailability);
const maxRiskscatterPlotDataRiskAvailability  = Math.max(...riskCountsAvailability);



// Update scatterPlotData to include scaled radius
const scaledScatterPlotDataRiskAvailability  = scatterPlotDataRiskAvailability .map(data => ({
    ...data,
    r: scaleRadius(data.riskCount, minRiskscatterPlotDataRiskAvailability , maxRiskscatterPlotDataRiskAvailability , minRadius, maxRadius)  // Scale radius
}));


const ctxAvailability  = document.getElementById('heatmapRiskAvailabilityChart').getContext('2d');
Chart.register(ChartDataLabels);

const scatterChartAvailability  = new Chart(ctxAvailability , {
    type: 'bubble',  // Use 'bubble' type to enable variable radius
    data: {
        datasets: [{
            label: 'Data Availability Risk Count',
            data: scaledScatterPlotDataRiskAvailability ,  // Use data with scaled radius
            backgroundColor: 'rgba(54, 162, 235, 0.5)',  // Bubble color
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const vulnerability = vulnerabilityLabels[context.raw.x - 1];
                        const threat = threatLabels[context.raw.y - 1];
                        const riskCount = context.raw.riskCount;
                        return `Vulnerability: ${vulnerability}, Threat: ${threat}, Risk Count: ${riskCount}`;
                    }
                }
            },
            datalabels: {
                align: 'center',
                anchor: 'center',
                formatter: function(value) {
                    return value.riskCount;  // Show the risk count on the bubble
                },
                color: '#000',  // Text color for the count
                font: {
                    weight: 'bold'
                }
            }
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
                    font: {
                        size: 12,  // Set font size

                    },
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
                    font: {
                        size: 12,  // Set font size

                    },
                    beginAtZero: true,
                    max: 3
                }
            }
        }
    }
});





   
</script>



@endsection



@endsection