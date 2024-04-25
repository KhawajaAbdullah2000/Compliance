@extends('master')

@section('content')

    @include('user-nav')
    @include('iso_sec_nav')

    @php
        $permissions = json_decode($project_permissions);
        $setRiskData=0
    @endphp



    <div class="container">

        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Project Name:</td>
                            <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                            </a>
                            </td>
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


        <h3 class="fw-bold">Information Security Risk Treatment </h3>

        <p >

            Asset Service Name: {{$assetData->s_name}}
            <br>

            @isset($assetData->g_name)
                Asset Group Name: {{ $assetData->g_name }}
            @endisset

            @isset($assetData->name)
                <br>
                Asset Name: {{ $assetData->name }}
            @endisset

            @isset($assetData->c_name)
                <br>
                Asset Component Name: {{ $assetData->c_name }}
            @endisset




        </p>


        <h2 class="text-center fw-bold">Risk Level before Risk Treatment</h2>

        @if (isset($check))
            <div class="mt-4">
                <table class="table table-responsive table-primary table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Control Number</th>
                            <th>Title Of Control</th>
                            <th>Description of Control</th>
                            <th>Control is Applicable</th>
                            <th>Control Compliance</th>
                            <th>Vulnerability</th>
                            <th>threat</th>
                            <th>Risk Level</th>
                            <th>Risk Treatment</th>


                        </tr>
                    </thead>
                    <tbody>

                        @for ($i = 0; $i < count($sec2_4_a5_rows); $i++)
                            <tr style="vertical-align: middle;text-align:initial">

                                @foreach ($sec2_4_a5_rows[$i] as $col)
                                    @if (in_array(strval($sec2_4_a5_rows[$i][0]), $controls, true))
                                        @if (isset($col))
                                            <td>

                                                <p>{!! nl2br($col) !!}</p>
                                            </td>
                                        @endif
                                    @endif

                                @endforeach


                                @foreach ($assetDataForFive as $a5)
                                    @if($a5->control_num===strval($sec2_4_a5_rows[$i][0]))
                                    <td>{{$a5->applicability}}</td>
                                    <td>{{$a5->control_compliance}}%</td>
                                    <td>{{$a5->vulnerability}}%</td>
                                    <td>{{$a5->threat}}%</td>
                                    <td>{{$a5->risk_level}}</td>

                                    @break
                                    @endif


                                @endforeach







                                @if (in_array(strval($sec2_4_a5_rows[$i][0]), $controls, true))
                                    <td>
                                        @if (in_array('Data Inputter', $permissions))
                                            <a href="/iso_sec_2_3_2_risk_treat_form/{{ $sec2_4_a5_rows[$i][0] }}/{{ $assetData->assessment_id }}/{{ $project_id }}/{{ auth()->user()->id }}"
                                                class="btn my_bg_color text-white">Risk Treatment </a>
                                        @else
                                            <p>Not allowed</p>
                                        @endif
                                    </td>
                                @endif



                            </tr>
                        @endfor

                        @for ($i = 0; $i < count($sec2_4_a6_rows); $i++)
                            <tr style="vertical-align: middle;text-align:initial">

                                @foreach ($sec2_4_a6_rows[$i] as $col)
                                    @if (in_array(strval($sec2_4_a6_rows[$i][0]), $controls, true))
                                        @if (isset($col))
                                            <td>
                                                <p>{!! nl2br($col) !!}</p>
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                                @foreach ($assetDataForFive as $a5)
                                @if($a5->control_num===strval($sec2_4_a6_rows[$i][0]))
                                <td>{{$a5->applicability}}</td>
                                <td>{{$a5->control_compliance}}%</td>
                                <td>{{$a5->vulnerability}}%</td>
                                <td>{{$a5->threat}}%</td>
                                <td>{{$a5->risk_level}}</td>
                                @break
                                @endif


                            @endforeach



                                @if (in_array(strval($sec2_4_a6_rows[$i][0]), $controls, true))
                                    <td>
                                        @if (in_array('Data Inputter', $permissions))
                                            <a href="/iso_sec_2_3_2_risk_treat_form/{{ $sec2_4_a6_rows[$i][0] }}/{{ $assetData->assessment_id }}/{{ $project_id }}/{{ auth()->user()->id }}"
                                                class="btn my_bg_color text-white">Risk Treatment </a>
                                        @else
                                            <p>Not allowed</p>
                                        @endif
                                    </td>
                                @endif



                            </tr>
                        @endfor



                        @for ($i = 0; $i < count($sec2_4_a7_rows); $i++)
                            <tr style="vertical-align: middle;text-align:initial">

                                @foreach ($sec2_4_a7_rows[$i] as $col)
                                    @if (in_array(strval($sec2_4_a7_rows[$i][0]), $controls, true))
                                        @if (isset($col))
                                            <td>
                                                <p>{!! nl2br($col) !!}</p>
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                                @foreach ($assetDataForFive as $a5)
                                @if($a5->control_num===strval($sec2_4_a7_rows[$i][0]))
                                <td>{{$a5->applicability}}</td>
                                <td>{{$a5->control_compliance}}%</td>
                                <td>{{$a5->vulnerability}}%</td>
                                <td>{{$a5->threat}}%</td>
                                <td>{{$a5->risk_level}}</td>
                                @break
                                @endif


                            @endforeach



                                @if (in_array(strval($sec2_4_a7_rows[$i][0]), $controls, true))
                                    <td>
                                        @if (in_array('Data Inputter', $permissions))
                                            <a href="/iso_sec_2_3_2_risk_treat_form/{{ $sec2_4_a7_rows[$i][0] }}/{{ $assetData->assessment_id }}/{{ $project_id }}/{{ auth()->user()->id }}"
                                                class="btn my_bg_color text-white">Risk Treatment </a>
                                        @else
                                            <p>Not allowed</p>
                                        @endif
                                    </td>
                                @endif



                            </tr>
                        @endfor


                        @for ($i = 0; $i < count($sec2_4_a8_rows); $i++)
                            <tr style="vertical-align: middle;text-align:initial">

                                @foreach ($sec2_4_a8_rows[$i] as $col)
                                    @if (in_array(strval($sec2_4_a8_rows[$i][0]), $controls, true))
                                        @if (isset($col))
                                            <td>
                                                <p>{!! nl2br($col) !!}</p>
                                            </td>
                                        @endif
                                    @endif
                                @endforeach

                                @foreach ($assetDataForFive as $a5)
                                @if($a5->control_num===strval($sec2_4_a8_rows[$i][0]))
                                <td>{{$a5->applicability}}</td>
                                <td>{{$a5->control_compliance}}%</td>
                                <td>{{$a5->vulnerability}}%</td>
                                <td>{{$a5->threat}}%</td>
                                <td>{{$a5->risk_level}}</td>
                                @break
                                @endif


                            @endforeach



                                @if (in_array(strval($sec2_4_a8_rows[$i][0]), $controls, true))
                                    <td>
                                        @if (in_array('Data Inputter', $permissions))
                                            <a href="/iso_sec_2_3_2_risk_treat_form/{{ $sec2_4_a8_rows[$i][0] }}/{{ $assetData->assessment_id }}/{{ $project_id }}/{{ auth()->user()->id }}"
                                                class="btn my_bg_color text-white">Risk Treatment </a>
                                        @else
                                            <p>Not allowed</p>
                                        @endif
                                    </td>
                                @endif



                            </tr>
                        @endfor





                    </tbody>





            </div>
        @else
            <h2>Please conduct a risk assessment before a risk treatment can be initiated</h2>
        @endif
    </div>



@section('scripts')
    @if (Session::has('success'))
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
