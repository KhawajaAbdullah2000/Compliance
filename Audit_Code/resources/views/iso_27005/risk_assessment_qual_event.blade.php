@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for {{auth()->user()->organization->id}}</h3>

   <span class="fw-bold">Services: </span> {{ $services->pluck('s_name')->implode(', ') }}
    
        
        <h5 class="fw-bold mt-4">Evaluate gaps in applicable controls 
        </h5>
        

@if($project->project_type==18)
{{-- only in coso --}}
<div class="text-end">
     <a href="/ai_input_submit_risk_assessment_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md" style="max-width: 200px;min-width:100px;">AI Input</a>
</div>
@endif

<div class="col-md-10">
    <form action="/iso_27005_submit_risk_assessment_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" method="POST">
        @csrf

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No.</th>
                <th>Controls (as per ISO 27001:2022 Annex A)</th>
                <th>Vulnerability Level due to </th>
                
           
            </tr>
        </thead>
        <tbody>
            @foreach ($controls as $control)
            @php
            $controlNum = trim((string) $control[0]); 
            $selectedValue = $savedData[$controlNum] ?? null;
        @endphp
        <tr>
            <td>{{ $controlNum }}</td>
            <td>{{ $control[1] }}</td>
         
            <input type="hidden" name="control_num[]" value="{{ $controlNum }}">
            <td>
                <div class="d-flex gap-2 align-items-center">
    <select class="form-select" name="vulnerability_due_to[]" style="min-width: 150px;max-width:150px;">
        @foreach (['Very High', 'High', 'Medium', 'Low', 'Very Low'] as $level)
            <option value="{{ $level }}" {{ $selectedValue == $level ? 'selected' : '' }}>{{ $level }}</option>
        @endforeach
    </select>
   
</div>
            </td>

            {{-- @if ($loop->first)
            <td class="text-center" rowspan="{{ count($controls) }}">
                <a href="/add_scenario_form_qual_event/{{$project->project_id}}/{{auth()->user()->id}}/risk_confidentiality" title="Edit Target Objective">
                    <i class="fas fa-address-book fa-2x" style="color: #e2850a;"></i>
                </a>
            </td>
            @endif --}}
         
        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end mb-4">
    <button type="submit" class="btn btn-primary btn-md">Save</button>
    </div>
</form>
    
</div>

<div class="row">
    <div class="col-md-6">
        <h5 class="fw-bold">Consolidated Level of Vulnerability</h5>

<form action="/proj_asset_selected_level_of_vulnerability_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" method="Post">
@csrf
<select name="vulnerability_level" class="form-select">
    @foreach($global_level_of_vulnerabilities as $vulnerability)
        <option value="{{ $vulnerability->global_level_of_vulnerability_id }}"
            {{ $vulnerability->global_level_of_vulnerability_id == $selected_level_of_vulnerability ? 'selected' : '' }}>
            {{ $vulnerability->global_vulnerability }}
        </option>
    @endforeach
</select>


<div class="mt-4 mb-4 d-flex justify-content-end gap-2">
    
    <a href="{{route('iso_sec_2_3_1_qual_event_scenarios',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id,
   
        ])}}" class="btn btn-secondary">Back</a>   
         <button type="submit" name="action" value="save_and_stay" class="btn btn-primary">
        Save & Stay
    </button>
    <button type="submit" name="action" value="save_and_next" class="btn btn-primary">
        Save & go to next step
    </button>

</div>
</form>





    </div>
</div>






</div>

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

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
