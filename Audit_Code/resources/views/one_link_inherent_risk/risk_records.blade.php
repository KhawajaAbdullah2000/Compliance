
@extends('master')

@section('content')

@include('user-nav')


@php
$permissions = json_decode($project_permissions);
@endphp
<div class="container">

        <div class="row mt-5">
        <div class="col-lg-12">
         
            @include('components.one_link_topTable')
            
        </div>

    
   <div class="col-12 col-md-4 col-lg-3">
    <div class="p-3 text-white text-center rounded shadow"
         style="background: linear-gradient(135deg, #FF512F, #DD2476);">
        <h5 class="fw-bold mb-0">Risk Identification and Classification</h5>
    </div>
</div>

<div class="text-end mt-4">
     @if (in_array('Data Inputter', $permissions))
    <a class="btn btn-success btn-md float-end"
        href="/add_new_risk_record/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">Add Inherent Risk Record
        <i class="fas fa-plus"></i></a>
@endif
</div>



 @if($riskRecords->isEmpty())
        <div class="alert alert-info mt-2">No risk records found.</div>
    @else
        <div class="card shadow-md mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>S.NO</th>
                                <th>Risk Id</th>
                                <th>Date of Risk Identification</th>
                                <th>Date of Rosk ReAssessment</th>
                                <th>Department (SBU)</th>
                                <th>Unit</th>
                                <th>Product</th>
                                <th>Cycle</th>
                                <th>Sub-Process</th>
                                <th>Created By</th>
                                <th>Edit Attributes</th>
                                <th>Edit Table</th>
                                {{-- <th>Created At</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riskRecords as $index => $record)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>R-IPS-{{$record->risk_id}}</td>
                                    <td>{{$record->risk_identification_date}}</td>
                                      <td>{{$record->risk_reassessment_date}}</td>
                                    <td>{{ $record->department_name }}</td>
                                    <td>{{ $record->unit_name }}</td>
                                    <td>{{ $record->product_name }}</td>
                                    <td>{{ $record->cycle_name }}</td>
                                    <td>{{ $record->sub_process_name }}</td>
                               
                                    <td>{{ $record->created_by_name ?? 'N/A' }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d M Y, h:i A') }}</td> --}}
                                    <td>
                                       <a href="/edit_risk_record_attributes/{{$record->risk_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="text-primary me-2">
                                            <i class="fas fa-edit fa-2x"></i>
                                        </a>
                                    </td>

                                      <td>
                                       <a href="/edit_risk_record_initial/{{$record->risk_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="text-success me-2">
                                            <i class="fas fa-edit fa-2x"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
 



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