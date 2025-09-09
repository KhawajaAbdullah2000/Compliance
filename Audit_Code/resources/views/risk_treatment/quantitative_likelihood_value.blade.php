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
   
    <h3 class="fw-bold mt-2">Risk Treatment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])


   
     <p class="fs-6 mt-2">By considering both the threats in the environment of an asset component and the vulnerabilities of the asset component, evaluate the likelihood that a DATA CONFIDENTIALITY exploit will occur in a finite timeframe
            </p>


     
    <div class="col-md-6 mt-4 mb-2">
        <form action="/qualitative_asset_likelihood_confidentiality_timeframe_risk_treatment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">

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

  

@if($framework_approach->framework_approach_types_id==2)
{{-- Quantitative Asset based --}}

<div class="col-md-8 mt-4 mb-2">
    <form action="/save_likelihood_value_risk_treatment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
        @csrf

        <label class="form-label fw-semibold mb-3">
            Selected likelihood value in Risk Assessment {{$risk_assessment_likelihood_value}}
        </label>
        <br>

        <label class="form-label fw-semibold mb-3">
            Select Likelihood Value
        </label>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Approximate Average Frequence</th>
                        <th>Log Expression</th>
                        <th>Scale Value</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $likelihoodOptions = [
                    6 => [
                    'scale' => '6',
                    'logExp' => 'Approximately 10^5',
                    'avg_freq'=>'Every Hour'
                    ],
                    5 => [
                    'scale' => '5',
                    'logExp' => 'Approximately 10^4',
                    'avg_freq'=>'Every 8 Hours'
                    ],
                    4 => [
                    'scale' => '4',
                    'logExp' => 'Approximately 10^3',
                    'avg_freq'=>'Twice a week'
                    ],
                    3 => [
                    'scale' => '3',
                    'logExp' => 'Approximately 10^2',
                    'avg_freq'=>'Once a month'
                    ],
                    2 => [
                    'scale' => '2',
                    'logExp' => 'Approximately 10^1',
                    'avg_freq'=>'Once a year'
                    ],
                    1 => [
                    'scale' => '1',
                    'logExp' => 'Approximately 10^0',
                    'avg_freq'=>'Once a decade'
                    ],

                    ];
                    @endphp


                    @foreach($likelihoodOptions as $value => $info)
                    <tr>
                        <td> {{ $info['avg_freq'] }}</strong></td>
                        <td>{{ $info['logExp'] }}</td>
                        <td>{{$info['scale']}}</td>
                        <td class="text-center">
                            <div class="form-check d-flex justify-content-center">
                                <input class="form-check-input" type="radio" name="likelihood_value" value="{{ $value }}" id="likelihood_{{ $value }}" {{ (isset($risk_treatment_likelihood_value) && $risk_treatment_likelihood_value == $value) ? 'checked' : '' }} {{ !$isEditable ? 'disabled' : '' }}>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <input type="hidden" name="risk_type_input" value="{{$risk_type}}">
        <input type="hidden" name="approach_type" value="{{"quantitative"}}">


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

@endif









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
