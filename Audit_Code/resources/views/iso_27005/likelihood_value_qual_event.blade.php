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
    <h3 class="fw-bold mt-2">Risk Assessment for {{auth()->user()->organization->name}}</h3>
    
<div class="row">

<div class="col-md-8">
<p class="fs-6 mt-2">Estimate the likelihood of strategic scenarios
    </p>
    </div>

    <div class="col-md-4">
        <a href="{{route('iso_27005_risk_assessment_qual_event',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id])}}" class="btn btn-secondary btn-md float-end">Back</a>
    </div>
    </div>

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

      <table class="table mt-4 table-responsive table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Strategic No.</th>
            <th>Scenario Title</th>
            <th>Party</th>
            <th>Party Type</th>
            <th>Party Category</th>
            <th>Adverse Impact on</th>
            <th>Description</th>
            <th>Likelihood Assessment</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($scenarios as $s)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $s->title }}</td>
                <td>{{ $s->party_name }}</td>
                <td>{{ $s->party_type_party }}</td>
                <td>{{ $s->party_category }}</td>
                <td>
                @if($s->risk_type=='risk_confidentiality')
                Data Confidentiality
                @elseif($s->risk_type=='risk_integrity')
                Data Integrity
                @elseif($s->risk_type=='risk_availability')
                Data Availability
                @endif
              </td>
                <td>{{ $s->scenario }}</td>
                <td>
                    <form action="/save_likelihood_qual_event_form/{{$project->project_id}}/{{auth()->user()->id}}" method="POST" class="d-flex">
                        @csrf
                        <input type="hidden" name="scenario" value="{{$s->scenario_id}}">
                          <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" name="likelihood" required>
                                <option value="">Select Likelihood</option>
                                <option value="5" {{ $s->likelihood_selected == 5 ? 'selected' : '' }}>Almost Certain</option>
                                <option value="4" {{ $s->likelihood_selected == 4 ? 'selected' : '' }}>Very Likely</option>
                                <option value="3" {{ $s->likelihood_selected == 3 ? 'selected' : '' }}>Likely</option>
                                <option value="2" {{ $s->likelihood_selected == 2 ? 'selected' : '' }}>Rather Unlikely</option>
                                <option value="1" {{ $s->likelihood_selected == 1 ? 'selected' : '' }}>Unlikely</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="/iso_section2_1/{{$project->project_id}}/{{auth()->user()->id}}/risk_assessment" class="btn btn-primary btn-md float-end mb-2">Services & Assets Page</a>



    {{-- <div class="col-md-6 mt-4">
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
    </div> --}}
    {{-- <div class="col-md-8 mt-4 mb-2">
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
            <input type="hidden" name="approach_type" value="{{"qualitative"}}">
    
         
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="/likelihood_and_consequence/{{$risk_type}}/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary">Next</a>
                </div>
          
        </form>
    </div> --}}
    
      

        
    




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
