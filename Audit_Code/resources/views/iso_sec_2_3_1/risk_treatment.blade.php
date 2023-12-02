@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);

$control_nums_array = [];

@endphp

@foreach ($component as $c)
@php
$control_nums_array[] =$c->control_num;

@endphp

@endforeach


<div class="container">

    <h3 class="text-center">Risk Treatment</h3>

    @if($component->count()>0)

    <h2 class="text-center">Component Name: {{$componentDetails->c_name}}</h2>
    <h2 class="text-center">Asset value: {{$component[0]->asset_value}}</h2>



    {{-- @foreach ($component as $c)

    <h3>{{$c->control_num}}</h3>

    @endforeach --}}


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

        @for ($i = 0; $i < count($sec2_4_a5_rows); $i++)
                    <tr style="vertical-align: middle;text-align:initial">

                        @foreach ($sec2_4_a5_rows[$i] as $col)


                                                @if(in_array( strval($sec2_4_a5_rows[$i][0]) ,$control_nums_array,true ))

                                                        @if(isset($col))
                                                                <td>
                                                                    <p>{!! nl2br($col) !!}</p>
                                                                </td>


                                                        @endif




                                                @endif





                         @endforeach




                         @if(in_array( strval($sec2_4_a5_rows[$i][0]) ,$control_nums_array,true ))


                         <td>
                            @if(in_array('Data Inputter',$permissions))
                            <a href="/iso_sec_2_3_2_risk_treat_form/{{$sec2_4_a5_rows[$i][0]}}/{{$componentDetails->assessment_id}}/{{$asset}}/{{$project_id}}/{{auth()->user()->id}}"
                                 class="btn btn-warning">Risk Treatment </a>
                            @else
                            <p>Not allowed</p>
                            @endif
                        </td>


                         @endif

















                            </tr>


    @endfor


            </tbody>




@else
            <p>Add risk Assessment in sec2.3.1 </p>
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
