@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">

            @include('components.one_link_topTable')

        </div>

        <h3 class="fw-bold text-center">View Risk Register</h3>

        <table class="table table-responsive table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2">Asset <br> Component</th>
                    <th colspan="3">Consequence</th>
                    <th rowspan="2">Threat</th>
                    <th rowspan="2">Vul</th>
                    <th colspan="6">Likelihood</th>
                    <th colspan="3">Risk</th>
                </tr>
                <tr>
                    <th>DC</th>
                    <th>DI</th>
                    <th>DA</th>

                    <th>DC</th>
                    <th>Days</th>
                    <th>DI</th>
                    <th>Days</th>
                    <th>DA</th>
                    <th>Days</th>

                    <th>DC</th>
                    <th>DI</th>
                    <th>DA</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($assets as $asset)
            
        <td>{{ $asset->c_name }}</td> 
        <td>{{$asset->risk_confidentiality}}</td>
        <td>{{$asset->risk_integrity}}</td>
        <td>{{$asset->risk_availability}}</td>
        <td>{{$asset->global_threat}}</td>
        <td>{{$asset->global_vulnerability}}</td>
        {{-- Qualitative Asset based --}}
        @if($framework_approach->framework_approach_types_id==1 && $risk_assessment_approach->global_risk_assessment_approach_id==2)
        <td>{{$asset->qualitative_likelihood_risk_confidentiality_selected}}</td>
        @endif
        <td>{{$asset->timeframe_risk_confidentiality}}</td>

        @if($framework_approach->framework_approach_types_id==1 && $risk_assessment_approach->global_risk_assessment_approach_id==2)
        <td>{{$asset->qualitative_likelihood_risk_integrity_selected}}</td>
        @endif
        <td>{{$asset->timeframe_risk_integrity}}</td>

        @if($framework_approach->framework_approach_types_id==1 && $risk_assessment_approach->global_risk_assessment_approach_id==2)
        <td>{{$asset->qualitative_likelihood_risk_availability_selected}}</td>
        @endif
        <td>{{$asset->timeframe_risk_availability}}</td>
        @endforeach

        <td></td>
        <td></td>
        <td></td>

        </tbody>
        </table>

<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle popover</button>

    </div>

    @section('scripts')
<script>
    $(function () {
  $('.popover').popover({
    container: 'body'
  })
})
</script>


    @endsection

    @endsection
