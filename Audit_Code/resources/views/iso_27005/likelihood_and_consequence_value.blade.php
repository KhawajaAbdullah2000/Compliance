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
    $likelihood_value_numeric = $likelihood_value ?? null;
    $consequence_value_numeric = $consequence_value ?? null;
@endphp


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Compliance Framework:</td>
                        <td>{{$complianceFramework->framework_name}}</td>
                        <td class="fw-bold">Information Security Risk Management Methodology:</td>
                        <td>{{$framework_approach->approach_name}} - {{$risk_assessment_approach->global_assessment_approach}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])

    <h4 class="fw-bold mt-4">Assessment of Risk to 
        @if($risk_type=='risk_confidentiality')
     Risk Confidentiality
     @else        
        {{$risk_type}}
        @endif
    
    </h4>



    <div class="col-md-6 mt-4">

        <table class="table table-bordered text-center align-middle" style="width: auto;">
            <thead class="table-dark">
                <tr>
                    <th>Likelihood \ Consequence</th>
                    @foreach ($consequences as $c_key => $c_label)
                        <th>{{ $c_label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($likelihoods as $l_key => $l_label)
                    <tr>
                        <th class="table-dark">{{ $l_label }}</th>
                        @foreach ($consequences as $c_key => $c_label)
                            @php
                                $cellValue = $riskMatrix[$l_key][$c_key];
                                $isHighlighted = $l_key == $likelihood_value_numeric && $c_key == $consequence_value_numeric;
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
