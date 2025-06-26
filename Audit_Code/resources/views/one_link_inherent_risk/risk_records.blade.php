
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
        <h5 class="fw-bold mb-0">Inherent Risk Assessment</h5>
    </div>
</div>

<div class="text-end mt-4">
     @if (in_array('Data Inputter', $permissions))
    <a class="btn btn-success btn-md float-end"
        href="/add_new_risk_record/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">Add Inherent Risk Record
        <i class="fas fa-plus"></i></a>
@endif
</div>

<table class="table table-responsive table-striped table-bordered mt-2">
    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Risk ID</th>
            <th>Date of Risk Identification</th>
            <th>Function (Unit)</th>
            <th>Product</th>
            <th>Cycle / Process Reference</th>
            <th>Sub-Process Name</th>
            <th>Edit Attributes</th>
            <th>Gross Risk Assessment</th>
            <th>Delete</th>
        </tr>
    </thead>
</table>

 



</div>









        @section('scripts')


        @endsection


@endsection