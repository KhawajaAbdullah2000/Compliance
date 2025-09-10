@extends('master')

@section('content')

@include('user-nav')

<h3 class="fw-bold text-center mt-4">Scanner Results for : {{auth()->user()->organization->name}}</h3>


<div class="container">
    <div class="text-end">
        <a href="/types_of_testing_list/{{auth()->user()->organization->id}}" class="btn btn-secondary btn-md">Back</a>
    </div>

    <h4 class="fw-bold mt-2 px-4 py-2">Select Tool</h4>

    @if($type_of_test=='vapt')
    <div class="col-lg-6 col-md-6">
 
      <div class="card qa-card overflow-hidden h-100">
        <div class="card-body p-4">
        

          <div class="d-grid gap-3">
            <a href="/nessus_results/{{ auth()->user()->id }}" class="btn btn-tile btn-proj-register">
              <span class="label">Nessus</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="#" class="btn btn-tile btn-services">
              <span class="label"> OWASP ZAP</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            

           
          </div>
        </div>
      </div>
    
    </div>

    @else
    <p class="fw-bold">To be Added</p>

    @endif





</div>

@endsection

@section('scripts')


@endsection
