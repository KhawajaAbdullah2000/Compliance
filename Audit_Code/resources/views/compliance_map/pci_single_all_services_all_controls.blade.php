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
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Services:</td>
                        <td>{{$uniqueServicesCount }}</td>
                        <td class="fw-bold">No. of Asset Subgroups:</td>
                        <td>{{ $uniqueSubGroupsCount }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Asset Groups:</td>
                        <td>{{$uniqueGroupsCount }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $uniqueComponentsCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold text-center mt-4">View @if(!session('comp_status')) or Download @endif Compliance Map (All Control Domains-All Services-All Applicable Controls)</h3>

    <a href="/compliance_map_dashboard_all_services/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md">Compliance Map (All Control Domains- All Services-All Applicable Controls)</a>

    @if(isset($formattedResults))

    @if(!isset($comp_status_count) )

    <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>

    <table class="table table-bordered mt-4">
        <thead class="table-dark">
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

            @foreach($formattedResults as $statuses)
            @php
                // Calculate row total and add to grand total
                $rowTotal2 = array_sum($statuses);
                $grandTotal += $rowTotal2;
            @endphp
            @endforeach


            @forelse($formattedResults as $domain => $statuses)
                <tr>
                    <td><a href="/select_assets_for_subdomain_map/{{$domain}}/{{$project->project_id}}/{{auth()->user()->id}}">
                        
                        {{ $domain }}- @if($domain==1) Install and Maintain Network Security Controls

                        @elseif($domain==2)
                        Apply Secure Configurations to All System Components

                        @elseif($domain==3)
                        Protect Stored Account Data

                        @elseif($domain==4)
                        Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks

                        @elseif($domain==5)
                        Protect All Systems and Networks from Malicious Software

                        @elseif($domain==6)
                        Develop and Maintain Secure Systems and Software

                        @elseif($domain==7)
                        Restrict Access to System Components and Cardholder Data by Business Need to Know

                        @elseif($domain==8)
                        Identify Users and Authenticate Access to System Components

                        @elseif($domain==9)
                        Restrict Physical Access to Cardholder Data

                        @elseif($domain==10)
                        Log and Monitor All Access to System Components and Cardholder Data

                        @elseif($domain==11)
                        Test Security of Systems and Networks Regularly

                        @elseif($domain==12)
                        Support Information Security with Organizational Policies and Programs

                        @elseif($domain=='A2')
                        Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections

                        @endif
                    </a>
                    </td>
                    @php
                        // Calculate row total
                        $rowTotal = 0;
                    @endphp

                    @foreach(['yes','partial', 'no', 'not_applicable', 'not_tested'] as $status)
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
                <th>
                    @if(array_sum($columnTotals) > 0)
                        {{ ceil(($columnTotals['yes'] / array_sum($columnTotals)) * 100) }}%
                    @else
                        0%
                    @endif
                </th>    
                      <th>
                    @if(array_sum($columnTotals) > 0)
                        {{ ceil(($columnTotals['partial'] / array_sum($columnTotals)) * 100) }}%
                    @else
                        0%
                    @endif
                </th>            
                <th>
                    @if(array_sum($columnTotals) > 0)
                        {{ ceil(($columnTotals['no'] / array_sum($columnTotals)) * 100) }}%
                    @else
                        0%
                    @endif
                </th>                 
                <th>
                    @if(array_sum($columnTotals) > 0)
                        {{ ceil(($columnTotals['not_applicable'] / array_sum($columnTotals)) * 100) }}%
                    @else
                        0%
                    @endif
                </th>                 
                
                <th>
                    @if(array_sum($columnTotals) > 0)
                        {{ ceil(($columnTotals['not_tested'] / array_sum($columnTotals)) * 100) }}%
                    @else
                        0%
                    @endif
                </th>               
                       
                   <th>100 %</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>

    @else
    {{-- comp status count==1 with pie chart--}}
@php
    $statusLabels = [
        'yes'            => 'In Place',
        'no'             => 'Not In Place',
        'not_applicable' => 'Not Applicable',
        'not_tested'     => 'Not Tested',
        'partial'        => 'Partially in Place',
    ];
        $statusLabel = $statusLabels[$comp_status] ?? ucfirst($comp_status);

       $statusColors = [
        'yes'            => 'bg-success text-white',   // green
        'no'             => 'bg-danger text-white',    // red
        'partial'        => 'bg-warning text-dark',    // orange/yellow
        'not_applicable' => 'bg-primary text-white',   // blue
        'not_tested'     => 'bg-secondary text-white', // grey
    ];

     $statusClass = $statusColors[$comp_status] ?? 'bg-light';
@endphp

        @php

    $domainNames = [
        1  => 'Install and Maintain Network Security Controls',
        2  => 'Apply Secure Configurations to All System Components',
        3  => 'Protect Stored Account Data',
        4  => 'Protect Cardholder Data w/ Strong Cryptography in Transit',
        5  => 'Protect All Systems and Networks from Malicious Software',
        6  => 'Develop and Maintain Secure Systems and Software',
        7  => 'Restrict Access by Business Need-to-Know',
        8  => 'Identify Users and Authenticate Access',
        9  => 'Restrict Physical Access to Cardholder Data',
        10 => 'Log and Monitor All Access',
        11 => 'Test Security of Systems and Networks Regularly',
        12 => 'Support Info-Sec with Policies and Programs',
        'A2' => 'Additional PCI DSS Requirements (SSL / Early TLS)'
    ];

    $grandTotal = 0;
@endphp

<div class="row">


<div class="col-md-6">

<table class="table table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>Domain</th>
        <th class="{{ $statusClass }}">{{ $statusLabel }}</th>
        </tr>
    </thead>

    <tbody>
        @forelse($formattedResults as $domain => $statuses)
            @php
                $count = $statuses[$comp_status] ?? 0;
                $grandTotal += $count;
            @endphp
            <tr>
                <td>
                    <a href="/select_assets_for_subdomain_map_comp_status/{{ $domain }}/{{$comp_status}}/{{ $project->project_id }}/{{ auth()->user()->id }}">
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
        {{-- <tr>
            <th>%</th>
            <th>{{ $grandTotal > 0 ? '100%' : '0%' }}</th>
        </tr> --}}
    </tfoot>
</table>
    
</div>

<div class="col-md-6 d-flex align-items-center justify-content-center">
    <div style="width: 400px; height: 400px;">
        <canvas id="compliancePieChart"></canvas>
    </div>
</div>

</div>


    
    @endif
    @endif
</div>


{{-- for Pie chart data --}}
@php
if(isset($comp_status_count) && $comp_status_count==1 ){
    $chartLabels = [];
    $chartData = [];

    foreach ($formattedResults as $domain => $statuses) {
        $count = $statuses[$comp_status] ?? 0;
        if ($count > 0) {
            $label = $domain . ' – ' . ($domainNames[$domain] ?? '');
            $chartLabels[] = $label;
            $chartData[] = $count;
        }
    }
}
@endphp

@section('scripts')

@if(isset($comp_status_count) && $comp_status_count==1)
<script>
    Chart.register(ChartDataLabels); 

 const ctx = document.getElementById('compliancePieChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: '{{ $statusLabel }} by Domain',
                data: {!! json_encode($chartData) !!},
                backgroundColor: [
                    '#ce93d8', '#2196f3', '#ff9800', '#9c27b0', '#00bcd4', '#e91e63', '#3f51b5', '#ffc107',
                    '#8bc34a', '#ff5722', '#795548', '#607d8b', '#ffeb3b', '#009688', '#cddc39', '#673ab7',
                    '#ff5252', '#b2ebf2', '#aed581', '#dce775', '#f06292', '#ba68c8', '#90caf9', '#fdd835',
                    '#a1887f', '#80cbc4', '#f48fb1', '#81c784', '#b3e5fc',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                // tooltip: {
                //     callbacks: {
                //         label: function(context) {
                //             return `${context.label}: ${context.parsed}`;
                //         }
                //     }
                // },
              datalabels: {
                color: '#000', // black text
                font: {
                    size: 14,    // increase size
                    weight: 'bold'
                },
                formatter: function(value, context) {
                    return value; // or add % / label etc.
                }
             }
            }
        },
        plugins: [ChartDataLabels]
    });


  
</script>
@endif

{{-- <script>
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
</script> --}}




@endsection

@endsection
