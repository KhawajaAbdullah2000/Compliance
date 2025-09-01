@extends('master')

@section('content')

@include('user-nav')

@php
$permissions = json_decode($project_permissions);
@endphp


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Risk Assessment for {{auth()->user()->organization->name}}</h3>


    
    <h4 class="">(Optional)Identify parties that can impact the organization’s information services and assets
</h4>


    @if (in_array('Data Inputter', $permissions))
    <a href="/new_party/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-success btn-md float-end mb-2" role="button">Enter a Party
        <i class="fas fa-plus"></i></a>
@endif


<table class=" mt-4 table table-bordered table-responsive table">
   <tr class="table-dark text-center">
        <th rowspan="2">Party Name</th>
        <th rowspan="2">Party Type</th>
        <th rowspan="2">Party Category</th>
        <th rowspan="2">Edit</th>
        <th rowspan="2">Delete</th>
    </tr>


    <tbody>
        @foreach ($party as $p)
        <tr>
            <td>{{$p->party_name}}</td>
            <td>{{$p->party_type}}</td>
            <td>{{$p->party_category}}</td>
            <td class="text-center">
     @if (in_array('Data Inputter', $permissions))
                  
        <a href="/edit_party/{{$p->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-success btn-md mb-2" role="button">
            <i class="fas fa-edit"></i></a>

            @else
                 <i class="fas fa-lock text-secondary"></i>

            @endif
            </td>

            <td class="text-center">
     @if (in_array('Data Inputter', $permissions))
                  
        <a href="/delete_party/{{$p->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-md mb-2" role="button">
            <i class="fas fa-trash"></i></a>

            @else
                 <i class="fas fa-lock text-secondary"></i>

            @endif
            </td>

       
           
        </tr>
            
        @endforeach
    </tbody>
</table>


<a href="/iso_sec_2_3_1_qual_event_scenarios/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md float-end mb-2">Save & Next</a>

{{-- <a href="/iso_sec_2_3_1_risk_selection_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-primary float-end mb-2">Go to Next</a> --}}

        
    




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
