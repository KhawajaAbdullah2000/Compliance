@extends('master')

@section('content')

@include('user-nav')

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
    

    <h4 class="mt-2">Impact Level Due to Loss of
        @if($risk_type=='risk_level')
        Data Confidentiality

        @if($serviceDetails->risk_confidentiality==10)
        <span style="background-color: red; border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @if($serviceDetails->risk_confidentiality==5)
        <span style="background-color: orange; border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @if($serviceDetails->risk_confidentiality==1)
        <span style="background-color: rgb(58, 235, 58); border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @endif

        @if($risk_type=='risk_integrity')
        Data Integrity

        @if($serviceDetails->risk_integrity==10)
        <span style="background-color: red; border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @if($serviceDetails->risk_integrity==5)
        <span style="background-color: orange; border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @if($serviceDetails->risk_integrity==1)
        <span style="background-color: rgb(58, 235, 58); border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @endif

        @if($risk_type=='risk_availability')
        Data Availability
        @if($serviceDetails->risk_availability==10)
        <span style="background-color: red; border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @if($serviceDetails->risk_availability==5)
        <span style="background-color: orange; border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif

        @if($serviceDetails->risk_availability==1)
        <span style="background-color: rgb(58, 235, 58); border-radius: 5px; width: 50px;
         height: 30px; display: inline-block; vertical-align: middle;"></span>
        @endif


        @endif



    </h4>

    {{-- <div class="row">
        <div class="col-md-6">

                <table class="table table-responsive table-bordered">
                    <tr>
                        <td colspan="4" class="table-primary text-center fw-bold">Risk Map of -  @if($risk_type=='risk_level')
                            Data Confidentiality

                            @elseif($risk_type=='risk_integrity')
                            Data Integrity

                            @elseif($risk_type=='risk_availability')
                            Data Availability

                            @endif </td>
                    </tr>
                    <tr>
                        <th>Adverse Business Impact</th>
                        <td colspan="3" class="text-center fw-bold" style="vertical-align: middle">Total Number of Risks: {{$totalCount}}</td>
                    </tr>


                    <tbody>
                        @foreach($data as $impactLevel => $counts)
                            <tr>
                                <td>{{ $impactLevel }}</td>
                                <td class="low" style="background-color: rgb(124, 251, 124)">
                             {{ $counts['low']['count'] }}

                                </td>
                                <td class="medium" style="background-color: orange">
                                    {{ $counts['medium']['count'] }}

                                </td>
                                <td class="high" style="background-color: rgb(222, 72, 72)">
                                    {{ $counts['high']['count'] }}

                                </td>
                            </tr>


                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="low">
                                {{ $overallRanges['low']['min'] ?? '-' }} - {{ $overallRanges['low']['max'] ?? '-' }}
                            </td>
                            <td class="medium">
                                {{ $overallRanges['medium']['min'] ?? '-' }} - {{ $overallRanges['medium']['max'] ?? '-' }}
                            </td>
                            <td class="high">
                                {{ $overallRanges['high']['min'] ?? '-' }} - {{ $overallRanges['high']['max'] ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3" class="fw-bold text-center">Likelihood of Exploit Range</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-center">
                    <a href="{{ route('risk_register_single_type', [
                        'service' => $service,
                        'component' => '_all',
                        'proj_id' => $project->project_id
                    ]) }}?group={{ $group }}&subgroup={{ $subgroup }}" class="btn btn-success btn-md">View or Download Risk Register</a>
                </div>


        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-6">
            <table class="table table-responsive table-bordered">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th rowspan="2" class="align-middle">Control Domain</th>
                            <th colspan="3">Likelihood of Exploit</th>
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
                            <td>{{$like->max_likelihood}}</td>
                            <td>{{$like->mean_likelihood}}</td>
                            <td>{{$like->min_likelihood}}</td>
                        </tr>
                      
                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td>{{ $max_total }}</td>
                            <td>{{ $count > 0 ? number_format($mean_total / $count, 2) : 0 }}</td>
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
                            <th colspan="3">Risk to 
                            @if($risk_type=='risk_level')
                             Data Confidentiality 
                             @endif

                                @if($risk_type=='risk_integrity')
                                Data Integrity
                                @endif
                
                                @if($risk_type=='risk_availability')
                                Data Availability
                                @endif</th>
                        </tr>
                        <tr>
                            <th>Max</th>
                            <th>Mean</th>
                            <th>Min</th>
                        </tr>
                    </thead>
                    <tbody class="table-secondary">
                        @foreach($results as $res)
                        <tr>
                            <td>{{$res->max_risk}}</td>
                            <td>{{$res->mean_risk}}</td>
                            <td>{{$res->min_risk}}</td>
                        </tr>
                        @endforeach

                    <tbody>



            </table>
        </div>
    </div>

</div>


@endsection