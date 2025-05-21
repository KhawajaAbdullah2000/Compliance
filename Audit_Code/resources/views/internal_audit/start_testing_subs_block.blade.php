
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
<h4 class="fw-bold mt-2 text-center text-primary">Risk Assessment for Internal Audit</h4>




<h5 style="text-decoration: underline;"><span class="fw-bold" >Sub-Organization:</span> {{$department->name}}</h5>
<h5><span class="fw-bold" >Available Unit or Activity or Function or Process:</span> {{$unit->name}}</h5>

{{-- <h5><span class="fw-bold mt-2" >Record:</span> {{$data_record->data_record_name}}</h5> --}}
<div class="text-end">
<a href="{{ route('attachments_data_record_risk_assessment', [
   'data_record_id'=>$data_record->id,
    'unit_id' => $unit->id,
    'proj_id' => $project->project_id,
    'user_id' => auth()->user()->id
]) }}" 
class="btn btn-md btn-secondary mb-2">
    Back
</a>
</div>
<div class="col-md-8">
    <table class="table table-responsive table-bordered">
        <tr>
            <td class="table-dark">Record</td>
            <td>{{$data_record->data_record_name}}</td>

            <td class="table-dark">Audit Approach</td>
            <td>{{$data_record->data_record_approach}}</td>

            <td class="table-dark">Sampling Methodology</td>
            <td>{{$data_record->data_record_sampling}}</td>
        </tr>
    </table>
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