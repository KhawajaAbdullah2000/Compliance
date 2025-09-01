@extends('master')

@section('content')

@include('user-nav')
@php
      $likelihoods = [
        6=>'Every hour',
        5 => 'Every 8 hours', 
        4 => 'Twice a week', 
        3 => 'Once a month', 
        2 => 'Once a year', 
        1 => 'Once a decade',
    ];
    $consequences = [
        5 => 'Catastrophic',
        4 => 'Critical',
        3 => 'Serious',
        2 => 'Significant',
        1 => 'Minor',
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

          <div class="col-12">
    @include('components.consequence_of_loss', ['asset' => $asset,'project'=>$project])
    </div>

    @include('components.consolidated_threat_vulnerability',['asset'=>$asset,'project'=>$project])

    <div class="text-end mt-2">
       @include('components.back_to_flow_chart_btn',['asset'=>$asset,'project'=>$project])
    </div>



    <div class="row mt-4 justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-2">
                <h5 class="fw-bold">Data Confidentiality</h5>
            </div>
            
        <div class="table-responsive">
            <table class="table risk-table">
                <thead>
                    <tr>
                        <th class="header-left"></th> <!-- Empty corner cell -->
                        <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood ({{$likelihood_timeframe_confidentialilty}} days)</th>
                    </tr>
                    <tr>
                        <th class="header-left">Consequence</th> <!-- Consequence label -->
                        @foreach ($likelihoods as $likelihood_key => $likelihood_label)
                            <th class="header-top">{{ $likelihood_label }}</th> <!-- Likelihood labels -->
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consequences as $consequence_key => $consequence_label)
                        <tr>
                            <th class="header-left">{{ $consequence_label }}</th> <!-- Consequence labels -->
                            @foreach ($likelihoods as $likelihood_key => $likelihood_label)
                                @php
                                    $cell_value = $likelihood_key * $consequence_key;
                                    $is_highlighted = $consequence_key == $consequence_value_confidentiality_numeric && $likelihood_key == $likelihood_value_confidentiality_numeric;
                                @endphp
                                <td style="{{ $is_highlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                    {{ $cell_value }}
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
                            <th class="header-left"></th> <!-- Empty corner cell -->
                            <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood ({{$likelihood_timeframe_integrity}} days)</th>
                        </tr>
                        <tr>
                            <th class="header-left">Consequence</th> <!-- Consequence label -->
                            @foreach ($likelihoods as $likelihood_key => $likelihood_label)
                                <th class="header-top">{{ $likelihood_label }}</th> <!-- Likelihood labels -->
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consequences as $consequence_key => $consequence_label)
                            <tr>
                                <th class="header-left">{{ $consequence_label }}</th> <!-- Consequence labels -->
                                @foreach ($likelihoods as $likelihood_key => $likelihood_label)
                                    @php
                                        $cell_value = $likelihood_key * $consequence_key;
                                        $is_highlighted = $consequence_key == $consequence_value_integrity_numeric && $likelihood_key == $likelihood_value_integrity_numeric;
                                    @endphp
                                    <td style="{{ $is_highlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                        {{ $cell_value }}
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
                            <th class="header-left"></th> <!-- Empty corner cell -->
                            <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood ({{$likelihood_timeframe_availability}} days)</th>
                        </tr>
                        <tr>
                            <th class="header-left">Consequence</th> <!-- Consequence label -->
                            @foreach ($likelihoods as $likelihood_key => $likelihood_label)
                                <th class="header-top">{{ $likelihood_label }}</th> <!-- Likelihood labels -->
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consequences as $consequence_key => $consequence_label)
                            <tr>
                                <th class="header-left">{{ $consequence_label }}</th> <!-- Consequence labels -->
                                @foreach ($likelihoods as $likelihood_key => $likelihood_label)
                                    @php
                                        $cell_value = $likelihood_key * $consequence_key;
                                        $is_highlighted = $consequence_key == $consequence_value_availability_numeric && $likelihood_key == $likelihood_value_availability_numeric;
                                    @endphp
                                    <td style="{{ $is_highlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                        {{ $cell_value }}
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
