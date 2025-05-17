
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

 
<h3 class="fw-bold text-center mt-4 mb-2">Reporting Framework</h3>

<h4>Organization: <span class="fw-bold"> {{$organization->name}} </span> </h4>
<h4>Sub Organization: <span class="fw-bold">{{$department->name}}</span> </h4>

<div class="col-md-6">
    <form method="POST" action="/select_fields_generate_report/{{$strategy->id}}/{{$project->project_id}}/{{auth()->user()->id}}">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <strong>Select Fields for Reporting</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;" class="text-center">
                              <input type="checkbox" id="selectAllToggle">
                            </th>
                            <th>Field</th>
                            <th>Current Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([
                            'audit_approach' => 'Audit Approach',
                            'sampling_methodology' => 'Sampling Methodology',
                            'risk_affecting' => 'Risks affecting the Audit Processes',
                            'risk_mitigation' => 'Risk Mitigation Approaches',
                            'audit_started' => 'Date Audit Started',
                            'audit_ended' => 'Date Audit Ended',
                            'inclusions_in_scope' => 'Specific inclusions in scope',
                            'exclusions_in_scope' => 'Specific exclusions from scope',
                            'persons_interviewed' => 'Persons interviewed',
                            'documents_reviewed' => 'Documents reviewed',
                            'processes_observed' => 'Processes observed',
                            'artefacts_examined' => 'Artefacts examined',
                            'requirements_status_compliance' => 'List of requirements and status of its compliance'
                        ] as $field => $label)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="fields[]" value="{{ $field }}" id="{{ $field }}">
                                </td>
                                <td>
                                    <label for="{{ $field }}" class="mb-0">{{ $label }}</label>
                                </td>
                                <td>
                                    {{ $strategy->$field ?? 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="/internal_audit_level_1/1/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </div>
    </form>
    </form>
</div>

  </div>
 




</div>

</div>




        @section('scripts')

        <script>
    document.getElementById('selectAllToggle').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="fields[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

@endsection


@endsection