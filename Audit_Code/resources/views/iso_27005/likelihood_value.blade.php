@extends('master')

@section('content')

@include('user-nav')
@php
$permissions = json_decode($project_permissions);

// User can edit data if they have "Data Inputter"
$isEditable = in_array('Data Inputter', $permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <h3 class="fw-bold mt-2">Assess Incident Likelihood (when Threat exploits Vulnerability) for</h3>

        </div>

        <div class="col-md-4 text-end">
            @include('components.back_to_flow_chart_btn',['asset'=>$asset,'project'=>$project])
        </div>
    </div>


    @include('components.asset-summary_component', ['asset' => $asset])


    <div class="col-12">
        @include('components.consequence_of_loss', ['asset' => $asset,'project'=>$project])
    </div>


    @include('components.consolidated_threat_vulnerability', ['threat' => $threat,'project'=>$project,
    'asset'=>$asset,'vulnerability'=>$vulnerability])

    <p class="fs-6 mt-2">By considering both the threats in the environment of an asset component and the vulnerabilities of the asset component, evaluate the likelihood that a DATA CONFIDENTIALITY exploit will occur in a finite timeframe
    </p>





    <div class="col-md-6 mt-4">
        <form action="/qualitative_asset_likelihood_confidentiality_timeframe/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">

            @csrf
            <label for="timeframe" class="form-label fw-semibold">
                Likelihood that a
                @if($risk_type=='risk_confidentiality')
                DATA CONFIDENTIALITY
                @elseif($risk_type=='risk_integrity')
                DATA INTEGRITY
                @else
                DATA AVAILABILITY
                @endif

                exploit will occur in a finite timeframe (days)
            </label>

            <div class="input-group">
                <input type="number" name="timeframe" class="form-control" placeholder="Enter Number of Days" value="{{ $likelihood_timeframe }}" {{ !$isEditable ? 'disabled' : '' }}>
                <input type="hidden" name="risk_type_input" value="{{$risk_type}}">
                @if($isEditable)
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
            </div>
        </form>
    </div>
    <div class="col-md-8 mt-4 mb-2">
        <form action="/save_likelihood_value/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
            @csrf
            <label class="form-label fw-semibold mb-3">
                Select Likelihood Value
            </label>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Likelihood</th>
                            <th>Description</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $likelihoodOptions = [
                        5 => [
                        'title' => 'Almost certain',
                        'desc' => 'The risk source will most certainly reach its objective by using one of the considered methods of attack. The likelihood of the risk scenario is very high.'
                        ],
                        4 => [
                        'title' => 'Very likely',
                        'desc' => 'The risk source will probably reach its objective by using one of the considered methods of attack. The likelihood of the risk scenario is high.'
                        ],
                        3 => [
                        'title' => 'Likely',
                        'desc' => 'The risk source is able to reach its objective by using one of the considered methods of attack. The likelihood of the risk scenario is significant.'
                        ],
                        2 => [
                        'title' => 'Rather unlikely',
                        'desc' => 'The risk source has relatively little chance of reaching its objective by using one of the considered methods of attack. The likelihood of the risk scenario is low.'
                        ],
                        1 => [
                        'title' => 'Unlikely',
                        'desc' => 'The risk source has very little chance of reaching its objective by using one of the considered methods of attack. The likelihood of the risk scenario is very low.'
                        ],
                        ];
                        @endphp


                        @foreach($likelihoodOptions as $value => $info)
                        <tr>
                            <td><strong>{{ $value }} - {{ $info['title'] }}</strong></td>
                            <td>{{ $info['desc'] }}</td>
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center">
                                    <input required class="form-check-input" type="radio" name="likelihood_value" value="{{ $value }}" id="likelihood_{{ $value }}" {{ (isset($likelihood_value) && $likelihood_value == $value) ? 'checked' : '' }} {{ !$isEditable ? 'disabled' : '' }}>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <input type="hidden" name="risk_type_input" value="{{$risk_type}}">
            <input type="hidden" name="approach_type" value="{{"qualitative"}}">


            {{-- <div class="text-end">
                <button type="submit" class="btn btn-secondary">Save</button>
                <a href="/likelihood_and_consequence/{{$risk_type}}/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary">Save & Next</a>
    </div> --}}

    <div class="text-end">
        <button type="submit" name="action" value="save" class="btn btn-secondary">
            Save
        </button>
        <button type="submit" name="action" value="save_next" class="btn btn-primary">
            Save & Next
        </button>
    </div>

    </form>
</div>









</div>

@section('scripts')


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
