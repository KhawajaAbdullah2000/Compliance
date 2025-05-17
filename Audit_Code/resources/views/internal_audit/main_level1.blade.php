
@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


@php
$permissions = json_decode($project_permissions);
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

        
         <div class=" my-2">

    <div class="row mt-5">
        <div class="col-lg-12">
         
            @include('components.topTable')
            
        </div>
    </div>
   </div>

<h3 class="fw-bold mt-4">Audit Strategy</h3>
 




</div>

</div>






        @section('scripts')


        @endsection


@endsection