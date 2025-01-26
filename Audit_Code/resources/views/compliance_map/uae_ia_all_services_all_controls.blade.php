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
        <thead class="table-dark">
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
                        
                        {{ $domain }}- @if($domain=='M1.1')
                        ENTITY CONTEXT AND LEADERSHIP

                        @elseif($domain=='M1.2')
                        INFORMATION SECURITY POLICY

                        @elseif($domain=='M1.3')
                        ORGANIZATION OF INFORMATION SECURITY

                        @elseif($domain=='M1.4')
                        SUPPORT

                        @elseif($domain=='M2.1')
                        INFORMATION SECURITY RISK MANAGEMENT POLICY

                        @elseif($domain=='M2.2')
                        INFORMATION SECURITY RISK ASSESSMENT

                        @elseif($domain=='M2.3')
                        INFORMATION SECURITY RISK TREATMENT

                        @elseif($domain=='M2.4')
                        ONGOING INFORMATION SECURITY RISK MANAGEMENT

                        @elseif($domain=='M3.1')
                        AWARENESS AND TRAINING POLICY

                        @elseif($domain=='M3.2')
                        AWARENESS AND TRAINING PLANNING

                        @elseif($domain=='M3.3')
                        SECURITY TRAINING

                        @elseif($domain=='M3.4')
                        SECURITY AWARENESS

                        @elseif($domain=='M4.1')
                        HUMAN RESOURCES SECURITY POLICY

                        @elseif($domain=='M4.2')
                        PRIOR TO EMPLOYMENT
                        
                        @elseif($domain=='M4.3')
                        DURING EMPLOYMENT

                        @elseif($domain=='M4.4')
                        TERMINATION OR CHANGE OF EMPLOYMENT

                        @elseif($domain=='M5.1')
                        COMPLIANCE POLICY

                        @elseif($domain=='M5.2')
                        COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS

                        @elseif($domain=='M5.3')
                        COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS

                        @elseif($domain=='M5.4')
                        COMPLIANCE WITH TECHNICAL REQUIREMENTS

                        @elseif($domain=='M5.5')
                        INFORMATION SYSTEMS AUDIT CONSIDERATIONS

                        @elseif($domain=='M6.1')
                        PERFORMANCE EVALUATION POLICY

                        @elseif($domain=='M6.2')
                        PERFORMANCE EVALUATION

                        @elseif($domain=='M6.3')
                        IMPROVEMENT

                        @elseif($domain=='T1.1')
                        ASSET MANAGEMENT POLICY

                        @elseif($domain=='T1.2')
                        RESPONSIBILITY FOR ASSETS

                        @elseif($domain=='T1.3')
                        INFORMATION CLASSIFICATION

                        @elseif($domain=='T1.4')
                        MEDIA HANDLING

                    @elseif($domain=='T2.1')
                    PHYSICAL AND ENVIRONMENTAL SECURITY POLICY

                    @elseif($domain=='T2.2')
                    SECURE AREAS

                    @elseif($domain=='T2.3')
                    EQUIPMENT SECURITY

                    @elseif($domain=='T3.1')
                    OPERATIONS MANAGEMENT POLICY

                    @elseif($domain=='T3.2')
                    OPERATIONAL PROCEDURES AND RESPONSIBILITIES

                    @elseif($domain=='T3.3')
                    SYSTEM PLANNING AND ACCEPTANCE

                    @elseif($domain=='T3.4')
                    PROTECTION FROM MALWARE

                    @elseif($domain=='T3.5')
                    BACKUP

                    @elseif($domain=='T3.6')
                    MONITORING

                    @elseif($domain=='T4.1')
                    COMMUNICATIONS POLICY

                    @elseif($domain=='T4.2')
                    INFORMATION TRANSFER

                    @elseif($domain=='T4.3')
                    ELECTRONIC COMMERCE SERVICES

                    @elseif($domain=='T4.4')
                    INFORMATION SHARING PROTECTION

                    @elseif($domain=='T4.5')
                    NETWORK SECURITY MANAGEMENT

                    @elseif($domain=='T5.1')
                    ACCESS CONTROL POLICY

                    @elseif($domain=='T5.2')
                    USER ACCESS MANAGEMENT

                    @elseif($domain=='T5.3')
                    USER RESPONSIBILITIES

                    @elseif($domain=='T5.4')
                    NETWORK ACCESS CONTROL

                    @elseif($domain=='T5.5')
                    OPERATING SYSTEM ACCESS CONTROL
                    
                    @elseif($domain=='T5.6')
                    APPLICATION AND INFORMATION ACCESS CONTROL
                    
                    @elseif($domain=='T5.7')
                    MOBILE DEVICES ACCESS CONTROL
                    
                    @elseif($domain=='T6.1')
                    THIRD-PARTY SECURITY POLICY
                    
                    @elseif($domain=='T6.2')
                    THIRD-PARTY SERVICE DELIVERY MANAGEMENT
                    
                    @elseif($domain=='T6.3')
                    CLOUD COMPUTING
                    
                    @elseif($domain=='T7.1')
                    INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY
                    
                    @elseif($domain=='T7.2')
                    SECURITY REQUIREMENTS OF INFORMATION SYSTEMS
                    
                    @elseif($domain=='T7.3')
                    CORRECT PROCESSING IN APPLICATIONS
                    
                    @elseif($domain=='T7.4')
                    CRYPTOGRAPHIC CONTROLS

                    @elseif($domain=='T7.5')
                    SECURITY OF SYSTEM FILES

                    @elseif($domain=='T7.6')
                    SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES

                    @elseif($domain=='T7.7')
                    TECHNICAL VULNERABILITY MANAGEMENT

                    @elseif($domain=='T7.8')
                    SUPPLY CHAIN MANAGEMENT

                    @elseif($domain=='T8.1')
                    INFORMATION SECURITY INCIDENT MANAGEMENT POLICY

                    @elseif($domain=='T8.2')
                    MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS

                    @elseif($domain=='T8.3')
                    INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING

                    @elseif($domain=='T9.1')
                    INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY

                    @elseif($domain=='T9.2')
                    INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT

                    @elseif($domain=='T9.3')
                    TESTING, MAINTAINING, AND REASSESSING PLANS

                        


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
