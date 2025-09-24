@extends('master')

@section('content')

@include('user-nav')



<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">

            @include('components.topTable')

        </div>
    </div>
    <h3 class="fw-bold mt-2">Assess Risk  for:</h3>

    @if($complianceFramework->framework_id==2 && $risk_assessment_approach->global_risk_assessment_approach_id==1 && $framework_approach->framework_approach_types_id==1)
    <p class="fs-4 mt-4"><span class="fw-bold">Methodology:</span> Qualitative Event Based</p>
    @endif


    <div class="container-fluid">
        <div class="flowchart-alt border rounded">
            <svg width="100%" height="100%" viewBox="0 0 1200 600" style="position:absolute;inset:0;pointer-events:none">
                <defs>
                    <marker id="arrow-alt" markerWidth="10" markerHeight="12" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
                        <path d="M0,0 L10,3 L0,6 z" fill="#0b5ed7"></path>
                    </marker>
                </defs>

                <!-- Organization → Parties -->
                <line x1="160" y1="50" x2="160" y2="220" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow-alt)" />

                <!-- Parties → Strategic Scenarios -->
                <line x1="260" y1="240" x2="410" y2="240" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow-alt)" />

                <!-- Strategic Scenarios → Threats -->
                <line x1="540" y1="240" x2="690" y2="200" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow-alt)" />

                <!-- Strategic Scenarios → Vulnerabilities -->
                <line x1="580" y1="240" x2="720" y2="280" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow-alt)" />


                <!-- Threats → Likelihood -->
                <line x1="860" y1="200" x2="980" y2="230" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow-alt)" />

                <!-- Vulnerabilities → Likelihood -->
                <line x1="860" y1="280" x2="980" y2="240" stroke="#0b5ed7" stroke-width="3" marker-end="url(#arrow-alt)" />
            </svg>

            <!-- Nodes -->
            <a class="node-alt p-org"><strong>{{auth()->user()->organization->name}}</strong></a>

            <a href="/initiaite_risk_assessment_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" class="node-alt p-parties">
                <strong>Identify parties</strong><br>
                <span>that can impact the organization’s<br>information services and assets</span>
            </a>

            <a href="/iso_sec_2_3_1_qual_event_scenarios/{{$project->project_id}}/{{auth()->user()->id}}" class="node-alt p-scenarios">
                <strong>Identify adverse impacts</strong><br>
                <span>related to parties as strategic scenarios</span>
            </a>

            <a href="/qual_event_consolidated_threat/{{$project->project_id}}/{{auth()->user()->id}}" class="node-alt p-threats"><strong>Evaluate Threats</strong></a>

            <a href="/iso_27005_risk_assessment_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" class="node-alt p-vulns"><strong>Evaluate Vulnerabilities</strong></a>

            <a href="/iso_27005_likelihood_value_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" class="node-alt p-like">
                <strong>Estimate the Likelihood</strong><br>
                <span>of occurrence of each strategic scenario</span>
            </a>
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
