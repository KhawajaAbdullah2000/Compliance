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

 
<h3 class="fw-bold">DAMA DMBOK Policy Enforcement</h3>

<div class="row h-100 w-50">
    
    <div class="row mt-2 mb-2">
     
     <a href="/dama_main_section/{{1}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> 1. Data Governance Framework</p></a>

    </div>

    <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{2}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> 2. Data Stewardship</p></a>
   
       </div>

       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{3}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> 3. Data Catalog and Metadata Management</p></a>
   
       </div>

       
       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{4}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> 4. Data Quality</p></a>
   
       </div>

       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{5}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> 5. Data Governance Communication and Training</p></a>
   
       </div>

       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{6}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">6. Data Governance Metrics and Reporting</p>
        </a>
   
       </div>

       
       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{7}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">7. Data Issue Resolution</p>
        </a>
   
       </div>

       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{8}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">8. Data Governance Tools and Technology</p>
        </a>
   
       </div>

       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{9}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">9. Data Governance Auditing and Compliance</p>
        </a>
   
       </div>

       
       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{10}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">10. Data Governance Financial Impact</p>
        </a>
   
       </div>

       <div class="row mt-2 mb-2">
     
        <a href="/dama_main_section/{{11}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">11. Data Security and Privacy</p>
        </a>
   
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
