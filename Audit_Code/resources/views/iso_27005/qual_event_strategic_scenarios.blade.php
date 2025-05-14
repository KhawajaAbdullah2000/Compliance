@extends('master')

@section('content')

@include('user-nav')

@php
    // Decode permissions from controller
    $permissions = json_decode($project_permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

    <h3 class="fw-bold mt-2">Information Security Risk Assessment for {{ auth()->user()->organization->name }}</h3>
    <span class="fw-bold">Services: </span>{{ $services->pluck('s_name')->implode(', ') }}

       <div class="float-end mb-4">
        <a href="{{route('initiaite_risk_assessment_qual_event',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id])}}" class="btn btn-md btn-secondary">Back</a>
    </div>

  <div class="row">

    <h4>(Optional) Identify strategic scenarios of adverse impacts</h4>

 
  </div>


{{-- 
    @if (in_array('Data Inputter', $permissions))
      <div class="col-md-6">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">
            Add Scenario
        </div>
        <div class="card-body">
            <form action="/party_strategic_scenario_submit/{{$project->project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Write your strategic scenario here..." id="scenario" name="scenario" style="height: 150px" required></textarea>
                    <label for="scenario">Strategic Scenario</label>
                </div>

                <input type="hidden" name="risk_type" value="{{$risk_type_selected}}">
                <input type="hidden" name="party_type" value="{{$party->id}}">
                <button type="submit" class="btn btn-primary w-100">Save</button>
            </form>
        </div>
    </div>
</div>
    @endif --}}

    

       @if (in_array('Data Inputter', $permissions))
             <a href="/qual_event_add_scenario_form/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-success float-end btn-md mb-2" role="button">
            Add Scenario <i class="fas fa-plus"></i></a>

       @endif
   
    <table class="table table-responsive table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Scenario Title</th>
                <th>Party</th>
                <th>party Type</th>
                <th>Party Category</th>
                <th>Adverse Impact on</th>
              <th>Description</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($scenarios as $s )
          <tr>
              <td>{{$s->title}}</td>
              <td>{{$s->party_name}}</td>
              <td>{{$s->party_type_party}}</td>
              <td>{{$s->party_category}}</td>
              <td>
                @if($s->risk_type=='risk_confidentiality')
                Data Confidentiality
                @elseif($s->risk_type=='risk_integrity')
                Data Integrity
                @elseif($s->risk_type=='risk_availability')
                Data Availability
                @endif
              </td>
              <td>{{$s->scenario}}</td>
              <td>
                @if (in_array('Data Inputter', $permissions))

                              
        <a href="/delete_strategic_scenario/{{$s->scenario_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-md mb-2" role="button">
            <i class="fas fa-trash"></i></a>

                @else
                            
            <i class="fas fa-lock"></i></a>
                @endif
              </td>
          </tr>
            
            @endforeach
        </tbody>
    </table>


    <a href="{{route('iso_27005_risk_assessment_qual_event',[
    'proj_id'=>$project->project_id,
    'user_id'=>auth()->user()->id])}}" class="btn btn-primary btn-md float-end">Go to Next</a>


</div>

@section('scripts')
    @if(Session::has('success'))
        <script>
            swal({
                title: "{{ Session::get('success') }}",
                icon: "success",
                closeOnClickOutside: true,
                timer: 3000,
            });
        </script>
    @endif
@endsection

@endsection
