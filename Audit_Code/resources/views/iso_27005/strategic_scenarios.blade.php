@extends('master')

@section('content')

@include('user-nav')

@php
    // Define risk type labels
    $risk_type_labels = [
        'risk_confidentiality' => 'Data Confidentiality',
        'risk_integrity' => 'Data Integrity',
        'risk_availability' => 'Data Availability'
    ];

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

  <div class="row">
    <div class="col-md-10">
          <h4 class="">
        Strategic Scenarios of Adverse Impacts for 
        {{ $risk_type_labels[$risk_type_selected] ?? 'Unknown Risk Type' }}
    </h4>
    </div>

    <div class="col-md-2 float-end mb-4">
        <a href="{{route('initiaite_risk_assessment_qual_event',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id])}}" class="btn btn-md btn-secondary">Back</a>
    </div>
  </div>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light fw-bold">
        Party Details
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-2">
                <small class="text-muted">Party Name</small>
                <div class="fw-semibold">{{ $party->party_name }}</div>
            </div>
            <div class="col-md-4 mb-2">
                <small class="text-muted">Party Type</small>
                <div class="fw-semibold">{{ $party->party_type }}</div>
            </div>
            <div class="col-md-4 mb-2">
                <small class="text-muted">Party Category</small>
                <div class="fw-semibold">{{ $party->party_category }}</div>
            </div>
        </div>
    </div>
</div>


    @if (in_array('Data Inputter', $permissions))
      <div class="col-md-6">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">
            Add Strategic Scenario
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
    @endif


    <h4 class="fw-bold">Scenarios Added so far</h4>
    <table class="table table-responsive table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Scenario</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($scenarios as $s )
          <tr>
              <td>{{$s->scenario}}</td>
              <td>
                @if (in_array('Data Inputter', $permissions))

                              
        <a href="/delete_strategic_scenario/{{$s->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-md mb-2" role="button">
            <i class="fas fa-trash"></i></a>

                @else
                            
            <i class="fas fa-lock"></i></a>
                @endif
              </td>
          </tr>
            
            @endforeach
        </tbody>
    </table>


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
