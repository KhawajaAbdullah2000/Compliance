@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h3 class="text-center fw-bold mb-3">Project id: {{$project_id}} Project name: {{$project_name}} Section2.3 Information Security Risk Assessment And Treatment</h3>

    <h2 class="text-center">Asset: {{$assetData->name}}</h2>

    <p>Asset Group Name: {{$assetData->g_name}}</p>
    <p>Asset Name: {{$assetData->name}}</p>
    <p>Asset Component Name: {{$assetData->c_name}}</p>
    <p>Asset Owner Dept: {{$assetData->owner_dept}}</p>
    <p>Asset Physical Location: {{$assetData->physical_loc}}</p>
    <p>Asset Logical Location: {{$assetData->logical_loc}}</p>
<p>Asset Id is Iso_sec_2_1 table: {{$assetData->assessment_id}}</p>



@if(!$assetvalue)
    <form action="/iso_sec_2_3_new_asset_value/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" method="post">
        @csrf
        <div class="flex">
<label for="">First Select Asset Value</label>
        <select name="asset_value" id="">
            <option value="">Select Value</option>
            <option value=10>High</option>
            <option value=5>Medium</option>
            <option value=1>Low</option>
        </select>

        <button class="btn btn-primary btn-sm" type="submit">Submit</button>

    </div>


    </form>

    @else
    <p>Asset value: {{$assetvalue}}</p>


    <div class="main">

<table class="table table-primary table-hover">
    <thead style="vertical-align: middle">
        <td>Applicable Control Category</td>
        <td>Control</td>
        <td>Control Compliance %</td>
        <td>Vulnerability %</td>
        <td>Threat %</td>
        <td>Risk Level</td>
        <td>Residual Risk Treatment</td>
        <td>Treatment Action</td>
        <td>Treatment Target Date</td>
        <td>Responsibiliy for Treatment</td>
        <td>Actions</td>
    </thead>


        @if($iso_sec_2_4_a5)
        @foreach ($iso_sec_2_4_a5 as $a5 )
        <tr style="vertical-align: middle">

        <td>Organization Controls</td>
        <td>{{$a5->control_num}}</td>

        @if($tableData->count()>0)
        @foreach ($tableData as $tdata)

         @if($tdata->control_num==$a5->control_num)
            <td>{{$tdata->control_compliance}}</td>
            <td>{{$tdata->vulnerability}}</td>
            <td>{{$tdata->threat}}</td>
            <td>{{$tdata->risk_level}}</td>
            <td>{{$tdata->residual_risk_treatment}}</td>
            <td>{{$tdata->treatment_action}}</td>
            <td>{{$tdata->treatment_target_date}}</td>
            <td>{{$tdata->first_name}} {{$tdata->last_name}}</td>
        <td><a href="/iso_sec_2_3_edit_table/{{$assetData->assessment_id}}/{{$a5->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-warning btn-sm">Edit risk values</a></td>

            @break
         @endif

          @if($loop->last)
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a5->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>


         @endif

        @endforeach

        @else
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a5->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>


    @endif

         {{-- <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a5->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td> --}}

    </tr>
        @endforeach

        @endif

        @if($iso_sec_2_4_a6)
        @foreach ($iso_sec_2_4_a6 as $a6 )
        <tr style="vertical-align: middle">

        <td>People Controls</td>
        <td>{{$a6->control_num}}</td>

        @if($tableData->count()>0)
        @foreach ($tableData as $tdata)

         @if($tdata->control_num==$a6->control_num)
            <td>{{$tdata->control_compliance}}</td>
            <td>{{$tdata->vulnerability}}</td>
            <td>{{$tdata->threat}}</td>
            <td>{{$tdata->risk_level}}</td>
            <td>{{$tdata->residual_risk_treatment}}</td>
            <td>{{$tdata->treatment_action}}</td>
            <td>{{$tdata->treatment_target_date}}</td>
            <td>{{$tdata->first_name}} {{$tdata->last_name}}</td>
            <td><a href="/iso_sec_2_3_edit_table/{{$assetData->assessment_id}}/{{$a6->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
                class="btn btn-warning btn-sm">Edit risk values</a></td>
            @break
         @endif
         @if($loop->last)
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a6->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>


         @endif
        @endforeach

        @else
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a6->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>
        @endif





    </tr>
        @endforeach


        @endif



        @if($iso_sec_2_4_a7)
        @foreach ($iso_sec_2_4_a7 as $a7 )
        <tr style="vertical-align: middle">

        <td>Physical Controls</td>
        <td>{{$a7->control_num}}</td>

        @if($tableData->count()>0)
        @foreach ($tableData as $tdata)

         @if($tdata->control_num==$a7->control_num)
            <td>{{$tdata->control_compliance}}</td>
            <td>{{$tdata->vulnerability}}</td>
            <td>{{$tdata->threat}}</td>
            <td>{{$tdata->risk_level}}</td>
            <td>{{$tdata->residual_risk_treatment}}</td>
            <td>{{$tdata->treatment_action}}</td>
            <td>{{$tdata->treatment_target_date}}</td>
            <td>{{$tdata->first_name}} {{$tdata->last_name}}</td>
            <td><a href="/iso_sec_2_3_edit_table/{{$assetData->assessment_id}}/{{$a7->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
                class="btn btn-warning btn-sm">Edit risk values</a></td>
            @break
         @endif
         @if($loop->last)
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a7->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>
         @endif


        @endforeach
        @else
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a7->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>

        @endif




    </tr>
        @endforeach


        @endif



        @if($iso_sec_2_4_a8)
        @foreach ($iso_sec_2_4_a8 as $a8 )
        <tr style="vertical-align: middle">

        <td>Technological Controls</td>
        <td>{{$a8->control_num}}</td>

        @if($tableData->count()>0)
        @foreach ($tableData as $tdata)

         @if($tdata->control_num==$a8->control_num)
            <td>{{$tdata->control_compliance}}</td>
            <td>{{$tdata->vulnerability}}</td>
            <td>{{$tdata->threat}}</td>
            <td>{{$tdata->risk_level}}</td>
            <td>{{$tdata->residual_risk_treatment}}</td>
            <td>{{$tdata->treatment_action}}</td>
            <td>{{$tdata->treatment_target_date}}</td>
            <td>{{$tdata->first_name}} {{$tdata->last_name}}</td>
            <td><a href="/iso_sec_2_3_edit_table/{{$assetData->assessment_id}}/{{$a8->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
                class="btn btn-warning btn-sm">Edit risk values</a></td>
            @break
         @endif

         @if($loop->last)
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td><a href="/iso_sec_2_3_edit_table/{{$assetData->assessment_id}}/{{$a8->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>
         @endif
        @endforeach

        @else
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="/iso_sec_2_3_table_insert/{{$assetData->assessment_id}}/{{$a8->control_num}}/{{$project_id}}/{{auth()->user()->id}}"
            class="btn btn-success btn-sm">Add risk values</a></td>
        @endif




    </tr>
        @endforeach


        @endif




</table>

    </div>

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
