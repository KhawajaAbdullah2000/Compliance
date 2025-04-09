@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Compliance Framework:</td>
                        <td>{{$complianceFramework->framework_name}}</td>
                        <td class="fw-bold">Information Security Risk Management Methodology:</td>
                        <td>{{$framework_approach->approach_name}} - {{$risk_assessment_approach->global_assessment_approach}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])
    
        
        <h5 class="fw-bold mt-4">Risk Source</h5>
        <p class="fs-5">{{$global_risk_source->global_risk_source}}</p>

        <h5 class="fw-bold mt-4">Threats posed by the Risk Source</h5>
        <div class="col-md-8">

            @php
    // Prepare group titles and determine the max number of rows
    $grouped = $global_threat_and_descs;
    $headers = [];
    $maxRows = 0;

    foreach($grouped as $groupId => $items) {
        $headers[$groupId] = $items->first()->global_threat_posed ?? 'Group ' . $groupId;
        $maxRows = max($maxRows, $items->count());
    }
@endphp

<table class="table table-responsive table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            @foreach($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < $maxRows; $i++)
            <tr>
                @foreach($grouped as $group)
                    <td>
                        {{ $group[$i]->threat_description ?? '' }}
                    </td>
                @endforeach
            </tr>
        @endfor
    </tbody>
</table>



          

        
        
        </div>









</div>

@section('scripts')


@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif



@endsection

@endsection
