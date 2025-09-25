{{-- resources/views/compliance_map/all_services_all_controls.blade.php --}}

@extends('master')

@section('content')

@include('user-nav')

<div class="container my-2">
    {{-- ───────────────────────────────────────────────── HEADER INFO ─────────────────────────────────────────────── --}}
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-warning">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td>
                            <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->id() }}">
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
                    <tr>
                        <td class="fw-bold">No. of Services:</td>
                        <td>{{ $uniqueServicesCount }}</td>
                        <td class="fw-bold">No. of Asset Sub-groups:</td>
                        <td>{{ $uniqueSubGroupsCount }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">No. of Asset Groups:</td>
                        <td>{{ $uniqueGroupsCount }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $uniqueComponentsCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ───────────────────────────────────────────────── MAIN CTA ─────────────────────────────────────────────── --}}
    <h3 class="fw-bold text-center mt-4">
        View @if(!session('comp_status')) or Download @endif Compliance Map
        (All Control Domains – All Services – All Applicable Controls)
    </h3>

    <a href="/compliance_map_dashboard_all_services/{{ $project->project_id }}/{{ auth()->id() }}"
       class="btn btn-primary btn-md">
        Compliance Map (All Control Domains – All Services – All Applicable Controls)
    </a>

    {{-- ───────────────────────────────────────────────── TABLES / CHARTS ────────────────────────────────────────── --}}
    @if(isset($formattedResults))

        {{-- ====== CASE 1: no comp_status filter (full matrix) ====== --}}
        @if(!isset($comp_status_count))

            <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">
                Download Excel
            </a>

            <table class="table table-bordered mt-4">
                <thead class="table-secondary">
                    <tr>
                        <th>Domain</th>
                        <th class="bg-success">In Place</th>
                        <th style="background-color: orange">Partially in Place</th>
                        <th class="bg-danger">Not In Place</th>
                        <th style="background-color: rgb(79,174,190)">Not Applicable</th>
                        <th class="bg-secondary">Not Tested</th>
                        <th>Total</th>
                        <th>%</th>
                    </tr>
                </thead>

                @php
                    $columnTotals = ['yes' => 0, 'partial' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0];
                    $grandTotal   = 0;
                @endphp

                <tbody>
                    @forelse($formattedResults as $domain => $statuses)
                        @php
                            $rowTotal = array_sum($statuses);
                            $grandTotal += $rowTotal;
                            foreach (['yes','partial','no','not_applicable','not_tested'] as $st) {
                                $columnTotals[$st] += $statuses[$st] ?? 0;
                            }
                        @endphp
                        <tr>
                            <td>
                                <a href="/select_assets_for_subdomain_map/{{ $domain }}/{{ $project->project_id }}/{{ auth()->id() }}">
                                    {{ $domain }} – {{ $domainNames[$domain] ?? '' }}
                                </a>
                            </td>

                            @foreach(['yes','partial','no','not_applicable','not_tested'] as $st)
                                <td>{{ $statuses[$st] ?? 0 }}</td>
                            @endforeach

                            <td><strong>{{ $rowTotal }}</strong></td>
                            <td><strong>{{ $grandTotal ? ceil(($rowTotal / $grandTotal) * 100) : 0 }}%</strong></td>
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
                        @foreach($columnTotals as $tot)
                            <th>{{ array_sum($columnTotals) ? ceil(($tot / array_sum($columnTotals)) * 100) : 0 }}%</th>
                        @endforeach
                        <th>100%</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        {{-- ====== CASE 2: filtered by one comp_status (pie + simple table) ====== --}}
        @else
            @php
                $statusLabels = [
                    'yes'            => 'In Place',
                    'partial'        => 'Partially in Place',
                    'no'             => 'Not In Place',
                    'not_applicable' => 'Not Applicable',
                    'not_tested'     => 'Not Tested',
                ];
                $statusColors = [
                    'yes'            => 'bg-success text-white',
                    'partial'        => 'bg-warning text-dark',
                    'no'             => 'bg-danger text-white',
                    'not_applicable' => 'bg-primary text-white',
                    'not_tested'     => 'bg-secondary text-white',
                ];
                $statusLabel = $statusLabels[$comp_status] ?? ucfirst($comp_status);
                $statusClass = $statusColors[$comp_status] ?? 'bg-light';
                $grandTotal  = 0;
            @endphp

            <div class="row">
                {{-- ── Left: compact table ── --}}
                <div class="col-md-6">
                    <table class="table table-bordered mt-4">
                        <thead class="table-secondary">
                            <tr>
                                <th>Domain</th>
                                <th class="{{ $statusClass }}">{{ $statusLabel }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($formattedResults as $domain => $statuses)
                                @php $count = $statuses[$comp_status] ?? 0; $grandTotal += $count; @endphp
                                <tr>
                                    <td>
                                        <a href="/select_assets_for_subdomain_map_comp_status/{{ $domain }}/{{ $comp_status }}/{{ $project->project_id }}/{{ auth()->id() }}">
                                            {{ $domain }} – {{ $domainNames[$domain] ?? '' }}
                                        </a>
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
                                <th>{{ $grandTotal }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- ── Right: pie chart ── --}}
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div style="width:400px;height:400px;">
                        <canvas id="compliancePieChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- -- Build chart data arrays here so JS can consume them -- --}}
            @php
                $chartLabels = $chartData = [];
                foreach ($formattedResults as $domain => $statuses) {
                    $count = $statuses[$comp_status] ?? 0;
                    if ($count > 0) {
                        $chartLabels[] = $domain . ' – ' . ($domainNames[$domain] ?? '');
                        $chartData[]   = $count;
                    }
                }
            @endphp
        @endif
    @endif
</div>

{{-- ───────────────────────────────────────────────── SCRIPTS ─────────────────────────────────────────────── --}}
@section('scripts')
@if(isset($comp_status_count) && $comp_status_count == 1)
<script>
    Chart.register(ChartDataLabels);

    const ctx = document.getElementById('compliancePieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [{
                label: '{{ $statusLabel ?? '' }} by Domain',
                data: {!! json_encode($chartData ?? []) !!},
                borderWidth: 1,
                backgroundColor: [
                    '#ce93d8','#2196f3','#ff9800','#9c27b0','#00bcd4',
                    '#e91e63','#3f51b5','#ffc107','#8bc34a','#ff5722',
                    '#795548','#607d8b','#ffeb3b','#009688','#cddc39',
                    '#673ab7','#ff5252','#b2ebf2','#aed581','#dce775',
                    '#f06292','#ba68c8','#90caf9','#fdd835','#a1887f',
                    '#80cbc4','#f48fb1','#81c784','#b3e5fc',
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                datalabels: {
                    color: '#000',
                    font: { size: 14, weight: 'bold' },
                    formatter: (v) => v,
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
@endif

<script>
    $(document).ready(function () {
        // Cache the button and checkboxes
        const downloadExcelButton = $('#downloadExcelButton');
        const projectID = {{ $project->project_id }};
        const userID = {{ auth()->user()->id }};

        // Function to update the Excel download link
        function updateDownloadLink() {

        
            const url = `/download_excel_compliance_map/${projectID}/${userID}`;
            downloadExcelButton.attr('href', url);
        }

        // Update the link on page load and when a checkbox changes
        updateDownloadLink();
    });
</script>
@endsection

@endsection
