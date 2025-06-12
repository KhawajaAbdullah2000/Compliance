
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
    
  
       <div class="row">
        <div class="col-md-4">
            <h5 class="fw-bold mb-3 mt-4">Project Types Selected</h5>
            
            <ul class="list-group shadow-sm rounded">
                @forelse ($projects as $proj)
                    <li class="list-group-item d-flex align-items-center bg-light">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        {{$proj->type}}
                    </li>
                @empty
                    <li class="list-group-item text-muted">No project types selected.</li>
                @endforelse
            </ul>

            <h4 class="mt-4">Risk Management selected:</h4>
                <p class="fw-bold fs-5">{{$framework_name}}</p>


                <div class="mt-2">

                </div>

                <h4 class="mt-4">Risk Management Approach selected:</h4>
                    <p class="fw-bold fs-5">{{$framework_approach}}</p>

                    <h4 class="mt-4">Likelihood Scale</h4>
                                 <p class="fw-bold fs-5">Probabilistic</p>

                                 
                <h4 class="mt-4">
                    Qualitative Risk Acceptance Criteria
                </h4>
                <p class="fw-bold fs-5">{{$risk_acceptance_criteria}}</p>

                    <div class="mt-4">
                    
                        <form action="/qualitative_info_security_risk_criteria/{{auth()->user()->org_id}}" method="get">
                            @foreach ($projects as $proj)
                            <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
                    
                        @endforeach
                        <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">
        
        
                        <button type="submit" class="btn btn-primary btn-lg">Back</button>
        
                        </form>
                    
            

                    </div>
        </div>

        <div class="col-md-8">
            <h4 class="fw-bold">Accept Qualitative Information Security Risk Criteria</h4>
         

            
                <div class="col-md-6">
           
                <form action="/risk_assessment_approach/{{auth()->user()->organization->id}}" method="POST">
                    @csrf

                    @foreach($global_risk_assessment_approaches as $g)
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="risk_assessment_approach" 
                            id="approach-{{ $g->global_risk_assessment_approach_id }}" 
                            value="{{ $g->global_risk_assessment_approach_id }}">
                            
                        <label class="form-check-label" for="approach-{{ $g->global_risk_assessment_approach_id }}">
                            {{ $g->global_assessment_approach }}
                        </label>
                    </div>
                @endforeach
                    @foreach ($projects as $proj)
                    <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
                @endforeach
                
                    <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">

                    <button type="submit" class="btn btn-primary mt-2 btm-md">Save</button>
                </form>
                         
            </div>
        </div>




    




       </div>
    
    
    
    
    
    
    </div>
</section>

@section('scripts')
@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}",
        icon: "error",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>

@endif


@endsection

@endsection

