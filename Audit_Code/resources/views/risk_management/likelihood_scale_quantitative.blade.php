
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

                    <h4 class="mt-4">Consequences Scale</h4>
                                 <p class="fw-bold fs-5">Quantitative</p>

                    <div class="mt-4">
                    
                            <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md">Back
                            </a>
                    
            

                    </div>
        </div>

        <div class="col-md-8">
            <h4 class="fw-bold">Accept Likelihood Scale: Frequentist </h4>
            <p class="fs-5">(Frequency of an event occurring within a given timeframe)
                </p>

                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Approximate average frequency</th>
                            <th>Log expression</th>
                            <th>Scale value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Every hour</td>
                            <td>(approximately 10<sup>5</sup>)</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>Every 8 hours</td>
                            <td>(approximately 10<sup>4</sup>)</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Twice a week</td>
                            <td>(approximately 10<sup>3</sup>)</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Once a month</td>
                            <td>(approximately 10<sup>3</sup>)</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Once a year</td>
                            <td>(10<sup>1</sup>)</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>Once a decade</td>
                            <td>(10<sup>0</sup>)</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>

                <form action="" method="get">
                    @foreach ($projects as $proj)
                    <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">

                @endforeach
                <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">


                <button type="submit" class="btn btn-primary btn-lg">Save</button>

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

