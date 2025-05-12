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
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for {{auth()->user()->organization->name}}</h3>


    
    <h4 class="">Identify parties and the adverse impacts they can have on the organization’s information assets
</h4>


    @if (in_array('Data Inputter', $permissions))
    <a href="/new_party/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-success btn-md float-end mb-2" role="button">Enter a Party
        <i class="fas fa-plus"></i></a>
@endif


<table class=" mt-4 table table-bordered table-responsive table">
    <tr class="table-dark text-center">
        <th>Party Name</th>
        <th>Party Type</th>
        <th>Party Category</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Data Confidentiality</th>
        <th>Data Integrity</th>
        <th>Data Availability</th>
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

         <td class="text-center">       
        <a href="/strategic_scenarios/{{$p->id}}/risk_confidentiality/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-warning btn-md mb-2" role="button">
            <i class="fas fa-address-book"></i></a>         
            </td>

                 <td class="text-center">       
        <a href="/strategic_scenarios/{{$p->id}}/risk_integrity/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md mb-2" role="button">
            <i class="fas fa-address-book"></i></a>         
            </td>

                 <td class="text-center">       
        <a href="/strategic_scenarios/{{$p->id}}/risk_availability/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary btn-md mb-2" role="button">
            <i class="fas fa-address-book"></i></a>         
            </td>
           
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
