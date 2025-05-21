
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

<h5><span class="fw-bold mt-2" >Record:</span> {{$data_record->data_record_name}}</h5>

<div class="text-end">
<a href="{{ route('data_records_risk_assessment', [
    'unit_id' => $unit->id,
    'proj_id' => $project->project_id,
    'user_id' => auth()->user()->id
]) }}" 
class="btn btn-md btn-secondary mb-2">
    Back
</a>
</div>

<div class="container">
    @if ($attachments->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header bg-primary text-white fw-bold">
            Attached Files
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>File Name</th>
                        <th>Download</th>
                        <th>Uploaded On</th>
              
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attachments as $index => $file)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ basename($file->attachment) }}</td>
                            <td>
                                <a href="{{ asset($file->attachment) }}" class="btn btn-sm btn-outline-success" download>
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($file->last_edited_at)->format('Y-m-d H:i') }}</td>
                       
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
    @else
    <p class="fw-bold">No Record Available</p>
@endif


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