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
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])
    
    <p class="fs-6 mt-2">By considering both the threats in the environment of an asset component and the vulnerabilities of the asset component, evaluate the likelihood that a DATA CONFIDENTIALITY exploit will occur in a finite timeframe
    </p>

    <div class="col-md-6">

    <div class="card mt-4">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md-6">
              <p class="mb-0 text-muted">Consolidated Level of Threats</p>
              <h5 class="fw-bold text-danger">{{$threat}}</h5>
            </div>
            <div class="col-md-6">
              <p class="mb-0 text-muted">Consolidated Vulnerability Level</p>
              <h5 class="fw-bold text-warning">{{$vulnerability}}</h5>
            </div>
          </div>
        </div>
      </div>


              
    </div>

    <div class="col-md-6 mt-4 mb-2">
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

                exploit will occur in a finite timeframe
            </label>
    
            <div class="input-group">
                <input 
                    type="number" 
                    name="timeframe" 
                    class="form-control" 
                    placeholder="Enter Number of Days"
                    value="{{ $likelihood_timeframe }}"
                    {{ !$isEditable ? 'disabled' : '' }}
                >
                <input type="hidden" name="risk_type_input" value="{{$risk_type}}">
                @if($isEditable)
                    <button type="submit" class="btn btn-primary">Save</button>
                @endif
            </div>
        </form>
    </div>

    @if($framework_approach->framework_approach_types_id==1)
    {{-- Qualitative Asset based --}}
    <div class="col-md-8 mt-4 mb-2">
        <form action="/save_likelihood_value/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
            @csrf
            <label class="form-label fw-semibold mb-3">
                Select Likelihood That a 
                @if($risk_type=='risk_confidentiality')
                DATA CONFIDENTIALITY 
                @elseif($risk_type=='risk_integrity')
                DATA INTEGRITY
                @else
                DATA AVAILABILITY
                @endif
                
                Exploit Will Occur:
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
                                        <input class="form-check-input" type="radio" name="likelihood_value" value="{{ $value }}"
                                               id="likelihood_{{ $value }}"
                                               {{ (isset($likelihood_value) && $likelihood_value == $value) ? 'checked' : '' }}
                                               {{ !$isEditable ? 'disabled' : '' }}>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <input type="hidden" name="risk_type_input" value="{{$risk_type}}">
    
         
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="/likelihood_and_consequence/{{$risk_type}}/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary">Next</a>
                </div>
          
        </form>
    </div>
    @endif

    @if($framework_approach->framework_approach_types_id==2)
    {{-- Quantitative Asset based --}}

    <div class="col-md-8 mt-4 mb-2">
        <form action="/save_likelihood_value/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
            @csrf
            <label class="form-label fw-semibold mb-3">
                Select Likelihood That a 
                @if($risk_type=='risk_confidentiality')
                DATA CONFIDENTIALITY 
                @elseif($risk_type=='risk_integrity')
                DATA INTEGRITY
                @else
                DATA AVAILABILITY
                @endif
                
                Exploit Will Occur:
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
                                        <input class="form-check-input" type="radio" name="likelihood_value" value="{{ $value }}"
                                               id="likelihood_{{ $value }}"
                                               {{ (isset($likelihood_value) && $likelihood_value == $value) ? 'checked' : '' }}
                                               {{ !$isEditable ? 'disabled' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="/likelihood_and_consequence/{{$risk_type}}/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary">Next</a>
                </div>
          
        </form>
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
