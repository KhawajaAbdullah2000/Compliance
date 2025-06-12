@extends('master')

@section('content')

@include('user-nav')
@php
    $likelihoods = [
        5 => 'Almost certain',
        4 => 'Very likely',
        3 => 'Likely',
        2 => 'Rather unlikely',
        1 => 'Unlikely',
    ];

    $consequences = [
        5 => 'Catastrophic',
        4 => 'Critical',
        3 => 'Serious',
        2 => 'Significant',
        1 => 'Minor',
    ];

    $riskMatrix = [
        5 => [5 => 'Very high', 4 => 'Very high', 3 => 'High',      2 => 'High',     1 => 'Medium'],
        4 => [5 => 'Very high', 4 => 'High',      3 => 'High',      2 => 'Medium',   1 => 'Low'],
        3 => [5 => 'High',      4 => 'High',      3 => 'Medium',    2 => 'Low',      1 => 'Low'],
        2 => [5 => 'Medium',    4 => 'Medium',    3 => 'Low',       2 => 'Low',      1 => 'Very low'],
        1 => [5 => 'Low',       4 => 'Low',       3 => 'Low',       2 => 'Very low', 1 => 'Very low'],
    ];

    // Convert IDs to levels if necessary
     $likelihood_value_confidentiality_numeric = $likelihood_value_confidentiality ?? null;
     $consequence_value_confidentiality_numeric = $consequence_value_confidentiality ?? null;

     $likelihood_value_integrity_numeric = $likelihood_value_integrity ?? null;
     $consequence_value_integrity_numeric = $consequence_value_integrity ?? null;

     $likelihood_value_availability_numeric = $likelihood_value_availability ?? null;
     $consequence_value_availability_numeric = $consequence_value_availability ?? null;
@endphp


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])


    <div class="row mt-4 justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-2">
                <h5 class="fw-bold">Data Confidentiality</h5>
            </div>
            <div class="table-responsive">
                <table class="table risk-table">
                    <thead>
                        <tr>
                            <th class="header-left"></th> <!-- Empty corner -->
                            <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood</th> <!-- Likelihood label spanning across -->
                        </tr>
                        <tr>
                            <th class="header-left">Consequence</th> <!-- Consequence label on the Y-axis -->
                            @foreach ($likelihoods as $l_key => $l_label)
                                <th class="header-top">{{ $l_label }}</th> <!-- Likelihood values across top -->
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consequences as $c_key => $c_label)
                            <tr>
                                <th class="header-left">{{ $c_label }}</th> <!-- Consequence values along the Y-axis -->
                                @foreach ($likelihoods as $l_key => $l_label)
                                    @php
                                        $cellValue = $riskMatrix[$l_key][$c_key]; // Note: matrix remains [likelihood][consequence]
                                        $isHighlighted = $l_key == $likelihood_value_confidentiality_numeric && $c_key == $consequence_value_confidentiality_numeric;
                                    @endphp
                                    <td style="{{ $isHighlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                        {{ $cellValue }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
    <div class="row mt-4 justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-2">
                <h5 class="fw-bold">Data Integrity</h5>
            </div>
            <div class="table-responsive">
                <table class="table risk-table">
                    <thead>
                        <tr>
                            <th class="header-left"></th> <!-- Empty corner -->
                            <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood</th> <!-- Likelihood label spanning across -->
                        </tr>
                        <tr>
                            <th class="header-left">Consequence</th> <!-- Consequence label on the Y-axis -->
                            @foreach ($likelihoods as $l_key => $l_label)
                                <th class="header-top">{{ $l_label }}</th> <!-- Likelihood values across top -->
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consequences as $c_key => $c_label)
                            <tr>
                                <th class="header-left">{{ $c_label }}</th> <!-- Consequence values along the Y-axis -->
                                @foreach ($likelihoods as $l_key => $l_label)
                                    @php
                                        $cellValue = $riskMatrix[$l_key][$c_key]; // Note: matrix remains [likelihood][consequence]
                                        $isHighlighted = $l_key == $likelihood_value_integrity_numeric && $c_key == $consequence_value_integrity_numeric;
                                    @endphp
                                    <td style="{{ $isHighlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                        {{ $cellValue }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

    <div class="row mt-4 justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-2">
                <h5 class="fw-bold">Data Availability</h5>
            </div>
            <div class="table-responsive">
                <table class="table risk-table">
                    <thead>
                        <tr>
                            <th class="header-left"></th> <!-- Empty corner -->
                            <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood</th> <!-- Likelihood label spanning across -->
                        </tr>
                        <tr>
                            <th class="header-left">Consequence</th> <!-- Consequence label on the Y-axis -->
                            @foreach ($likelihoods as $l_key => $l_label)
                                <th class="header-top">{{ $l_label }}</th> <!-- Likelihood values across top -->
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consequences as $c_key => $c_label)
                            <tr>
                                <th class="header-left">{{ $c_label }}</th> <!-- Consequence values along the Y-axis -->
                                @foreach ($likelihoods as $l_key => $l_label)
                                    @php
                                        $cellValue = $riskMatrix[$l_key][$c_key]; // Note: matrix remains [likelihood][consequence]
                                        $isHighlighted = $l_key == $likelihood_value_availability_numeric && $c_key == $consequence_value_availability_numeric;
                                    @endphp
                                    <td style="{{ $isHighlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                        {{ $cellValue }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
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
