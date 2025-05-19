
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


<div class="text-end">

    <a href="{{ route('audit_universe', [
    'risk_based_plan_id' => $risk_based_plan_details->id,
    'proj_id' => $project->project_id,
    'user_id' => auth()->user()->id
]) }}" 
class="btn btn-md btn-secondary me-2 mb-2">
    Back
</a>
    
</div>



<div class="container mt-2">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Add Auditable Unit / Activity / Function / Process
        </div>
        <div class="card-body">
            <form action="/save_audit_universe/{{ $risk_based_plan_details->id }}/{{ $project->project_id }}/{{ auth()->user()->id }}" method="POST">
                @csrf

                <input type="hidden" name="dept_id" value="{{$risk_based_plan_details->department_id}}">

                {{-- Name of Auditable Unit --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Auditable Unit / Activity / Function / Process</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                {{-- Planned and Actual Dates --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Planned Start:</label>
                        <input type="date" name="planned_start" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Planned End:</label>
                        <input type="date" name="planned_end" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Actual Start:</label>
                        <input type="date" name="actual_start" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Actual End:</label>
                        <input type="date" name="actual_end" class="form-control">
                    </div>
                </div>

                {{-- Auditor --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Auditor:</label>
                    <select name="auditor" class="form-select">
                        <option value="">Select Auditor</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Approver --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Approver:</label>
                    <select name="approver" class="form-select">
                        <option value="">Select Approver</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Auditable Unit
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