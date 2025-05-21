
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



@if (in_array('Data Inputter', $permissions))
    <a class="btn btn-success btn-md float-end me-2 mb-2"
       href="/add_new_data_record_form/{{$unit->id}}/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">
 Add new Record
 <i class="fas fa-plus"></i>
    </a>
@endif

<a href="{{ route('audit_universe', [
    'risk_based_plan_id' => $unit->risk_based_plan_audit_id,
    'proj_id' => $project->project_id,
    'user_id' => auth()->user()->id
]) }}" 
class="btn btn-md btn-secondary float-end me-2 mb-2">
    Back
</a>

  <table class="table table-responsive table-bordered">
                <thead class="table-dark">
            <tr>
                <th>Record</th>
                <th>Audit Approach</th>
                <th>Sampling Methodology</th>
                <th>Enter data</th>
        
                <th>Edit</th>
                <th>Delete</th>
             

               </tr>        
                </thead>
                 <tbody>
                    @foreach ($data_records as $d )
                    <tr>
                    <td>{{$d->data_record_name}}</td>
                    <td>{{$d->data_record_approach}}</td>
                    <td>{{$d->data_record_sampling}}</td>
                    <td class="text-center">
                         <a href="/attachments_data_record/{{$d->id}}/{{$unit->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-success">
                          <i class="fa fa-file"></i> 
                      </a>
                    </td>

                <td class="text-center">
                         @if (in_array('Data Inputter', $permissions))
                        <a href="/edit_data_record/{{$d->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-warning">
                          <i class="fa fa-edit"></i> Edit
                      </a>
                      @else
                       <i class="fas fa-lock text-secondary"></i>
                       @endif

                        </td>

              <td class="text-center">
                         @if (in_array('Data Inputter', $permissions))
                        <a href="/delete_data_record/{{$d->id}}/{{$unit->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-sm btn-danger">
                          <i class="fas fa-trash"></i> Delete
                      </a>
                      @else
                       <i class="fas fa-lock text-secondary"></i>
                       @endif

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