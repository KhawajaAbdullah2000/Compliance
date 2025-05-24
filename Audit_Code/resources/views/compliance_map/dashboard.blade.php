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

    <h3 class="fw-bold text-center mt-4">Compliance Map (All Control Domains- All Services-All Applicable Controls)</h3>


    @if(isset($formattedResults))

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
                    @endforeach

                

                @empty
             
            @endforelse

            <div class="row mt-4 justify-content-center">
                <div class="col-md-2">
                    <div class="card shadow-lg p-4 text-center bg-success h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                                {{ array_sum($columnTotals) > 0 ? ceil(($columnTotals['yes'] / array_sum($columnTotals)) * 100) . ' %' : '0 %' }}
                            </p>
                        </div>
                    </div>
                </div>

                      <div class="col-md-2">
                    <div class="card shadow-lg p-4 text-center h-100 d-flex flex-column justify-content-between" style="background-color: orange">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">Partially In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                                {{ array_sum($columnTotals) > 0 ? ceil(($columnTotals['partial'] / array_sum($columnTotals)) * 100) . ' %' : '0 %' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card shadow-lg p-4 text-center bg-danger h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">Not In Place</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                                {{ array_sum($columnTotals) > 0 ? ceil(($columnTotals['no'] / array_sum($columnTotals)) * 100) . ' %' : '0 %' }}
                            </p>
                        </div>
                    </div>
                </div>


          
                


                <div class="col-md-2">
                    <div style="background-color: rgb(79, 174, 190)" class="card shadow-lg p-4 text-center h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">Not Applicable</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                                {{ array_sum($columnTotals) > 0 ? ceil(($columnTotals['not_applicable'] / array_sum($columnTotals)) * 100) . ' %' : '0 %' }}
                            </p>
                        </div>
                    </div>
                </div>
                


                <div class="col-md-2">
                    <div class="card shadow-lg p-4 text-center bg-secondary h-100 d-flex flex-column justify-content-between">
                        <div class="body flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">Not Tested</h5>
                            <p class="text-white fw-bold mt-3 fs-4 align-self-center">
                                {{ array_sum($columnTotals) > 0 ? ceil(($columnTotals['not_tested'] / array_sum($columnTotals)) * 100) . ' %' : '0 %' }}
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row mt-4">
                <div class="d-flex justify-content-center align-content-center">
                    <a href="/compliance_map_all_services/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg">View or Download Compliance Map</a>
                </div>
            </div>
           
        
    
      

            {{-- <tr>
                <th>%</th>
                <th>{{ ceil( ($columnTotals['yes']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['no']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['not_applicable']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['not_tested']/array_sum($columnTotals) )*100 )}}%</th>
                <th>{{ ceil( ($columnTotals['partial']/array_sum($columnTotals) )*100 )}}%</th>
                <th>100 %</th>
                <th></th>
            </tr> --}}
     



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
