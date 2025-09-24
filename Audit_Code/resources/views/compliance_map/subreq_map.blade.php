@extends('master')

@section('content')

@include('user-nav')

<div class="container my-2">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-warning">
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
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold text-center mt-4">View @if(!session('comp_status')) or Download @endif Compliance Map (Selected Domain-Selected Service-Selected Asset-Selected Subdomain-All Applicable Controls)</h3>

    <div class="row">

        <div class="col-md-6">


            <h4><span class="fw-bold mt-4">Domain {{$MainDomainNum}} :</span>{{$MainDomainTitle}}</h4>
            <h4><span class="fw-bold">Service Selected : </span>
                @if($service=='_all')
                All services - All Controls
                @else
                {{$service}} - All Controls
                @endif
            </h4>

            <h5><span class="fw-bold">Assets Selected : </span>
                @isset($group)
                @if($group=='_all')
                All Asset Types -
                @else
                {{$group}} -
                @endif
                @endisset


                @isset($subgroup)
                @if($subgroup=='_all')
                All Asset Sub Types -
                @else
                {{$subgroup}} -
                @endif
                @endisset

                @if($component=='_all')

                All Asset Components

                @else

                {{$component}}
                @endif
            </h5>

            <h5><span class="fw-bold mt-4">Subdomain {{$subdomainNum}} :</span> {{$subdomainTitle}}</h5>
        </div>

        @if(session('comp_status'))
        <div class="col-md-6 position-relative">
            <a href="/compliance_map_all_services_comp_type/{{$project->project_id}}/{{auth()->user()->id}}/{{session('comp_status')}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">Compliance Map - All Services - All Controls</a>
        </div>

        @else
        <div class="col-md-6 position-relative">
            <a href="/compliance_map_all_services/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">Compliance Map - All Services - All Controls</a>
        </div>
        @endif

    </div>
    @if(isset($formattedResults))

    @if(session('comp_status'))
    @php
    $comp_status = session('comp_status');

    if (!$comp_status) return;

    $statusLabels = [
    'yes' => 'In Place',
    'no' => 'Not In Place',
    'not_applicable' => 'Not Applicable',
    'not_tested' => 'Not Tested',
    'partial' => 'Partial',
    ];

    $statusLabel = $statusLabels[$comp_status] ?? ucfirst($comp_status);

    $statusColors = [
    'yes' => 'bg-success text-white', // green
    'no' => 'bg-danger text-white', // red
    'partial' => 'bg-warning text-dark', // orange/yellow
    'not_applicable' => 'bg-primary text-white', // blue
    'not_tested' => 'bg-secondary text-white', // grey
    ];

    $statusClass = $statusColors[$comp_status] ?? 'bg-light';
    $columnTotal = 0;

    $chartLabels = [];
    $chartData = [];

    foreach ($formattedResults as $subReq => $statuses) {
    $count = $statuses[$comp_status] ?? 0;
    if ($count > 0) {
    $columnTotal += $count;
    $chartLabels[] = $subReq . (isset($UniqueSubReqs[$subReq]) ? ' – ' . $UniqueSubReqs[$subReq] : '');
    $chartData[] = $count;
    }
    }
    @endphp

    <div class="row">

        <div class="col-md-6">
            <table class="table table-bordered mt-4">
                <thead class="table-secondary">
                    <tr>
                        <th>Sub Requirement</th>
                        <th class="{{$statusClass}}">{{ $statusLabel }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formattedResults as $subReq => $statuses)
                    {{-- @php
                $count = $statuses[$comp_status] ?? 0;
                $columnTotal += $count;
            @endphp --}}
                    <tr>
                        <td>
                            {{ $subReq }}
                            @if(isset($UniqueSubReqs[$subReq]))
                            – {{ $UniqueSubReqs[$subReq] }}
                            @endif
                        </td>
                        <td>{{ $count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th>{{ $columnTotal }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div style="width: 500px; height: 500px;">
                <canvas id="compliancePieChart"></canvas>
            </div>
        </div>

    </div>



    @else

    <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>

    <table class="table table-bordered mt-4">
        <thead class="table-secondary">
            <tr>
                <th>Domain</th>
                <th class="bg-success">In Place</th>
                <th style="background-color: orange">Partially in Place</th>
                <th class="bg-danger">Not In Place</th>
                <th style="background-color: rgb(79, 174, 190)">Not Applicable</th>
                <th class="bg-secondary">Not Tested</th>
                <th>Total</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @php
            $rowTotal2=0;
            $grandTotal=0;
            // Initialize column totals
            $columnTotals = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];
            @endphp

            {{-- FOr row percentage --}}
            @foreach($formattedResults as $statuses)
          
            @php
            // Calculate row total and add to grand total
            $rowTotal2 = array_sum($statuses);
            $grandTotal += $rowTotal2;
            @endphp
            @endforeach

            @forelse($formattedResults as $domain => $statuses)
            <tr>
                <td>
                      
                    @foreach($UniqueSubReqs as $sub_req=>$value)
                
                    @if ($sub_req==$domain)
                    <a href="{{ route('compliance_map_sub_req_components', [
                        'domain' => $domain,
                        'service' => $service,
                        'component' => $component,
                        'proj_id' => $project->project_id,
                    
                    ]) }}?group={{ $group }}&subgroup={{ $subgroup }}">
     {{ $domain }}-
                  {{$value}}
                </a>

                    @endif

                    @endforeach

                </td>

                @php
                // Calculate row total
                $rowTotal = 0;
                @endphp

                @foreach(['yes', 'partial','no', 'not_applicable', 'not_tested', ] as $status)
                @php
                $count = $statuses[$status] ?? 0;
                $rowTotal += $count;
                $columnTotals[$status] += $count;
                @endphp
                <td>{{ $count }}</td>
                @endforeach

                <td><strong>{{ $rowTotal }}</strong></td>

                <!-- Row Percentage -->
                <td>
                    <strong>
                        @if($grandTotal > 0)
                        {{ ceil(($rowTotal / $grandTotal) * 100) }}%
                        @else
                        0%
                        @endif
                    </strong>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No data available</td>
            </tr>
            @endforelse

        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>{{ $columnTotals['yes'] }}</th>
                <th>{{ $columnTotals['partial'] }}</th>
                <th>{{ $columnTotals['no'] }}</th>
                <th>{{ $columnTotals['not_applicable'] }}</th>
                <th>{{ $columnTotals['not_tested'] }}</th>

                <th>{{ array_sum($columnTotals) }}</th>
                <th>100%</th>

            </tr>

            <tr>
                <th>%</th>
                <th>{{ ceil( ($columnTotals['yes']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['partial']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['no']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['not_applicable']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['not_tested']/array_sum($columnTotals) )*100 )}}%</th>

                <th>100 %</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <a id="downloadExcelButton2" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>

    @endif


    @endif


