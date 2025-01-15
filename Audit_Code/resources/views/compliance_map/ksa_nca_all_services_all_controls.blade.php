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
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold text-center mt-4">View or Download Compliance Map (All Domains-All Services-All Applicable Controls)</h3>


    @if(isset($formattedResults))

    <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>

    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Domain</th>
                <th>Yes</th>
                <th>No</th>
                <th>Not Applicable</th>
                <th>Not Tested</th>
                <th>Partial</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Initialize column totals
                $columnTotals = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];
            @endphp

            @forelse($formattedResults as $domain => $statuses)
                <tr>
                    <td><a href="/select_assets_for_subdomain_map/{{$domain}}/{{$project->project_id}}/{{auth()->user()->id}}">
                        
                        {{ $domain }}- @if($domain==1) Cybersecurity Governance

                        @elseif($domain==2)
                        Cybersecurity Defense

                        @elseif($domain==3)
                        Cybersecurity Resilience

                        @elseif($domain==4)
                        Third-Party and Cloud Computing Cybersecurity

                        @elseif($domain==5)
                        Industrial Control Systems Cybersecurity

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
