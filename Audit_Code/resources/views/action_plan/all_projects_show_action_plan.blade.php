@extends('master')

@section('content')

@include('user-nav')

@php
    $actionPlanType = Session('action_plan_type') == "Mandatory" ? 'Compliance' : Session('action_plan_type');
@endphp

<div class="container my-2">
   
    <h3 class="fw-bold text-center mt-4">View or Download {{$actionPlanType}} Action Plan</h3>

    <div class="row">
        <div class="col-md-6 mt-2">

    <h4><span class="fw-bold">Service Selected:</span> All Services - All Controls</h4>
    <h4><span class="fw-bold"></span>Assets Selected: All Asset Components</h4>

          
        </div>
           
        


     <div class="col-md-6 position-relative">
        <a href="/all_projects_action_plan_download/{{$action_plan_type}}/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;"> Download Action Plan</a>

        </div>
    </div>


    @if($action_plan_type=='Both')

    <h3 class="fw-bold mt-4">View or Download Action Plan for Compliance</h3>

    @endif

    @if($action_plan_type=='Mandatory'|| $action_plan_type=='Both')

    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Req No.</th>
                <th>Action</th>
                <th>Target Date</th>
                <th>Completion Date</th>
                <th>Actual Acceptance Date</th>
                <th>Responsibility</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($mandatory_action_plan as $mand)

    <tr>
        <td>{{$mand->sub_req}}</td>
        <td>{{$mand->treatment_action}}</td>
        <td>{{$mand->treatment_target_date}}</td>
        <td>{{$mand->treatment_comp_date}}</td>
        <td>{{$mand->acceptance_actual_date}}</td>
        <td>{{$mand->first_name}} {{$mand->last_name}}</td>
    </tr>
    
    @endforeach

        </tbody>


    </table>

    {{ $mandatory_action_plan->appends(['treatment_page' => request('treatment_page')])->links() }}



    @endif

    @if($action_plan_type=='Both')

    <h3 class="fw-bold">View or Download Action Plan for Risk Treatment</h3>

    @endif

    @if($action_plan_type=='Treatment'|| $action_plan_type=='Both')
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Req No.</th>
                <th>Action</th>
                <th>Target Date</th>
                <th>Completion Date</th>
                <th>Actual Acceptance Date</th>
                <th>Responsibility</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($treatment_action_plan as $treat)

            <tr>
                <td>{{$treat->control_num}}</td>
                <td>{{$treat->treatment_action}}</td>
                <td>{{$treat->treatment_target_date}}</td>
                <td>{{$treat->treatment_comp_date}}</td>
                <td>{{$treat->acceptance_actual_date}}</td>
                <td>{{$treat->first_name}} {{$treat->last_name}}</td>
            </tr>
    
    @endforeach
        </tbody>


    </table>

    {{ $treatment_action_plan->appends(['mandatory_page' => request('mandatory_page')])->links() }}


    @endif



 
    </div>




</div>



@endsection
