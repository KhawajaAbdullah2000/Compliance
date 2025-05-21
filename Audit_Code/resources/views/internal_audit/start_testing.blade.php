
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


<div class="container">
    <form action="">
  <table class="table mt-2 table-bordered table-responsive table-bordered">
    <tr class="table-primary">
        <th>Select</th>
        <th>Paid PKR</th>
        <th>Invoice Date</th>
        <th>Invoice PKR</th>
        <th>Contract PKR</th>
    </tr>

    <tbody>
        <tr>
            <td><input type="checkbox" name="" id=""></td>
            <td>25000000</td>
             <td>10-Jan-2024</td>
             <td>50000000</td>
             <td>75000000</td>
        </tr>

         <tr>
            <td><input type="checkbox" name="" id=""></td>
            <td>45000000</td>
            <td>18-Aug-2023</td>
            <td>90000000</td>
            <td>135000000</td>
        </tr>

        
         <tr>
            <td><input type="checkbox" name="" id=""></td>
            <td>105000000</td>
            <td>20-Oct-2023</td>
            <td>210000000</td>
            <td>315000000</td>
        </tr>

            <tr>
             <td><input type="checkbox" name="" id=""></td>
            <td>50000000</td>
            <td>14-Oct-2024</td>
            <td>100000</td>
            <td>150000</td>
        </tr>

            <tr>
                <td><input type="checkbox" name="" id=""></td>
            <td>25000</td>
            <td>27-July-2023</td>
            <td>50000</td>
            <td>750000</td>
        </tr>

           <tr>
            <td><input type="checkbox" name="" id=""></td>
            <td>220000000</td>
            <td>12-Jan-2025</td>
            <td>220000000</td>
            <td>220000000</td>
        </tr>
    </tbody>

  </table>  
</form>

<div class="text-center">
    <a href="" class="btn btn-primary btn-md ">Trace Test</a>
     <a href="" class="btn btn-primary btn-md ">Recalculation Test</a>
      <a href="" class="btn btn-primary btn-md ">Trace Test</a>
        <a href="" class="btn btn-primary btn-md ">Confirmation Test</a>
          <a href="" class="btn btn-primary btn-md ">Trend Analysis</a>
            <a href="" class="btn btn-primary btn-md ">Data Analytics</a>
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