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
                        <td>{{ auth()->user()->organization->sub_org }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="fw-bold text-center mt-4">View or Download Action Plan</h3>

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
                All Asset Groups -
                @else
                {{$group}} -
                @endif
                @endisset
        
        
            @isset($subgroup)
            @if($subgroup=='_all')
            All Asset Subgroups -
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
            <a href="/action_plan/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">Action Plan</a>
        </div>
    </div>


    <a href="/action_plan_download/{{$project->project_id}}/{{$service}}/{{$component}}?group={{ $group }}&subgroup={{ $subgroup }}" class="btn btn-success float-end mb-4">Download Action Plan</a>
    
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

            
    @if($action_plan_type=='Mandatory'|| $action_plan_type=='Both')

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


    @endif

    @if($action_plan_type=='Treatment'|| $action_plan_type=='Both')

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


    @endif

            
        </tbody>

        </table>



</div>



@endsection
