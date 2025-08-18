@extends('master')

@section('content')

@include('user-nav')

@php
    $actionPlanType = Session('action_plan_type') == "Mandatory" ? 'Compliance' : Session('action_plan_type');
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
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="fw-bold text-center mt-4">View or Download {{$actionPlanType}} Action Plan</h3>

    <div class="row">
        <div class="col-md-6">

    
            <h4><span class="fw-bold">Service Selected : </span>
                @if($service=='_all')
                All services - All Controls
                @else
                {{$service}} - All Controls
                @endif
            </h4>
        
            <h4><span class="fw-bold">Assets Selected : </span> 
                @isset($group)
                @if($group=='_all')
                All Asset Types -
                @else
                {{$group}} -
                @endif
                @endisset
        
        
            @isset($subgroup)
            @if($subgroup=='_all')
            All Asset Sub Types -
            @else
            {{$subgroup}} -
            @endif
            @endisset
        
        @if($component=='_all')
        
        All Asset Components 
        
        @else
        
        {{$component}}
        @endif
        </h4>
        </div>

        <div class="col-md-6 position-relative">
            <a href="/action_plan/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">View or Download another Action Plan</a>
        </div>
    </div>


    <a href="/action_plan_download/{{$project->project_id}}/{{$service}}/{{$component}}?group={{ $group }}&subgroup={{ $subgroup }}" class="btn btn-success float-end mb-4">Download Action Plan</a>
    

    @if($action_plan_type=='Both')

    <h3 class="fw-bold mt-4">View or Download Action Plan for Compliance</h3>

    @endif

    @if($action_plan_type=='Mandatory'|| $action_plan_type=='Both')

    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Req No.</th>
                <th>Compliance Status</th>
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
        <td>
            @if($mand->comp_status == 'not_applicable')
                Not applicable
            @elseif($mand->comp_status == 'yes')
                Inplace
            @elseif($mand->comp_status == 'no')
                Not In Place
                 @elseif($mand->comp_status == 'not_tested')
                Not Tested
                @elseif($mand->comp_status == 'partial')
                Partial 
                @else
                {{$mand->comp_status}}
            @endif
        </td>
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

    





        <a href="/action_plan_download/{{$project->project_id}}/{{$service}}/{{$component}}?group={{ $group }}&subgroup={{ $subgroup }}" class="btn btn-success float-end mb-4">Download Action Plan</a>

        <a href="/action_plan/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary float-end mb-4 mx-2">View or Download another Action Plan</a>


</div>



@endsection
