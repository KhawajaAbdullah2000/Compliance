
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
                    <li class="list-group-item d-flex align-items-center">
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
            <h4 class="fw-bold">Accept Consequences Scale: Qualitative </h4>
            <p class="fs-5">(Qualitative consequences of loss of data confidentiality, integrity or
                availability)
                </p>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Consequences</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>5 - Catastrophic</strong></td>
                            <td>
                                <strong>Sector or regulatory consequences beyond the organization</strong><br>
                                Substantially impacted sector ecosystem(s), with consequences that can be long lasting.<br><br>
                                And/or: difficulty for the State, and even an incapacity, to ensure a regulatory function or one of its missions of vital importance.<br><br>
                                And/or: critical consequences on the safety of persons and property (health crisis, major environmental pollution, destruction of essential infrastructures, etc.).
                            </td>
                        </tr>
                        <tr>
                            <td><strong>4 - Critical</strong></td>
                            <td>
                                <strong>Disastrous consequences for the organization</strong><br>
                                Incapacity for the organization to ensure all or a portion of its activity, with possible serious consequences on the safety of persons and property. The organization will most likely not overcome the situation (its survival is threatened), the activity sectors or state sectors in which it operates will likely be affected slightly, without any long-lasting consequences.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>3 - Serious</strong></td>
                            <td>
                                <strong>Substantial consequences for the organization</strong><br>
                                High degradation in the performance of the activity, with possible significant consequences on the safety of persons and property. The organization will overcome the situation with serious difficulties (operation in a highly degraded mode), without any sector or state impact.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>2 - Significant</strong></td>
                            <td>
                                <strong>Significant but limited consequences for the organization</strong><br>
                                Degradation in the performance of the activity with no consequences on the safety of persons and property. The organization will overcome the situation despite a few difficulties (operation in degraded mode).
                            </td>
                        </tr>
                        <tr>
                            <td><strong>1 - Minor</strong></td>
                            <td>
                                <strong>Negligible consequences for the organization</strong><br>
                                No consequences on operations or the performance of the activity or on the safety of persons and property. The organization will overcome the situation without too much difficulty (margins will be consumed).
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button class="btn btn-primary btn-lg">Accept</button>
                
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

