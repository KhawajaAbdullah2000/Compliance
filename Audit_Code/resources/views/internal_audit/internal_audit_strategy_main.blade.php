
@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


@php
$permissions = json_decode($project_permissions);
$canEdit = is_array($permissions) && in_array('Data Inputter', $permissions);
@endphp



<div class="wrapper d-flex align-items-stretch">


   @include('internal_audit.internal_audit_nav')

   <div id="content" class="p-4 p-md-5">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">

     
    
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
    

      </div>
    </nav>

         {{-- <div class=" my-2">

    <div class="row mt-5">
        <div class="col-lg-12">
         
            @include('components.topTable')
            
        </div>
    </div>
   </div> --}}

<h3 class="fw-bold mt-2 text-center">Audit Strategy and Processes</h3>
<h4 class="fw-bold mt-2 text-center text-primary">Internal Audit Strategy</h3>

 


<h3 class="fw-bold text-center mt-4 mb-2">Scope of Audit</h3>
<div class="col-md-12">
    @foreach ($departments as $d)
        @php
            $strategy = $existingStrategies[$d->id] ?? null;
        @endphp
     
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-bold" style="text-decoration: underline">
                    Sub Organization: {{ $d->name }}
                </h5>

                <form action="/audit_strategy_department/{{$project->project_id}}/{{auth()->user()->id}}" method="POST">
                    @csrf
                    <input type="hidden" name="organization_id" value="{{$d->org_id}}">
                    <input type="hidden" name="department_id" value="{{$d->id}}">
                    <input type="hidden" name="level_num" value="{{$level_num}}">

                    {{-- Audit Approach --}}
                    <div class="row align-items-center mb-2">
                        <div class="col-auto">
                            <label for="audit_approach_{{ $d->id }}" class="col-form-label fw-semibold">Audit Approach:</label>
                        </div>
                        <div class="col-md-4">
                            <select {{ $canEdit ? '' : 'disabled' }} id="audit_approach_{{ $d->id }}" name="audit_approach" class="form-select">
                                <option value="Substantive Testing" {{ (optional($strategy)->audit_approach == 'Substantive Testing') ? 'selected' : '' }}>Substantive Testing</option>
                                <option value="Risk-Based" {{ (optional($strategy)->audit_approach == 'Risk-Based') ? 'selected' : '' }}>Risk-Based</option>
                                <option value="Hybrid" {{ (optional($strategy)->audit_approach == 'Hybrid') ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                    </div>

                    {{-- Sampling Methodology --}}
                    <div class="row align-items-center mb-2">
                        <div class="col-auto">
                            <label for="sampling_methodology_{{ $d->id }}" class="col-form-label fw-semibold">Sampling Methodology:</label>
                        </div>
                        <div class="col-md-4">
                            <select {{ $canEdit ? '' : 'disabled' }} id="sampling_methodology_{{ $d->id }}" name="sampling_methodology" class="form-select">
                                <option value="Random Selection" {{ (optional($strategy)->sampling_methodology == 'Random Selection') ? 'selected' : '' }}>Random Selection</option>
                                <option value="Systematic Selection" {{ (optional($strategy)->sampling_methodology == 'Systematic Selection') ? 'selected' : '' }}>Systematic Selection</option>
                                <option value="Haphazard Selection" {{ (optional($strategy)->sampling_methodology == 'Haphazard Selection') ? 'selected' : '' }}>Haphazard Selection</option>
                                <option value="Block Selection" {{ (optional($strategy)->sampling_methodology == 'Block Selection') ? 'selected' : '' }}>Block Selection</option>
                            </select>
                        </div>
                    </div>

                    {{-- Audit Period --}}
                    <div class="row align-items-center mb-4 mt-4">
                        <div class="col-md-3">
                            <label class="fw-semibold">Audit Started:</label>
                            <input {{ $canEdit ? '' : 'disabled' }} type="date" name="audit_started" value="{{ optional($strategy)->audit_started }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="fw-semibold">Audit Ended:</label>
                            <input {{ $canEdit ? '' : 'disabled' }} type="date" name="audit_ended" value="{{ optional($strategy)->audit_ended }}" class="form-control">
                        </div>
                    </div>

                    {{-- Risk Affecting --}}
                    <div class="row align-items-center mb-2">
                        <div class="col-auto">
                            <label for="risk_affecting_{{ $d->id }}" class="col-form-label fw-semibold">Risks Affecting the Audit Processes:</label>
                        </div>
                        <div class="col">
                            <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="risk_affecting" id="risk_affecting_{{$d->id}}" rows="2">{{ optional($strategy)->risk_affecting }}</textarea>
                        </div>
                    </div>

                    {{-- Risk Mitigation --}}
                    <div class="row align-items-center mb-2">
                        <div class="col-auto">
                            <label for="risk_mitigation_{{ $d->id }}" class="col-form-label fw-semibold">Risk Mitigation Approaches:</label>
                        </div>
                        <div class="col">
                            <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="risk_mitigation" id="risk_mitigation_{{$d->id}}" rows="2">{{ optional($strategy)->risk_mitigation }}</textarea>
                        </div>
                    </div>

                   {{-- Inclusions in Scope --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Inclusions in Scope:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="inclusions_in_scope" rows="2">{{ optional($strategy)->inclusions_in_scope }}</textarea>
    </div>
</div>

{{-- Exclusions in Scope --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Exclusions in Scope:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="exclusions_in_scope" rows="2">{{ optional($strategy)->exclusions_in_scope }}</textarea>
    </div>
</div>

{{-- Persons Interviewed --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Persons Interviewed:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="persons_interviewed" rows="2">{{ optional($strategy)->persons_interviewed }}</textarea>
    </div>
</div>

{{-- Documents Reviewed --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Documents Reviewed:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="documents_reviewed" rows="2">{{ optional($strategy)->documents_reviewed }}</textarea>
    </div>
</div>

{{-- Processes Observed --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Processes Observed:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="processes_observed" rows="2">{{ optional($strategy)->processes_observed }}</textarea>
    </div>
</div>

{{-- Artefacts Examined --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Artefacts Examined:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="artefacts_examined" rows="2">{{ optional($strategy)->artefacts_examined }}</textarea>
    </div>
</div>

{{-- Requirements Status Compliance --}}
<div class="row align-items-center mb-2">
    <div class="col-auto">
        <label class="fw-semibold">Requirements Status & Compliance:</label>
    </div>
    <div class="col">
        <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="requirements_status_compliance" rows="2">{{ optional($strategy)->requirements_status_compliance }}</textarea>
    </div>
</div>


                    {{-- Save Button --}}
                    @if($canEdit)
                        <button type="submit" class="float-end btn btn-success btn-md mt-2">Save Changes</button>
                    @endif
                </form>

                @if($strategy)
    <a href="/select_internal_audit_fields_for_report/{{$strategy->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-outline-primary btn-sm mt-2">
        Select Fields for Reporting
    </a>
@endif
            </div>
        </div>
    @endforeach
</div>





  </div>
 




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