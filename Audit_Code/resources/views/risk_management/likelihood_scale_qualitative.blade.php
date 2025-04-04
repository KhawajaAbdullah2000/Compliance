
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

            <h4 class="mt-4">Information Security Risk
                Management Framework selected:</h4>
                <p class="fw-bold fs-5">{{$framework_name}}</p>

                <div class="mt-2">

                </div>

                <h4 class="mt-4">Information Security Risk
           Management Approach selected:</h4>
                    <p class="fw-bold fs-5">{{$framework_approach}}</p>

                    <div class="mt-4">
                    
                            <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md">Back
                            </a>
                    
            

                    </div>
        </div>

        <div class="col-md-8">
            <h4 class="fw-bold">Accept Likelihood Scale: Probabilistic</h4>
            <p class="fs-5">(Probability of an event occurring within a given timeframe)
                </p>

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                      <tr>
                        <th>Likelihood</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>5 - Almost certain</strong></td>
                        <td>
                          The risk source will most certainly reach its objective by using one of the considered methods of attack.<br>
                          The likelihood of the risk scenario is very high.
                        </td>
                      </tr>
                      <tr>
                        <td><strong>4 - Very likely</strong></td>
                        <td>
                          The risk source will probably reach its objective by using one of the considered methods of attack.<br>
                          The likelihood of the risk scenario is high.
                        </td>
                      </tr>
                      <tr>
                        <td><strong>3 - Likely</strong></td>
                        <td>
                          The risk source is able to reach its objective by using one of the considered methods of attack.<br>
                          The likelihood of the risk scenario is significant.
                        </td>
                      </tr>
                      <tr>
                        <td><strong>2 - Rather unlikely</strong></td>
                        <td>
                          The risk source has relatively little chance of reaching its objective by using one of the considered methods of attack.<br>
                          The likelihood of the risk scenario is low.
                        </td>
                      </tr>
                      <tr>
                        <td><strong>1 - Unlikely</strong></td>
                        <td>
                          The risk source has very little chance of reaching its objective by using one of the considered methods of attack.<br>
                          The likelihood of the risk scenario is very low.
                        </td>
                      </tr>
                    </tbody>
                  </table>
             

                <form action="/qualitative_info_security_risk_criteria/{{auth()->user()->organization->id}}" method="get">
                    @foreach ($projects as $proj)
                    <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">

                @endforeach
                <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">


                <button type="submit" class="btn btn-primary btn-lg">Accept</button>

                </form>
                
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

