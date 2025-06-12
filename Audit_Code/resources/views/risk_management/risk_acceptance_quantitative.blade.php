
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

                    <h4 class="mt-4">Consequences Scale</h4>
                                 <p class="fw-bold fs-5">Quantitative</p>

                                 <h4 class="mt-4">Likelihood Scale</h4>
                                 <p class="fw-bold fs-5">Frequentist</p>


                    <div class="mt-4">
                    
                            <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md">Back
                            </a>
                    
            

                    </div>
        </div>

        <div class="col-md-8">
            <h4 class="fw-bold">Accept Quantitative Risk Criteria </h4>
            <p class="fs-5">(Terms of reference against which the significance of a risk
                is evaluated)
                </p>

                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                      <tr class="table-secondary">
                        <th rowspan="2" class="align-middle">Likelihood<br><small>Scale Value</small></th>
                        <th colspan="6">Consequence</th>
                      </tr>
                      <tr>
                        <th>6</th>
                        <th>5</th>
                        <th>4</th>
                        <th>3</th>
                        <th>2</th>
                        <th>1</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Loop through Likelihood values from 6 to 1 -->
                      <!-- Each cell = row_value * column_value -->
                      <!-- Row 6 -->
                      <tr>
                        <th>6</th>
                        <td>36</td>
                        <td>30</td>
                        <td>24</td>
                        <td>18</td>
                        <td>12</td>
                        <td>6</td>
                      </tr>
                      <!-- Row 5 -->
                      <tr>
                        <th>5</th>
                        <td>30</td>
                        <td>25</td>
                        <td>20</td>
                        <td>15</td>
                        <td>10</td>
                        <td>5</td>
                      </tr>
                      <!-- Row 4 -->
                      <tr>
                        <th>4</th>
                        <td>24</td>
                        <td>20</td>
                        <td>16</td>
                        <td>12</td>
                        <td>8</td>
                        <td>4</td>
                      </tr>
                      <!-- Row 3 -->
                      <tr>
                        <th>3</th>
                        <td>18</td>
                        <td>15</td>
                        <td>12</td>
                        <td>9</td>
                        <td>6</td>
                        <td>3</td>
                      </tr>
                      <!-- Row 2 -->
                      <tr>
                        <th>2</th>
                        <td>12</td>
                        <td>10</td>
                        <td>8</td>
                        <td>6</td>
                        <td>4</td>
                        <td>2</td>
                      </tr>
                      <!-- Row 1 -->
                      <tr>
                        <th>1</th>
                        <td>6</td>
                        <td>5</td>
                        <td>4</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                  

                

                  <h4 class="fw-bold">Set up Quantitative Risk Criteria </h4>

                  <div class="col-md-6">

                <form action="/save_risk_acceptance_quantitative/{{auth()->user()->organization->id}}" method="post">
                    @csrf
                    <label for="" class="form-label">Select a threshold risk acceptance value from the list below</label>
                    <select name="risk_acceptance_quantitative" class="form-select">
                        @for ($i = 1; $i <= 36; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>

                     @foreach ($projects as $proj)
                    <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
                    @endforeach
                <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">


                <button type="submit" class="btn btn-primary btn-md mt-4">Save</button>


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

