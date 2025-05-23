
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


<h3 class="fw-bold mt-2 text-center">Audit Strategy and Processes</h3>
<h4 class="fw-bold mt-2 text-center text-primary">Internal Audit Strategy</h3>

 




<div class="col-md-6">
<form action="/submit_strategy_time_period/{{$project->project_id}}/{{auth()->user()->id}}" method="POST" class="d-flex align-items-center gap-2 mb-2">
    @csrf

    <label for="time_period" class="form-label mb-0 fw-semibold">Strategy Time Period:</label>
    <select {{ $canEdit ? '' : 'disabled' }} name="time_period" id="time_period" class="form-select w-50">
        @for ($i = 1; $i <= 10; $i++)
           <option value="{{ $i }}" {{ isset($time_period_selected) && $time_period_selected == $i ? 'selected' : '' }}>
                {{ $i }}
            </option>
        @endfor
    </select>

    <button {{ $canEdit ? '' : 'disabled' }} type="submit" class="btn btn-success btn-sm">Submit</button>
</form>
</div>

<h3 class="fw-bold text-center mt-4 mb-2">Scope of Audit</h3>

<div class="accordion mt-4" id="departmentAccordion">
    @foreach ($departments as $index => $d)
        @php
            $strategy = $existingStrategies[$d->id] ?? null;
        @endphp

        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading{{ $index }}">
                <button class="accordion-button collapsed fw-bold elevation-effect" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                    Sub Organization: {{ $d->name }}
                </button>
            </h2>

            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#departmentAccordion">
                <div class="accordion-body">

                    {{-- Start of the Full Form --}}
                    <form action="/audit_strategy_department/{{$project->project_id}}/{{auth()->user()->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="organization_id" value="{{ $d->org_id }}">
                        <input type="hidden" name="department_id" value="{{ $d->id }}">
                        <input type="hidden" name="level_num" value="{{ $level_num }}">

                        {{-- Audit Approach --}}
                        <div class="row align-items-center mb-2">
                            <div class="col-auto"><label for="audit_approach_{{ $d->id }}" class="fw-semibold">Audit Approach:</label></div>
                            <div class="col-md-4">
                                <select {{ $canEdit ? '' : 'disabled' }} name="audit_approach" class="form-select">
                                    <option value="Substantive Testing" {{ optional($strategy)->audit_approach == 'Substantive Testing' ? 'selected' : '' }}>Substantive Testing</option>
                                    <option value="Risk-Based" {{ optional($strategy)->audit_approach == 'Risk-Based' ? 'selected' : '' }}>Risk-Based</option>
                                 <option value="Hybrid" {{ optional($strategy)->audit_approach == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                            </div>
                        </div>

                        {{-- Sampling Methodology --}}
                        <div class="row align-items-center mb-2">
                            <div class="col-auto"><label for="sampling_methodology_{{ $d->id }}" class="fw-semibold">Sampling Methodology:</label></div>
                            <div class="col-md-4">
                                <select {{ $canEdit ? '' : 'disabled' }} name="sampling_methodology" class="form-select">
                                   <option value="Random Selection" {{ optional($strategy)->sampling_methodology == 'Random Selection' ? 'selected' : '' }}>Random Selection</option>

                                    <option value="Systematic Selection" {{ optional($strategy)->sampling_methodology == 'Systematic Selection' ? 'selected' : '' }}>Systematic Selection</option>

                                    <option value="Monetary Unit Sampling" {{ optional($strategy)->sampling_methodology == 'Monetary Unit Sampling' ? 'selected' : '' }}>Monetary Unit Sampling</option>

                                    <option value="Haphazard Selection" {{ optional($strategy)->sampling_methodology == 'Haphazard Selection' ? 'selected' : '' }}>Haphazard Selection</option>

                                    <option value="Block Selection" {{ optional($strategy)->sampling_methodology == 'Block Selection' ? 'selected' : '' }}>Block Selection</option>
                                </select>
                            </div>
                        </div>

                        {{-- Audit Period --}}
                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="fw-semibold">Audit Started:</label>
                                <input {{ $canEdit ? '' : 'disabled' }} type="date" name="audit_started" value="{{ optional($strategy)->audit_started }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="fw-semibold">Audit Ended:</label>
                                <input {{ $canEdit ? '' : 'disabled' }} type="date" name="audit_ended" value="{{ optional($strategy)->audit_ended }}" class="form-control">
                            </div>
                        </div>

                        {{-- Textareas --}}
                        @foreach ([
                            'risk_affecting' => 'Risks Affecting the Audit Processes',
                            'risk_mitigation' => 'Risk Mitigation Approaches',
                            'inclusions_in_scope' => 'Inclusions in Scope',
                            'exclusions_in_scope' => 'Exclusions in Scope',
                            'persons_interviewed' => 'Persons Interviewed',
                            'documents_reviewed' => 'Documents Reviewed',
                            'processes_observed' => 'Processes Observed',
                            'artefacts_examined' => 'Artefacts Examined',
                            'requirements_status_compliance' => 'Requirements Status & Compliance'
                        ] as $field => $label)
                            <div class="row align-items-center mb-2">
                                <div class="col-auto"><label class="fw-semibold">{{ $label }}:</label></div>
                                <div class="col">
                                    <textarea {{ $canEdit ? '' : 'disabled' }} class="form-control" name="{{ $field }}" rows="2">{{ optional($strategy)->$field }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        {{-- Save Button --}}
                        @if($canEdit)
                                  <div class="text-end mt-2">
                            <button type="submit" class="btn btn-success btn-md">Save Changes</button>
                        </div>
                        @endif
                    </form>
                    {{-- End of the Full Form --}}

                    {{-- Optional: Select Fields for Reporting --}}
                    @if($strategy)
                        <a href="/select_internal_audit_fields_for_report/{{$strategy->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-outline-primary btn-sm mt-2">
                            Select Fields for Reporting
                        </a>
                    @endif

                </div>
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