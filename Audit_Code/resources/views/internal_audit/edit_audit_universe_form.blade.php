
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



<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Auditable Unit
        </div>
        <div class="card-body">
            <form action="/submit_audit_universe_edit/{{$unit->id}}/{{$project->project_id}}/{{auth()->user()->id}}" method="POST">
                @csrf

                <input type="hidden" name="dept_id" value="{{$unit->dept_id}}">
                <input type="hidden" name="risk_based_plan_audit_id" value={{$unit->risk_based_plan_audit_id}}>

                <div class="mb-3">
                    <label class="form-label">Auditable Unit Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $unit->name }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Planned Start</label>
                        <input type="date" name="planned_start" class="form-control" value="{{ $unit->planned_start }}">
                    </div>
                    <div class="col-md-3">
                        <label>Planned End</label>
                        <input type="date" name="planned_end" class="form-control" value="{{ $unit->planned_end }}">
                    </div>
                    <div class="col-md-3">
                        <label>Actual Start</label>
                        <input type="date" name="actual_start" class="form-control" value="{{ $unit->actual_start }}">
                    </div>
                    <div class="col-md-3">
                        <label>Actual End</label>
                        <input type="date" name="actual_end" class="form-control" value="{{ $unit->actual_end }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Auditor</label>
                    <select name="auditor" class="form-select">
                        <option value="">Select Auditor</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $unit->auditor == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Approver</label>
                    <select name="approver" class="form-select">
                        <option value="">Select Approver</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $unit->approver == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
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