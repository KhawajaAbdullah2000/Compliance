@extends('master')

@section('content')

@include('user-nav')
@php
    $highlight_value = $likelihood_value * $consequence_value;
@endphp


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])

    <h4 class="fw-bold mt-4">Assessment of Risk to 
        @if($risk_type=='risk_confidentiality')
     Risk Confidentiality
     @elseif($risk_type=='risk_integrity')
     Risk Integrity 
     @else
     Risk Availability       
        
        @endif
    
    </h4>

    <h2>Likelihood: {{$likelihood_value}} COnsequenceVal: {{$consequence_value}}</h2>

    <div class="col-md-6 mt-4">
      
    <div class="table-responsive">
        <table class="table risk-table">
            <thead>
                <tr>
                    <th class="header-left"></th> <!-- Empty corner cell -->
                    <th colspan="6" class="header-top">Likelihood</th>
                </tr>
                <tr>
                    <th class="header-left">Consequence</th> <!-- Consequence label -->
                    @for ($likelihood = 6; $likelihood >= 1; $likelihood--)
                        <th class="header-top">{{ $likelihood }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @for ($consequence = 5; $consequence >= 1; $consequence--)
                    <tr>
                        <th class="header-left">{{ $consequence }}</th> <!-- Consequence values -->
                        @for ($likelihood = 6; $likelihood >= 1; $likelihood--)
                            @php
                                $cell_value = $likelihood * $consequence;
                                $is_highlighted = $consequence == $consequence_value && $likelihood == $likelihood_value;
                            @endphp
                            <td style="{{ $is_highlighted ? 'border: 2px solid red; font-weight: bold; background-color:rgba(255, 99, 71, 0.6);' : '' }}">
                                {{ $cell_value }}
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    
    </div>

    @if($risk_type=="risk_confidentiality")
    <div class="text-center">
        <a href="/iso_27005_likelihood_value/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/risk_integrity" class="btn btn-primary">Next</a>
    </div>
    @endif

    @if($risk_type=="risk_integrity")
    <div class="text-center">
        <a href="/iso_27005_likelihood_value/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/risk_availability" class="btn btn-primary">Next</a>
    </div>
    @endif

    @if($risk_type=="risk_availability")
    <div class="text-center">
        <a href="/iso_27005_likelihood_value_all/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary">Next</a>
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
