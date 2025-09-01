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

    <h3 class="fw-bold mt-2">Risk Assessment for {{ auth()->user()->organization->name }}</h3>
    <span class="fw-bold">Services: </span>{{ $services->pluck('s_name')->implode(', ') }}

      

  <div class="row col-md-6">

    <h4>Consolidated Level of Threats</h4>

    <form action="/proj_asset_selected_level_of_threat_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" method="Post">
@csrf
<select name="threat_level" class="form-select">
    @foreach($global_level_of_threats as $threats)
        <option value="{{ $threats->global_level_of_threats_id }}"
            {{ $threats->global_level_of_threats_id == $selected_level_of_threat ? 'selected' : '' }}>
            {{ $threats->global_threat }}
        </option>
    @endforeach
</select>


<div class="mt-4 mb-4 d-flex justify-content-end gap-2">
    
    <a href="{{route('iso_sec_2_3_1_qual_event_scenarios',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id,
   
        ])}}" class="btn btn-secondary">Back</a>   
         <button type="submit" name="action" value="save_and_stay" class="btn btn-secondary">
        Save
    </button>
    <button type="submit" name="action" value="save_and_next" class="btn btn-primary">
        Save & Next
    </button>

</div>
</form>

 
  </div>




    
    {{-- <a href="{{route('iso_27005_risk_assessment_qual_event',[
    'proj_id'=>$project->project_id,
    'user_id'=>auth()->user()->id])}}" class="btn btn-primary btn-md float-end">Go to Next</a> --}}

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
