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

    <h3 class="fw-bold text-center mt-4">View or Download Compliance Map (All Control Domains-All Services-All Applicable Controls)</h3>


    @if(isset($formattedResults))

    <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>

    <table class="table table-bordered mt-4">
        <thead class="table-secondary">
            <tr>
                <th>Domain</th>
                <th>In Place</th>
                <th>Not In Place</th>
                <th>Not Applicable</th>
                <th>Not Tested</th>
                <th>Partial</th>
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
                        
                        {{ $domain }}- 
                        @if($domain == 1)
    Asset Management
@elseif($domain == 2)
    Availability
@elseif($domain == 3)
    Change Management
@elseif($domain == 4)
    Communications
@elseif($domain == 5)
    Confidentiality
@elseif($domain == 6)
    Data Classification
@elseif($domain == 7)
    Fraud Management
@elseif($domain == 8)
    Human Resource aspects of Trust Services
@elseif($domain == 9)
    Information Assets Security Management Policy
@elseif($domain == 10)
    Information Security Events Monitoring
@elseif($domain == 11)
    Information Security Incident Management
@elseif($domain == 12)
    Information Security Monitoring
@elseif($domain == 13)
    IT Operational Anomalies Reporting
@elseif($domain == 14)
    Logical and Physical Access Controls
@elseif($domain == 15)
    Monitoring of Controls
@elseif($domain == 16)
    Organization & Management
@elseif($domain == 17)
    Risk Management
@elseif($domain == 18)
    Vendor and Business Partner Risk Management
@elseif($domain == 19)
    Vulnerability Management
@endif

                    </a>
                    </td>
                    @php
                        // Calculate row total
                        $rowTotal = 0;
                    @endphp

                    @foreach(['yes', 'no', 'not_applicable', 'not_tested', 'partial'] as $status)
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
                <th>{{ $columnTotals['no'] }}</th>
                <th>{{ $columnTotals['not_applicable'] }}</th>
                <th>{{ $columnTotals['not_tested'] }}</th>
                <th>{{ $columnTotals['partial'] }}</th>
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
                <th>
                    @if(array_sum($columnTotals) > 0)
                        {{ ceil(($columnTotals['partial'] / array_sum($columnTotals)) * 100) }}%
                    @else
                        0%
                    @endif
                </th>              
                   <th>100 %</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <a id="downloadExcelButton2" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>




    @endif
</div>

@section('scripts')


<script>
    $(document).ready(function () {
        // Cache the button and checkboxes
        const downloadExcelButton = $('#downloadExcelButton');
          const downloadExcelButton2 = $('#downloadExcelButton2');

        const projectID = {{ $project->project_id }};
        const userID = {{ auth()->user()->id }};

        // Function to update the Excel download link
        function updateDownloadLink() {

            const url = `/download_excel_compliance_map/${projectID}/${userID}`;
            downloadExcelButton.attr('href', url);
             downloadExcelButton2.attr('href', url);
        }

        // Update the link on page load and when a checkbox changes
        updateDownloadLink();
    });
</script>

@endsection

@endsection
