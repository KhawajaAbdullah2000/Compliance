@extends('master')

@section('content')

@include('user-nav')

@php
$permissions = json_decode($project_permissions);
@endphp

@php
$impactLevels = [
5 => 'Catastrophic',
4 => 'Critical',
3 => 'Serious',
2 => 'Significant',
1 => 'Minor'
];

$likelihoodLevels = [
    5 => 'Almost Certain',
    4 => 'Very Likely',
    3 => 'Likely',
    2 => 'Rather Unlikely',
    1 => 'Unlikely'
];
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
                <tr>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#assetModal-{{ $asset->assessment_id }}">
                            {{ $asset->c_name }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="assetModal-{{ $asset->assessment_id }}" tabindex="-1" aria-labelledby="assetModalLabel-{{ $asset->assessment_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="assetModalLabel-{{ $asset->assessment_id }}">Asset Component Details - {{ $asset->c_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body overflow-auto" style="max-height: 500px;">
                                        {!! view('components.asset-popover', ['asset' => $asset])->render() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>


                    <td>{{ $impactLevels[$asset->risk_confidentiality] ?? $asset->risk_confidentiality }}</td>
                    <td>{{ $impactLevels[$asset->risk_integrity] ?? $asset->risk_integrity }}</td>
                    <td>{{ $impactLevels[$asset->risk_availability] ?? $asset->risk_availability }}</td>


                    <td>{{$asset->global_threat}}</td>
                    <td>{{$asset->global_vulnerability}}</td>

                    @if($framework_approach->framework_approach_types_id == 1 && $risk_assessment_approach->global_risk_assessment_approach_id == 2)
                  <td>{{ $likelihoodLevels[$asset->qualitative_likelihood_risk_confidentiality_selected] ?? $asset->qualitative_likelihood_risk_confidentiality_selected }}</td>

                    @endif

                    <td>{{$asset->timeframe_risk_confidentiality}}</td>

                    @if($framework_approach->framework_approach_types_id == 1 && $risk_assessment_approach->global_risk_assessment_approach_id == 2)
                 <td>{{ $likelihoodLevels[$asset->qualitative_likelihood_risk_integrity_selected] ?? $asset->qualitative_likelihood_risk_integrity_selected }}</td>
                    @endif

                    <td>{{$asset->timeframe_risk_integrity}}</td>

                    @if($framework_approach->framework_approach_types_id == 1 && $risk_assessment_approach->global_risk_assessment_approach_id == 2)
                    <td>{{ $likelihoodLevels[$asset->qualitative_likelihood_risk_availability_selected] ?? $asset->qualitative_likelihood_risk_availability_selected }}</td>
                    @endif

                    <td>{{$asset->timeframe_risk_availability}}</td>

                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    @endsection

    @section('scripts')
    <!-- No additional JS needed for Bootstrap modal -->
    @endsection
