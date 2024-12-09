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

    <h3 class="fw-bold text-center mt-4">Report: Compliance Status by Asset Component</h3>

    <form method="GET" action="/compliance_status/{{$project->project_id}}/{{auth()->user()->id}}">
        @csrf

        <label for="" class="form-label fs-5">Select Service(s)</label>

        <!-- 'All Services' Checkbox -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="allServicesCheckbox">
            <label class="form-check-label" for="allServicesCheckbox">
                All Services
            </label>
        </div>

        <!-- Service Checkboxes -->
        @foreach($uniqueServices as $index => $service)
        <div class="form-check">
            <input class="form-check-input service-checkbox" type="checkbox" name="services[]" 
                   id="serviceCheckbox{{ $index }}" value="{{ $service->s_name }}" data-index="{{ $index }}"
                   @if(in_array($service->s_name, $selectedServices ?? [])) checked @endif>

                   <label class="form-check-label" for="serviceCheckbox{{ $index }}">
                {{ $service->s_name }}
            </label>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>


    @if(isset($formattedResults))

    <a id="downloadExcelButton" href="#" class="btn btn-success btn-md float-end mb-2">Download Excel</a>
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Service</th>
                <th>Asset Component</th>
                <th>In Place</th>
                <th>Not In Place</th>
                <th>Not Applicable</th>
                <th>Not Tested</th>
                <th>Partial</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $columnTotals = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0, 'total' => 0];
            @endphp

            @forelse($formattedResults as $service => $components)
                @foreach($components as $component => $statuses)
                    <tr>
                        <td>{{ $service }}</td>
                        <td>{{ $component }}</td>
                        <td>{{ $statuses['yes'] }}</td>
                        <td>{{ $statuses['no'] }}</td>
                        <td>{{ $statuses['not_applicable'] }}</td>
                        <td>{{ $statuses['not_tested'] }}</td>
                        <td>{{ $statuses['partial'] }}</td>
                        <td>{{ $statuses['total'] }}</td>
                    </tr>
                    @php
                        // Update column totals
                        $columnTotals['yes'] += $statuses['yes'];
                        $columnTotals['no'] += $statuses['no'];
                        $columnTotals['not_applicable'] += $statuses['not_applicable'];
                        $columnTotals['not_tested'] += $statuses['not_tested'];
                        $columnTotals['partial'] += $statuses['partial'];
                        $columnTotals['total'] += $statuses['total'];
                    @endphp
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center">No data available</td>
                </tr>
            @endforelse

            <!-- Grand Total Row -->
            <tr class="fw-bold">
                <td colspan="2" class="text-end">Total</td>
                <td>{{ $columnTotals['yes'] }}</td>
                <td>{{ $columnTotals['no'] }}</td>
                <td>{{ $columnTotals['not_applicable'] }}</td>
                <td>{{ $columnTotals['not_tested'] }}</td>
                <td>{{ $columnTotals['partial'] }}</td>
                <td>{{ $columnTotals['total'] }}</td>
            </tr>
        </tbody>
    </table>

    @endif
</div>

@section('scripts')

<script>
    $(document).ready(function () {
        // Cache the checkboxes
        const allServicesCheckbox = $('#allServicesCheckbox'); // "All Services" checkbox
        const serviceCheckboxes = $('.service-checkbox'); // All individual service checkboxes

        // When "All Services" checkbox is clicked
        allServicesCheckbox.on('change', function () {
            if ($(this).is(':checked')) {
                // Check all individual service checkboxes
                serviceCheckboxes.prop('checked', true);
            } else {
                // Uncheck all individual service checkboxes
                serviceCheckboxes.prop('checked', false);
            }
        });

        // When any individual service checkbox is clicked
        serviceCheckboxes.on('change', function () {
            if (!$(this).is(':checked')) {
                // If one is unchecked, uncheck "All Services"
                allServicesCheckbox.prop('checked', false);
            } else if (serviceCheckboxes.filter(':checked').length === serviceCheckboxes.length) {
                // If all are checked, check "All Services"
                allServicesCheckbox.prop('checked', true);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Cache the button and checkboxes
        const downloadExcelButton = $('#downloadExcelButton');
        const serviceCheckboxes = $('.service-checkbox');
        const projectID = {{ $project->project_id }};
        const userID = {{ auth()->user()->id }};

        // Function to update the Excel download link
        function updateDownloadLink() {
            const selectedServices = [];
            serviceCheckboxes.each(function () {
                if ($(this).is(':checked')) {
                    selectedServices.push($(this).val());
                }
            });

            // Construct the query string
            const query = selectedServices.length > 0 ? '?services[]=' + selectedServices.join('&services[]=') : '';
            const url = `/download_excel_compliance_status/${projectID}/${userID}${query}`;
            downloadExcelButton.attr('href', url);
        }

        // Update the link on page load and when a checkbox changes
        updateDownloadLink();
        serviceCheckboxes.on('change', updateDownloadLink);
    });
</script>

@endsection

@endsection