</div>

{{-- @section('scripts')

@if(session('comp_status'))

<script>
    console.log("IN comp status")
    Chart.register(ChartDataLabels);

    const ctx = document.getElementById('compliancePieChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie'
        , data: {
            labels: {
                !! json_encode($chartLabels) !!
            }
            , datasets: [{
                label: '{{ $statusLabel }} by Sub Requirement'
                , data: {
                    !! json_encode($chartData) !!
                }
                , backgroundColor: [
                    '#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#00bcd4', '#e91e63'
                    , '#3f51b5', '#ffc107', '#8bc34a', '#ff5722', '#795548', '#607d8b'
                ]
                , borderWidth: 1
            }]
        }
        , options: {
            responsive: true
            , plugins: {
                legend: {
                    display: false
                }
                , datalabels: {
                    color: '#000'
                    , font: {
                        weight: 'bold'
                        , size: 14
                    }
                    , formatter: function(value) {
                        return value;
                    }
                }
            }
        }
        , plugins: [ChartDataLabels]
    });

</script>

@endif

<script>
    $(document).ready(function() {
        // Cache the button and checkboxes
        const downloadExcelButton = $('#downloadExcelButton');
        const downloadExcelButton2 = $('#downloadExcelButton2');
        const projectID = {
            {
                $project->project_id
            }
        };
        const userID = {
            {
                auth()->user()-> id
            }
        };
        const formattedResult = @json($results);


        // Function to update the Excel download link
        function updateDownloadLink() {
            const formattedResultEncoded = encodeURIComponent(JSON.stringify(formattedResult));


            const url = `/download_excel_compliance_map_subreq/${projectID}/${userID}?formattedResult=${formattedResultEncoded}`;
            downloadExcelButton.attr('href', url);
            downloadExcelButton2.attr('href', url);
        }

        // Update the link on page load and when a checkbox changes
        updateDownloadLink();
    });

</script>

@endsection --}}

@section('scripts')

@if(session('comp_status'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('compliancePieChart');
    if (!canvas) return;

    // Register plugin only once (Chart.js 4)
    if (typeof ChartDataLabels !== 'undefined') {
        Chart.register(ChartDataLabels);
    }

    const ctx = canvas.getContext('2d');

    // ✅ Proper JSON injection (arrays, not objects)
    const labels = {!! json_encode($chartLabels ?? []) !!};
    const data   = {!! json_encode($chartData ?? []) !!};

    // Optional: skip rendering if no data
    if (!data.length || data.every(v => v === 0)) return;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: '{{ $statusLabel ?? "Status" }} by Sub Requirement',
                data: data,
                backgroundColor: [
                    '#4caf50','#2196f3','#ff9800','#9c27b0','#00bcd4','#e91e63',
                    '#3f51b5','#ffc107','#8bc34a','#ff5722','#795548','#607d8b'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#000',
                    font: { weight: 'bold', size: 14 },
                    formatter: (value) => value
                }
            }
        }
    });
});
</script>
@endif

<script>
$(function () {
    const downloadExcelButton  = $('#downloadExcelButton');
    const downloadExcelButton2 = $('#downloadExcelButton2');

    // ✅ Correct Blade variables (no stray braces/spaces)
    const projectID = {{ $project->project_id }};
    const userID    = {{ auth()->user()->id }};

    // Ensure $results exists; fall back to empty object/array if needed
    const formattedResult = @json($results ?? []);

    function updateDownloadLink() {
        const formattedResultEncoded = encodeURIComponent(JSON.stringify(formattedResult));
        const url = `/download_excel_compliance_map_subreq/${projectID}/${userID}?formattedResult=${formattedResultEncoded}`;
        downloadExcelButton.attr('href', url);
        downloadExcelButton2.attr('href', url);
    }

    updateDownloadLink();
});
</script>

@endsection


@endsection
