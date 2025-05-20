
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
<h4 class="fw-bold mt-2 text-center text-primary">Risk Based Audit Plan</h4>

<h4 class="fw-bold text-center text-danger">Audit Universe</h4>


<h5 style="text-decoration: underline;"><span class="fw-bold" >Sub-Organization:</span> {{$department->name}}</h5>
<h5><span class="fw-bold" >Available Unit or Activity or Function or Process:</span> {{$unit->name}}</h5>


<div class="text-end">
<a href="{{ route('data_records', [
    'unit_id' => $unit->id,
    'proj_id' => $project->project_id,
    'user_id' => auth()->user()->id
]) }}" 
class="btn btn-md btn-secondary mb-2">
    Back
</a>
</div>

<div class="container mt-2">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Add Data Record
        </div>
        <div class="card-body">
           <form action="/update_data_record/{{ $data_record->id }}/{{ $unit->id }}/{{ $project->project_id }}/{{ auth()->user()->id }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label fw-semibold">Data Record</label>
        <input type="text" name="data_record_name" class="form-control" value="{{ $data_record->data_record_name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Audit Approach</label>
        <select name="data_record_approach" class="form-select">
            <option value="Substantive Testing" {{ $data_record->data_record_approach == 'Substantive Testing' ? 'selected' : '' }}>Substantive Testing</option>
            <option value="Risk-Based" {{ $data_record->data_record_approach == 'Risk-Based' ? 'selected' : '' }}>Risk-Based</option>
            <option value="Hybrid" {{ $data_record->data_record_approach == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Sampling Methodology</label>
        <select name="data_record_sampling" class="form-select">
            <option value="Random Selection" {{ $data_record->data_record_sampling == 'Random Selection' ? 'selected' : '' }}>Random Selection</option>
            <option value="Systematic Selection" {{ $data_record->data_record_sampling == 'Systematic Selection' ? 'selected' : '' }}>Systematic Selection</option>
            <option value="Monetary Unit Sampling" {{ $data_record->data_record_sampling == 'Monetary Unit Sampling' ? 'selected' : '' }}>Monetary Unit Sampling</option>
            <option value="Haphazard Selection" {{ $data_record->data_record_sampling == 'Haphazard Selection' ? 'selected' : '' }}>Haphazard Selection</option>
            <option value="Block Selection" {{ $data_record->data_record_sampling == 'Block Selection' ? 'selected' : '' }}>Block Selection</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> Update Data Record
    </button>
</form>

        </div>
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