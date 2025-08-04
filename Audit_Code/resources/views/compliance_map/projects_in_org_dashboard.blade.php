@extends('master')

@section('content')

@include('user-nav')

<div class="container my-2">
    <div class="row mt-5">
        <div class="col-lg-12">
            <h2 class="fw-bold text-center">View Compliances on All Projects in: {{auth()->user()->organization->name}}</h2>
        </div>
    </div>

    @foreach($formattedResults as $projectId => $projectData)
    @php
    $columnTotals = ['yes' => 0, 'no' => 0, 'not_applicable' => 0, 'not_tested' => 0, 'partial' => 0];

    if (!empty($projectData['compliance_results'])) {

    foreach($projectData['compliance_results'] as $domain => $statuses) {
    foreach(['yes', 'no', 'not_applicable', 'not_tested', 'partial'] as $status) {
    $count = $statuses[$status] ?? 0;
    $columnTotals[$status] += $count;
    }
    }
    }
    $total = array_sum($columnTotals);
    @endphp


    <div class="row align-items-center py-3 border-bottom">
        <!-- Column 1: Project Name -->
        <div class="col-md-2">
            <h5 class="fw-bold">
                <a href="/iso_sections/{{ $projectId }}/{{ auth()->user()->id }}" class="text-decoration-none">
                    {{ $projectData['project_name'] ?? 'Unnamed Project' }}
                </a>
            </h5>
        </div>

        <!-- Column 2: Compliance Status Summary -->
        <div class="col-md-6 d-flex justify-content-around">

            @php
            $statuses = [
            'yes' => ['label' => 'In Place', 'color' => 'bg-success'],
            'no' => ['label' => 'Not In Place', 'color' => 'bg-danger'],
            'partial' => ['label' => 'Partial', 'color' => 'bg-warning text-dark'],
            'not_applicable' => ['label' => 'Not Applicable', 'color' => 'bg-secondary'],
            'not_tested' => ['label' => 'Not Tested', 'color' => 'bg-secondary']
            ];
            @endphp

            <div class="d-flex w-100 justify-content-between">
                @foreach($statuses as $status => $data)
                <div class="card shadow-lg text-center {{ $data['color'] }} flex-fill mx-2" style="min-width: 150px;">
                    <a href="/compliance_map_all_services_comp_type/{{$projectId}}/{{auth()->user()->id}}/{{$status}}" style="text-decoration: none; color: inherit;">

                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white">{{ $data['label'] }}</h5>
                            <p class="text-white fw-bold fs-4">
                                {{ array_sum($columnTotals) > 0 ? ceil(($columnTotals[$status] / array_sum($columnTotals)) * 100) . ' %' : '0 %' }}
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Column 3: Action Button -->
        <div class="col-md-4 text-end">
            <a href="/compliance_map_all_services/{{ $projectId }}/{{ auth()->user()->id }}" class="btn btn-primary btn-md">
                View / Download
            </a>
        </div>
    </div>

    @endforeach
</div>

@section('scripts')

@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 6000
    , });

</script>
@endif

<script>
    $(document).ready(function() {
        $('.downloadExcelButton').each(function() {
            const projectID = $(this).data('project-id');
            const userID = {
                {
                    auth() - > user() - > id
                }
            };
            const url = `/download_excel_compliance_map/${projectID}/${userID}`;
            $(this).attr('href', url);
        });
    });

</script>
@endsection

@endsection
