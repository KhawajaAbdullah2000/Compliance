@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])
    
        
        <h5 class="fw-bold mt-4">By evaluating gaps in applicable controls, evaluate how vulnerable the asset component is to actions by risk sources in the environment 
        </h5>
        




<div class="col-md-8">
    <form action="/iso_27005_submit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
        @csrf

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No.</th>
                <th>Controls (as per ISO 27001:2022 Annex A)</th>
                @if($framework_approach->framework_approach_types_id==1)
                <th>Vulnerabilities</th>
                @endif
                <th>Vulnerability Level due to </th>
                <th>Risk Scenarios (Optional)</th>
           
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
            @if($framework_approach->framework_approach_types_id==1)
            <td class="text-center">
                <a href="/select_vul_for_control/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/{{$controlNum}}" title="Vulnerabilities"><i class="fas fa-edit fa-lg" style="color: #124903;"></i></a>
            </td>
            @endif
            <input type="hidden" name="control_num[]" value="{{ $controlNum }}">
            <td>
                <select class="form-select" name="vulnerability_due_to[]">
                    @foreach (['Very High', 'High', 'Medium', 'Low', 'Very Low'] as $level)
                        <option value="{{ $level }}" {{ $selectedValue == $level ? 'selected' : '' }}>{{ $level }}</option>
                    @endforeach
                </select>
            </td>

            @if ($loop->first)
            <td class="text-center" rowspan="{{ count($controls) }}">
                <a href="/add_scenario_form/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" title="Edit Target Objective">
                    <i class="fas fa-address-book fa-2x" style="color: #e2850a;"></i>
                </a>
            </td>
            @endif
         
        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end mb-4">
    <button type="submit" class="btn btn-primary btn-md">Save</button>
    </div>
</form>
    
</div>


<h5 class="fw-bold">Consolidated Level of Vulnerability</h5>

<form action="/proj_asset_selected_level_of_vulnerability/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
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
    
    <a href="{{route('route_for_risk_source',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id,
        'asset_id'=>$asset->assessment_id
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
