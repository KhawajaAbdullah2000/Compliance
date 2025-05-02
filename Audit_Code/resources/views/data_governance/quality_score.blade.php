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

    <h4 class="fw-bold">Data Quality Score for Dataset ID/Name : {{$data_catalog->name}} </h4>
 

         @if($datasets->isNotEmpty())
    <h5 class="mt-4">Datasets (Total: {{ $datasets->count() }})</h5>

  
@else
    <div class="alert alert-warning">No datasets found.</div>
@endif

<div class="col-md-6 mt-4">
    <table class='table table-bordered table-responsive'>

        <tr class="table-dark">
            <th>Quality Attribute</th>
            <th>Score</th>
        </tr>
    
        <tbody>
            <tr>
                <td>Completeness</td>
                <td>{{$completeness}}</td>
            </tr>
            <tr>
                <td>Accuracy Score</td>
                <td></td>
            </tr>
            <tr>
                <td>Timeliness Score</td>
                <td></td>
            </tr>

            <tr>
                <td>Uniqueness Score</td>
                <td></td>
            </tr>

            <tr>
                <td>Validity Score</td>
                <td></td>
            </tr>

            <tr>
                <td>Consistency across systems Score</td>
                <td></td>
            </tr>

            <tr>
                <td>Aggregate Score</td>
                <td></td>
            </tr>
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif




@endsection

@endsection
