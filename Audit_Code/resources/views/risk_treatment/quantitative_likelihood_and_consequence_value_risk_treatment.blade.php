@extends('master')

@section('content')

@include('user-nav')
@php
    $highlight_value = $likelihood_value * $consequence_value;
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
@endphp


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])

    <h4 class="fw-bold mt-4">Assessment of Risk to 
        @if($risk_type=='risk_confidentiality')
     Data Confidentiality
     @elseif($risk_type=='risk_integrity')
     Data Integrity 
     @else
     Data Availability       
        
        @endif
    
    </h4>


    <div class="col-md-6 mt-4">
      
        <div class="table-responsive">
            <table class="table risk-table">
                <thead>
                    <tr>
                        <th class="header-left"></th> <!-- Empty corner cell -->
                        <th colspan="{{ count($likelihoods) }}" class="header-top">Likelihood ({{$likelihood_timeframe}} days)</th>
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
                                    $is_highlighted = $consequence_key == $consequence_value && $likelihood_key == $likelihood_value;
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

    @if($risk_type=="risk_confidentiality")
    <div class="text-center">
        <a href="/iso_27005_likelihood_value_risk_treatment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/risk_integrity" class="btn btn-primary">Next</a>
    </div>
    @endif

    @if($risk_type=="risk_integrity")
    <div class="text-center">
        <a href="/iso_27005_likelihood_value_risk_treatment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/risk_availability" class="btn btn-primary">Next</a>
    </div>
    @endif

    @if($risk_type=="risk_availability")
    <div class="text-center">
        <a href="/iso_27005_likelihood_value_all_risk_treatment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary">Next</a>
    </div>
    @endif

    

        
    




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
