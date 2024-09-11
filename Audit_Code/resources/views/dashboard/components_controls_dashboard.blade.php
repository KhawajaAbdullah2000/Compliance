@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h2>Service Name: {{$s_name}}</h2>

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td><a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}">{{$project->project_name}}</a></td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


        @if($results->count() > 0)

        <div class="row mt-4">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">Asset Component</th>
                            <th rowspan="2">Risk Category</th>
                            <th colspan="4">ISO 27001-Annex A Control group</th>
                            <th rowspan="2">All</th>
                        </tr>
                        <tr>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Group the results by component name (c_name)
                            $groupedResults = $results->groupBy('c_name');
                        @endphp

                        @foreach ($groupedResults as $componentName => $componentResults)
                            @php
                                // Initialize arrays to hold the counts for each control number and risk category for this component
                                $riskCategories = ['Low', 'Medium', 'High'];
                                $controlCounts = [
                                    'Low' => ['5' => 0, '6' => 0, '7' => 0, '8' => 0],
                                    'Medium' => ['5' => 0, '6' => 0, '7' => 0, '8' => 0],
                                    'High' => ['5' => 0, '6' => 0, '7' => 0, '8' => 0],
                                ];

                                // Populate the controlCounts array from the componentResults collection
                                foreach ($componentResults as $result) {
                                    $controlCounts[$result->risk_category][$result->control_number_start] = $result->total_controls;
                                }
                            @endphp

                            @foreach ($riskCategories as $category)
                            @php
                                // Calculate the total controls for the current risk category by summing up the values for control numbers 5, 6, 7, and 8
                                $totalControls = $controlCounts[$category]['5'] + $controlCounts[$category]['6'] + $controlCounts[$category]['7'] + $controlCounts[$category]['8'];
                            @endphp
                            <tr>
                                @if ($loop->first)
                                    <td rowspan="3">{{ $componentName }}</td>
                                @endif
                                <td>{{ $category }}</td>
                                <td>{{ $controlCounts[$category]['5'] }}</td>
                                <td>{{ $controlCounts[$category]['6'] }}</td>
                                <td>{{ $controlCounts[$category]['7'] }}</td>
                                <td>{{ $controlCounts[$category]['8'] }}</td>
                                <td>{{ $totalControls }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>



        @else
            <h2 class="fw-bold">No Risk Assessment added yet</h2>
        @endif


</div>

@endsection
