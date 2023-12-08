@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);


@endphp



<div class="container">


    <h3 class="text-center">Risk Treatment </h3>

    <p class="text-center fw-bold">

        Assetid: {{$assetData->assessment_id}}

        @isset($assetData->g_name)
        <br>
        Asset Group Name: {{$assetData->g_name}}
        @endisset

        @isset($assetData->name)
        <br>
        Asset Name: {{$assetData->name}}
        @endisset

        @isset($assetData->c_name)
        <br>
        Asset Component Name: {{$assetData->c_name}}
        @endisset





    </p>



@if(isset($check))


    <div class="mt-4">
        <table class="table table-responsive table-primary table-striped">
            <thead class="thead-dark">
              <tr>
                <th>Control Number</th>
                <th>Title Of Control</th>
                <th>Description of Control</th>
                <th>Risk Treatment</th>

              </tr>
            </thead>
            <tbody>

        @for ($i = 0; $i < count($sec2_4_a6_rows); $i++)
                    <tr style="vertical-align: middle;text-align:initial">

                        @foreach ($sec2_4_a5_rows[$i] as $col)


                                                @if(in_array( strval($sec2_4_a5_rows[$i][0]) ,$controls,true ))

                                                        @if(isset($col))
                                                                <td>
                                                                    <p>{!! nl2br($col) !!}</p>
                                                                </td>


                                                        @endif




                                                @endif





                         @endforeach




                         @if(in_array( strval($sec2_4_a5_rows[$i][0]) ,$controls,true ))


                         <td>
                            @if(in_array('Data Inputter',$permissions))
                            <a href="/iso_sec_2_3_2_risk_treat_form/{{$sec2_4_a5_rows[$i][0]}}/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                                 class="btn btn-warning">Risk Treatment </a>
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


                                @if(in_array( strval($sec2_4_a6_rows[$i][0]) ,$controls,true ))

                                        @if(isset($col))
                                                <td>
                                                    <p>{!! nl2br($col) !!}</p>
                                                </td>


                                        @endif




                                @endif





         @endforeach




         @if(in_array( strval($sec2_4_a6_rows[$i][0]) ,$controls,true ))


         <td>
            @if(in_array('Data Inputter',$permissions))
            <a href="/iso_sec_2_3_2_risk_treat_form/{{$sec2_4_a6_rows[$i][0]}}/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                 class="btn btn-warning">Risk Treatment </a>
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


                                @if(in_array( strval($sec2_4_a7_rows[$i][0]) ,$controls,true ))

                                        @if(isset($col))
                                                <td>
                                                    <p>{!! nl2br($col) !!}</p>
                                                </td>


                                        @endif




                                @endif





         @endforeach




         @if(in_array( strval($sec2_4_a7_rows[$i][0]) ,$controls,true ))


         <td>
            @if(in_array('Data Inputter',$permissions))
            <a href="/iso_sec_2_3_2_risk_treat_form/{{$sec2_4_a7_rows[$i][0]}}/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                 class="btn btn-warning">Risk Treatment </a>
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


                            @if(in_array( strval($sec2_4_a8_rows[$i][0]) ,$controls,true ))

                                    @if(isset($col))
                                            <td>
                                                <p>{!! nl2br($col) !!}</p>
                                            </td>


                                    @endif




                            @endif





     @endforeach




     @if(in_array( strval($sec2_4_a8_rows[$i][0]) ,$controls,true ))


     <td>
        @if(in_array('Data Inputter',$permissions))
        <a href="/iso_sec_2_3_2_risk_treat_form/{{$sec2_4_a8_rows[$i][0]}}/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
             class="btn btn-warning">Risk Treatment </a>
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
<h2>DO Risk Assessment first for the asset</h2>
@endif
</div>



@section('scripts')

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

@endsection



@endsection
