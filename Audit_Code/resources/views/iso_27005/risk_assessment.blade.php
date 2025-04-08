@extends('master')

@section('content')

@include('user-nav')


@php
function getRiskLevelLabel($value)
{
    return match ($value) {
        5 => ['label' => 'Catastrophic', 'class' => 'text-danger'],
        4 => ['label' => 'Critical', 'class' => 'text-warning'],
        3 => ['label' => 'Serious', 'class' => 'text-success'],
        2 => ['label' => 'Significant', 'class' => 'text-success'],
        1 => ['label' => 'Minor', 'class' => 'text-success'],
        default => ['label' => 'Unknown', 'class' => 'text-muted'],
    };
}
    
@endphp

@php
    $riskDescriptions = [
        5 => 'Sector or regulatory consequences beyond the organization
Substantially impacted sector ecosystem(s), with consequences that can be long lasting.

And/or: difficulty for the State, and even an incapacity, to ensure a regulatory function or one of its missions of vital importance.

And/or: critical consequences on the safety of persons and property (health crisis, major environmental pollution, destruction of essential infrastructures, etc.).',

        4 => 'Disastrous consequences for the organization
Incapacity for the organization to ensure all or a portion of its activity, with possible serious consequences on the safety of persons and property. The organization will most likely not overcome the situation (its survival is threatened), the activity sectors or state sectors in which it operates will likely be affected slightly, without any long-lasting consequences',

        3 => 'Substantial consequences for the organization
High degradation in the performance of the activity, with possible significant consequences on the safety of persons and property. The organization will overcome the situation with serious difficulties (operation in a highly degraded mode), without any sector or state impact.',

        2 => 'Significant but limited consequences for the organization
Degradation in the performance of the activity with no consequences on the safety of persons and property. The organization will overcome the situation despite a few difficulties (operation in degraded mode).',
        1 => 'Negligible consequences for the organization

No consequences on operations or the performance of the activity or on the safety of persons and property.

The organization will overcome the situation without too much difficulty (margins will be consumed).'
    ];
@endphp


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

    @include('components.asset-summary', ['asset' => $asset])
    
        
        <h5 class="fw-bold mt-4">By evaluating gaps in applicable controls, evaluate how vulnerable the asset component is to actions by risk sources in the environment 
        </h5>
        




<div class="col-md-8">
    <form action="/iso_27005_submit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
        @csrf

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No.</th>
                <th>Controls (as per ISO 27001:2022 Annex A)</th>
                <th>Vulnerabilities</th>
                <th>Vulnerability Level due to </th>
           
            </tr>
        </thead>
        <tbody>
            @foreach ($controls as $control)
            @php
            $controlNum = trim((string) $control[0]); 
            $selectedValue = $savedData[$controlNum] ?? null;
        @endphp
        <tr>
            <td>{{ $controlNum }}</td>
            <td>{{ $control[1] }}</td>
            <td class="text-center">
                <a href="" title="Vulnerabilities"><i class="fas fa-edit fa-lg" style="color: #124903;"></i></a>
            </td>
            <input type="hidden" name="control_num[]" value="{{ $controlNum }}">
            <td>
                <select class="form-select" name="vulnerability_due_to[]">
                    @foreach (['Very High', 'High', 'Medium', 'Low', 'Very Low'] as $level)
                        <option value="{{ $level }}" {{ $selectedValue == $level ? 'selected' : '' }}>{{ $level }}</option>
                    @endforeach
                </select>
            </td>
         
        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end mb-4">
    <button type="submit" class="btn btn-primary btn-md">Save</button>
    </div>
</form>
    
</div>








</div>

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

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
