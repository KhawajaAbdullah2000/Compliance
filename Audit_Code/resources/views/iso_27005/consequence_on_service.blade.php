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

            @include('components.topTable')

        </div>
    </div>

      
    <h3 class="fw-bold mt-2">Select the business impact (consequence) on this service in case of:</h3>

    @include('components.asset-summary', ['asset' => $asset])


      <div class="text-end mt-2">
       @include('components.back_to_flow_chart_btn',['asset'=>$asset,'project'=>$project])
    </div>

    <div class="row mt-4">

        @if($framework_approach->framework_approach_types_id==2)
        <div class="col-md-6">
            @else
            <div class="col-md-8">
                @endif

                <form action="/iso_sec2_3_1_risk_selection/{{$asset->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" method="POST">
                    @csrf
                    @method('PUT')
                
                    @php
    use App\Support\RiskScheme;
    
@endphp

@if(\App\Support\RiskScheme::isNone($schemeKey))
    <div class="alert alert-info">
          @php
                    $riskOptions = [5,4,3,2,1];
                    @endphp

                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Loss of Data Confidentiality</th>
                                <th>Loss of Data Integrity</th>
                                <th>Loss of Data Availability</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        @foreach($riskOptions as $option)
                        <tr>


                            <td>
                                <input class="form-check-input" type="radio" name="risk_confidentiality" value="{{ $option }}" {{ (old('risk_confidentiality', $asset->risk_confidentiality ?? '') == $option) ? 'checked' : '' }}>
                            </td>


                            <td>
                                <input class="form-check-input" type="radio" name="risk_integrity" value="{{ $option }}" {{ (old('risk_integrity', $asset->risk_integrity ?? '') == $option) ? 'checked' : '' }}>
                            </td>


                            <td>
                                <input class="form-check-input" type="radio" name="risk_availability" value="{{ $option }}" {{ (old('risk_availability', $asset->risk_availability ?? '') == $option) ? 'checked' : '' }}>
                            </td>


                            <td class="score-cell">
                                @if($option==5)
                                5-Catastrophic
                                @elseif($option==4)
                                4-Critical
                                @elseif($option==3)
                                3-Serious
                                @elseif($option==2)
                                2-Significant
                                @elseif($option==1)
                                1-Minor
                                @else
                                UnKnown
                                @endif
                                <div class="hover-desc">
                                    {{ $riskDescriptions[$option] }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
    </div>
@else
    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Loss of Data Confidentiality</th>
                <th>Loss of Data Integrity</th>
                <th>Loss of Data Availability</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
        @foreach($riskValues as $value)
            @php $disp = RiskScheme::display($value, $schemeKey); @endphp
            <tr>
                <td>
                    <input class="form-check-input" type="radio"
                           name="risk_confidentiality"
                           value="{{ $value }}"
                           {{ (int)old('risk_confidentiality', $asset->risk_confidentiality ?? 0) === (int)$value ? 'checked' : '' }}>
                </td>
                <td>
                    <input class="form-check-input" type="radio"
                           name="risk_integrity"
                           value="{{ $value }}"
                           {{ (int)old('risk_integrity', $asset->risk_integrity ?? 0) === (int)$value ? 'checked' : '' }}>
                </td>
                <td>
                    <input class="form-check-input" type="radio"
                           name="risk_availability"
                           value="{{ $value }}"
                           {{ (int)old('risk_availability', $asset->risk_availability ?? 0) === (int)$value ? 'checked' : '' }}>
                </td>
                <td class="score-cell {{ $disp['class'] }}">
                    {{ $value }}{{ $scheme['named'] ? ' — '.$disp['label'] : '' }}
                    @if(isset($riskDescriptions[$value]))
                        <div class="hover-desc">{{ $riskDescriptions[$value] }}</div>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

                    <div class="mt-4 mb-4 d-flex justify-content-end gap-2">
                        <button type="submit" name="action" value="save_and_stay" class="btn btn-secondary">
                            Save
                        </button>
                        <button type="submit" name="action" value="save_and_next" class="btn btn-primary">
                            Save & Next
                        </button>
                    </div>
                </form>


            </div>

            @if($framework_approach->framework_approach_types_id==2)
            {{-- Quantitative Asset Based --}}
            <div class="col-md-6">
                <form action="/quantitave_consequence_scale_amount_entered/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}" method="POST">
                    @csrf

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Consequence ( a loss of)</th>
                                <th>Currency</th>
                                <th>Log Expression</th>
                                <th>Scale Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $rows = [
                            ['log' => '10^6', 'scale' => 6],
                            ['log' => '10^5', 'scale' => 5],
                            ['log' => '10^4', 'scale' => 4],
                            ['log' => '10^3', 'scale' => 3],
                            ['log' => '10^2', 'scale' => 2],
                            ['log' => '10^1', 'scale' => 1],
                            ];

                            @endphp

                            @foreach ($rows as $index => $row)
                            <tr>
                                <td>
                                    <input type="number" step="any" name="consequence_amount[{{ $index }}]" class="form-control" value="{{ $consequence_scale[$index]->consequence_amount ?? '' }}" placeholder="Enter amount">

                                </td>
                                <td>
                                    <select disabled name="currency_selected[{{ $index }}]" required class="form-select">
                                        <option value="">Select</option>
                                        @foreach ($global_currency as $currency)
                                        <option value="{{ $currency->global_currency_id }}" @if(isset($consequence_scale[$index]) && $consequence_scale[$index]->currency_selected == $currency->global_currency_id) selected @endif>
                                            {{ $currency->currency }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {{ $row['log'] }}
                                    <input type="hidden" name="log_expression[{{ $index }}]" value="{{ $row['log'] }}">
                                </td>
                                <td>
                                    {{ $row['scale'] }}
                                    <input type="hidden" name="scale[{{ $index }}]" value="{{ $row['scale'] }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button class="btn btn-secondary btn-md mb-2" type="submit">Save</button>


                </form>
            </div>

            @endif

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
