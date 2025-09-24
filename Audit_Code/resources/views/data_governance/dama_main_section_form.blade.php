@extends('master')

@section('content')

@include('user-nav')


@php
$permissions = json_decode($project_permissions);

// User can edit data if they have "Data Inputter"
$isEditable = in_array('Data Inputter', $permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

 
<h3 class="fw-bold">DAMA DMBOK Policy Enforcement</h3>


<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0" style="background-color: #007BFF; color: white; padding: 0.5rem; border-radius: 4px; display: inline-block;">
        {{$policyDetails[0][0]}}. {{$policyDetails[0][1]}}
    </h5>
    <a href="{{ route('dama_main_policies',[
    'proj_id'=>$project->project_id,
    'user_id'=>auth()->user()->id]) }}" class="btn btn-secondary btn-md">← Back</a>
</div>
  
<p class="fw-bold fs-5">Category Description: </p>
<p>
    {{$policyDetails[0][2]}}
</p>

<p class="fw-bold fs-5">Objectives: </p>
<p>
    {!! nl2br($policyDetails[0][3]) !!}
</p>

<table class="table table-bordered align-middle">
    <thead class="table-secondary">
        <tr>
            <th style="width: 50%">KPI</th>
            <th style="width: 10%">Actual Measured Value</th>
            <th style="width: 5%">Actual Measurement Date</th>
            <th style="width: 10%">Target Value</th>
            <th style="width: 5%">Target Date</th>
            <th style="width: 15%">Responsible</th>
            <th style="width: 5%">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($policyDetails as $index => $row)
            @php
                $existing = $savedData[$index+1] ?? null;
            @endphp
            <tr>
                <form method="POST" action="/dama_kpi_submit/{{$project->project_id}}/{{auth()->user()->id}}">
                    @csrf
                    <td>{{ $row[4] }}</td>
        
                    <td>
                        <input type="number" name="measured_value" class="form-control"
                            value="{{ old('measured_value', $existing->measured_value ?? '') }}">
                        <input type="hidden" name="policy_num" value="{{ $policy_num }}">
                        <input type="hidden" name="kpi_num" value="{{ $index+1 }}">
                    </td>
        
                    <td>
                        <input type="date" name="measurement_date" class="form-control"
                            value="{{ old('measurement_date', isset($existing->measurement_date) ? \Carbon\Carbon::parse($existing->measurement_date)->format('Y-m-d') : '') }}">
                    </td>
        
                    <td>
                        <input type="number" name="target_value" class="form-control"
                            value="{{ old('target_value', $existing->target_value ?? '') }}">
                    </td>
        
                    <td>
                        <input type="date" name="target_date" class="form-control"
                            value="{{ old('target_date', isset($existing->target_date) ? \Carbon\Carbon::parse($existing->target_date)->format('Y-m-d') : '') }}">
                    </td>
        
                    <td>
                        <select class="form-select" name="responsibility">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ (old('responsibility', $existing->responsible ?? '') == $user->id) ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
        
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </td>
                </form>
            </tr>
        @endforeach
        </tbody>
</table>





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
