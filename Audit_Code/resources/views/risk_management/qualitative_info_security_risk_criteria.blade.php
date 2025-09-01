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

                <div class="mt-4">

                    <form action="/qualititave_likelihood_scale/{{auth()->user()->org_id}}" method="get">
                        @foreach ($projects as $proj)
                        <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
                        <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">

                        @endforeach

                        <button type="submit" class="btn btn-primary btn-lg">Back</button>

                    </form>



                </div>
            </div>

            <div class="col-md-8">
                <h4 class="fw-bold">Accept Qualitative Information Security Risk Criteria</h4>
                <p class="fs-5">(Terms of reference against which the significance of a risk
                    will be evaluated)
                </p>

                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle">Likelihood</th>
                            <th colspan="5">Consequence</th>
                        </tr>
                        <tr>
                            <th>Catastrophic</th>
                            <th>Critical</th>
                            <th>Serious</th>
                            <th>Significant</th>
                            <th>Minor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Almost certain</th>
                            <td>Very high</td>
                            <td>Very high</td>
                            <td>High</td>
                            <td>High</td>
                            <td>Medium</td>
                        </tr>
                        <tr>
                            <th>Very likely</th>
                            <td>Very high</td>
                            <td>High</td>
                            <td>High</td>
                            <td>Medium</td>
                            <td>Low</td>
                        </tr>
                        <tr>
                            <th>Likely</th>
                            <td>High</td>
                            <td>High</td>
                            <td>Medium</td>
                            <td>Low</td>
                            <td>Low</td>
                        </tr>
                        <tr>
                            <th>Rather unlikely</th>
                            <td>Medium</td>
                            <td>Medium</td>
                            <td>Low</td>
                            <td>Low</td>
                            <td>Very low</td>
                        </tr>
                        <tr>
                            <th>Unlikely</th>
                            <td>Low</td>
                            <td>Low</td>
                            <td>Low</td>
                            <td>Very low</td>
                            <td>Very low</td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="fw-bold mt-4">Set Up Qualitative Risk Acceptance Criteria</h4>
                <p class="fs-5">(Select a threshold risk acceptance value from the list below)
                </p>
                <div class="col-md-6">

                    <form action="/qualitative_risk_acceptance_criteria/{{auth()->user()->organization->id}}" method="POST">
                        @csrf
                        <select class="form-control" name="risk_acceptance_criteria">

                            <option value="Very Low" @selected(optional($qualitative_risk_acceptance_criteria)->criteria_selected == 'Very Low')>Very Low</option>
                            <option value="Low" @selected(optional($qualitative_risk_acceptance_criteria)->criteria_selected == 'Low')>Low</option>
                            <option value="Medium" @selected(optional($qualitative_risk_acceptance_criteria)->criteria_selected == 'Medium')>Medium</option>
                            <option value="High" @selected(optional($qualitative_risk_acceptance_criteria)->criteria_selected == 'High')>High</option>
                            <option value="Very High" @selected(optional($qualitative_risk_acceptance_criteria)->criteria_selected == 'Very High')>Very High</option>


                        </select>
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
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>

@endif


@endsection

@endsection
