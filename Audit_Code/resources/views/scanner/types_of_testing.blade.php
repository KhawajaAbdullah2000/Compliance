@extends('master')

@section('content')

@include('user-nav')

<h3 class="fw-bold text-center mt-4">Scanner Results for : {{auth()->user()->organization->name}}</h3>


<div class="container">
    <div class="text-end">
        <a href="/user_home" class="btn btn-secondary btn-md">Back</a>
    </div>

    <h4 class="fw-bold mt-2 px-4 py-2">Select type of Testing</h4>

    <div class="col-lg-6 col-md-6">
 
      <div class="card qa-card overflow-hidden h-100">
        <div class="card-body p-4">
        

          <div class="d-grid gap-3">
            <a href="/select_tools/{{ auth()->user()->id }}/vapt" class="btn btn-tile btn-proj-register">
              <span class="label"><i class="bi bi-kanban"></i> VAPT</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/select_tools/{{ auth()->user()->organization->id }}/source_code" class="btn btn-tile btn-services">
              <span class="label"><i class="bi bi-download"></i> Source Code Testing</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/select_tools/{{ auth()->user()->organization->id }}/network_discovery" class="btn btn-tile btn-docs">
              <span class="label"><i class="bi bi-router"></i> Network Discovery</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/select_tools/{{ auth()->user()->organization->id }}/other_tests" class="btn btn-tile btn-comp-register">
              <span class="label"><i class="bi bi-reception-3"></i> Other Tests</span>
              <i class="bi bi-arrow-right"></i>
            </a>

           
          </div>
        </div>
      </div>
    
    </div>





</div>

@endsection

@section('scripts')


@endsection
