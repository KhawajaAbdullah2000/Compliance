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

    <h3 class="fw-bold text-center mt-4">View or Download Compliance Map (Selected Domain-Selected Service-Selected Asset-Selected Subdomain-All Applicable Controls)</h3>

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

    <h4><span class="fw-bold">Assets Selected : </span> 
        @isset($group)
        @if($group=='_all')
        All Asset Groups -
        @else
        {{$group}} -
        @endif
        @endisset


    @isset($subgroup)
    @if($subgroup=='_all')
    All Asset Subgroups -
    @else
    {{$subgroup}} -
    @endif
    @endisset

@if($component=='_all')

All Asset Components 

@else

{{$component}}
@endif
</h4>

<h4><span class="fw-bold mt-4">Subdomain {{$subdomainNum}} :</span> {{$subdomainTitle}}</h4>
</div>

<div class="col-md-6 position-relative">
    <a href="/compliance_map_all_services/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">Compliance Map - All Services - All Controls</a>
</div>

</div>
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
                    {{ $domain }}    @foreach($UniqueSubReqs as $sub_req=>$value)

                    @if ($sub_req==$domain)

                    {{$value}}

                    @endif

           

                    @endforeach
         
                    
               
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
            <th>{{ ceil( ($columnTotals['yes']/array_sum($columnTotals) )*100 )}}%</th>
            <th>{{ ceil( ($columnTotals['no']/array_sum($columnTotals) )*100 )}}%</th>
            <th>{{ ceil( ($columnTotals['not_applicable']/array_sum($columnTotals) )*100 )}}%</th>
            <th>{{ ceil( ($columnTotals['not_tested']/array_sum($columnTotals) )*100 )}}%</th>
            <th>{{ ceil( ($columnTotals['partial']/array_sum($columnTotals) )*100 )}}%</th>
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
        const formattedResult = @json($results);


        // Function to update the Excel download link
        function updateDownloadLink() {
            const formattedResultEncoded = encodeURIComponent(JSON.stringify(formattedResult));

        
            const url = `/download_excel_compliance_map_subreq/${projectID}/${userID}?formattedResult=${formattedResultEncoded}`;
            downloadExcelButton.attr('href', url);
        }

        // Update the link on page load and when a checkbox changes
        updateDownloadLink();
    });
</script>

@endsection

@endsection
