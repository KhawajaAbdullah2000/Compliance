
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

<h4 class="fw-bold text-center text-danger">Audit Universe</h4>


<h5 style="text-decoration: underline;"><span class="fw-bold" >Sub-Organization:</span> {{$department->name}}</h5>



<a href="{{ route('internal_audit_level_1', [
    'level_num' => 3,
    'proj_id' => $project->project_id,
    'user_id' => auth()->user()->id
]) }}" 
class="btn btn-md btn-secondary float-end me-2 mb-2">
    Back
</a>

  <table class="table table-responsive table-bordered">
                <thead class="table-secondary">
            <tr>
                <th>Auditable unit or activity or function or process</th>
                <th>Planned Start</th>
                <th>Planned End</th>
                <th>Actual Start</th>
                <th>Actual End</th>
                <th>Auditor</th>
                <th>Approver</th>
                <th>Conduct Compliance</th>
                

               </tr>        
                </thead>
                 <tbody>
                        @foreach ($auditUniverseList as $unit)
                            <tr>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->planned_start ?? 'N/A' }}</td>
                                <td>{{ $unit->planned_end ?? 'N/A' }}</td>
                                <td>{{ $unit->actual_start ?? 'N/A' }}</td>
                                <td>{{ $unit->actual_end ?? 'N/A' }}</td>
                                <td>{{ $unit->auditor_name ?? 'N/A' }}</td>
                                <td>{{ $unit->approver_name ?? 'N/A' }}</td>
                                <td class="text-center">
                       
                        <a href="/data_records_risk_assessment/{{$unit->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-sm btn-success">
                          <i class="fa fa-search fa-lg"></i>
                      </a>
                

                        </td>



                  
                                
                            </tr>
                        @endforeach
                    </tbody>
            </table>





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