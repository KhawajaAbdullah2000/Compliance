@extends('master')

@section('content')

@include('user-nav')

@php
function getColor($value) {
        if ($value >= 0 && $value < 0.3) return 'background-color: rgb(58, 235, 58);'; // Green
        if ($value >= 0.3 && $value < 0.7) return 'background-color: orange;'; // Orange
        if ($value >= 0.7) return 'background-color: rgb(243, 71, 71);'; // Red
        return '';
    }

    function getRiskColor($value) {
        if ($value >= 0 && $value < 3) return 'background-color: rgb(58, 235, 58);'; // Green
        if ($value >= 3 && $value < 7) return 'background-color: orange;'; // Orange
        if ($value >= 7) return 'background-color: rgb(243, 71, 71);'; // Red
        return '';
    }
@endphp

<div class="container my-2">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->user()->id }}">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Services:</td>
                        <td>{{$uniqueServicesCount }}</td>
                        <td class="fw-bold">No. of Asset Subgroups:</td>
                        <td>{{ $uniqueSubGroupsCount }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Asset Groups:</td>
                        <td>{{$uniqueGroupsCount }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $uniqueComponentsCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <div class="row">
        <div class="col-md-8">
            <h4 class="fw-bold">
                <span class="fw-bold text-primary">{{ $service }}</span>
                Risk Heatmap for:
                <span class="text-primary fw-bold">
                    @if($risk_type=='risk_level') Data Confidentiality @endif
                    @if($risk_type=='risk_integrity') Data Integrity @endif
                    @if($risk_type=='risk_availability') Data Availability @endif
                </span>
            </h4>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <a href="/assigned_projects/{{auth()->user()->id}}" class="btn btn-warning btn-md">Go back to Dashboard</a>
        </div>
    </div>
    

    <h4 class="mt-2">Adverse Consequence Level to the Service: 
        @if($risk_type=='risk_level')
    
        @if($serviceDetails->risk_confidentiality==10)
          <span class="fs-4 fw-bold">
           High(10)</span>
        @endif

        @if($serviceDetails->risk_confidentiality==5)
            <span class="fs-5 fw-bold">
           Medium(5)</span>
        @endif

        @if($serviceDetails->risk_confidentiality==1)
             <span class="fs-4 fw-bold">
           Low (1)</span>
        @endif

        @endif

        @if($risk_type=='risk_integrity')
       
        @if($serviceDetails->risk_integrity==10)
             <span class="fs-4 fw-bold">
                       High (10)
             </span>
        @endif

        @if($serviceDetails->risk_integrity==5)
            <span class="fs-4 fw-bold">
                    Medium (5)
             </span>
        @endif

        @if($serviceDetails->risk_integrity==1)
         <span class="fs-4 fw-bold">
                  Low (1)
             </span>
        @endif

        @endif

        @if($risk_type=='risk_availability')
   
        @if($serviceDetails->risk_availability==10)
               <span class="fs-4 fw-bold">
                      High (10)
             </span>
        @endif

        @if($serviceDetails->risk_availability==5)
             <span class="fs-4 fw-bold">
                      Medium (5)
             </span>
        @endif

        @if($serviceDetails->risk_availability==1)
       <span class="fs-4 fw-bold">
Low (1)</span>
        @endif


        @endif


    </h4>


    <div class="row">
        <div class="col-md-6">
            <table class="table table-responsive table-bordered">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2" class="align-middle">Control Domain</th>
                            <th colspan="3">Likelihood of Exploit (Threat x Vul )</th>
                        </tr>
                        <tr>
                            <th>Max</th>
                            <th>Mean</th>
                            <th>Min</th>
                        </tr>
                    </thead>
                    <tbody class="table-secondary">
                        @php
                            $max_total = 0;
                            $mean_total = 0;
                            $min_total = 0;
                            $count = count($likelihood_of_exploit); // To calculate mean average
                        @endphp
                        @foreach($likelihood_of_exploit as $like)
                        @php
                            $max_total += $like->max_likelihood;
                            $mean_total += $like->mean_likelihood;
                            $min_total += $like->min_likelihood;
                        @endphp
                        <tr>
                            <td>
                            @if($like->category=='5')
                            Organization
                            @endif

                            @if($like->category=='6')
                            People
                            @endif

                            @if($like->category=='7')
                            Physical
                            @endif

                            @if($like->category=='8')
                            Technological
                            @endif
                            </td>
                             <td >{{ number_format($like->max_likelihood,6) }}</td>
                            <td >{{ number_format($like->mean_likelihood,6) }}</td>
                            <td >{{ number_format($like->min_likelihood,6) }}</td>
                        </tr>
                      
                        @endforeach
                          <tr class="fw-bold table-dark">
                            <td>Total</td>
                            <td>{{ $max_total }}</td>
                            <td>{{ $mean_total }}</td>
                            <td>{{ $min_total }}</td>
                        </tr>

                    <tbody>



            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-responsive table-bordered">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            {{-- <th rowspan="2" class="align-middle">Control Domain</th> --}}
                            <th colspan="3">Risk ( Impact Level x Likelihood of Exploit)</th>
                        </tr>
                        <tr>
                            <th>Max</th>
                            <th>Mean</th>
                            <th>Min</th>
                        </tr>
                    </thead>
                    @php
                    $totalMax = 0;
                    $totalMean = 0;
                    $totalMin = 0;
                @endphp

                    <tbody class="table-secondary">
                        @foreach($results as $res)
                        @php
                        $totalMax += $res->max_risk;
                        $totalMean += $res->mean_risk;
                        $totalMin += $res->min_risk;
                    @endphp
                                    <tr>
                       <td >{{ number_format($res->max_risk, 6) }}</td>
            <td >{{ number_format($res->mean_risk, 6) }}</td>
            <td >{{ number_format($res->min_risk, 6) }}</td>
                        </tr>
                        @endforeach
                          <tr class="fw-bold table-dark">
        <td>Total: {{ $totalMax }}</td>
        <td>Total: {{ $totalMean }}</td>
        <td>Total: {{ $totalMin }}</td>
    </tr>

                    <tbody>



            </table>
        </div>
    </div>

</div>


@endsection