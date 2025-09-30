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



<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2 mb-2">Assess Risk  for:</h3>

    @include('components.asset-summary_component', ['asset' => $asset])


    @if($complianceFramework->framework_id==2 && $risk_assessment_approach->global_risk_assessment_approach_id==2 && $framework_approach->framework_approach_types_id==1) 

    <p class="fs-4 mt-4"><span class="fw-bold">Methodology:</span> Qualitative Asset Based</p>
    @endif

     @if($complianceFramework->framework_id==2 && $risk_assessment_approach->global_risk_assessment_approach_id==2 && $framework_approach->framework_approach_types_id==2) 

    <p class="fs-4 mt-4"><span class="fw-bold">Methodology:</span> Quantitative Asset Based</p>
    @endif


    <div class="container-fluid mt-4">


        <div class="flowchart border rounded">
            <svg width="100%" height="100%" viewBox="0 0 1200 600" style="position:absolute;inset:0;pointer-events:none">
                <defs>
                    <marker id="arrow" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
                        <path d="M0,0 L10,3 L0,6 z" fill="#0b5ed7"></path>
                    </marker>
                </defs>


                <!-- Service → Business Impact (longer, clearer) -->
                <line x1="190" y1="100" x2="320" y2="100" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />

                <!-- Business Impact → Risk -->
                <line x1="540" y1="100" x2="1060" y2="100" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />

                <!-- Asset → Threats -->
                <line x1="190" y1="320" x2="320" y2="260" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />

                <!-- Asset → Vulnerabilities -->
                <line x1="190" y1="320" x2="320" y2="420" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />

                <!-- Threats → Likelihood -->
                <line x1="580" y1="280" x2="680" y2="300" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />

                <!-- Vulnerabilities → Likelihood -->
                <line x1="580" y1="420" x2="680" y2="340" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />

                <!-- Likelihood → Risk -->
                <line x1="940" y1="300" x2="1060" y2="100" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow)" />
            </svg>

            <!-- Nodes (unchanged titles/links; only positions matter) -->
            <a class="node p-service text-center"><small class="text-light d-block">Service</small><strong>{{$asset->s_name}}</strong></a>
            <a href="{{route('consequence_of_service',[
  'asset_id'=>$asset->assessment_id,
  'proj_id'=>$project->project_id,
  'user_id'=>auth()->user()->id])}}" class="node p-business"><strong>Business Impact</strong><br><span>(Consequence)</span></a>
            <a href="/likelihood_and_consequence/risk_confidentiality/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="node p-risk node-tall d-flex align-items-center justify-content-center"><strong>Risk</strong></a>
            <a href="#" class="node p-asset text-center"><small class="text-light d-block">Asset Component</small><strong>{{$asset->c_name}}</strong></a>

            <a href="{{ route('route_for_risk_source', [
    'proj_id'  => $project->project_id,
    'user_id'  => auth()->user()->id,
    'asset_id' => $asset->assessment_id,
]) }}" class="node p-threats">
                <strong>Risk Sources</strong><br>
                <span>(Threats)</span>
            </a>
            <a href="
            {{ route('iso_27005_risk_assessment', [
    'proj_id'  => $project->project_id,
    'user_id'  => auth()->user()->id,
    'asset_id' => $asset->assessment_id,
]) }}" class="node p-vulns"><strong>Vulnerabilities</strong></a>
            <a href="/iso_27005_likelihood_value/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/risk_confidentiality" class="node p-like slim"><strong>Likelihood of Incident</strong><br><small>in a finite time period</small></a>
        </div>
    </div>





    @section('scripts')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

    </script>

    @if(Session::has('success'))
    <script>
        swal({
            title: "{{Session::get('success')}}"
            , icon: "success"
            , closeOnClickOutside: true
            , timer: 3000
        , });

    </script>
    @endif



    @endsection

    @endsection
