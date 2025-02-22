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
                        
                        {{ $domain }}- @if($domain == '5.2')
                        SM-1: Development process
                    @elseif($domain == '5.3')
                        SM-2: Identification of responsibilities
                    @elseif($domain == '5.4')
                        SM-3: Identification of applicability
                    @elseif($domain == '5.5')
                        SM-4: Security expertise
                    @elseif($domain == '5.6')
                        SM-5: Process scoping
                    @elseif($domain == '5.7')
                        SM-6: File integrity
                    @elseif($domain == '5.8')
                        SM-7: Development environment security
                    @elseif($domain == '5.9')
                        SM-8: Controls for private keys
                    @elseif($domain == '5.10')
                        SM-9: Security requirements for externally provided components
                    @elseif($domain == '5.11')
                        SM-10: Custom developed components from third-party suppliers
                    @elseif($domain == '5.12')
                        SM-11: Assessing and addressing security-related issues
                    @elseif($domain == '5.13')
                        SM-12: Process verification
                    @elseif($domain == '5.14')
                        SM-13: Continuous improvement
                    @elseif($domain == '6.2')
                        SR-1: Product security context
                    @elseif($domain == '6.3')
                        SR-2: Threat model
                    @elseif($domain == '6.4')
                        SR-3: Product security requirements
                    @elseif($domain == '6.5')
                        SR-4: Product security requirements content
                    @elseif($domain == '6.6')
                        SR-5: Security requirements review
                    @elseif($domain == '7.2')
                        SD-1: Secure design principles
                    @elseif($domain == '7.3')
                        SD-2: Defense in depth design
                    @elseif($domain == '7.4')
                        SD-3: Security design review
                    @elseif($domain == '7.5')
                        SD-4: Secure design best practices
                    @elseif($domain == '8.3')
                        SI-1: Security implementation review
                    @elseif($domain == '8.4')
                        SI-2: Secure coding standards
                    @elseif($domain == '9.2')
                        SVV-1: Security requirements testing
                    @elseif($domain == '9.3')
                        SVV-2: Threat mitigation testing
                    @elseif($domain == '9.4')
                        SVV-3: Vulnerability testing
                    @elseif($domain == '9.5')
                        SVV-4: Penetration testing
                    @elseif($domain == '9.6')
                        SVV-5: Independence of testers
                    @elseif($domain == '10.2')
                        DM-1: Receiving notifications of security-related issues
                    @elseif($domain == '10.3')
                        DM-2: Reviewing security-related issues
                    @elseif($domain == '10.4')
                        DM-3: Assessing security-related issues
                    @elseif($domain == '10.5')
                        DM-4: Addressing security-related issues
                    @elseif($domain == '10.6')
                        DM-5: Disclosing security-related issues
                    @elseif($domain == '10.7')
                        DM-6: Periodic review of security defect management practice
                    @elseif($domain == '11.2')
                        SUM-1: Security update qualification
                    @elseif($domain == '11.3')
                        SUM-2: Security update documentation
                    @elseif($domain == '11.4')
                        SUM-3: Dependent component or operating system security update documentation
                    @elseif($domain == '11.5')
                        SUM-4: Security update delivery
                    @elseif($domain == '11.6')
                        SUM-5: Timely delivery of security patches
                    @elseif($domain == '12.2')
                        SG-1: Product defense in depth
                    @elseif($domain == '12.3')
                        SG-2: Defense in depth measures expected in the environment
                    @elseif($domain == '12.4')
                        SG-3: Security hardening guidelines
                    @elseif($domain == '12.5')
                        SG-4: Secure disposal guidelines
                    @elseif($domain == '12.6')
                        SG-5: Secure operation guidelines
                    @elseif($domain == '12.7')
                        SG-6: Account management guidelines
                    @elseif($domain == '12.8')
                        SG-7: Documentation review
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
